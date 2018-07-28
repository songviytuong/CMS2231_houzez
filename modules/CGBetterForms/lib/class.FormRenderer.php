<?php
namespace CGBetterForms;

class FormRenderer
{
    private $_mod;
    private $_dom;
    private $_form;
    private $_id;
    private $_returnid;
    private $_captcha_provider;

    public function __construct( \CGBetterForms $mod, Form $form, ICaptchaProvider $provider = null, $smarty, $id, $returnid, FormResponse $response )
    {
        // if template modified since form saved.. don't render.
        $this->_mod = $mod;
        $this->_form = $form;
        $this->_id = trim($id);
        $this->_returnid = (int) $returnid;
        $this->_error = null;
        $this->_url = $this->_mod->create_url($id,'default',$returnid, ['form'=>$form->name, 'process'=>1 ] );
        $this->_captcha_provider = $provider;

        $smarty->assign('form_data',$response);
        $html = $smarty->fetch( 'cms_template:'.$form->template_id );
        libxml_use_internal_errors(true);
        set_error_handler(function($number,$error){
		if( $number != E_NOTICE ) debug_to_log("CGBetterForms ERROR: ".$error) ;
            });
        $this->_dom = new \DomDocument;
        //$this->_dom->loadHTML( $html,  LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
        $this->_dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
        $this->alterFormTag();
        $this->addHiddenReturnid();
        $this->addHiddenFormName();
        $this->addHiddenMact();
        $this->addHiddenGuid();
        $this->addHiddenHoneyPot();
        $this->handleDataSelected();
        $this->addJavascript();
        if( $form->has_captcha && $this->_captcha_provider ) $this->addCaptchaContent();
        // todo: $this->adjustInputValues( $response );
    }

    protected function getInputsByType($type)
    {
        $type = strtolower(trim($type));
        if( !$type ) return;

        $out = [];
        $nodes = $this->_dom->getElementsByTagName( 'input' );
        if( ! $nodes ) return;
        foreach( $nodes as $node ) {
            if( strtolower($node->getAttribute('type')) == $type ) $out[] = $node;
        }
        if( count($out) ) return $out;
    }

    protected function walkDOM(\DOMNode $node, callable $func)
    {
        $func($node);
        $node = $node->firstChild;
        while( $node ) {
            $this->walkDOM($node,$func);
            $node = $node->nextSibling;
        }
    }

    protected function getAttributesArray(\DOMNamedNodeMap $map)
    {
        $out = [];
        foreach( $map as $attr ) {
            $out[$attr->nodeName] = $attr->nodeValue;
        }
        return $out;
    }

    protected function handleDataSelected()
    {
        // find nodes of type select, radio, checkbox with attribute data-cgbf-selected
        // parse the values of the attribute
        // for select.. add 'selected' attribute to each option where values match
        // for checkbox/radio add 'checked' attribute to each input node where values match
        $nodes = $this->_dom->getElementsByTagName( 'select' );
        if( $nodes ) {
            foreach( $nodes as $node ) {
                if( !($attr = $node->getAttribute('data-cgbf-selected')) ) continue;
                $this->walkDOM( $node, function(\DOMNode $in_node) use ($attr) {
                        if( $in_node->nodeName != 'option' ) return;
                        if( $in_node->getAttribute('value') == $attr ) $in_node->setAttribute('selected','selected');
                    });
            }
        }

        $nodes = $this->getInputsByType('checkbox');
        if( $nodes ) {
            foreach( $nodes as $node ) {
                if( !($attr = $node->getAttribute('data-cgbf-selected')) ) continue;
                if( $node->getAttribute('value') == $attr ) $node->setAttribute('checked','checked');
            }
        }

        $nodes = $this->getInputsByType('radio');
        if( $nodes ) {
            foreach( $nodes as $node ) {
                $tmp = $this->getAttributesArray( $node->attributes );
                if( !($attr = $node->getAttribute('data-cgbf-selected')) ) continue;
                if( $node->getAttribute('value') == $attr ) $node->setAttribute('checked','checked');
            }
        }
    }

    protected function getContentUrl()
    {
        $out = 'moduleinterface.php';
        $hm = \CmsApp::get_instance()->GetHierarchyManager();
        $node = $hm->sureGetNodeById( $this->_returnid );
        if( $node ) {
            $content_obj = $node->getContent();
            if( $content_obj ) $out = $content_obj->GetURL();
        }
        return $out;
    }

    protected function getFormNode()
    {
        $form = $this->_dom->getElementsByTagName( 'form' )->item(0);
        return $form;
    }

    protected function alterFormTag()
    {
        // find the form dom node
        $form = $this->getFormNode();
        $form->setAttribute( 'method', 'post' );
        $form->setAttribute( 'action', $this->getContentUrl() );
        $form->setAttribute( 'enctype', 'multipart/form-data' );
    }

    protected function findInput($name)
    {
        $list = $this->_dom->getElementsByTagName( 'input' );
        foreach( $list as $node ){
            $t_name = $node->getAttribute( 'name' );
            if( $t_name == $name ) return true;
        }
    }

