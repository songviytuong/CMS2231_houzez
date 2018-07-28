<?php
final class CGHeadMaster extends CGExtensions
{
    /**
     * @ignore
     */
    private $_fields;

    /**
     * @ignore
     */
    private $_data;

    /**
     * @ignore
     */
    private $_config;

    /**
     * @ignore
     */
    private $_hide;

    /**
     * @ignore
     */
    public function InitializeFrontend()
    {
        $smarty = \Smarty_CMS::get_instance();
        if( !$smarty ) return;

        // register our functions.
        $smarty->register_function('cghm_config_set','\CGHeadMaster\smarty_plugins::cghm_config_set');
        $smarty->register_function('cghm_set','\CGHeadMaster\smarty_plugins::cghm_set');
        $smarty->register_function('cghm_unset','\CGHeadMaster\smarty_plugins::cghm_unset');
        $smarty->register_function('cghm_hide','\CGHeadMaster\smarty_plugins::cghm_hide');
        $smarty->register_function('cghm_render','\CGHeadMaster\smarty_plugins::cghm_render');

        // load standard fields
        $files = $this->get_module_files('config','fields.ini');
        if( !count($files) ) throw new \RuntimeException('Could not find field definition file(s) named fields.ini');
        $files = array_reverse($files);
        $this->_fields = array();
        foreach( $files as $file ) {
            $tmp = parse_ini_file($file,TRUE);
            if( count($tmp) ) $this->_fields = array_merge($this->_fields,$tmp);
        }

        // load the cgsm_config vars
        $sysconfig = \cms_config::get_instance();
        $fn = $sysconfig['root_path'].'/config.php';
        include($fn);
        unset($sysconfig);
        $this->_config = array();
        foreach( $config as $key => $val ) {
            if( !startswith($key,'cghm_') ) continue;
            $this->_config[$key] = $val;
        }
    }

    /**
     * @ignore
     */
    public function GetVersion() { return '1.0.14'; }

    /**
     * @ignore
     */
    public function IsPluginModule() { return TRUE; }

    /**
     * @ignore
     */
    public function HasAdmin() { return FALSE; }

    /**
     * @ignore
     */
    public function AllowAutoInstall() { return FALSE; }

    /**
     * @ignore
     */
    public function AllowAutoUpgrade() { return FALSE; }

    /**
     * @ignore
     */
    public function GetDependencies()
    {
        return array('CGExtensions'=>'1.56','CGSimpleSmarty'=>'1.8');
    }

    /**
     * @ignore
     */
    public function str_to_array($str)
    {
        $str = (string) $str;
        if( $str ) {
            $tmp = explode(',',$str);
            $tmp2 = array();
            foreach( $tmp as $one ) {
                $one = trim($one);
                if( !in_array($one,$tmp2) ) $tmp2[] = $one;
            }
            if( count($tmp2) ) return $tmp2;
        }
    }

    /**
     * Set a config value.
     *
     * @param string $key
     * @param string $val
     */
    public function set_config($key,$val)
    {
        $key = (string) $key;
        $val = (string) $val;
        if( strlen($val) == 0 && isset($this->_config[$key]) ) {
            unset($this->_config[$key]);
        }
        else {
            $this->_config[$key] = $val;
        }
    }

    /**
     * Hide a field so that it will not be rendered.
     *
     * @param string $fldname The field name.
     */
    public function hide_field($fldname)
    {
        $fldnames = $this->str_to_array($fldname);
        if( !is_array($fldnames) || !count($fldnames) ) return;
        if( !is_array($this->_hidden) ) $this->_hidden = array();
        foreach( $fldnames as $name ) {
            if( !in_array($name,$this->_hidden) ) $this->_hidden[] = $name;
        }
    }

    /**
     * Unset a field so that it will not be rendered.
     *
     * @param string $fldname The field name.
     */
    public function unset_field($fldname)
    {
        $fldname = (string) $fldname;
        if( isset($this->_data[$fldname]) ) unset($this->_data[$fldname]);
    }

    /**
     * Get a cghm config value.
     *
     * @param string $key The config field.
     * @param string $dflt The default value.
     */
    public function get_config($key,$dflt = null)
    {
        $key = (string) $key;
        if( isset($this->_config[$key]) ) return $this->_config[$key];
        return $dflt;
    }

