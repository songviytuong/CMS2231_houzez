<?php
namespace CGBetterForms;

class FormScanner implements IFormScanner
{
    const CAPTCHA_ATTRIBUTE = 'data-cgbf-captcha';

    private $_html;
    private $_forms = [];
    private $_inputs = [];
    private $_labels = [];
    private $_has_captcha = false;
    private $_errors;

    public function __construct( $html_contents )
    {
        $html_contents = trim( $html_contents );
        if( !$html_contents ) throw new FormScannerError('err_nocontents');
        $this->_html = $html_contents;
        $this->parse();
    }

    protected function getParentLabel(\DOMNode $node)
    {
        $node = $node->parentNode;
        if( !$node ) return;

        $name = strtolower($node->nodeName);
        if( $name != 'label' ) return;
        return $node->nodeValue;
    }

    protected function extractForm(\DOMNode $node)
    {
        $fld = new DOMFormField($node);
        return $fld;
    }

    protected function extractInput(\DomNode $node)
    {
        $fld = new DOMInputField($node);
        return $fld;
    }

    protected function extractButton(\DomNode $node)
    {
        $fld = new DOMButtonField($node);
        return $fld;
    }

    protected function extractTextArea(\DomNode $node)
    {
        $fld = new DOMTextAreaField($node);
        return $fld;
    }

    protected function extractSelect(\DomNode $node)
    {
        $fld = new DOMSelectField( $node );
        foreach( $node->childNodes as $node ) {
            $name = strtolower( $node->nodeName );
            if( $name != 'option' ) continue;
            $option = new DOMSelectOption( $node );
            $fld->add_option( $option );
        }
        return $fld;
    }

    protected function extractLabel(\DOMNode $node)
    {
        $fld = new DOMLabelField( $node );
        return $fld;
    }

    protected function isCaptchaContainer(\DOMNode $node)
    {
        // look for the data-cgbf-captcha attribute
        foreach( $node->attributes as $attr ) {
            if( $attr->localName == self::CAPTCHA_ATTRIBUTE ) return TRUE;
        }
    }

    protected function extractFields(\DomNode $parent)
    {
        foreach( $parent->childNodes as $node) {
            $name = strtolower($node->nodeName);
            switch( $name ) {
            case 'div':
            case 'p':
                if( $this->isCaptchaContainer( $node ) ) $this->_has_captcha = true;
                break;
            case 'form':
                $rec = $this->extractForm( $node );
                $this->_forms[] = $rec;
                break;
            case 'input':
                $rec = $this->extractInput( $node );
                $this->_inputs[] = $rec;
                break;
            case 'button':
                $rec = $this->extractButton( $node );
                $this->_inputs[] = $rec;
                break;
            case 'textarea':
                $rec = $this->extractTextArea( $node );
                $this->_inputs[] = $rec;
                break;
            case 'select':
                $rec = $this->extractSelect( $node );
                $this->_inputs[] = $rec;
                break;
            case 'label':
                $rec = $this->extractLabel( $node );
                if( $rec ) $this->_labels[] = $rec;
                break;
            }
            if( $node->hasChildNodes() ) $this->extractFields( $node );
        }
    }

    protected function setLabels( array $inputs, array $labels )
    {
        // given an array of inputs, and labels.. for inputs with id's.. set the label element
        foreach( $inputs as &$input ) {
            if( !($id = $input->get_attribute('id')) ) continue;
            foreach( $labels as $label ) {
                $for = $label->get_attribute('for');
                if( $label->get_attribute('for') == $id ) {
                    $input->set_label($label->get_value());
                    break;
                }
            }
        }
        return $inputs;
    }

    protected function parse_errors( array $errors = null )
    {
        if( !count($errors) ) return;
        $out = [];
        foreach( $errors as $obj ) {
            switch( $obj->level ) {
            case LIBXML_ERR_WARNING:
                $out[] = sprintf("WARNING: %s at about line %d column %d",trim($obj->message),$obj->line,$obj->column);
                break;
            case LIBXML_ERR_ERROR:
                if( $obj->code == 801 ) {
                    $out[] = sprintf("ERROR: %s at about line %d column %d.  (PHP's libxml does not understand HTML5 elements)",trim($obj->message),$obj->line,$obj->column);
                }
                else {
                    $out[] = sprintf("ERROR: %s at about line %d column %d",trim($obj->message),$obj->line,$obj->column);
                }
                break;
            case LIBXML_ERR_FATAL:
                $out[] = sprintf("FATAL: %s at about line %d column %d",trim($obj->message),$obj->line,$obj->column);
                break;
            default:
                $out[] = sprintf("NOTICE: %s at about line %d column %d",trim($obj->message),$obj->line,$obj->column);
                break;
            }
        }
        return $out;
    }

    protected function parse()
    {
        // note: may need to setup an error handler here that throws exceptions
        $dom = new \DomDocument();
        $orig = ini_get('display_errors');
        @ini_set('display_errors',0);
        libxml_use_internal_errors(true);
        $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $this->_html );
        $this->_errors = $this->parse_errors(libxml_get_errors());
        $this->extractFields( $dom );
        $this->_inputs = $this->setLabels( $this->_inputs, $this->_labels );
        @ini_set('display_errors',$orig);
    }

    public function get_errors()
    {
        return $this->_errors;
    }

    public function get_forms()
    {
        return $this->_forms;
    }

    public function get_fields()
    {
        return $this->_inputs;
    }

    public function has_captcha()
    {
        // note... only detects if captcha is detected across the whole template.
        // not individual forms if there are multiple forms (which is invalid anyways)
        return $this->_has_captcha;
    }
} // end of class