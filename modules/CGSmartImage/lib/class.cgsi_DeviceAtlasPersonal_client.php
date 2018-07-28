<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2012 by Robert Campbell (calguy1000@cmsmadesimple.org)
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

class cgsi_DeviceAtlasPersonal_client extends cgsi_devicecapabilities_client
{
  const request_url = 'http://deviceatlas.appspot.com/query';

  public function get_device_resolution()
  {
      debug_buffer('calling deviceatlas to get browser capabilities');
      $client = cge_http::get_http();
      $client->setMethod('GET');
      $client->settimeout(3); // override the timeout.
      $client->setTarget(self::request_url);
      $client->addParam('User-Agent',$this->get_agent());
      $json = $client->execute();
      $status = $client->getStatus();

      if( $status != 200 || !$json ) {
          throw new \RuntimeException('CGSmartImage:  Connection to DeviceAtlas failed');
      }

      // could be tracking failures here

      $data = json_decode($json,TRUE);
      if( !is_array($data) ) return;
      if( !isset($data['isBrowser']) ) return;

      if( !isset($data['displayWidth']) || !isset($data['displayHeight']) ) {
          debug_buffer('connection to deviceatlas succeded, but no resolution information');
          return $data;
      }

      // woot, it worked.
      $res = array();
      $res['width'] = $data['displayWidth'];
      $res['height'] = $data['displayHeight'];
      return $res;
  }
} // end of class

#
# EOF
#
?>