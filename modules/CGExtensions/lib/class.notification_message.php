<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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

/**
 * This file contains classes and utilities for sending notifications.
 *
 * @package CGExtensions
 * @category Exceptions
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A base class notification message object.  This is used to convey information that can be formatted and sent out via various transports.
 *
 * This object is used to send data to various twitter, facebook, mail, and other modules.  some transports may not use all of the fields
 * or may aggregate the data in various ways.
 *
 * @package CGExtensions
 * @see CGNotifier
 * @property string $subject The message subject
 * @property string $body The message body.   Some distribution transports may strip HTML out of the body and/or shorten URLS or do other processing to make
 *   text compliant with their requirements.
 * @property string $module The name of the originationg module.
 * @property int/const $priority A message priority (1 = high, 2 = normal, 3 = low)
 * @property int $to A user identifier.  A negative value indicates an admin user id.  A positive value indicates an FEU uid.
 * @property int $to_group A group identifier.  A negative value indicates an admin gid.  A positive value indicates an FEU gid.
 * @property float $lat Latitude of sender
 * @property float $long Longitude of sender
 * @property bool $html May indicate that the message is an HTML message.  Some transports may ignore this.
 * @property bool $ischeckin May indicate that the message is a user checkin.
 * @property string $link URL to attach to the message
 * @property string $linkname A name for the link
 * @property string $caption A caption for the link
 * @property string $description A description for the link
 * @property string $picture A URL to an image to attach to the message
 * @property bool $shorten Indicates that URLS in the message body (and possibly the link and picture) can be shortened by the transport
 */
class notification_message
{
  const PRIORITY_HIGH = 1;
  const PRIORITY_NORMAL = 2;
  const PRIORITY_LOW = 3;

  /**
   * @ignore
   */
  private static $_keys = array('subject','body','module','priority','to','to_group','lat','long','html','ischeckin','link','linkname',
                                'caption','description','picture','shorten');

  /**
   * @ignore
   */
  private $_data = array();

  /**
   * @ignore
   */
  public function __get($okey)
  {
    // key translation
    if( $okey == 'message' || $okey == 'msg' ) $okey = 'body';

    $key = strtolower($okey);
    if( !in_array($key,self::$_keys) ) throw new Exception('Attempt to retrieve invalid key '.$okey.' from message object');
    if( isset($this->_data[$key]) ) return $this->_data[$key];

    switch($key) {
    case 'priority':
      return self::PRIORITY_NORMAL;

    case 'to':
    case 'to_group':
      return 0;

    case 'html':
      return 0;

    case 'module':
      return -1;

    case 'shorten':
      return 0;
    }
  }

  /**
   * @ignore
   */
  public function __set($key,$value)
  {
    if( $key == 'message' || $key == 'msg' ) $key = 'body';

    $key = strtolower($key);
    if( !in_array($key,self::$_keys) ) throw new Exception('Attempt to store invalid data into message object');

    $this->_data[$key] = $value;
  }

  /**
   * @ignore
   */
  public function __isset($key)
  {
    if( !in_array($key,self::$_keys) ) throw new Exception('Attempt to retrieve invalid key '.$okey.' from message object');
    return isset($this->_data[$key]);
  }

  /**
   * Test if the key specified is valid
   *
   * @param string $key
   * @return bool
   */
  public function valid_key($key)
  {
    if( $key == 'message' || $key == 'msg' ) $key = 'body';
    return in_array($key,self::$_keys);
  }
} // end of class

#
# EOF
#
