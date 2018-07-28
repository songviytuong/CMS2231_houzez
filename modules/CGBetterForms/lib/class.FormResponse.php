<?php
namespace CGBetterForms;

class FormResponse
{
    private $_data;
    private $_files = [];
    private $_guid;
    private $_time;
    private $_can_cleanup = true;
    private $_field_names;
    private $_form_id;
    private $_modified;
    private $_form;
    private $_final_url;
    private $_translator;
    private $_honeypot_value;

    public function __construct( \CGBetterForms $mod, Form $form, $guid = null, array $input = null)
    {
        // todo: this should be a value object.
        // the gather stuff should be in a factory class/function.
        $this->_field_names = $form->get_fieldnames();
        $this->_time = time();
        $this->_form_id = $form->id;
        $this->initialize( $mod, $form, $guid );
        if( is_array($input) ) $this->gather_input( $form, $input );
        $this->_translator = $mod->get_translator();
    }

    protected function initialize( \CGBetterForms $mod, Form $form, $guid )
    {
        $this->_field_names[] = 'cgbf_submit_time';
        $this->_field_names[] = 'cgbf_submit_ip';
        $this->_field_names[] = 'cgbf_version';
        $this->_field_names[] = 'cgbf_formname';
        $this->_field_names[] = 'cgbf_formdesc';
        $this->_field_names[] = 'cgbf_requestid';
        $this->_data['cgbf_submit_time'] = $this->get_time();
        $this->_data['cgbf_submit_ip'] = \cge_utils::get_real_ip();
        $this->_data['cgbf_version'] = $mod->GetVersion();
        $this->_data['cgbf_formname'] = $form->name;
        $this->_data['cgbf_formdesc'] = $form->description;
        $this->_data['cgbf_requestid'] = $guid;
        $this->_guid = $guid;
    }

    protected function clean_input($item)
    {
        $item = trim($item);
        $item = cleanValue($item);
        return cms_html_entity_decode($item);
    }

    protected function gather_async_uploads( Form $form, array $input )
    {
        $guid = $this->_guid;
        $tmp_location = TMP_CACHE_LOCATION.'/'.$guid;
        if( !is_dir( $tmp_location ) ) return;

        $out = [];
        foreach( $form->fields as $field ) {
            if( $field->type != 'file' ) continue;
            if( empty( $input[$field->name] ) ) continue; // no async uploads

            if( is_array($input[$field->name]) ) {
                $arr = [];
                foreach( $input[$field->name] as $str ) {
                    list($tmp_name,$dest_name) = explode(':|:',$str);
                    if( !$tmp_name || !$dest_name ) continue;
                    $tmp_file = $tmp_location.'/'.$tmp_name;
                    if( !is_file( $tmp_file ) ) continue;
                    $rec = ['tmp_name'=>$tmp_name, 'name'=>$dest_name, 'error'=>0, 'size'=>filesize( $tmp_file ), 'mime_type'=>\cge_utils::get_mime_type( $tmp_file ) ];
                    $arr[] = $rec;
                }
                if( count($arr) ) $out[$field->name] = $arr;
            } else {
                list($tmp_name,$dest_name) = explode(':|:',$input[$field->name]);
                if( !$tmp_name || !$dest_name ) continue;
                $tmp_file = $tmp_location.'/'.$tmp_name;
                if( !is_file( $tmp_file ) ) continue;
                $rec = ['tmp_name'=>$tmp_name, 'name'=>$dest_name, 'error'=>0, 'size'=>filesize( $tmp_file ), 'mime_type'=>\cge_utils::get_mime_type( $tmp_file ) ];
                $out[$field->name] = [ $rec ];
            }
        }
        return $out;
    }

    protected function gather_uploads( Form $form, array $input )
    {
        // restructures the $_FILES data into something more sane.
        $out = $this->gather_async_uploads( $form, $input );
        foreach( $_FILES as $field_name => $rec ) {
            if( is_string($rec['name']) ) {
                $out[$field_name] = [ $rec ];
            } else {
                $keys = array_keys($rec);
                $out2 = [];
                for( $i = 0; $i < count($rec['name']); $i++ ) {
                    $new_rec = [];
                    foreach( $keys as $key ) {
                        $new_rec[$key] = $rec[$key][$i];
                    }
                    $out2[] = $new_rec;
                }
                $out[$field_name] = $out2;
            }
        }
        return $out;
    }

