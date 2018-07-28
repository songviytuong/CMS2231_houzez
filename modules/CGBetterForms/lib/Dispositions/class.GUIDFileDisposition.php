<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class GUIDFileDisposition extends Disposition
{
    protected function move_file( $guid, $tmp_name, $dest )
    {
        $srcdir = TMP_CACHE_LOCATION."/$guid";
        $fn = "$srcdir/$tmp_name";
        if( is_file( $fn ) ) {
            $config = \CmsApp::get_instance()->GetConfig();
            rename( $fn, $dest );
            @chmod($destination,octdec($config['default_upload_permission']));
        } else {
            cms_move_uploaded_file( $tmp_name, $dest );
        }
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $resp)
    {
        $destdir = $this->get_destdir( $resp );
        utils::mkdirr( $destdir );

        // now, for each file field.. we get the values
        $moved_files = false;
        foreach( $form->fields as $field ) {
            if( ! $field instanceof \CGBetterForms\FormFileField ) continue;
            $name = $field->name;
            if( endswith( $name, '[]') ) $name = substr($name,0,-2);
            $value = $resp->$name;
            if( !$value ) continue;

            $filenames = [];
            $files = $resp->list_files($name);
            if( !count($files) ) continue;
            foreach( $files as $file ) {
                if( !$file['name'] || !$file['tmp_name'] ) continue;
                $destname = $destdir.'/'.$file['name'];
                $this->move_file( $resp->guid, $file['tmp_name'], $destname );
                $filenames[] = $destname;
                $moved_files = true;
            }
            if( $field->multiple ) {
                $resp->modify_value( $name, $filenames );
            } else {
                $resp->modify_value( $name, $filenames[0] );
            }
        }

        // put a meta data file in this directory so that we can track this later.
        if( $moved_files ) $this->create_metafile( $form, $resp );

        $dir = TMP_CACHE_LOCATION.'/'.$resp->guid;
        if( is_dir( $dir ) ) recursive_delete( $dir );
    }

    protected function get_destdir( \CGBetterForms\FormResponse $resp )
    {
        $config = \cms_config::get_instance();
        $parent_dir = $config['uploads_path'].'/_CGBetterForms';
        $destdir = $parent_dir.'/'.$resp->guid;
        return $destdir;
    }

    protected function create_metafile(\CGBetterForms\Form $form, \CGBetterForms\FormResponse $resp)
    {
        $out = [];
        $out['form_name'] = $form->name;
        $out['responseid'] = $resp->get_requestid();
        $out['date'] = $resp->get_time();
        $filename = $this->get_destdir( $resp ).'/.meta.json';
        file_put_contents($filename,json_encode($out));
    }
} // end of class
