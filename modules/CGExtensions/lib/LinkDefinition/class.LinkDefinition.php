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
 * This file defines a Link Definition
 *
 * @package CGExtensions
 * @category Communications
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\LinkDefinition;

/**
 * A class with all of the information necessary to create a link definition <a> tag.
 *
 * @property string $download
 * @property string $href
 * @property string $hreflang
 * @property string $media
 * @property string $id
 * @property string $name
 * @property string $rel
 * @property string $target
 * @property string $type
 * @property string $class
 * @property string $accesskey
 * @property string $contenteditable
 * @property string $contextmenu
 * @property string $dir
 * @property string $draggable
 * @property string $dropzone
 * @property string $hidden
 * @property string $lang
 * @property string $spellcheck
 * @property string $style
 * @property string $tabindex
 * @property string $title
 * @property string $translate
 * @property string $text The text to display in the link.
 */
class LinkDefinition
{
    /**
     * @ignore
     */
    private $_data = array();

    /**
     * Constructor
     *
     * @param array $parms An array of input properties.
     */
    public function __construct($parms = array())
    {
        foreach( $parms as $key => $val ) {
            $this->$key = $val;
        }
    }

    /**
     * @ignore
     */
    private function _is_valid_key($key)
    {
        switch( $key ) {
        case 'download':
        case 'href':
        case 'hreflang':
        case 'media':
        case 'id':
        case 'name': // deprecated
        case 'rel':
        case 'target':
        case 'type':
        case 'class':
        case 'accesskey':
        case 'contenteditable':
        case 'contextmenu':
        case 'dir':
        case 'draggable':
        case 'dropzone':
        case 'hidden':
        case 'lang':
        case 'spellcheck':
        case 'style':
        case 'tabindex':
        case 'title':
        case 'translate':
        case 'text': // magic... it's the text of the link.
            return TRUE;

        default:
            if( startswith($key,'data') ) {
                return TRUE;
            }
            else if( startswith($key,'on') ) {
                return TRUE;
            }
            return FALSE;
        }
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        if( !$this->_is_valid_key($key) ) throw new \Exception($key.' is not a valid member for '.__CLASS__);
        if( array_key_exists($key,$this->_data) ) return $this->_data[$key];
    }

    /**
     * @ignore
     */
    public function __set($key,$val)
    {
        // anything set here must be representable as a string
        $val = (string) $val;
        if( !$this->_is_valid_key($key) ) throw new \Exception($key.' is not a valid member for '.__CLASS__);
        $val = (string) $val;
        $this->_data[$key] = $val;
    }

    /**
     * @ignore
     */
    public function __isset($key)
    {
        if( !$this->_is_valid_key($key) ) throw new \Exception($key.' is not a valid member for '.__CLASS__);
        return array_key_exists($key,$this->_data) && $this->_data[$key] != null;
    }

    /**
     * @ignore
     */
    public function __unset($key)
    {
        if( !$this->_is_valid_key($key) ) throw new \Exception($key.' is not a valid member for '.__CLASS__);
        unset($this->_data[$key]);
    }

    /**
     * @ignore
     */
    public function __toString()
    {
        return $this->draw();
    }

    /**
     * A simple function to validate the contents of this link.
     *
     * @throws RuntimeException
     */
    public function validate()
    {
        // only required portion is the href
        if( !isset($this->href) ) throw new \RuntimeException('This link definition is invalid (no href attribute)');
        if( !isset($this->text) ) throw new \RuntimeException('This link definition is invalid (no text attribute)');
    }

    /**
     * Draw the link.
     * Actually it just outputs an &lt;a&gt; tag.
     *
     * @return string
     */
    public function draw()
    {
        $this->validate();

        $tmp = array();
        foreach( $this->_data as $key => $val ) {
            if( $key == 'text' ) continue;
            $tmp[] = $key.'="'.$val.'"';
        }
        $out = '<a '.implode(' ',$tmp).'>'.htmlentities($this->text).'</a>';
        return $out;
    }
}

?>