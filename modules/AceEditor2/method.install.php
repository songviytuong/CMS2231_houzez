<?php
/**
 *
 * Copyright:
 *
 * MajorLabel - Guido Goluke
 * Web: www.majorlabel.nl
 * Email: info@majorlabel.nl
 *
 *
 * Authors:
 *
 * Guido Goluke, <info@majorlabel.nl>
 *  
 *
 * License:
 *-------------------------------------------------------------------------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
 *
 * ------------------------------------------------------------------------- */

if( !defined('CMS_VERSION') ) exit;
$this->CreatePermission(AceEditor2::MANAGE_PERM,'Manage Ace Editor 2');

$db = $this->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$flds = "
id I KEY AUTO,
editor_width_type X,
editor_width_px X,
editor_width_pc X,
editor_height_px X,
editor_css_prefmode X
";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.'mod_ace_editor2',$flds,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Create the first and only line in the table, used to store the preferences
$db 			= \cms_utils::get_db();
$sql 			= 'INSERT INTO '.CMS_DB_PREFIX.'mod_ace_editor2 (editor_width_type, editor_width_px, editor_width_pc, editor_height_px, editor_css_prefmode) VALUE (?,?,?,?,?)';
$startvalues	= array('pc','800','95','600','css');
$db->Execute($sql, $startvalues);