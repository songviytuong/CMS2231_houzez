<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class EmailFixedAddressesDisposition extends Disposition
{
    private $_addresses;
    private $_subjecttemplate;
    private $_bodytemplate;

    public function __get($key)
    {
        switch( $key ) {
        case 'addresses':
            return $this->_addresses;
        case 'subjecttemplate':
            return trim($this->_subjecttemplate);
        case 'bodytemplate':
            return trim($this->_bodytemplate);
        }
    }

    public function set_addresses( $email )
    {
        $this->_addresses = trim($email);
    }

    public function get_addresses()
    {
        if( !$this->_addresses ) return;
        $tmp = explode(',',$this->_addresses);
        $tmp2 = [];
        foreach( $tmp as $one ) {
            $one = trim($one);
            if( $one && !in_array($one,$tmp2)) $tmp2[] = $one;
        }
        if( count($tmp2) ) return $tmp2;
    }

    public function set_subjecttemplate( $data )
    {
        $this->_subjecttemplate = trim($data);
    }

    public function set_bodytemplate( $data )
    {
        $this->_bodytemplate = trim($data);
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data)
    {
        $tmp_addresses = explode(',',$this->addresses);

        $mailer = \CGBetterForms\utils::get_mailer( $form );
        $added = false;
        foreach( $tmp_addresses as $addr ) {
            $addr = trim($addr);
            if( !$addr ) continue;
            if( !is_email( $addr) ) continue;
            $mailer->AddAddress( $addr );
            $added = true;
        }
        if( !$added ) throw new \RuntimeException('No valid email addresses to send to for EmailFixedAddressesDisposition');
        $mailer->SetSubject(utils::process_template( $this->subjecttemplate, $form, $data) );
        $mailer->SetBody(utils::process_template( $this->bodytemplate, $form, $data) );
        $mailer->Send();
    }
} // end of class
