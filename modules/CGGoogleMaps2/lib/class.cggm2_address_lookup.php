<?php
/**
 * A class to assist in doing geolocation (address to latitude and longitude conversion)
 *
 * @package CGGoogleMaps2
 * @author Robert Campbell <calguy1000@gmail.com>
 */

/**
 * A class to assist in doing geolocation (address to latitude and longitude conversion)
 *
 * @package CGGoogleMaps2
 * @author Robert Campbell <calguy1000@gmail.com>
 */
final class cggm2_address_lookup
{

  /**
   * @ignore
   */
  static private $_lookup_service;

  /**
   * @ignore
   */
  static private $_lookup_policy;

  /**
   * @ignore
   */
  private function __construct() {}

  /**
   * @ignore
   */
  static private function initialize()
  {
      if( self::$_lookup_service == '' ) {
          $mod = cge_utils::get_module('CGGoogleMaps2');
          if( $mod ) {
              self::$_lookup_service = $mod->GetPreference('lookup_service','GOOGLE');
              self::$_lookup_policy  = $mod->GetPreference('lookup_policy','CACHE');
          }
      }
  }

  /**
   * @ignore
   */
  static private function cache_lookup($address)
  {
      if( empty($address) ) return FALSE;

      $db = cmsms()->GetDb();
      $query = 'SELECT lon,lat FROM '.cms_db_prefix().'module_cggooglemaps2_cache WHERE address = ?';
      $tmp = $db->GetRow($query,array($address));
      if( !$tmp || !is_array($tmp) ) return FALSE;

      return array($tmp['lat'],$tmp['lon']);
  }

  /**
   * @ignore
   */
  static private function cache_address($address,$coords)
  {
      if( !$address || !is_array($coords) || count($coords) != 2 ) return FALSE;

      $db = cmsms()->GetDb();
      $query = 'INSERT INTO '.cms_db_prefix().'module_cggooglemaps2_cache (address,lat,lon) VALUES (?,?,?)';
      $dbr = $db->Execute($query,array($address,$coords[0],$coords[1]));
      if( !$dbr ) throw new cg_sql_error($db->ErrorMsg().' -- / -- '.$db->sql);
      return TRUE;
  }


  /**
   * Do a remote lookup to convert an address to a coodinate
   *
   * This method does not do any caching
   *
   * @param string $address
   * @return float[]
   */
  static public function geo_lookup($address)
  {
      $address = trim($address);
      switch( self::$_lookup_service ) {
      case 'GOOGLE':
      default:
          $address = str_replace('%20','+',rawurlencode($address));
          //$address = str_replace(' ','+',$address);
          $url = sprintf('http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s',$address);
          $res = cge_http::get($url,'',FALSE);
          if( $res ) {
              $tmp = json_decode($res);
              if( !isset($tmp->status) || $tmp->status != 'OK' ) {
                  audit('','cggm2_address_lookup','Address lookup of '.$address.' returned '.$tmp->status);
                  return FALSE;
              }
              if( !isset($tmp->results[0]->geometry->location) ) return FALSE;
              return array((float)$tmp->results[0]->geometry->location->lat,(float)$tmp->results[0]->geometry->location->lng);
          }
          break;
      }

      return FALSE;
  }

  /**
   * Convert an address into a coordinate (if possible).  This method
   * will use caching (depending upon the lookup policy as set in the CGGM2 admin panel
   *
   * @param string $address
   * @return float[]
   */
  static public function lookup($address)
  {
      if( empty($address) ) return FALSE;

      self::initialize();
      $address = trim($address);
      $coords = FALSE;

      switch( self::$_lookup_policy ) {
      case 'NOCACHE':
          $coords = self::geo_lookup($address);
          break;

      case 'CACHEONLY':
          $coords = self::cache_lookup($address);
          break;

      case 'CACHEFIRST':
      default:
          $coords = self::cache_lookup($address);
          if( !$coords ) {
              $coords = self::geo_lookup($address);
              if( !$coords ) return FALSE;
              self::cache_address($address,$coords);
          }
          break;
      }

      return $coords;
  }

  /**
   * @ignore
   */
  static private function cache_lookup_multiple($addresses)
  {
      if( !is_array($addresses) || count($addresses) == 0 ) return;

      // eliminate empties
      $db = cmsms()->GetDb();
      $tmp = array();
      foreach( $addresses as $one ) {
          if( !$one ) continue;
          $tmp[] = $db->qstr($one);
      }
      $query = 'SELECT address,lon,lat FROM '.cms_db_prefix().'module_cggooglemaps2_cache WHERE address IN ('.implode(',',$tmp).')';
      $tmp = $db->GetArray($query);
      if( !is_array($tmp) || count($tmp) == 0 ) return;

      $out = array();
      foreach( $tmp as $row ) {
          $out[$row['address']] = array($row['lat'],$row['lon']);
      }
      return $out;
  }

  /**
   * Geolocate multiple addresses
   * This method will use caching (depending upon the lookup policy as set in the CGGM2 admin panel
   *
   * @param string[] $addresses An array of address strings
   * @return array An associative array of latitudes and longitude coordinates.  The key is the address.
   */
  static public function lookup_multiple($addresses)
  {
      if( !is_array($addresses) || count($addresses) == 0 ) return;

      $out = array();
      self::initialize();
      switch( self::$_lookup_policy ) {
      case 'NOCACHE':
          foreach( $addresses as $one ) {
              $tmp = self::geo_lookup($address);
              if( is_array($tmp) ) $out[$address] = $tmp;
          }
          break;

      case 'CACHEONLY':
          $out = self::cache_lookup_multiple($addresses);
          break;

      case 'CACHEFIRST':
      default:
          $missing = $addresses;
          $tmp = self::cache_lookup_multiple($addresses);
          if( is_array($tmp) && count($tmp) ) {
              $missing = array();
              $keys = array_keys($tmp);
              foreach( $addresses as $one ) {
                  if( !in_array($one,$keys) ) $missing[] = $one;
              }
          }
          if( is_array($missing) && count($missing) ) {
              foreach( $missing as $one ) {
                  $coords = self::geo_lookup($one);
                  if( $coords ) {
                      $tmp[$one] = $coords;
                      try {
                          self::cache_address($one,$coords);
                      }
                      catch( \Exception $e ) {
                          // ignore error
                      }
                  }
              }
          }
          return $tmp;
      }
  }
} // end of class

?>