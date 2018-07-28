<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

$entry_id = $params['entryid'];
$lang = cms_current_language();

$entry = FAQ_utils::GetEntry($entry_id);

if ( !empty($entry) )
{
	$smarty->assign('faq_entry', $entry);

	// get template
	$template = $this->GetPreference('default_detail_template');
	if ( !empty($params['template']) && $params['template'] != $template )
	{
		$template = 'detail_tpl_' . $params['template'];
	}

	// clear cache for this template
	$smarty->clearCache($this->GetDatabaseResource($template));

	echo $this->ProcessTemplateFromDatabase($template);
}

?>