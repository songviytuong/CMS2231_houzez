<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2
# A fork of ListI2
# maintained by Fernando Morgado AKA Jo Morg
# since 2015
#-------------------------------------------------------------------------
#
# Original Author: Ben Malen, <ben@conceptfactory.com.au>
# Co-Maintainer: Simon Radford, <simon@conceptfactory.com.au>
# Web: www.conceptfactory.com.au
#
#-------------------------------------------------------------------------
#
# Maintainer since 2011 up to 2014: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2012 and stopped at 2014:
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# Goran Ilic, <uniqu3e@gmail.com>
# Web: www.ich-mach-das.at
#
#-------------------------------------------------------------------------
#
# LISE is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of LISE
# LISE program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# LISE program is distributed in the hope that it will be useful,
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

class LISEItemOperations {
    #---------------------
    # Variables
    #---------------------	

    public static $identifiers = array(
        'item_id' => 'item_id',
        'alias' => 'alias',
        'key1' => 'key1',
        'key2' => 'key2',
        'key3' => 'key3',
        'url' => 'url'
    );

    #---------------------
    # Magic methods
    #---------------------		

    private function __construct() {
        
    }

    #---------------------
    # Database methods
    #---------------------	

    static final public function Save(LISE &$mod, LISEItem &$obj, $mleblock = "") {
        
        $db = cmsms()->GetDb();
        $counter = count_language($mod->_GetModuleAlias());
        $checked = active_languages();
        if ($counter == false || $checked == false || $mleblock == '_en') {
            $mleblock = "";
        }
        
        Events::SendEvent($mod->GetName(), 'PreItemSave', array('item_object' => &$obj));

        // Check against mandatory list
        foreach (LISEItem::$mandatory as $rule) {
            if ($obj->$rule == '')
                return;
        }

        //$time = $db->DBTimeStamp(time());

        $sql_start_time = $obj->start_time ? date('Y-m-d', strtotime($obj->start_time)) : NULL;
        $sql_end_time = $obj->end_time ? date('Y-m-d', strtotime($obj->end_time)) : NULL;

        // Ensure that we have alias
        if ($obj->alias == '') {
            $obj->alias = munge_string_to_url($obj->title, true);
        }

        // Try grabbing owner if not set
        if (is_null($obj->owner)) {
            $loggedin = get_userid(false);
            if ($loggedin)
                $obj->owner = $loggedin;
        }
        // Existing item	
        if ($obj->item_id > 0) {
            // update item
            $query = 'UPDATE ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item 
					SET `title' . $mleblock . '` = ?,`desc' . $mleblock . '` = ?, alias = ?, active = ?, start_time = ?, end_time = ?, modified_time = NOW(), `key1' . $mleblock . '` = ?, `key2' . $mleblock . '` = ?, `key3' . $mleblock . '` = ?, owner = ?, url = ? 
					WHERE item_id = ?';

            $terms = array(
                $obj->title,
                $obj->desc,
                $obj->alias,
                //$obj->category_id,
                $obj->active,
                $sql_start_time,
                $sql_end_time,
                $obj->key1,
                $obj->key2,
                $obj->key3,
                $obj->owner,
                $obj->url,
                $obj->item_id
            );
            $result = $db->Execute($query, $terms);

            // TODO: turn this into an exception (JM)
//			if (!$result)
//				die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);
            if (!$result)
                die("Plz Sync Languages: " . $mleblock);
                //throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB);

            // New item
        }
        else {

            // find position before inserting new item
            $query = 'SELECT MAX(position) + 1 FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item';
            $position = $db->GetOne($query);

            if ($position == null)
                $position = 1;

            // check alias is unique
            $query = 'SELECT COUNT(alias) as alias FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item WHERE alias LIKE "' . $obj->alias . '%"';
            $dbresult = $db->GetOne($query);


            if ($dbresult > 0)
                $obj->alias .= '_' . ($dbresult + 1);

            // insert item
            $query = 'INSERT INTO ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item 
					(`title' . $mleblock . '`,`desc' . $mleblock . '`, alias, position, active, create_time, modified_time, start_time, end_time, `key1' . $mleblock . '`, `key2' . $mleblock . '`, `key3' . $mleblock . '`, owner, url) 
					VALUES (?,?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?, ?, ?, ?)';

            $terms = array(
                $obj->title,
                $obj->desc,
                $obj->alias,
                //$obj->category_id,
                $position,
                $obj->active,
                $sql_start_time,
                $sql_end_time,
                $obj->key1,
                $obj->key2,
                $obj->key3,
                $obj->owner,
                $obj->url
            );

            $result = $db->Execute($query, $terms);

            // TODO: turn this into an exception (JM)
//			if (!$result)
//				die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);
            if (!$result)
                throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB);

            // populate $item_id for newly inserted item
            $obj->item_id = $db->Insert_ID();
        }

