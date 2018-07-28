<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
# Version: 2.0.3
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2009 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------


class FAQ extends CMSModule
{
  
	function GetName()
	{
		return 'FAQ';
	}

	function GetFriendlyName()
	{
		return $this->GetPreference('custom_modulename', $this->Lang('friendlyname'));
	}

	function GetVersion()
	{
		return '2.0.3';
	}

	function GetHelp()
	{
    $helptxt = $this->Lang('help') . '<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_donations"><input type="hidden" name="business" value="josvd@live.nl"><input type="hidden" name="item_name" value="Jos"><input type="hidden" name="item_number" value="CMSms FAQ Module"><input type="hidden" name="currency_code" value="EUR"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1"></form><br />
<h3>Copyright and License</h3>
<p>Copyright &copy; 2013, Jos &lt;<a href="mailto:josvd@live.nl">josvd@live.nl</a>&gt;. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License v3</a>. However, as a special exception to the GPL, this software is distributed as an addon module to CMS Made Simple. You may only use this software when there is a clear and obvious indication in the admin section that the site was built with CMS Made Simple.</p>
';
		return $helptxt;
	}

	function GetAuthor()
	{
		return 'Jos';
	}

	function GetAuthorEmail()
	{
		return 'josvd@live.nl';
	}

	function GetChangeLog()
	{
		return file_get_contents(dirname(__FILE__).'/changelog.inc');
	}

	function IsPluginModule()
	{
		return true;
	}

	function HasAdmin()
	{
		return true;
	}

	function GetAdminSection()
	{
		return $this->GetPreference('admin_section', 'content');
	}

	function GetAdminDescription()
	{
		return $this->Lang('moddescription');
	}

	function VisibleToAdminUser()
	{
		return $this->CheckPermission('FAQ: Use');
	}
  
	function GetDependencies()
	{
		return array();
	}

	function MinimumCMSVersion()
	{
		return "1.11";
	}

	function InitializeFrontend()
	{
		$this->RegisterModulePlugin();
		$this->RestrictUnknownParams();

		$this->SetParameterType('entryid',CLEAN_INT);
		$this->SetParameterType('category',CLEAN_STRING);
		$this->SetParameterType('template',CLEAN_STRING);
		$this->SetParameterType('modpage',CLEAN_INT);
		
	}

	function SetParameters()
	{
		$this->CreateParameter('action', 'default', $this->Lang('help_action'));
		$this->CreateParameter('category','',$this->Lang('help_category'));
		$this->CreateParameter('template','',$this->Lang('help_template'));
	}

	function InitializeAdmin()
	{
	  $this->SetParameters();
	}

	function AllowSmartyCaching()
	{
		return TRUE;
	}

	function LazyLoadFrontend()
	{
		return TRUE;
	}

	function LazyLoadAdmin()
	{
		return TRUE;
	}

	function InstallPostMessage()
	{
		return $this->Lang('postinstall', $this->Lang('friendlyname'));
	}
  
	function GetEventDescription($eventname)
	{
		return; // $this->lang('eventdesc_' . $eventname);
	}

	function GetEventHelp($eventname)
	{
		return; // $this->lang('eventhelp_' . $eventname);
	}
	
	function SearchResult($returnid, $entry_id, $attr = '')
	{
		$result = array();

		if ($attr == 'entry')
		{
			$entry = FAQ_utils::GetEntry($entry_id);
			if ( $entry )
			{
				//0 position is the prefix displayed in the list results.
				$result[0] = $this->GetFriendlyName();

				//1 position is the title
				$result[1] = $entry->question;

				//2 position is the URL to the title.
				$prettyurl = ''; //'faq/' . $entry_id . '/' . $returnid;
				$result[2] = $this->CreateLink('cntnt01', 'detail', $returnid, '', array('entryid' => $entry_id) ,'', true, false, '', true, $prettyurl);
			}
		}
		return $result;
	}

	function SearchReindex(&$module)
	{
		$db = cmsms()->GetDB();
		$query = "SELECT
								entry_id, question, answer
							FROM
								" . cms_db_prefix() . "module_faq_entries
							WHERE
								active=1";
		$result = $db->Execute($query);
		if ( $result && $result->RecordCount() > 0 )
		{
			while ( $row=$result->FetchRow() )
			{
				$module->AddWords($this->GetName(), $row['entry_id'], 'entry', $row['question'] . ' ' . $row['answer']);
			}
		}
		if ( !$result )
		{
			echo 'ERROR: ' . $db->ErrorMsg();
			exit();
		}
	}
	
	function GetHeaderHTML()
	{
		$tmpl = <<<EOT
<script type="text/javascript" src="../modules/FAQ/lib/jquery/jquery.tablednd.js"></script>
<script type="text/javascript" src="../modules/FAQ/lib/faq_adminscripts.js"></script>

EOT;
		return $tmpl;
	}

/*
	public function CreateStaticRoutes()
	{
		$route = new CmsRoute('/[Ff][Aa][Qq]\/(?P<alias>[0-9]+)-(?P<gbpage>[0-9]+)\/(?P<returnid>[0-9]+)$/', $this->GetName());
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[Ff][Aa][Qq]\/(?P<entryid>[0-9]+)\/(?P<returnid>[0-9]+)$/', $this->GetName());
		cms_route_manager::add_static($route);
	}
*/
} //end class
?>
