<?php
namespace CGBetterForms;
use \CGBetterForms\Dispositions\Disposition;
use \CGBetterForms\FieldValidators\Validation;

class Form
{
    private $_id;
    private $_name;
    private $_template_id;
    private $_tpl_modified; // the date the template was last modified
    private $_description;
    private $_field_messages = [];
    private $_fields = [];
    private $_prerender_logic;
    private $_finalaction;
    private $_finalmsg;
    private $_finalpage;
    private $_dispositions;
    private $_validations; // user added validations
    private $_has_captcha;
    private $_created;
    private $_modified;
    private $_display_inline;
    private $_email_from_addr;
    private $_email_from_name;
    private $_cgbf_version;
    private $_use_async_upload;

    protected function setValue($key,$val)
    {
        $key = trim($key);
        $kkey = '_'.$key;

        switch( $key ) {
        case 'id':
            $this->$kkey = (int) $val;
            break;

        case 'name':
        case 'description':
        case 'email_from_addr':
        case 'email_from_name':
        case 'cgbf_version';
            $this->$kkey = trim($val);
            break;

        case 'has_captcha':
        case 'display_inline':
        case 'use_async_upload':
            $this->$kkey = cms_to_bool($val);
            break;

        case 'template_id':
            $val = (int) $val;
            if( $val < 1 ) throw new \LogicException('Invalid template_id provided to '.__CLASS__);
            $this->$kkey = $val;
            break;

        case 'field_messages':
            if( !is_array($val) ) throw new \LogicException('Invalid field_messagess array provided to '.__CLASS__);
            $this->field_messages = [];
            foreach( $val as $one ) {
                $this->field_messages[] = trim($one);
            }
            break;

        case 'fields':
            if( !is_array($val) ) throw new \LogicException('Invalid fields array provided to '.__CLASS__);
            foreach( $val as $one ) {
                if( !$one instanceof FormField ) {
                    throw new \LogicException('Invalid fields array provided to '.__CLASS__);
                }
            }
            $this->$kkey = $val;
            break;

        case 'validations':
            if( !is_array($val) ) throw new \LogicException('Invalid validations array provided to '.__CLASS__);
            foreach( $val as $one ) {
                if( !$one instanceof Validation ) {
                    throw new \LogicException('Invalid validations array provided to '.__CLASS__);
                }
            }
            $this->$kkey = $val;
            break;

        case 'dispositions':
            if( !is_array($val) ) throw new \LogicException('Invalid dispositions array provided to '.__CLASS__);
            foreach( $val as $one ) {
                if( !$one instanceof IDisposition ) {
                    throw new \LogicException('Invalid dispositions array provided to '.__CLASS__);
                }
            }
            $this->$kkey = $val;
            break;

        case 'finalaction':
        case 'prerender_logic':
        case 'finalmsg':
            $this->$kkey = trim($val);
            break;

        case 'finalpage':
        case 'tpl_modified':
        case 'created':
        case 'modified':
            $this->$kkey = (int)$val;
            break;
        }
    }

    public function __construct(array $data = null)
    {
        $this->_finalaction = 'message';
        if( !is_array($data) ) return;
        foreach( $data as $key => $val ) {
            $this->adjustWith( $data );
        }
    }

    public function __clone()
    {
        $this->_id = $this->_name = null;
        $this->_created = $this->_modified = null;
    }

    public function __get($key)
    {
        $key = trim($key);
        $kkey = '_'.$key;

        switch( $key ) {
        case 'name':
        case 'description':
        case 'email_from_addr':
        case 'email_from_name':
        case 'finalaction':
        case 'prerender_logic':
        case 'finalmsg':
        case 'cgbf_version':
            return trim($this->$kkey);

        case 'id':
        case 'template_id':
            return (int) $this->$kkey;

        case 'has_captcha':
        case 'display_inline':
        case 'use_async_upload':
            return (bool) $this->$kkey;

        case 'field_messages':
        case 'fields':
        case 'validations':
        case 'dispositions':
            return $this->$kkey;

        case 'finalpage':
        case 'tpl_modified':
        case 'created':
        case 'modified':
            return (int) $this->$kkey;
        }
    }

    /**
     * Allows adjusting the form id, created and modified dates.
     * @ignore
     */
    public function adjustPrivate(array $data)
    {
        foreach( $data as $key => $val ) {
            $this->setValue( $key, $val );
        }
        return $this;
    }

    public function adjustWith(array $data)
    {
        foreach( $data as $key => $val ) {
            if( $key == 'id' ) continue; // can't be set at runtime.
            if( $key == 'created' ) continue; // can't be set at runtime.
            if( $key == 'modified' ) continue; // can't be set at runtime.
            $this->setValue( $key, $val );
        }
        return $this;
    }

