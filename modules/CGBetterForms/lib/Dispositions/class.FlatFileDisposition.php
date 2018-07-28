<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class FlatFileDisposition extends Disposition
{
    private $_filename;
    private $_headertemplate;
    private $_entrytemplate;

    public function __get($key)
    {
        switch( $key ) {
        case 'filename':
            return trim($this->_filename);
        case 'headertemplate':
            return trim($this->_headertemplate);
        case 'entrytemplate':
            return trim($this->_entrytemplate);
        }
    }

    public function set_filename( $filename )
    {
        $this->_filename = trim($filename);
    }

    public function set_headertemplate( $data )
    {
        $this->_headertemplate = trim($data);
    }

    public function set_entrytemplate( $data )
    {
        $this->_entrytemplate = trim($data);
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data)
    {
        $config = \cms_config::get_instance();
        $val = $data->{$this->field};

        $filename = $config['root_path'].'/'.$this->filename;
        $dir = dirname($filename);
        if( !is_dir( $dir ) && utils::is_cmsms_relative( $dir ) ) {
            $res = mkdir( $dir, 0777, TRUE );
            if( !$res ) throw new \RuntimeException('SYSTEM ERROR:  Could not create directory at '.$dir);
        }
        if( !utils::can_write_file( $filename) ) throw new \RuntimeException('SYSTEM ERROR: Cannot write to '.$filename);

        if( !is_file($filename) ) {
            $output = utils::process_template( $this->headertemplate, $form, $data );
            file_put_contents($filename,$output);
        }

        // process template for the entry,  and write.
        $output = utils::process_template( $this->entrytemplate, $form, $data );
        file_put_contents($filename,$output,FILE_APPEND);
    }
} // end of class
