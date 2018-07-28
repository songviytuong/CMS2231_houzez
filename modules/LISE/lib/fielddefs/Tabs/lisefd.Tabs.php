<?php

class lisefd_Tabs extends LISEFielddefBase
{
	public function __construct(&$db_info, $caller_object) 
	{	
		parent::__construct($db_info, $caller_object);
		
		$this->SetFriendlyType($this->ModLang('fielddef_Tabs'));
	}

	public function closeTab()
	{
		return '</div>';
	}

	public function displayTabHeader()
	{
		$template = '<div id="tab{{id}}">{{label}}</div>';
		return str_replace(
			['{{id}}', '{{label}}'],
			[$this->alias, $this->name],
			$template
		);
	}

	public function RenderInput($id, $returnid)
	{
		$template = '</div><div id="tab{{alias}}_c">';
		return str_replace(
			['{{alias}}'],
			[$this->alias],
			$template
		);
	}
}