    protected function findFileInputs()
    {
        $list = $this->_dom->getElementsByTagName( 'input' );
        $out = null;
        foreach( $list as $node ) {
            $t_type = $node->getAttribute( 'type' );
            if( strtolower($t_type) == 'file' ) $out[] = $node;
        }
        return $out;
    }

    protected function getSelectNode($name)
    {
        $list = $this->_dom->getElementsByTagName( 'select' );
        foreach( $list as $node ){
            $t_name = $node->getAttribute( 'name' );
            if( $t_name == $name ) return $node;
        }
    }

    protected function appendHTMLtoNode(\DOMNode $parent, $source)
    {
        $tmpDoc = new \DOMDocument();
        $tmpDoc->loadHTML($source);
        foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
            $node = $parent->ownerDocument->importNode($node,true);
            $parent->appendChild($node);
        }
    }

    protected function addCaptchaContent()
    {
        $xpath = new \DOMXPath( $this->_dom );
        $tmp = $xpath->query( '//@data-cgbf-captcha')->item(0);
        if( !$tmp ) return;
        $elem = $tmp->parentNode;
        if( !$elem ) return;
        $output = $this->_captcha_provider->get_captcha_display();
        if( $output) $this->appendHTMLtoNode( $elem, $output );

        $output = $this->_captcha_provider->get_captcha_inputfield();
        if( !$output ) return;

        $elem2 = null;
        $tmp = $xpath->query( '//@data-cgbf-captcha-input')->item(0);
        if( $tmp ) $elem2 = $tmp->parentNode;
        if( $elem2 ) {
            $this->appendHTMLtoNode( $elem2, $output );
        }
        else {
            $this->appendHTMLtoNode( $elem, $output );
        }
    }

    protected function addHiddenInput( $name, $val )
    {
        $elem = $this->_dom->CreateElement('input');
        $elem->setAttribute('type','hidden');
        $elem->setAttribute('name',$name);
        $elem->setAttribute('value',$val);
        $this->getFormNode()->appendChild( $elem );
    }

    protected function addInvisibleInput( $name, $val )
    {
        $elem = $this->_dom->CreateElement('input');
        $elem->setAttribute('type','text');
        $elem->setAttribute('style','display: none;');
        $elem->setAttribute('name',$name);
        $elem->setAttribute('value',$val);
        $this->getFormNode()->appendChild( $elem );
    }

    protected function addHiddenReturnId()
    {
        if( !$this->findInput('returnid') ) $this->addHiddenInput( 'returnid', $this->_returnid );
    }

    protected function addHiddenMact()
    {
        if( !$this->findInput('mact') ) {
            $mact = "CGBetterForms,{$this->_id},default,%d";
            $mact = sprintf($mact,$this->_form->display_inline);
            $this->addHiddenInput( 'mact', $mact );
        }
    }

    protected function addHiddenGuid()
    {
        if( !$this->findInput('__guid') ) {
            $guid = \cge_utils::create_guid();
            $_SESSION['CGBF_GUID_TOKEN'][$guid] = time();
            $this->addHiddenInput( '__guid', $guid );
        }
    }

    protected function addHiddenHoneyPot()
    {
        if( !$this->findInput('__hpname') ) $this->addInvisibleInput( '__hpname', '');
    }

    protected function addHiddenFormName()
    {
        if( !$this->findInput( $this->_id.'form') ) $this->addHiddenInput( $this->_id.'form', $this->_form->name );
    }

    protected function addFileScriptNode( $src )
    {
        $elem = $this->_dom->CreateElement('script');
        $elem->setAttribute('src',$src);
        $this->getFormNode()->appendChild( $elem );
        return $elem;
    }

    protected function filename_to_url( $fn )
    {
        $config = \CmsApp::get_instance()->GetConfig();
        $out = str_replace( $config['root_path'], $config['root_url'], $fn );
        return $out;
    }

    protected function addJavascript()
    {
        // if we have at least one file input field... do this.
        if( !$this->_form->use_async_upload ) return;
        $tmp = $this->findFileInputs();
        if( !$tmp ) return;

        static $have_fileupload;
        $src_everytime = $this->filename_to_url( $this->_mod->find_module_file('js/async_upload.js') );

        if( !$have_fileupload ) {
            // todo: allow use of jsrender for this.
            // only include the jquery.CGBFUploadHandler stuff once.
            $page_id = \ContentOperations::get_instance()->GetDefaultContent();
            $ajax_url = $this->_mod->create_url( 'cntnt01', 'ajax_upload', $page_id );
            $ajax_url = str_replace('amp;','',$ajax_url).'&showtemplate=false';
            $src_fileupload = $this->filename_to_url( $this->_mod->find_module_file( 'js/jquery.CGBFUploadHandler.js') );
            $elem = $this->addFileScriptNode( $src_fileupload );
            $elem->setAttribute('foo','bar');
            $elem->setAttribute('data-cgbf-uploadurl',$ajax_url);
            $have_fileupload = 1;
        }
        $this->addFileScriptNode( $src_everytime );
    }

    public function getHTML()
    {
        $out = $this->_dom->saveHTML();
        $out = preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $out);
        $out = preg_replace('~<\?xml[^>]*\?>\s*~', '', $out);
        return $out;
    }
}