    /**
     * Get the list of displayed field groups.
     *
     * @return string[]
     */
    public function get_groups()
    {
        $tmp = $this->get_config('cghm_groups','dates,misc,google,geo,twitter,og,fb,!old,!apple');
        $tmp = strtolower($tmp);
        return $this->str_to_array($tmp);
    }

    /**
     * Get the field in the specified group(s).
     *
     * @param string[] The group names.
     * @return string[] The fields in the specified groups.
     */
    public function get_fields($groups)
    {
        // first, split out the groups into something that is included, and explicitly excluded
        $incl = $excl = [];
        foreach( $groups as $grp ) {
            if( startswith($grp,'!') ) {
                if( !in_array($grp,$excl) ) $excl[] = substr($grp,1);
            } else {
                if( !in_array($grp,$incl) ) $incl[] = $grp;
            }
        }
        $incl = array_diff($incl,$excl);

        $out = array();
        foreach( $this->_fields as $key => $data ) {
            if( isset($data['group']) ) {
                // woot, only one group
                if( (!count($incl) || in_array(strtolower($data['group']),$incl)) && !in_array($data['group'],$excl) ) $out[] = $key;
            }
            else if( isset($data['groups']) ) {
                $tmp = $this->str_to_array($data['groups']);
                $in_excl = $in_incl = false;
                foreach( $tmp as $one ) {
                    $one = strtolower($one);
                    if( !count($incl) || in_array($one,$incl) ) $in_incl = true;
                    if( in_array($one,$excl) ) $in_excl = true;
                }
                if( $in_incl && !$in_excl ) $out[] = $key;
            }
        }
        if( count($out) ) return $out;
    }

    /**
     * Get information about the field (does not include attribute values.
     *
     * @param string $name The field name.
     * @return array
     */
    public function get_raw_field($name)
    {
        $dflt = array('keyattr'=>'name','attr1'=>'content');
        if( isset($this->_fields['**dflt**']) ) {
            $tmp = $this->_fields['**dflt**'];
            $dflt = array_merge($dflt,$tmp);
        }

        if( $name == '**dflt**' ) return $dflt;
        if( !isset($this->_fields[$name]) ) return $dflt;
        $tmp = $this->_fields[$name];
        $tmp = array_merge($dflt,$tmp);
        return $tmp;
    }

    /**
     * Get a field attribute value.
     * Some fields have more than one attribute.
     *
     * @param string $fld The field name
     * @param string $attr The attribute name (usually "content")
     * @param string $val The attribute value.
     */
    public function set_field_attr($fldname,$attr,$val)
    {
        $fldname = (string) $fldname;
        $attr = (string) $attr;
        $val = (string) $val;
        if( !$fldname || !$attr || (!$val && $val !== '0') ) return;

        $flddef = $this->get_raw_field($fldname);
        foreach( $flddef as $key => $tmp ) {
            if( !startswith($key,'attr') ) continue;
            $attrname = $flddef[$key];
            if( $attr != $attrname ) continue;

            if( !isset($this->_data[$fldname]) ) $this->_data[$fldname] = array();
            $this->_data[$fldname][$attr] = $val;
        }
    }

    /**
     * Get a field attribute value.
     * Some fields have more than one attribute.
     *
     * @param string $fld The field name
     * @param string $attr The attribute name
     * @param string $dflt The default value to return
     * @return string
     */
    public function get_field_attr($fld,$attr = 'content',$dflt = null)
    {
        $fld = (string) $fld;
        $attr = (string) $attr;
        $val = null;
        if( isset($this->_data[$fld]) ) {
            if( isset($this->_data[$fld][$attr]) ) {
                $val = $this->_data[$fld][$attr];
            }
        }
        $rec = $this->get_raw_field($fld);

        if( !$val ) {
            // gotta get a default value
            if( !$dflt ) {
                // find a dflt through configs.
                if( array_search($attr,$rec) == 'attr1' ) {
                    $dflt = \cge_param::get_string($this->_config,'cghm_'.$fld);
                    $fld2 = str_replace(' ','-',$fld);
                    $dflt = \cge_param::get_string($this->_config,'cghm_'.$fld2,$dflt);
                }
                $dflt = \cge_param::get_string($this->_config,'cghm_'.$attr.'_'.$fld,$dflt);
            }
            if( !$dflt ) {
                // find a default through the field attribs
                $t_key = array_search($attr,$rec);
                if( $t_key && strlen($t_key) == 5 ) {
                    $t_key = 'dflt'.substr($t_key,4);
                    if( isset($rec[$t_key]) ) $dflt = $rec[$t_key];
                }
            }
            if( !$dflt ) return;

            // treat the dflt as a template (cuz it prolly is)
            $smarty = \Smarty_CMS::get_instance();
            $tpl = $smarty->createTemplate('string:'.$dflt);
            $tpl->assign('content_obj',\cms_utils::get_current_content());
            $tpl->assign('config',$this->_config);
            $val = $tpl->fetch();
        }

        if( $val ) {
            $t_attr = \cge_param::get_string($rec,'isfile');
            if( $t_attr == $attr && !\cge_param::get_bool($rec,'noattrs') ) {
                // resolve absolute url to absolute file
                $fn = $val;
                $config = \cms_config::get_instance();
                if( startswith($val,'http') ) {
                    $fn = str_replace($config->smart_root_url(),$config['root_path'],$val);
                } else if( startswith($val,'/') ) {
                    $fn = $config['root_path'].$val;
                } else {
                    $fn = $config['root_path']."/$val";
                }
                if( !is_file($fn) ) $val = null;
            }
        }
        return $val;
    }

