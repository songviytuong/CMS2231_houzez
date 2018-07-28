<?php
#-------------------------------------------------------------------------
# Module: Quotes Made Simple
# Author: Morten Poulsen <morten@poulsen.org>
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2014 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/quotesms
#-------------------------------------------------------------------------
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
#-------------------------------------------------------------------------

if (!cmsms())exit;

$db =cmsms()->GetDb();
$dict = NewDataDictionary($db);

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quotegroups");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_quotegroups_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quotes");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_quotes_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quotetemplates");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_quotetemplates_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quoteconnections");
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_quoteprops");
$dict->ExecuteSQLArray($sqlarray);

$this->RemovePermission("managequotes");

#
# EOF
#
?>