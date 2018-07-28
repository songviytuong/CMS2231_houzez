<?php
namespace CGBetterForms;

class FormFieldConverter
{
    const TYPE_TEXT  = 'text';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_HIDDEN = 'hidden';
    const TYPE_DATE = 'date';
    const TYPE_NUMBER = 'number';
    const TYPE_SELECT = 'select';
    const TYPE_FILE = 'file';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_PASSWORD = 'password';
    const TYPE_SUBMIT = 'submit';
    const TYPE_RESET = 'reset';
    const TYPE_BUTTON = 'button';
    const TYPE_COLOR = 'color';
    const TYPE_DATETIME_LOCAL = 'datetime-local';
    const TYPE_EMAIL = 'email';
    const TYPE_MONTH = 'month';
    const TYPE_SEARCH = 'search';
    const TYPE_TEL = 'tel';
    const TYPE_TIME = 'time';
    const TYPE_URL = 'url';
    const TYPE_WEEK = 'week';

    private $_fields = [];

    public function __construct( array $fields )
    {
        // we already have our messages, so here we don't care about validation
        // if there are multiple DOM fields with the same name... we get their
        // value and add them as options
        // if it is a select, we get it's options.

        $tmp = [];
        // do the magic
        foreach( $fields as $field ) {
            if( !$field instanceof DOMField ) continue;
            $name = $field->get_name();
            if( !$name ) continue;

            $is_new = null;
            $nodename = strtolower($field->get_nodename());
            if( !isset($tmp[$name]) ) {
                $is_new = true;
                $par = [];
                $par['node'] = $nodename;
                $par['name'] = $name;
                $par['type'] = $this->get_type($field);
                $par['options'] = $this->get_select_options( $field );
                $par['id'] = $field->get_attribute('id');
                $par['class'] = $field->get_attribute('class');
                $par['min'] = $field->get_attribute('min');
                $par['max'] = $field->get_attribute('max');
                $par['pattern'] = $field->get_attribute('pattern');
                $par['multiple'] = $this->is_multivalue_field( $field );
                $par['required'] = $field->has_attribute('required');
                $par['label'] = $field->get_label();
                $par['primitive'] = strtolower($field->get_attribute('data-cgbf-primitive'));
                if( !$par['primitive'] ) {
                    $par['primitive'] = 'string';
                    if( $par['type'] == 'email' ) $par['primitive'] = 'email';
                }
                $par['novalidate'] = $field->has_attribute('data-cgbf-novalidate');
                if( !$par['required'] ) $par['required'] = $field->has_attribute('data-cgbf-required');
                if( !$par['pattern'] ) $par['pattern'] = $field->get_attribute('data-cgbf-pattern');
                if( !$par['min'] ) $par['min'] = $field->get_attribute('data-cgbf-min');
                if( !$par['max'] ) $par['max'] = $field->get_attribute('data-cgbf-max');

                $extra_attrs = $this->get_field_extra_attrs( $field );
                if( $extra_attrs ) $par['extra_attribs'] = $extra_attrs;

                switch( $par['type'] ) {
                case self::TYPE_CHECKBOX:
                case self::TYPE_RADIO:
                    // override the internal label but only for the first instance of an element with this name.
                    if( ($attr = $field->get_attribute('data-cgbf-label') ) ) $par['label'] = $attr;
                    $tmp[$name] = new FormField( $par );
                    break;

                case self::TYPE_FILE:
                    $tmp[$name] = $this->create_file_field( $par, $field );
                    break;

                    // todo: should create different form field objects for radio button groups and selects and multi-selects
                default:
                    $tmp[$name] = new FormField( $par );
                    break;
                }
            }

            $obj =& $tmp[$name];
            // do we add a value for this thing, or do we add an option
            // add an option if type is radio, checkbox, button
            // othewise, add a value.
            if( in_array($obj->type,[self::TYPE_RADIO,self::TYPE_CHECKBOX,self::TYPE_BUTTON]) ) {
                // it'sa checkbox, select, or radio
                // add the value and human-readable stuff
                $parms = $field->get_attributes();
                $parms = array_merge( $parms, ['text'=>$field->get_value(),'value'=>$field->get_value(), 'hr'=>$field->get_value() ] );
                if( ($hr = $field->get_attribute('data-cgbf-human')) ) $parms['hr'] = $hr;
                if( $field->has_attribute('checked') ) $parms['selected'] = true;
                $opt = new FormMultiValueOption( $parms );
                $obj->add_option( $opt );
            }
            else {
                $value = $this->clean_value($field->get_value());
                $obj->add_value( $value );
            }
        }
        $this->_fields = $tmp;
    }