    /**
     * Is the field specified hidden?
     *
     * @param string $name the field name
     * @return bool
     */
    public function is_hidden($name)
    {
        if( is_array($this->_hidden) && in_array($name,$this->_hidden) ) return TRUE;

        static $hidden = null;
        if( !is_array($hidden) ) {
            $tmp = $this->str_to_array(\cge_param::get_string($this->_config,'cghm_hidden'));
            if( is_array($tmp) && count($tmp) ) $hidden = $tmp;
        }
        if( is_array($hidden) && in_array($name,$hidden) ) return TRUE;
        return FALSE;
    }

    /**
     * Render a meta tag.
     *
     * @param string $name The field name.
     */
    public function render_field($name)
    {
        if( $this->is_hidden($name) ) return;
        $fld = $this->get_raw_field($name);

        // find out how many value attributes are in the field
        if( !isset($fld['noattrs']) || $fld['noattrs'] != 1 ) {
            $out = '<'.$fld['tag'];
            $keyval = \cge_param::get_string($fld,'keyval',$name);
            $out .= ' '.$fld['keyattr'].'="'.$keyval.'"';
            foreach( $fld as $key => $recval ) {
                if( !startswith( $key, 'attr' ) ) continue;
                $idx = (int) substr($key,4);
                if( $idx < 1 ) continue;
                //$dflt = ( isset($fld['dflt'.$idx]) ) ? $fld['dflt'.$idx] : null;

                $val = trim($this->get_field_attr($name,$recval));
                if( !$val && $val !== '0' ) return; // could not find a value for this atttibute for this field.
                $out .= ' '.$fld[$key].'="'.$val.'"';
            }
            $out .= '/>';
        }
        else {
            $out = '<'.$fld['tag'].'>';
            $dflt = ( isset($fld['dflt']) ) ? $fld['dflt'] : null;
            $val = trim($this->get_field_attr($name,null,$dflt));
            $out .= $val.'</'.$fld['tag'].'>';
        }
        return $out;
    }

    /**
     * @ignore
     */
    public function generate_ga()
    {
        // generate analytics stuff
        $property_id = \cge_param::get_string($this->_config,'cghm_ga_propertyid');
        if( !$property_id ) return;
        $linkdomains = \cge_param::get_string($this->_config,'cghm_ga_linkdomains');
        if( $linkdomains ) $linkdomains = $this->str_to_array($linkdomains);
        $subdomains = \cge_param::get_bool($this->_config,'cghm_ga_subdomains');
        $domain = \cge_param::get_string($this->_config,'cghm_ga_domain');
        if( $subdomains && !$domain ) {
            $sysconfig = \cms_config::get_instance();
            $url = new \cms_url($sysconfig['root_url']);
            $domain = $url->get_host();
        }

        $tpl = $this->CreateSmartyTemplate('google_analytics.tpl');
        $tpl->assign('content_obj',\cms_utils::get_current_content());
        $tpl->assign('config',$this->_config);
        $tpl->assign('domain',$domain);
        if( count($linkdomains) ) $tpl->assign('linkdomains',$linkdomains);
        return $tpl->fetch();
    }
}
?>
