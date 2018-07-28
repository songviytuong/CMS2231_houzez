<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class DropdownFileDisposition extends Disposition
{
    private $_field;
    private $_folder;
    private $_headertemplate;
    private $_entrytemplate;

    public function __get($key)
    {
        switch( $key ) {
        case 'field':
            return trim($this->_field);
        case 'folder':
            return trim($this->_folder);
        case 'headertemplate':
            return trim($this->_headertemplate);
        case 'entrytemplate':
            return trim($this->_entrytemplate);
        }
    }

    public function set_field( $data )
    {
        $this->_field = trim($data);
    }

    public function set_folder( $data )
    {
        $this->_folder = trim($data);
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
        // get the value.
        $val = $data->{$this->field};

        // build a filename for this value.
        /// get the field
        $field = $form->get_field( $this->field );
        $hr = $val;
        $opt = $field->get_option_by_value( $val );
        if( $opt ) $hr = $opt->hr;

        // todo: cleanup $hr to smething reasonable (no funky chars)

        $filename = $this->field.'_'.$hr.'.txt';
        $filename = $config['root_path'].'/'.$this->folder.'/'.$filename;

        // if the directory is relative to the root path,  AND doesn't exist
        // create it.
        $dir = dirname($filename);
        if( !is_dir( $dir ) && utils::is_cmsms_relative( $dir ) ) {
            $res = mkdir( $dir, 0777, TRUE );
            if( !$res ) throw new \RuntimeException('SYSTEM ERROR:  Could not create directory at '.$dir);
        }
        if( !utils::can_write_file( $filename) ) throw new \RuntimeException('SYSTEM ERROR: Cannot write to '.$filename);
        // if the file does not exist
        // process the template for the header, and write it.

        if( !is_file($filename) ) {
            $output = utils::process_template( $this->headertemplate, $form, $data );
            file_put_contents($filename,$output);
        }

        // process template for the entry,  and write.
        $output = utils::process_template( $this->entrytemplate, $form, $data );
        file_put_contents($filename,$output,FILE_APPEND);
    }
} // end of class