        /*
          if ($obj->active && $obj->url != '')
          {
          cms_route_manager::del_static('',$mod->_GetModuleAlias(),$obj->item_id);

          $detailpage = $this->GetPreference('detailpage', -1);

          if( $detailpage == -1 )
          {
          $contentops = cmsms()->GetContentOperations();
          $detailpage = $contentops->GetDefaultContent();
          }
          $parms = array('action'=>'detail','returnid'=>$detailpage,'articleid'=>$obj->item_id);
          $route = CmsRoute::new_builder($obj->url,$mod->GetName(),$obj->item_id,$parms,TRUE);
          cms_route_manager::add_static($route);
          }
         */
// Init search
    $allowed_types = array('TextInput', 'TextArea');
		$search = cms_utils::get_search_module();
    $words = $obj->title;
//		if (is_object($search))
//    {
//      $search->AddWords($mod->GetName(), $obj->item_id, 'title',  $obj->title);
//    } 

    // handle inserting custom fields into database
    if(count($obj->fielddefs)) 
    {  
      foreach ($obj->fielddefs as $field) 
      {    
        $field->SetItemId($obj->item_id); // <- Remove in 1.5 (???)
        $field->EventHandler()->OnItemSave($mod);  

        // Part of search reindexing
        if( !in_array($field->GetType(), $allowed_types) ) continue;
        if( !$field->GetOptionValue('search_index') ) continue;
        $words .= ' ' . $field->GetValue('string');   
      }
    }
    
    if(is_object($search))
      $search->AddWords( $mod->GetName(), $obj->item_id, $mod->GetPreference('item_singular', 'item'), $words );  

