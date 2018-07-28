<?php
namespace CGBetterForms;

class TemplateFormScanner extends FormScanner
{
    private $_tpl_obj;

    public function __construct( \Smarty_CMS $smarty, \CmsLayoutTemplate $template )
    {
        $this->_tpl_obj = $template;

        $orig = ini_get('display_errors');
        @ini_set('display_errors',0);
        $smarty->assign('form_data',new DummyFormResponse());
        $html = $smarty->fetch('cms_template:'.$template->get_name() );
        parent::__construct( $html );
        @ini_set('display_errors',$orig);
    }

    public function get_template_contents()
    {
        return $this->_tpl_obj->get_content();
    }

    public function get_fields()
    {
        $fields = parent::get_fields();
        $out = [];
        foreach( $fields as $field ) {
            if( $field->get_attribute('name') == 'mact' ) continue;
            if( $field->get_attribute('name') == CMS_SECURE_PARAM_NAME ) continue;
            $out[] = $field;
        }
        return $out;
    }
} // end of class


/* a simple form response object to use in the template scanner */
class DummyFormResponse
{
    public function __get( $key )
    {
        return '';
    }
}