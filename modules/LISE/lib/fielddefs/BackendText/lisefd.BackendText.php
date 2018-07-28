<?php
class lisefd_BackendText extends LISEFielddefBase
{
  private $_opts = array();
  
	public function __construct(&$db_info, $caller_object) 
	{	
		parent::__construct($db_info, $caller_object);
    		
		$this->SetFriendlyType($this->ModLang('fielddef_BackendText'));
	}
  
  public function GetOptions()
  {
    $this->_opts['txt'] = $this->GetOptionValue('txt', '');
    
    $this->_opts['container_div'] = array(
                                            'none'        => lang('none'),
                                            'green'       => $this->ModLang('green'),
                                            'yellow'      => $this->ModLang('yellow'),
                                            'red'         => $this->ModLang('red'),
                                            'information' => $this->ModLang('fielddef_BT_information'),
                                            'warning'     => $this->ModLang('fielddef_BT_warning')
                                          );
                                          
    $this->_opts['container_div_sel'] = $this->GetOptionValue('container_div_sel', 'none');
    
    return $this->_opts;
  }

	public function RenderInput($id, $returnid)
	{
    $cont_div_opt = $this->GetOptionValue('container_div_sel', 'none');
    $value = $this->GetOptionValue('txt', '');
    
    switch ($cont_div_opt) 
    {
      case 'green':
      case 'yellow':
      case 'red':
      case 'information':
      case 'warning':
        $txt = '<p class="pagetext"><div class="' . $cont_div_opt . '" id="' . $this->GetAlias() . '">' . $value . '</div></p>';         
      break;
      
      default:
        $txt = '<p class="pagetext">' . $value . '</p>';   
    }

		return $txt;
	}
}