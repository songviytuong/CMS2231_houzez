<?php

namespace CGSmartImage;

final class AutoProcessMessage extends \CMSMS\Async\Job
{
    private $_files;

    public function __construct($files)
    {
        parent::__construct();
        $this->_files = $files;
    }

    protected function &get_prefs()
    {
        static $_prefs;
        if( !$_prefs ) $_prefs = autoprocess_options::load();
        return $_prefs;
    }

    protected function autoconvert_file($filename)
    {
        try {
            if( !is_file($filename) ) throw new \Exception('File not found');
            if( !is_writable($filename) ) throw new \Exception('File not writable');
            $prefs = $this->get_prefs();
            if( !$prefs->is_file_scannable($filename) ) return;

            $sizeinfo = getimagesize($filename);
            if( !is_array($sizeinfo) || count($sizeinfo) < 2 ) throw new \Exception('Problem getting image details');
            if( $sizeinfo[0] <= $prefs->max_size && $sizeinfo[1] <= $prefs->max_size) return; // nothing to do.

            $opts = array();
            $opts['src'] = $filename;
            $opts['notag'] = 1;
            $opts['noembed'] = 1;
            $opts['overwrite'] = 1;
            if( !$prefs->autorotate ) $opts['norotate'] = 1;
            $opts['filter_resize'] = 'e,'.$prefs->max_size;
            if( $prefs->watermark ) $opts['filter_watermark'] = 1;

            $out = \cgsi_utils::process_image($opts);
            if( $out['error'] ) throw new \Exception($out['error']);
            if( !$out['dest_file'] ) throw new \Exception('No cached image generated');
            if( !is_file($out['dest_file']) ) throw new \Exception('Output file not found');
            @rename($out['dest_file'],$filename);
            @unlink($out['dest_file']);
        }
        catch( \Exception $e ) {
            \cge_utils::log_exception( $e );
            audit('','CGSmartImage AutoProcess',$e->GetMessage());
            audit('','CGSmartImage AutoProcess','Failed converting '.$filename);
        }
    }

    public function execute()
    {
        foreach( $this->_files as $file ) {
            $this->autoconvert_file($file);
        }
        return TRUE;
    }
} // class