		Events::SendEvent($mod->GetName(), 'PostItemSave', array('item_object' => &$obj));
		
	}

    static final public function Delete(LISE &$mod, LISEItem &$obj) {
        Events::SendEvent($mod->GetName(), 'PreItemDelete', array('item_object' => &$obj));

        $db = cmsms()->GetDb();

        if ($obj->item_id > 0) {
            // get details
            $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item WHERE item_id = ?';
            $row = $db->GetRow($query, array($obj->item_id));

            // delete item
            $query = 'DELETE FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item WHERE item_id = ?';
            $db->Execute($query, array($obj->item_id));

            // Delete from items
            $query = 'DELETE FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item_categories WHERE item_id = ?';
            $db->Execute($query, array($obj->item_id));

            // Clean up sort order
            $query = 'UPDATE ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item SET position = (position - 1) WHERE position > ?';
            $db->Execute($query, array($row['position']));

            // Delete field values from regular tables
            $query = 'DELETE FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_fieldval WHERE item_id = ?';
            $db->Execute($query, array($obj->item_id));

            // Delete field values from any external tables (this might not belong here, double check)
            if (count($obj->fielddefs)) {
                foreach ((array) $obj->fielddefs as $field) {
                    $field->EventHandler()->OnItemDelete($mod);
                } // end of foreach
            } // end of count

            Events::SendEvent($mod->GetName(), 'PostItemDelete', array('item_object' => &$obj));

            return true;
        }

        return FALSE;
    }

    static final public function Load(LISE &$mod, LISEItem &$obj, $row = false, $mleblock) {
        
        $db = cmsms()->GetDb();
        $counter = count_language($mod->_GetModuleAlias());
        $checked = active_languages();
        if ($counter == false || $checked == false || $mleblock == '_en') {
            $mleblock = "";
        }

        Events::SendEvent($mod->GetName(), 'PreItemLoad', array('item_object' => &$obj));

        // If we don't have row then attempt to load it
        if (!$row) {
            foreach (self::$identifiers as $db_column => $identifier) {
                if (!is_null($obj->$identifier)) {
                    $db = cmsms()->GetDb();
                    $query = "SELECT * FROM " . cms_db_prefix() . "module_" . $mod->_GetModuleAlias() . "_item
                                                                                       WHERE $db_column = ? 
                                                                                       LIMIT 1";
                    $row = $db->GetRow($query, array($obj->$identifier));

                    if ($row)
                        break;
                }
            }
        }

        if ($row) {

            $obj->item_id = $row['item_id']; // deprecated
            $obj->title = (!empty($row['title' . $mleblock])) ? $row['title' . $mleblock] : $row['title'];
            $obj->desc = (!empty($row['desc' . $mleblock])) ? $row['desc' . $mleblock] : $row['desc'];

            $obj->alias = $row['alias'];
            $obj->position = $row['position'];
            $obj->active = $row['active'];
            $obj->create_time = $row['create_time'];
            $obj->modified_time = $row['modified_time'];
            $obj->start_time = $row['start_time'];
            $obj->end_time = $row['end_time'];
            $obj->owner = $row['owner'];

            $query_user = "SELECT username,first_name,last_name FROM " . cms_db_prefix() . "users WHERE user_id = ?";
            $user = $db->GetRow($query_user, array($row['owner']));
            $obj->owner_name = $user["first_name"] . ' ' . $user["last_name"] . ' (' . $user["username"] . ')';

            $obj->key1 = (!empty($row['key1' . $mleblock])) ? $row['key1' . $mleblock] : $row['key1'];
            $obj->key2 = (!empty($row['key2' . $mleblock])) ? $row['key2' . $mleblock] : $row['key2'];
            $obj->key3 = (!empty($row['key3' . $mleblock])) ? $row['key3' . $mleblock] : $row['key3'];

            $obj->url = $row['url'];
            // Fields
            if (count($obj->fielddefs)) {
                foreach ((array) $obj->fielddefs as $field) {
                    $field->SetItemId($obj->item_id); // <- Remove in 1.5
                    $field->EventHandler()->OnItemLoad($mod);
                } // end of foreach
            } // end of count

            Events::SendEvent($mod->GetName(), 'PostItemLoad', array('item_object' => &$obj));

            return true;
        }

        return FALSE;
    }

    static final public function Copy(LISEItem $obj) {
        $obj = clone $obj;

        $obj->item_id = null;
        $obj->alias = null;
        $obj->position = -1;
        $obj->create_time = '';
        $obj->modified_time = '';
        $obj->key1 = null;
        $obj->key2 = null;
        $obj->key3 = null;
        $obj->url = null;
        $obj->owner = null;

        return $obj;
    }

    static final public function GetIdentifier(LISE $mod, $identifier) {

        $query = "SELECT title, $identifier FROM " . cms_db_prefix() . "module_" . $mod->_GetModuleAlias() . "_item WHERE active = 1 ORDER BY position";
        $dbr = cmsms()->GetDb()->Execute($query);

        $ret = array();
        while ($dbr && !$dbr->EOF) {

            $ret[$dbr->fields[$identifier]] = $dbr->fields['title'];
            $dbr->MoveNext();
        }

        if ($dbr)
            $dbr->Close();

        return $ret;
    }
  static final public function reindex_search($Search, LISE $mod)
  {
    if( !$mod->GetPreference('reindex_search', 0) ) return;
        
    if(!is_object($Search)) return;

    $params = array();
    $item_query = $mod->GetItemQuery($params);
    $item_query->AppendTo(LISEQuery::VARTYPE_WHERE, 'A.active = 1');
    $result = $item_query->Execute(true);
    $items = array();
    $allowed_types = array('TextInput', 'TextArea');    

    while($result && $row = $result->FetchRow()) 
    {
      $words = $row['title']; 
      $item = $mod->InitiateItem();
      self::Load($mod, $item, $row);  
      $obj = clone $item;
      
      foreach($obj->fielddefs as $one)
      {
        if( !in_array($one->GetType(), $allowed_types) ) continue;
        if( !$one->GetOptionValue('search_index') ) continue;
        $words .= ' ' . $one->GetValue('string'); 
      }
      
      $Search->AddWords( $mod->GetName(), $row['item_id'], $mod->GetPreference('item_singular', 'item'), $words );
    }             
  }
     
  static final public function remove_index_search($Search, LISE $mod)
  {
    if(!is_object($Search)) return;
    
    $params = array();
    $item_query = $mod->GetItemQuery($params);
    $item_query->AppendTo(LISEQuery::VARTYPE_WHERE, 'A.active = 1');
    $result = $item_query->Execute(true);

    while($result && $row = $result->FetchRow()) 
    {
      $Search->DeleteWords($mod->GetName(), $row['item_id'], $mod->GetPreference('item_singular', 'item'));
    }    
  }    
	
} // end of class
?>