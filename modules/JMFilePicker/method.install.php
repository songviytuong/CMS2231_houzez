<?php
#-------------------------------------------------------------------------
# JMFilePicker
# Version 1.0
# (c) 2016 by Fernando Morgado aka Jo Morg <jomorg@cmsmadesimple.org>
# The module's homepage is: http://dev.cmsmadesimple.org/projects/jmfilepicker/
#
# A fork of: GBFilePicker (c) 2010-2012 by Georg Busch
# maintained by Fernando Morgado AKA Jo Morg
# since 2016
#-------------------------------------------------------------------------
# Original Author: Georg Busch <georg.busch@gmx.net>
#-------------------------------------------------------------------------
#
# JMFilePicker is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
#
# CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of JMFilePicker
# JMFilePicker program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# JMFilePicker program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------

if(!function_exists('cmsms') || !is_object(cmsms())) exit;
$config = cmsms()->GetConfig();

$this->CreatePermission('Manage JMFilePicker', 'Manage JMFilePicker');
$this->CreatePermission('Use JMFilePicker', 'Use JMFilePicker');

#$this->AddEventHandler( 'Core', 'ContentPostRender', false ); // for frontend usage

$this->SetPreference('restrict_users_diraccess', false);
$this->SetPreference('show_filemanagement', false);
$this->SetPreference('show_thumbfiles', false);
$this->SetPreference('allow_scaling', true);
$this->SetPreference('scaling_width', '');
$this->SetPreference('scaling_height', '');
$this->SetPreference('create_thumbs', true);
$this->SetPreference('allow_upscaling', false);
$this->SetPreference('use_mimetype', false);
$this->SetPreference('feu_access','');

@mkdir(cms_join_path($config['previews_path'] , 'JMFilePickerThumbs'), 0755);

$this->Audit( 0, 'JMFilePicker',
	$this->Lang('installed',$this->GetVersion()));

?>