    public function setField(FormField $field)
    {
        if( is_array($this->_fields) && count($this->_fields) ) {
            foreach( $this->_fields as &$e_field ) {
                if( $e_field->name == $field->name ) {
                    $e_field = $field;
                    return;
                }
            }
        }
        // it's an add
        $this->_fields[] = $field;
    }

    public function setValidation( Validation $obj )
    {
        $this->_validations[$obj->get_guid()] = $obj;
    }

    public function getValidation( $guid )
    {
        if( isset($this->_validations[$guid]) ) return $this->_validations[$guid];
    }

    public function hasValidation( $classname )
    {
        if( !count($this->_validations) ) return;
        foreach( $this->_validations as $guid => $obj ) {
            if( get_class($obj) == $classname ) return TRUE;
        }
    }

    public function removeValidation( $guid )
    {
        if( isset($this->_validations[$guid]) ) unset($this->_validations[$guid]);
    }

    public function setDisposition( Disposition $obj )
    {
        $this->_dispositions[$obj->get_guid()] = $obj;
    }

    public function getDisposition( $guid )
    {
        if( isset($this->_dispositions[$guid]) ) return $this->_dispositions[$guid];
    }

    public function removeDisposition( $guid )
    {
        if( isset($this->_dispositions[$guid]) ) unset($this->_dispositions[$guid]);
    }

    public function orderDispositions( array $guid_list )
    {
        if( !count($guid_list) ) return;
        if( count($guid_list) != count($this->_dispositions) ) throw new \LogicException('Invalid data passed to '.__METHOD__);

        $new_list = [];
        foreach( $guid_list as $one_guid ) {
            if( !isset($this->_dispositions[$one_guid]) ) throw new \LogicException('Invalid data passed to '.__METHOD__);
            $obj = $this->_dispositions[$one_guid];
            $new_list[$one_guid] = $obj;
        }
        $this->_dispositions = $new_list;
    }

