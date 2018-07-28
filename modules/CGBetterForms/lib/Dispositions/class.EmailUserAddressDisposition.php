<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class EmailUserAddressDisposition extends Disposition
{
    private $_fieldname;
    private $_subjecttemplate;
    private $_bodytemplate;

    public function __get($key)
    {
        switch( $key ) {
        case 'fieldname':
            return $this->_fieldname;
        case 'subjecttemplate':
            return trim($this->_subjecttemplate);
        case 'bodytemplate':
            return trim($this->_bodytemplate);
        }
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
        if( !$this->fieldname ) return;
        $addr = $response->get_field_value($this->fieldname);
        if( !$addr || !is_email($addr) ) return;

        $mailer = \CGBetterForms\utils::get_mailer( $form );
        $mailer->AddAddress( $addr );
        $mailer->SetSubject(utils::process_template( $this->subjecttemplate, $form, $response) );
        $mailer->SetBody(utils::process_template( $this->bodytemplate, $form, $response) );
        $mailer->Send();
    }
} // end of class
