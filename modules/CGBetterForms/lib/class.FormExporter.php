<?php
namespace CGBetterForms;


class FormExporter
{
    private $_form;

    public function __construct( Form $form )
    {
        $this->_form = $form;
    }

    public function download()
    {
        $get_classnames = function( array $in = null ) {
            if( is_null($in) ) return;
            $out = null;
            foreach( $in as $one ) {
                if( !is_object($one) ) continue;
                $out[] = get_class( $one );
            }
            return array_unique($out);
        };

        $tpl = \CmsLayoutTemplate::load( $this->_form->template_id );
        $delim = '~~~';
        $arr = [];
        $arr[0] = 'CGBF';
        $arr[1] = '1';
        $arr[2] = base64_encode( $this->_form->name );
        $template_data = base64_encode($tpl->get_content());
        $form_data = base64_encode( serialize($this->_form) );
        $salt_template = md5($form_data);
        $salt_form = md5($template_data);
        $arr[3] = md5($template_data.$salt_template);
        $arr[4] = md5($form_data.$salt_form);
        $arr[5] = $form_data;
        $arr[6] = $template_data;
        $validation_list = $get_classnames( $this->_form->validations );
        $arr[7] = base64_encode( serialize( $validation_list) );
        $disposition_list = $get_classnames( $this->_form->dispositions );
        $arr[8] = base64_encode( serialize( $disposition_list) );
        $arr[9] = base64_encode( $tpl->get_name() );

        $data = implode( $delim, $arr );
        \cge_utils::send_data_and_exit( $data, 'text/plain', $this->_form->name.'.cgbf');
    }
} // class