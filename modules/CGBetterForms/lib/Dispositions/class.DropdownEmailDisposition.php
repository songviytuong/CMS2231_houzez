<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class DropdownEmailDisposition extends Disposition
{
    private $_field;
    private $_dflt_address;
    private $_value_map;
    private $_subjecttemplate;
    private $_bodytemplate;

    public function __get($key)
    {
        switch( $key ) {
        case 'field':
            return trim($this->_field);
        case 'dflt_address':
            return trim($this->_dflt_address);
        case 'subjecttemplate':
            return trim($this->_subjecttemplate);
        case 'bodytemplate':
            return trim($this->_bodytemplate);
        case 'value_map':
            return trim($this->_value_map);
        }
    }

    public function set_field( $data )
    {
        $this->_field = trim($data);
    }

    public function set_dflt_address( $data )
    {
        $data = trim($data);
        if( $data && !is_email( $data ) ) throw new \LogicException("$data is not a valid email address");
        $this->_dflt_address = $data;
    }

    public function set_value_map( $data )
    {
        $this->_value_map = trim($data);
    }

    public function set_subjecttemplate( $data )
    {
        $this->_subjecttemplate = trim($data);
    }

    public function set_bodytemplate( $data )
    {
        $this->_bodytemplate = trim($data);
    }

    protected function from_text($map_text)
    {
        $out = [];
        $lines = explode("\n",$map_text);
        foreach( $lines as $line ) {
            $line = trim($line);
            if( !$line ) continue;
            $parts = explode("|",$line,2);
            if( count($parts) != 2 ) continue;
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            $out[$key] = $val;
        }
        return $out;
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data)
    {
        $addresses = [];
        if( $this->dflt_address ) $addresses[] = $this->dflt_address;
        $val = $data->{$this->field};
        $field = $form->get_field( $this->field );

        // $val could be an array
        if( !is_array($val) ) $val = [ $val ];
        $map = $this->from_text($this->value_map);
        if( count($map) ) {
            foreach( $val as $one_val ) {
                if( array_key_exists($one_val,$map) ) $addresses[] = $map[$one_val];
            }
        }
        if( !count($addresses) ) throw new \RuntimeException('No valid email addresses to send to for DropDownEmailDispostion on '.$field->name);

        $mailer = \CGBetterForms\utils::get_mailer( $form );
        foreach( $addresses as $email ) {
            $mailer->AddAddress( $email );
        }
        $mailer->SetSubject( utils::process_template( $this->subjecttemplate, $form, $data) );
        $mailer->SetBody( utils::process_template( $this->bodytemplate, $form, $data) );
        $mailer->Send();
    }
} // end of class
