<?php

namespace CGHeadMaster;

final class smarty_plugins
{
    private function __construct() {}

    private static function &mod()
    {
        return \cms_utils::get_module(MOD_CGHEADMASTER);
    }

    public static function cghm_config_set($params,&$tempalte)
    {
        $key = \cge_param::get_string($params,'key');
        $key = \cge_param::get_string($params,'name',$key);
        $val = \cge_param::get_string($params,'val');
        $val = \cge_param::get_string($params,'value',$val);
        self::mod()->set_config($key,$val);
    }

    /**
     * Set a meta variable
     *
     * {cgsm_set key=cgsm_name value='foo'}
     * {cgsm_set key=fb:admins value='bar'}
     * {cgs_set rel=fb:admins value='abc'}
     * {{cgs_set name=fb:admins 'abc'}
     */
    public static function cghm_set($params,&$template)
    {
        $vals = array();
        foreach( $params as $key => $pval ) {
            switch( $key ) {
            case 'name':
            case 'key':
                $fld = self::mod()->get_raw_field($pval);
                // check that there is only one value needed
                if( !isset($fld['attr2']) ) {
                    // get the name of the value attribute
                    $attr = $fld['attr1'];

                    $val = \cge_param::get_string($params,'val');
                    $val = \cge_param::get_string($params,'value',$val);
                    $val = \cge_param::get_string($params,$attr,$val);
                    $val = trim($val);
                    if( $val && $val !== '0' ) self::mod()->set_field_attr($pval,$attr,$val);
                }
                return;

            case 'rel':
                // support multiple attributes (gotta search to make sure it is in the attrs)
                $fld = self::mod()->get_raw_field($pval);
                foreach( $fld as $fkey => $fval ) {
                    if( !startswith($fkey,'attr') ) continue;
                    $attr = $fval;
                    $newval = \cge_param::get_string($params,$attr);
                    $newval = trim($newval);
                    if( $newval && $newval !== '0' ) self::mod()->set_field_attr($pval,$attr,$newval);
                }
                return;
            }
        }
    }


    public static function cghm_hide($params,&$template)
    {
        $key = \cge_param::get_string($params,'key');
        $key = \cge_param::get_string($params,'name',$key);
        self::mod()->hide_field($key);
    }

    public static function cghm_unset($params,&$template)
    {
        $key = \cge_param::get_string($params,'key');
        $key = \cge_param::get_string($params,'name',$key);
        self::mod()->unset_field($key);
    }

    public static function cghm_render($params,&$template)
    {
        // make sure that this method is only called once per request.
        static $_done = 0;
        if( $_done != 0 ) return;
        $_done = 1;

        $groups = \cge_param::get_string($params,'group');
        $assign = \cge_param::get_string($params,'assign');
        if( $groups ) $groups = self::mod()->str_to_array($groups);
        if( !$groups ) $groups = self::mod()->get_groups();

        $out = null;
        $flds = self::mod()->get_fields($groups);
        foreach( $flds as $name ) {
            $tmp = self::mod()->render_field($name);
            if( $tmp ) $out .= "$tmp\n";
        }

        //
        // now do google analytics stuff
        //
        $out .= self::mod()->generate_ga();

        if( $assign ) {
            $template->assign($assign,$out);
        } else {
            return $out;
        }
    }

} // end of class
?>