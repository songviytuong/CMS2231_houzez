<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class ComputedPageDisposition extends Disposition
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

        $mod = \cms_utils::get_module(MOD_CGBETTERFORMS); // not DI... but who cares
        $pageid = $mod->resolve_alias_or_id( $out );
        if( !$pageid ) return;

        redirect_to_alias($pageid);
    }
} // end of class
