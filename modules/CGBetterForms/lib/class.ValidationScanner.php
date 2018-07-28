<?php
namespace CGBetterForms;
use \CGBetterForms\FieldValidators;

// scans a form and fields, and determines a minimal list of validations.
class ValidationScanner
{
    private $_form;
    private $_fields;
    private $_captcha_provider;
    private $_validations;

    public function __construct( \CGBetterForms $mod, Form $form, array $fields )
    {
        $this->_form = $form;
        $this->_fields = $fields;
        $this->_captcha_provider = $mod->get_captcha_provider();

        $validations = $this->_form->validations;
        if( count( $validations ) ) {
            foreach( $validations as $guid => $obj ) {
                $class = get_class($obj);
                $this->_validations[] = $class;
            }
        }
    }

    protected function add_unique_validation( array& $out, $classname, $field = null, callable $cb = null )
    {
        if( !startswith( $classname, '\\' ) ) $classname = __NAMESPACE__.'\\'.$classname;
        if( is_array($this->_validations) && in_array( $classname, $this->_validations ) ) return;
        if( !is_callable($cb) ) {
            $obj = new $classname;
        } else {
            $obj = call_user_func( $cb, $classname, $field );
        }
        $out[] = $obj;
    }

    public function get_validations()
    {
        $out = [];
        $this->add_unique_validation( $out, 'FieldValidators\HtmlDetectionValidation' );
        $this->add_unique_validation( $out, 'FieldValidators\SelectFieldValidation' );
        if( $this->_form->has_captcha && $this->_captcha_provider ) {
            $this->add_unique_validation( $out, 'FieldValidators\CaptchaValidatorProxy', null,
                                          function( $classname, $field ) {
                                              return new $classname( $this->_captcha_provider );
                                          });
        }
        if( $this->has_required_fields() ) $this->add_unique_validation( $out, 'FieldValidators\RequiredFieldValidation' );
        if( $this->has_file_fields() ) $this->add_unique_validation( $out, 'FieldValidators\FileValidator' );
        if( $this->has_date_fields() ) $this->add_unique_validation( $out, 'FieldValidators\DatePrimitiveValidation' );
        if( $this->has_email_fields() ) $this->add_unique_validation( $out, 'FieldValidators\EmailPrimitiveValidation' );

        // now process each field individually.
        foreach( $this->_fields as $field ) {
            if( $field->novalidate ) continue;
            if( $field->pattern ) {
                // if field has pattern, add regex validation for this filed.
                $this->add_unique_validation( $out, 'FieldValidators\RegexFieldValidation', $field,
                                              function( $classname, $field ){
                                                  $obj = new $classname();
                                                  $obj->set_fieldName( $field->name );
                                                  $obj->set_pattern('|'.$field->pattern.'|');
                                                  return $obj;
                                              });
            }

            // if it's a simple primitive...  we can validate it's value  i.e:  to ensure a numeric number is input in the field
            // and then optionally validate min and max values.
            $primitive = $field->primitive;
            if( $primitive != 'float' && $primitive != 'int' ) {
                if( $field->min || $field->max ) $primitive = 'float';
            }
            switch( $primitive ) {
            case 'int':
                $this->add_unique_validation( $out, 'FieldValidators\IntegerFieldValidation', $field,
                                              function( $classname, $field ){
                                                  $obj = new $classname();
                                                  $obj->set_fieldName( $field->name );
                                                  if( $field->min ) $obj->set_minValue( (int) $field->min );
                                                  if( $field->max ) $obj->set_maxValue( (int) $field->max );
                                                  return $obj;
                                              });
                break;
            case 'float':
                $this->add_unique_validation( $out, 'FieldValidators\FloatFieldValidation', $field,
                                              function( $classname, $field ){
                                                  $obj = new FieldValidators\FloatFieldValidation();
                                                  $obj->set_fieldName( $field->name );
                                                  if( $field->min ) $obj->set_minValue( (float) $field->min );
                                                  if( $field->max ) $obj->set_maxValue( (float) $field->max );
                                                  return $obj;
                                              });
                break;
            }
        }

        if( count($out) ) return $out;
    }

    protected function has_email_fields()
    {
        foreach( $this->_fields as $field ) {
            if( $field->type == 'email' || $field->primitive == 'email' ) return TRUE;
        }
    }

    protected function has_date_fields()
    {
        foreach( $this->_fields as $field ) {
            if( $field->type == 'date' || $field->primitive == 'date' ) return TRUE;
        }
    }

    protected function has_file_fields()
    {
        foreach( $this->_fields as $field ) {
            if( $field->type == 'file' ) return TRUE;
        }
    }

    protected function has_required_fields()
    {
        foreach( $this->_fields as $field ) {
            if( $field->required ) return TRUE;
        }
    }
}