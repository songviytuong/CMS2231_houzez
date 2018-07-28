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
 * This file contains a class for defining an address.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class for defining and manipulating an address.
 *
 * @package CGExtensions
 */
class cge_address implements \JsonSerializable
{
    /**
     * @ignore
     */
    private $_company;

    /**
     * @ignore
     */
    private $_firstname;

    /**
     * @ignore
     */
    private $_lastname;

    /**
     * @ignore
     */
    private $_address1;

    /**
     * @ignore
     */
    private $_address2;

    /**
     * @ignore
     */
    private $_city;

    /**
     * @ignore
     */
    private $_state;

    /**
     * @ignore
     */
    private $_postal;

    /**
     * @ignore
     */
    private $_country;

    /**
     * @ignore
     */
    private $_phone;

    /**
     * @ignore
     */
    private $_fax;

    /**
     * @ignore
     */
    private $_email;

    public function jsonSerialize()
    {
        return [ 'company' => $this->company, 'firstname' => $this->firstname, 'lastname' => $this->lastname, 'address1' => $this->address1,
                 'address2' => $this->address2, 'city' => $this->city, 'state' => $this->state, 'postal' => $this->postal,
                 'country' => $this->country, 'phone' => $this->phone, 'fax' => $this->fax, 'email' => $this->email ];
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'company':
        case 'firstname':
        case 'lastname':
        case 'address1':
        case 'address2':
        case 'city':
        case 'state':
        case 'postal':
        case 'country':
        case 'phone':
        case 'fax':
        case 'email':
            $tkey = '_'.$key;
            return $this->$tkey;

        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        switch( $key ) {
        case 'company':
        case 'firstname':
        case 'lastname':
        case 'address1':
        case 'address2':
        case 'city':
        case 'state':
        case 'postal':
        case 'country':
        case 'phone':
        case 'fax':
        case 'email':
            $tkey = '_'.$key;
            $this->$tkey = trim($val);
            break;

        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    /**
     * Set the company name for this address.
     *
     * @param string $str
     */
    public function set_company($str)
    {
        $this->company = $str;
    }

    /**
     * Return the company name (if any) associated with this address.
     *
     * @return string
     */
    public function get_company()
    {
        return $this->company;
    }

    /**
     * Set the first name for this address.
     *
     * @param string $str
     */
    public function set_firstname($str)
    {
        $this->firstname = $str;
    }

    /**
     * Return the first name (if any) associated with this address.
     *
     * @return string
     */
    public function get_firstname()
    {
        return $this->firstname;
    }

    /**
     * Set the last name for this address.
     *
     * @param string $str
     */
    public function set_lastname($str)
    {
        $this->lastname = $str;
    }

    /**
     * Return the last name (if any) associated with this address.
     *
     * @return string
     */
    public function get_lastname()
    {
        return $this->lastname;
    }

    /**
     * Set the first address line for this address.
     *
     * @param string $str
     */
    public function set_address1($str)
    {
        $this->address1 = $str;
    }

    /**
     * Return the first address line (if any) associated with this address.
     *
     * @return string
     */
    public function get_address1()
    {
        return $this->address1;
    }

    /**
     * Set the second address line for this address.
     *
     * @param string $str
     */
    public function set_address2($str)
    {
        $this->address2 = $str;
    }

    /**
     * Return the second address line (if any) associated with this address.
     *
     * @return string
     */
    public function get_address2()
    {
        return $this->address2;
    }

    /**
     * Set the city for this address.
     *
     * @param string $str
     */
    public function set_city($str)
    {
        $this->city = $str;
    }

    /**
     * Return the city (if any) associated with this address.
     *
     * @return string
     */
    public function get_city()
    {
        return $this->city;
    }

    /**
     * Set the state for this address.
     *
     * @param string $str
     */
    public function set_state($str)
    {
        $this->state = $str;
    }

    /**
     * Return the state (if any) associated with this address.
     *
     * @return string
     */
    public function get_state()
    {
        return $this->state;
    }

    /**
     * Set the postal/zip code for this address.
     *
     * @param string $str
     */
    public function set_postal($str)
    {
        $this->postal = $str;
    }

    /**
     * Return the postal/zip code (if any) associated with this address.
     *
     * @return string
     */
    public function get_postal()
    {
        return $this->postal;
    }

    /**
     * Set the country for this address.
     * it is recommended to use the short country code (i.e: US or CA) for most addresses.
     *
     * @param string $str
     */
    public function set_country($str)
    {
        $this->country = $str;
    }

    /**
     * Return the country (if any) associated with this address.
     *
     * @return string
     */
    public function get_country()
    {
        return $this->country;
    }

    /**
     * Set a phone number for this address.
     *
     * @param string $str
     */
    public function set_phone($str)
    {
        $this->phone = $str;
    }

    /**
     * Return the phone number (if any) associated with this address.
     *
     * @return string
     */
    public function get_phone()
    {
        return $this->phone;
    }

    /**
     * Set a fax number for this address.
     *
     * @param string $str
     */
    public function set_fax($str)
    {
        $this->fax = $str;
    }

    /**
     * Return the fax number (if any) associated with this address.
     *
     * @return string
     */
    public function get_fax()
    {
        return $this->fax;
    }

    /**
     * Set an email address for this address.
     *
     * @param string $str
     */
    public function set_email($str)
    {
        $this->email = $str;
    }

    /**
     * Return the email address (if any) associated with this address.
     *
     * @return string
     */
    public function get_email()
    {
        return $this->email;
    }

    /**
     * Test if the address is valid or not.
     *
     * @return bool
     */
    public function is_valid()
    {
        if( $this->firstname == '' ) return FALSE;
        if( $this->lastname == '' ) return FALSE;
        if( $this->address1 == '' ) return FALSE;
        if( $this->city == '' ) return FALSE;
        if( $this->country == '' ) return FALSE;
        if( $this->email == '' ) return FALSE;
        return TRUE;
    }

    /**
     * Fill the contents of the current object with the data from an array.
     * Expects an associative array with the following fields:  company,firstname,lastname,address1,address2,city,state,postal,country,phone,fax,email.
     *
     * @param array $params The input array
     * @param string $prefix An optional prefix for the array keys.
     */
    public function from_array($params,$prefix = '')
    {
        $flds = array('company','firstname','lastname','address1','address2', 'city','state', 'postal','country', 'phone','fax','email');

        foreach( $flds as $fld ) {
            if( isset($params[$prefix.$fld]) ) $this->$fld = strip_tags($params[$prefix.$fld]);
            if( isset($params[$prefix.'first_name']) ) $this->firstname = strip_tags($params[$prefix.'first_name']);
            if( isset($params[$prefix.'last_name']) ) $this->lastname = strip_tags($params[$prefix.'last_name']);
        }
    }

    /**
     * Create an associative array with the details oft he address.
     *
     * @param string $prefix An optional prefix for each of the array keys.
     * @return array
     */
    public function to_array($prefix = '')
    {
        $result = array();
        $result[$prefix.'company'] = $this->company;
        $result[$prefix.'first_name'] = $this->firstname;
        $result[$prefix.'last_name'] = $this->lastname;
        $result[$prefix.'address1'] = $this->address1;
        $result[$prefix.'address2'] = $this->address2;
        $result[$prefix.'city'] = $this->city;
        $result[$prefix.'state'] = $this->state;
        $result[$prefix.'postal'] = $this->postal;
        $result[$prefix.'country'] = $this->country;
        $result[$prefix.'phone'] = $this->phone;
        $result[$prefix.'fax'] = $this->fax;
        $result[$prefix.'email'] = $this->email;
        return $result;
    }
} // class


#
# EOF
#
?>