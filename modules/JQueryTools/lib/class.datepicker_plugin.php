<?php

namespace JQueryTools;

final class datepicker_plugin
{
    private function __construct() {}

    private static function _get_localeInfo()
    {
        $out = array();
        $out = array();
        $out['monthNames'] = array();
        $out['monthNamesShort'] = array();
        for( $i = 0; $i < 12; $i++ ) {
            $out['monthNames'][] = strftime('%B',mktime(1,0,0,$i+1,1,2000));
            $out['monthNamesShort'][] = strftime('%b',mktime(1,0,0,$i+1,1,2000));
        }

        $fmt = 'last sunday + %d days';
        $out['dayNames'] = array();
        $out['dayNamesShort'] = array();
        $curday = (int)date('w');
        for( $i = 0; $i < 7; $i++ ) {
            $out['dayNames'][] = strftime('%A',strtotime(sprintf($fmt,$i)));
            $out['dayNamesShort'][] = strftime('%a',strtotime(sprintf($fmt,$i)));
        }
        return $out;
    }

    public static function load($libname)
    {
        if( $libname != 'cg_datepicker' ) return;

        // gotta return code
        $mod = \cms_utils::get_module('JQueryTools');
        $config = cmsms()->GetConfig();
        $smarty = cmsms()->GetSmarty();
        $smarty->assign('mod',$mod);
        $smarty->assign('config',$config);
        $smarty->assign('localeInfo',self::_get_localeInfo());
        $dateformat = 'dd/mm/yy';
        if( \CmsNlsOperations::get_current_language() == 'en_US' ) {
            $dateformat = 'mm/dd/yy';
        }
        $smarty->assign('dateformat',$dateformat);
        $code = $mod->ProcessTemplate('datepicker_plugin.js');
        $obj = new \StdClass;
        $obj->code = $code;
        return $obj;
    }
}
?>