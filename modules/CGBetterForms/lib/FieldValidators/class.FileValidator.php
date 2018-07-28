<?php
namespace CGBetterForms\FieldValidators;
use \CGBetterForms\FormFileField;

class FileValidator extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate( 'display_FileValidator' );
    }

    public function Validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $translator )
    {
        if( ! $response->has_uploads() ) return;

        // here for each upload field... we check the value
        $files = $response->list_files();
        if( !count($files) ) return; // nothing to do.

        foreach( $form->fields as $field ) {
            if( $field->novalidate ) continue;
            if( $field->type != 'file' ) continue;
            $name = $field->name;
            $value = $response->get_field_value( $name );
            if( !$value ) continue;
            if( !isset($files[$name]) ) continue;
            $this->validate_files( $field, $files[$name], $translator );
        }
    }

    protected function validate_files( FormFileField $field, array $file_info, \CGBetterForms\Translator $translator )
    {
        if( !count($file_info) ) return;
        foreach( $file_info as $rec ) {
            if( $field->accept && ! $this->file_accepted_by_type( $field->accept, $rec ) ) {
                throw new BadUploadError($field->name, $translator->translate('err_upload_type', $field->name) );
            }
            if( $field->extensions && ! $this->file_accepted_by_extension($field->extensions, $rec) ) {
                throw new BadUploadError($field->name, $translator->translate('err_upload_extension', $field->name) );
            }
            if( $field->max_size  && !$this->file_accepted_by_size( $field->max_size, $rec ) ) {
                throw new BadUploadError($field->name, $translator->translate('err_upload_size') );
            }
        }
    }

    protected function file_accepted_by_size( $max_size, array $rec )
    {
        $total = 0;
        if( isset($rec['size']) )  $rec = [ $rec ];
        for( $i = 0; $i < count($rec); $i++ ) {
            $total += $rec[$i]['size'];
        }
        if( $total <= $max_size ) return TRUE;
    }

    protected function file_accepted_by_extension( $extensions, array $rec )
    {
        if( !$extensions ) return TRUE;
        if( isset($rec['size']) )  $rec = [ $rec ];
        for( $i = 0; $i < count($rec); $i++ ) {
            $name = $rec[$i]['name'];
            if( !$name ) return FALSE;

            $ext = strtolower(substr(strrchr($filename,"."),1));
            if( !$ext ) return FALSE;

            $list = explode(',',$extensions);
            foreach( $list as $one ) {
                $one = trim($one);
                if( !$one ) continue;
                $one = strtolower($one);
                if( $ext == $one ) continue;
            }
            return FALSE;
        }
    }

    protected function wildcardMatchMimeType( $type, $test )
    {
        if( !$type ) return TRUE;
        if( $type == '*/*' || $type == '*' ) return TRUE;
        if( strpos('*',$type) !== FALSE ) {
            return (strtolower($type) == strtolower($test));
        }

        // it's a wildcard pattern.
        $type_parts = explode('/',$type,2);
        $test_parts = explode('/',$test,2);
        $n = min(count($type_parts),count($test_parts));
        for( $i = 0; $i < $n; $i++ ) {
            $a = strtolower($type_parts[$i]);
            $b = strtolower($test_parts[$i]);
            if( $a == '*' ) return TRUE;
            if( $a != $b ) return FALSE;
        }
        return TRUE;
    }

    protected function file_accepted_by_type( $accept, array $rec )
    {
        if( !$accept ) return TRUE;

        if( isset($rec['size']) )  $rec = [ $rec ];
        for( $i = 0; $i < count($rec); $i++ ) {
            $mime_type = $rec[$i]['mime_type'];
            $all = explode(',',$accept);
            $fnd = false;
            foreach( $all as $one ) {
                $one = trim($one);
                if( !$one ) continue;
                if( $this->wildcardMatchMimeType( $one, $mime_type ) ) {
                    $fnd = true;
                }
            }
            if( !$fnd ) return FALSE;
        }
        return TRUE;
    }
} // end of class