    public function orderValidations( array $guid_list )
    {
        if( !count($guid_list) ) return;
        if( count($guid_list) != count($this->_validations) ) throw new \LogicException('Invalid data passed to '.__METHOD__);

        $new_list = [];
        foreach( $guid_list as $one_guid ) {
            if( !isset($this->_validations[$one_guid]) ) throw new \LogicException('Invalid data passed to '.__METHOD__);
            $obj = $this->_validations[$one_guid];
            $new_list[$one_guid] = $obj;
        }
        $this->_validations = $new_list;
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function get_field( $name )
    {
        foreach( $this->fields as $field ) {
            $t_name = $field->name;
            if( $t_name == $name ) return $field;
            if( $t_name == $name.'[]' ) return $field;
        }
        throw new \LogicException('Could not find a field with name '.$name.' in field list');
    }

    public function get_fieldnames()
    {
        $names = [];
        foreach( $this->fields as $field ) {
            $name = $field->name;
            if( endswith($name,'[]') ) $name = substr($name,0,-2);
            if( !in_array($name,$names) ) $names[] = $name;
        }
        return $names;
    }

    public function get_field_list()
    {
        $out = [];
        foreach( $this->fields as $field ) {
            $multiple = false;
            $name = $field->name;
            if( endswith($name,'[]') ) {
                $name = substr($name,0,-2);
                $multiple = true;
            }
            if( $field->multiple ) $multiple = true;
            if( array_key_exists($name,$out) ) continue;
            $str = $name;
            if( $multiple ) $str .= "[]";
            $str .= ' ('.$field->type.')';
            $out[$name] = $str;
        }
        return $out;
    }

    public function list_fields_by_type($type)
    {
        $out = [];
        foreach( $this->fields as $field ) {
            if( $field->type != $type ) continue;
            $out[] = $field->name;
        }
        return $out;
    }

    public function is_file_field( $name )
    {
        $name = trim($name);
        if( !$name ) return;

        if( startswith($name,'cgbf_') ) return FALSE;
        $field = $this->get_field( $name );
        $res = ( $field && $field->type == 'file' );
        return $res;
    }

    /**
     * Given a field name and a field value,  lookup any human-readable equivalent value.
     * This is useful in output displays (emails, web frontends) etc.   i.e:  Display 'f' as 'Female' and 'm' as 'Male',
     * This method is only really useful when the field_name represents a select, or radio button group or checkbox group.
     *
     * If multiple values are passed in, then an attempt will be made to get an array of human readable values.
     *
     * @param string $field_name The field name
     * @param string|string[] $field_value The value for
     * @return string|string[]
     */
    public function get_human_readable_field_value( $field_name, $field_value )
    {
        if( startswith($field_name,'cgbf_') ) return $field_value;
        $field_name = trim($field_name);
        $field_value = trim($field_value);
        if( !$field_name ) throw new \LogicException('Invalid field name passed to '.__METHOD__);
        IF( !$field_value ) return;

        $field = $this->get_field( $field_name );
        if( ! $field->has_multiple_options() ) return $field_value;

        if( !is_array( $field_value ) ) {
            $opt = $field->get_option_by_value( $field_value );
            if( !$opt ) return;
            return $opt->hr;
        }

        // $field_val is an array. must return an array
        $out = [];
        foreach( $field_value as $one ) {
            $opt = $field->get_option_by_value( $one );
            if( !$opt ) continue;
            $out[] = $opt->hr;
        }
        return $out;
    }

    public function list_fields_by_type_or_primitive($type,$prim,$allow_multiple = false)
    {
        $type = strtolower(trim($type));
        $prim = strtolower(trim($prim));
        $out = [];
        foreach( $this->fields as $field ) {
            if( $field->type != $type && $field->primitive != $prim ) continue;
            if( $field->multiple && !$allow_multiple ) continue;
            $str = $field->name;
            if( $field->multiple ) $str .= '[]';
            $str .= ' ('.$field->type.')';
            $out[$field->name] = $str;
        }
        return $out;
    }

    public function list_multioption_fields( $multiple_okay = FALSE )
    {
        $out = [];
        foreach( $this->fields as $field ) {
            if( !$field->has_multiple_options() ) continue;
            if( !$multiple_okay && $field->multiple ) continue;
            $out[] = $field->name;
        }
        return $out;
    }

    public function get_multioption_fields( $multiple_okay = FALSE )
    {
        // fields are multi-option fieldss IF they occur multiple types, and they are radio
        // OR they are a select.
        $out = $tmp = [];
        foreach( $this->fields as $field ) {
            if( !$multiple_okay && $field->multiple ) continue;
            if( !$field->has_multiple_options() ) continue;
            $str = $field->name;
            if( $field->multiple ) $str .= "[]";
            $str .= " ({$field->type})";
            $out[$field->name] = $str;
        }
        return $out;
    }

    public function is_multivalue_field($name)
    {
        // a field is a multi-value field IF it's name ends with []
        foreach( $this->fields as $field ) {
            if( $field->name != $name  ) continue;
            return $field->multiple;
        }
        throw new \LogicException('Could not find a field with name '.$name.' in field list');
    }

    /**
     * Given a response, validate it against all validations, and call a hook.
     *
     * @param FormResponse $response The populated response object
     * @param TRanslator $translator The object for translating messages.
     * @return string[]|null A list of error messages created by accumulating messages caught by ValidationException errors.
     */
    public function validate_response( FormResponse $response, Translator $translator )
    {
        $errors = null;
        $validations = $this->validations;
        $validations[] = new FieldValidators\HookValidator();
        foreach( $validations as $validation ) {
            try {
                $validation->validate( $this, $response, $translator );
            }
            catch( FieldValidators\ValidationException $e ) {
                $errors[] = $e->GetFieldError();
            }
        }
        return $errors;
    }

    /**
     * Use all dispositions attached to a form, and call them.
     * This method assumes that all validations have already passed.
     * This method DOES NOT process the final action options.
     *
     * @param FormResponse $response
     */
    public function dispose_response_novalidate( FormResponse $response )
    {
        $dispositions = $this->dispositions;
        if( $response->has_uploads() ) {
            // special disposition to move uploaded files to a more permanent location (named by GUID)
            // this disposition is prepended to the list.
            $disp = new Dispositions\GUIDFileDisposition();
            array_unshift( $dispositions, $disp );
        }
        // append a hook disposition
        $dispositions[] = new Dispositions\HookDisposition();
        foreach( $dispositions as $disp ) {
            try {
                $disp->dispose( $this, $response );
            }
            catch( \CGBetterForms\StopDispositionTrigger $e ) {
                // woot, we stop handling stuff.
                break;
            }
        }
    }

    /**
     * This method is responsible for cleaning up after a form is disposed.
     * This method is called after disposition, but before the final action.
     */
    public function cleanup_response( FormResponse $response )
    {
        if( $response->can_cleanup() ) \CMSMS\HookManager::do_hook( 'CGBetterForms::cleanup', $response );
    }

    /**
     * This method is used to perform a final action after the form is disposed and cleaned up.
     * It may redirect to a content page, or may return a string to display in the primary content area.
     *
     * This method may not be called in a form disposition if another dispostion results in a redirect.
     *
     * @param FormResponse $response
     * @return string
     */
    public function do_final_action( FormResponse $response )
    {
        // this is just basically a disposition.
        switch( $this->finalaction ) {
        case 'redirect':
            if( $response->final_url ) {
                redirect( $response->final_url );
                return;
            }
            $mod = \cms_utils::get_module('CGBetterForms');
            $mod->RedirectContent( $this->finalpage );
            break;

        default:
        case 'message':
            $template = $this->finalmsg;
            return utils::process_template( $template, $this, $response );
        }

    }
} // end of class
