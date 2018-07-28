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
if( !defined('CMS_VERSION') ) exit;

$db = cmsms()->GetDb(); 

switch ($oldversion) 
{
  case '0.1.b.2':
    # add a template row for field definition
    $taboptarray = array('mysql' => 'TYPE=MyISAM');
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef', 'template C(255)');
    $dict->ExecuteSQLArray($sqlarray);
  
  case '0.1.b.3':
    # we now support InnoDB instead of MyISAM
    $prefix = cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_';
    
    $table_list = array(
                          'item',
                          'category',
                          'item_categories',
                          'fielddef',
                          'fielddef_opts',
                          'fieldval'
                        );
                        
    foreach($table_list as $table)
    {
      $tablename = $prefix . $table;
      $q = 'ALTER TABLE ' . $tablename . ' ENGINE=InnoDB;';
      
      try
      {
        $r = $db->Execute($q);
        
        if(!$r) throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );
        //if(!$r) throw new Exception($db->ErrorMsg(), $db->ErrorNo());
        $this->audit(0, 'alter table', $table . ' success!');
      }
      catch (Exception $e) 
      {
        $this->audit(0, 'alter table', $e);
      }

    }
    
  case '1.1':
  case '1.2.b.1':
  case '1.2.b.2':
  case '1.2.b.3':
  case '1.2.b.3.2':
  case '1.2.b.3.3':
  case '1.2.b.3.4':
  case '1.2.b.3.5':
  case '1.2.b.3.6':
  case '1.2.b.3.7':
  case '1.2.b.3.8':
  case '1.2.b.3.9':
    
    $mod_prefix = cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_';
  
    # so we made a booboo... let's fix it
    # 1st the auto fields
    $changes = array(
                      'item' => 'item_id',
                      'category' => 'category_id',
                      'fielddef' => 'fielddef_id'
                    );
                    
    foreach($changes as $table => $field)
    {
      $q1 = 'ALTER TABLE ' . $mod_prefix . $table . ' DROP INDEX ' . $field;
      $q2 = 'ALTER TABLE ' . $mod_prefix . $table . ' MODIFY ' . $field . ' INTEGER NOT NULL AUTO_INCREMENT , ADD PRIMARY KEY (' . $field . ')';
      try
      {
        $r = $db->Execute($q1);
        
        //if(!$r) throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() , \LISE\Error::DISCRETE_DB );
        //if(!$r) throw new Exception($db->ErrorMsg(), $db->ErrorNo());
        
        $r = $db->Execute($q2);
                
        if(!$r) throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );
        //if(!$r) throw new Exception($db->ErrorMsg(), $db->ErrorNo());
        
        $this->audit(0, 'alter table', $table . ' success!');
      }
      catch (Exception $e) 
      {
        $this->audit(0, 'alter table', $e);
      }
    }
    
  
    # then the keys...
    $changes = array(
                      'fielddef_opts' => 'fielddef_id,name',
                      'fieldval' => 'item_id,fielddef_id,value_index'
                    );
                    
    foreach($changes as $table => $fields)
    {
      $fs = explode(',', $fields);
      
      $sbq1 = array();
      $sbq2 = array();
      $nn = ($table === 'fielddef_opts') ? '' : 'NOT null';
      
      foreach($fs as $one )
      { 
        $sbq1[] = ' DROP INDEX (' . $one . ')';
        $sbq2[] = ' ADD INDEX (' . $one . ') ';
      }
            
      $q1 = 'ALTER TABLE ' . $mod_prefix . $table . implode(',', $sbq1);
      $q2 = 'ALTER TABLE ' . $mod_prefix . $table . implode(',', $sbq2);
     
      try
      {
        $r1 = $db->Execute($q1);
        $r2 = $db->Execute($q2);

        if(!$r2) throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );
        //if(!$r2) throw new Exception($db->ErrorMsg(), $db->ErrorNo());
        $this->audit(0, 'alter table', $table . ' success!');
      }
      catch (Exception $e) 
      {
        $this->audit(0, 'alter table', $e);
      }
    }
  case '1.2.2':
  case '1.2.2.1':
    try
    {
      $mod_prefix = cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_'; 
      $q = 'ALTER TABLE ' . $mod_prefix . 'item_categories ALTER item_id SET DEFAULT -1, ';
      $q .= ' ALTER category_id  SET DEFAULT -1';
      $r = $db->Execute($q);
      if(!$r) throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );
    }
    catch (Exception $e) 
    {
      $this->audit(0, 'alter table', $e);
    }
  break;
}
?>