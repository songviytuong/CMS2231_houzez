<?php

namespace CGSmartImage;

final class autoprocess_options
{
    private $_data = array('enabled'=>0,'ignore_dirs'=>null,'ignore_extensions'=>null,'include_dirs'=>null,'max_size'=>1024,'autorotate'=>1,'watermark'=>0);

    protected function __construct() {}

    public function __get($key)
    {
        if( array_key_exists($key,$this->_data) ) return $this->_data[$key];
        throw new \LogicException("$key is not a gettable member of ".__CLASS__);
    }

    public function __set($key,$val)
    {
        switch( $key ) {
        case 'ignore_dirs':
        case 'ignore_extensions':
        case 'include_dirs':
            $this->_data[$key] = trim($val);
            break;

        case 'max_size':
            $this->_data[$key] = max(100,(int) $val);
            break;

        case 'enabled':
        case 'autorotate':
        case 'watermark':
            $this->_data[$key] = \cge_utils::to_bool($val);
            break;
        }
    }

    protected function get_dirlist($str)
    {
        $tmp = trim($str);
        if( !$tmp ) return;

        $list_1 = explode("\n",$str);
        $out = array();
        foreach( $list_1 as $list_item ) {
            $list_item = trim($list_item);
            if( !$list_item ) continue;
            if( !is_dir($list_item) ) continue;
            if( !in_array($list_item,$out) ) $out[] = $list_item;
        }
        if( count($out) ) return $out;
    }

    public function get_include_dirs()
    {
        static $_out;
        if( !$_out ) $_out = $this->get_dirlist($this->include_dirs);
        return $_out;
    }

    public function get_exclude_dirs()
    {
        static $_out;
        if( !$_out ) $_out = $this->get_dirlist($this->ignore_dirs);
        return $_out;
    }

    public function is_imagefile($filename)
    {
        $type = \cge_utils::get_mime_type($filename);
        $type = strtolower($type);
        if( !startswith($type,'image/') ) return FALSE;
        return TRUE;
    }

    protected function is_file_excluded($filename)
    {
        if( !$this->ignore_extensions ) return FALSE;

        static $_ext;
        if( !$_ext ) {
            $_list = array();
            $list_a = explode(',',$this->ignore_extensions);
            foreach( $list_a as $ext ) {
                $ext = strtolower(trim($ext));
                if( !$ext ) continue;
                if( !in_array($ext,$_list) ) $_list[] = $ext;
            }
        }

        $ext = strtolower(substr(strrchr($filename, '.'), 1));
        if( !$ext ) return FALSE;

        if( in_array($ext,$_list) ) return TRUE;
        return FALSE;
    }

    public function is_file_scannable($filename)
    {
        if( !is_file($filename) ) return FALSE;

        $bn = basename($filename);
        if( startswith($bn,'.') ) return FALSE;
        if( !is_writable($filename) ) return FALSE;
        if( !$this->is_imagefile($filename) ) return FALSE;
        $mtime = filemtime($filename);
        $limit = time() - 30 * 24 * 3600;
        if( $mtime < $limit ) return FALSE; // OLD files
        if( $this->is_file_excluded($filename) ) return FALSE;
        return TRUE;
    }

    public function is_dir_scannable($dir)
    {
        $dir = trim($dir);
        if( !$dir ) return FALSE;
        $bn = basename($dir);
        if( startswith($bn,'.') ) return FALSE;
        if( is_file($dir."/.nocgsi") ) return FALSE;

        $config = \cms_config::get_instance();
        $up = $config['uploads_path'];
        if( startswith( $dir, $up) ) $dir = substr($dir,strlen($up));
        $dir = ltrim($dir,'/'.DIRECTORY_SEPARATOR);
        if( !is_dir($up.'/'.$dir) ) return FALSE; // must be a real directory inside uploads path

        $include_dirs = $this->get_include_dirs();
        if( count($include_dirs) ) {
            $fnd = false;
            foreach( $include_dirs as $onedir ) {
                if( startswith($dir,$onedir) ) {
                    $fnd = true;
                    break;
                }
            }
            if( !$fnd ) return FALSE;
        }

        $exclude_dirs = $this->get_exclude_dirs();
        if( !count($exclude_dirs) ) return TRUE;

        foreach( $exclude_dirs as $onedir ) {
            if( startswith( $dir, $onedir ) ) return FALSE;
        }
        return TRUE;
    }

    public static function &load()
    {
        static $_obj;
        if( !$_obj ) {
            $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
            $tmp = $mod->GetPreference('ap_settings');
            if( $tmp ) {
                $_obj = unserialize($tmp);
            } else {
                $_obj = new self();
            }
        }
        return $_obj;
    }

    public function save()
    {
        $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
        $mod->SetPreference('ap_settings',serialize($this));
    }

    public static function delete()
    {
        $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
        $mod->RemovePreference('ap_settings');
    }
}