    protected function gather_input( Form $form, array $input )
    {
        $this->_honeypot_value = md5(__FILE__);
        if( \cge_param::exists( $input, '__hpname') ) $this->_honeypot_value = \cge_param::get_string( $input, '__hpname' );

        $uploaded = $this->gather_uploads( $form, $input );
        foreach( $form->fields as $field ) {
            $name = $field->name;
            if( $field->type == 'file' ) {
                if( isset( $uploaded[$name]) ) {
                    if( !isset($uploaded[$name]) ) continue;
                    $this->_files[$name] = $uploaded[$name];
                    foreach( $uploaded[$name] as $rec ) {
                        if( $rec['error'] > 0 || $rec['size'] == 0 || $rec['error'] > 0 ) continue;
                        if( $field->multiple ) {
                            if( !isset($this->_data[$name]) ) $this->_data[$name] = [];
                            $this->_data[$name][] = $rec['name'];
                        } else {
                            $this->_data[$name] = $rec['name'];
                        }
                    }
                }
            }
            else {
                $val = null;
                if( ($data = \cge_utils::get_param( $input, $name)) ) {
                    if( is_array( $data ) ) {
                        array_walk_recursive( $data, function(&$item,$key){
                                $item = $this->clean_input($item);
                            });
                        $out = [];
                        foreach( $data as $one ) {
                            $one = trim($one);
                            if( $one ) $out[] = $one;
                        }
                        $val = $out;
                    }
                    else {
                        // single value.
                        $val = $this->clean_input($data);
                    }
                }
                $this->_data[$name] = $val;
            }
        }
    }

    public function get_form_id()
    {
        return $this->_form_id;
    }

    public function get_time()
    {
        return $this->_time;
    }

    public function get_requestid()
    {
        return $this->_guid;
    }

    public function get_translator()
    {
        return $this->_translator;
    }

    public function list_fields()
    {
        return $this->_field_names;
    }

    public function add_field( $name )
    {
        $name = trim($name);
        if( !in_array( $name, $this->_field_names ) ) $this->_field_names[] = $name;
    }

    public function can_cleanup()
    {
        return $this->_can_cleanup;
    }

    public function disable_clean()
    {
        $this->_can_cleanup = false;
    }

    public function set_final_url( $url )
    {
        // can only be set once for a response...
        // may be set from a disposition.
        $this->_final_url = $url;
    }

    public function __get($key)
    {
        $fields = $this->list_fields();
        if( in_array($key,$fields) && array_key_exists($key,$this->_data) ) return $this->_data[$key];
        switch( $key ) {
        case 'form_name':
        case 'form':
        case 'formname':
            return $this->cgbf_formname;
        case 'remote_ip':
        case 'ip_address':
        case 'ipaddress':
            return $this->cgbf_submit_ip;
        case 'submit_time':
        case 'submit_date':
        case 'date':
            return $this->cgbf_submit_time;
        case 'version':
        case 'cgbf_version':
            return $this->cgbf_version;
        case 'request_id':
        case 'guid':
        case 'cgbf_requestid':
            return $this->cgbf_requestid;
        case 'final_url':
            return $this->_final_url;
        case '__hpname':
        case 'honeypot':
            return $this->_honeypot_value;
        }
    }

    public function modify_value($key,$val)
    {
        // key is a string,  val is null|string|string[]
        $key = trim($key);
        if( !is_array($val) ) {
            $val = is_null($val) ? null : trim($val);
        }
        if( !$key ) return;

        if( !in_array($key,$this->_field_names) ) return;
        $this->_data[$key] = $val;
        $this->_modified = TRUE;
    }

    public function is_modified()
    {
        return $this->_modified;
    }

    public function list_files($name = null)
    {
        // field name
        $name = trim($name);
        if( !$name ) return $this->_files;

        if( isset($this->_files[$name]) ) return $this->_files[$name];
    }

    public function has_file($name)
    {
        // field name
        $name = trim($name);
        if( !$name ) return;

        return (bool) $this->list_files( $name );
    }

    public function has_uploads()
    {
        return (count($this->_files) > 0 );
    }

    public function get_file_as_url( $name)
    {
        // there may be multiple files for one field.
        $config = \cms_config::get_instance();
        $out = [];
        $files = $this->get_field_value( $name );
        if( !$files ) return;
        if( !is_array($files) ) $files = [ $files ];
        foreach( $files as $file ) {
            $str = str_replace('\\','/',$file);
            $url = str_replace($config['root_path'],$config['root_url'],$str);
            $out[] = $url;
        }

        if( count($out) == 1 ) return $out[0];
        return $out;
    }

    public function get_field_value( $key )
    {
        $key = trim($key);
        if( !$key ) return;

        if( array_key_exists( $key, $this->_data ) ) return $this->_data[$key];
    }

    public function as_array()
    {
        return $this->_data;
    }
} // end of class