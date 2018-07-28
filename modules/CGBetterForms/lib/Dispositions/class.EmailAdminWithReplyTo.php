<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class EmailAdminWithReplyTo extends Disposition
{
    private $_addresses;
    private $_fieldname;
    private $_subjecttemplate;
    private $_bodytemplate;

    public function __get($key)
    {
        switch( $key ) {
        case 'addresses':
            return $this->_addresses;
        case 'fieldname':
            return $this->_fieldname;
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

    public function set_fieldname( $email )
    {
        $this->_fieldname = trim($email);
    }

    public function get_fieldname()
    {
        return $this->_fieldname;
    }

    public function set_subjecttemplate( $data )
    {
        $this->_subjecttemplate = trim($data);
    }

    public function set_bodytemplate( $data )
    {
        $this->_bodytemplate = trim($data);
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response )
    {
        $tmp_addresses = explode(',',$this->addresses);

        if( !$this->fieldname ) return;
        $replyto = $response->get_field_value($this->fieldname);
        if( !$replyto || !is_email($replyto) ) return;

        $tmp_addresses = $this->get_addresses();
        $mailer = \CGBetterForms\utils::get_mailer( $form );
        // only one reply to,  and that's the reply to address that the user put in.
        $mailer->ClearReplyTos();
        $added = false;
        foreach( $tmp_addresses as $addr ) {
            $addr = trim($addr);
            if( !$addr ) continue;
            if( !is_email( $addr) ) continue;
            $mailer->AddAddress( $addr );
            $added = true;
        }
        if( !$added ) throw new \RuntimeException('No valid email addresses to send to for EmailFixedAddressesDisposition');

        $mailer->AddReplyTo($replyto);
        $mailer->SetSubject(utils::process_template( $this->subjecttemplate, $form, $response) );
        $mailer->SetBody(utils::process_template( $this->bodytemplate, $form, $response) );
        $mailer->Send();
    }
} // end of class
