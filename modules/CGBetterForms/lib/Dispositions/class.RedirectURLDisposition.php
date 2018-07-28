<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class RedirectURLDisposition extends Disposition
{
    private $_tpl;

    public function __get($key)
    {
        switch( $key ) {
        case 'tpl':
            return $this->_tpl;
        }
    }

    public function set_tpl( $tpl )
    {
        $this->_tpl = trim($tpl);
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response)
    {
        if( !$this->tpl ) return;
        $out = utils::process_template($this->tpl, $form, $response);
        $out = trim($out);
        if( !$out ) return;

        $response->set_final_url( $url );
    }
} // end of class
