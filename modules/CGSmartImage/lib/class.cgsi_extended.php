<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2013 by Robert Campbell (calguy1000@cmsmadesimple.org)
#  
#  An addon module for CMS Made Simple to allow creating image tags in a smart
#  way to optimize performance.
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin 
# section that the site was built with CMS Made simple.
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
#END_LICENSE

final class cgsi_extended
{
  private function __consstruct() {}

  public static function cgsi_getimages($params,$content,&$smarty,$repeat)
  {
    if( !$content ) return;

    $mod = cms_utils::get_module('CGSmartImage');
    $old_errorval = libxml_use_internal_errors(true);
    $dom = new CGDomDocument();
    $dom->strictErrorChecking = FALSE;
    $dom->validateOnParse = FALSE;
    if( function_exists('mb_convert_encoding') ) $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
    $dom->loadHTML($content);

    $imgs = $dom->GetElementsByTagName('img');
    if( is_object($imgs) && $imgs->length ) {
      $out = array();
      for( $i = 0; $i < $imgs->length; $i++ ) {
	$node = $imgs->item($i);
	$sxe = simplexml_import_dom($node);

	$rec = array();
	$rec['tag'] = $sxe->asXML();
	foreach( $sxe->attributes() as $name => $value ) {
	  $value = (string)$value;
	  if( $value == '' ) continue;
	  $rec[$name] = $value;
	}
	$out[] = $rec;
      }

      if( isset($params['assign']) ) $smarty->assign($params['assign'],$out);
    }

    $imagesonly = cms_to_bool(get_parameter_value($params,'imagesonly'));
    $nocontent = cms_to_bool(get_parameter_value($params,'nocontent'));;
    if( !$nocontent ) {
      if( $imagesonly ) {
	$content = '';
	foreach( $out as $rec ) {
	  $content .= $rec['tag'];
	}
      }
      return $content;
    }
  }

} // end of class

#
# EOF
#
?>