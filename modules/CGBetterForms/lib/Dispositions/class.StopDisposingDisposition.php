<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class StopDisposingDisposition extends Disposition
{
    private $_tpl;

    public function __get( $key )
    {
        switch( $key ) {
        case 'tpl':
        case 'template':
            return $this->_tpl;
        }
    }

    public function set_template( $str )
    {
        $this->_tpl = trim($str);
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response )
    {
        if( !$this->_tpl ) return;
        $out = utils::process_template( $this->tpl, $form, $response );
        $out = trim($out);
        if( !$out ) return;

        throw new \CGBetterForms\StopDispositionTrigger('stopped');
    }
} // end of class
