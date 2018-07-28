<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class UniqueFileDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new UniqueFileDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'folder':
        case 'filename_template':
        case 'headertemplate':
        case 'entrytemplate':
            return $this->_disp->$key;
        }
    }

    public function set_folder( $folder )
    {
        $this->_disp->set_folder( $folder );
    }

    public function set_filename_template( $filename_template )
    {
        $this->_disp->set_filename_template( $filename_template );
    }

    public function set_headertemplate( $data )
    {
        $this->_disp->set_headertemplate( $data );
    }

    public function set_entrytemplate( $data )
    {
        $this->_disp->set_entrytemplate( $data );
    }

    public function reset_templates( Form $form )
    {
        $labels = [];

        $tmp = [];
        foreach( $form->fields as $field ) {
            $name = $field->name;
            $label = $field->label;
            if( !$label ) $label = $name;
            $labels[] = $label;

            if( $field->multiple ) {
                $tmp[] = "\"{if !empty(\$$name)}{implode('+',\$$name)}{/if}\"\n";
            } else {
                $tmp[] = '"{$'.$name.'|default:\'\'}"'."\n";
            }
        }
        $this->set_headertemplate( '#'.implode(',',$labels).'{$EOL}' );
        $this->set_entrytemplate( "{strip}\n".implode(',',$tmp)."{\$EOL}{/strip}" );
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_UniqueFileDisposition');
    }

    public function get_displaystring()
    {
        return $this->_mod->Lang('display_UniqueFileDisposition',$this->folder);
    }

    public function get_settings_form_url(array $params = null)
    {
        return $this->_mod->create_url( 'm1_', 'admin_edit_ddfile_disposition', '', $params);
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof UniqueFileDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\UniqueFileDisposition';
    }

    public function handle_edit_form(array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid)
    {
        $mod = $this->_mod;

        if( !$disp_guid ) $this->reset_templates( $form );

        if( \cge_param::exists($params,'cancel') ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'reset_tpl') ) {
            $this->reset_templates( $form );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_folder(\cge_param::get_string($params,'folder'));
            $this->set_filename_template(\cge_param::get_string($params,'filename_template'));
            $this->set_headertemplate(\cge_utils::get_param($params,'headertemplate'));
            $this->set_entrytemplate(\cge_utils::get_param($params,'entrytemplate'));

            // now have the disposition object, store it.
            // todo: $this->finish_editing_session();
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_uniquefile_disposition.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->assign('tpl_help',\CGBetterForms\utils::get_form_tpl_help( $form ));
        $tpl->display();
    }
} // end of class
