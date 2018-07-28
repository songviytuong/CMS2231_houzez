<?php

namespace Banners;

class html_report_generator extends \CGExtensions\reports\html_report_generator
{
    public function get_head_contents()
    {
        $out = parent::get_head_contents();
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $fn = $mod->find_module_file('report.css');
        if( $fn ) {
            $url = \cge_utils::file_to_url($fn);
            if( $url ) $out .= '<link rel="stylesheet" type="text/css" href="'.$url.'">';
        }
        $fn = $mod->find_module_file($this->get_alias().'.css');
        if( $fn ) {
            $url = \cge_utils::file_to_url($fn);
            if( $url ) $out .= '<link rel="stylesheet" type="text/css" href="'.$url.'">';
        }
        return $out;
    }
}