    protected function get_field_extra_attrs( DOMField $field )
    {
        $arr = $field->get_attributes_by_prefix( 'data-' );
        if( ! $arr ) return;

        $out = null;
        foreach( $arr as $key => $val ) {
            if( startswith( $key, 'data-' ) && !startswith( $key, 'data-cgbf-') ) {
                $out[$key] = $val;
            }
        }
        return $out;
    }

    protected function clean_value( $in )
    {
        if( !$in ) return;
        if( strpos('Undefined index:',$in) !== FALSE ) return;
        if( strpos('Trying to get property of non-object in',$in) !== FALSE ) return;
        return $in;
    }

    protected function create_file_field( array $par, DOMField $field )
    {
        $par['accept'] = $field->get_attribute('accept');
        $maxsize=null;
        $extensions=null;
        $data_attribs = $field->get_attributes_by_prefix('data-');
        if( count($data_attribs) ) {
            foreach( $data_attribs as $key => $value ) {
                $key = substr($key,strlen('data-'));
                switch( $key ) {
                case 'cgpf-file-accept':
                    if( !$par['accept'] ) $par['accept'] = trim($value);
                    break;
                case 'cgbf-file-maxsize':
                    $value = (int) $value;
                    if( $value > 0 ) $par['max_size'] = $value;
                    break;
                case 'cgbf-file-extension':
                    $par['extensions'] = trim($value);
                    break;
                }
            }
        }

        $out = new FormFileField( $par );
        return $out;
    }

    protected function is_multivalue_field( DOMField $field )
    {
        $name = $field->get_name();
        if( endswith( $name, '[]' ) ) return TRUE;
        if( $field->has_attribute('multiple') ) return TRUE;
    }

    protected function create_option_from_domoption( DOMSelectOption $option )
    {
        $parms = $option->get_attribs();
        $parms['text'] = $option->get_textRaw();
        $obj = new FormMultiValueOption( $parms );
        return $obj;
    }

    protected function get_select_options( DOMField $field )
    {
        if( $field instanceof DOMSelectField ) {
            $out = [];
            $options = $field->get_options();
            foreach( $options as $dom_option ) {
                $new_option = $this->create_option_from_domoption( $dom_option );
                $out[] = $new_option;
            }
            return $out;
        }
    }

    protected function get_type( DOMField $field )
    {
        switch( $field->get_nodename() ) {
        case 'select':
            return self::TYPE_SELECT;
        case 'textarea':
            return self::TYPE_TEXTAREA;
        case 'button':
            return self::TYPE_BUTTON;
        case 'input':
            $type = $field->get_attribute('type');
            switch( $type ) {
            case 'radio':
                return self::TYPE_RADIO;
            case 'checkbox':
                return self::TYPE_CHECKBOX;
            case 'hidden':
                return self::TYPE_HIDDEN;
            case 'file':
                return self::TYPE_FILE;
            case 'email':
                return self::TYPE_EMAIL;
            case 'password':
                return self::TYPE_PASSWORD;
            case 'button':
                return self::TYPE_BUTTON;
            case 'submit':
                return self::TYPE_SUBMIT;
            case 'reset':
                return self::TYPE_RESET;
            case 'number':
                return self::TYPE_NUMBER;
            case 'color':
                return self::TYPE_COLOR;
            case 'month':
                return self::TYPE_MONTH;
            case 'search':
                return self::TYPE_SEARCH;
            case 'tel':
                return self::TYPE_TEL;
            case 'time':
                return self::TYPE_TIME;
            case 'url':
                return self::TYPE_URL;
            case 'week':
                return self::TYPE_WEEL;
            case 'date':
                return self::TYPE_DATE;
            case 'datetime-local':
                return self::TYPE_DATETIME_LOCAL;
            case 'text':
            default:
                return self::TYPE_TEXT;
            }
        }
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function __set( $key, $val )
    {
        throw new \LogicException(__CLASS__.' cannot be modified this way');
    }

} // class