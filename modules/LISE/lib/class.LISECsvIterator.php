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

/**
 * source: http://www.php.net/manual/en/function.fgetcsv.php#57802
 * 
 * => can import a csv file and iterate over the items
 * => allows to specify the separator and the enclosure
 * 
 * Requires at least PHP 4.3
 * 
 * HowTo use example:
	$csvIterator = new CsvIterator('/path/to/file', true, '|', '"');
	while ($csvIterator->next()) {
		print_r($csvIterator->current());
	}
 * 
 * @author MO mortanon at gmail dot com, 14-Oct-2005 08:05
 * @author TK Tobias Kluge, http://enarion.net
 * 
 * @version 1.1 - 2006-04-22 by TK
 * 		- backport to PHP 4
 * 		- added usage of enclosure
 * 		- added support of headers 
 * @version 1.0 - 2005-10-14 by MO
 * 
 */

class LISECsvIterator
{
   var $ROW_SIZE = 4096;
   /**
     * The pointer to the cvs file.
     * @var resource
     * @access private
     */
   var $filePointer = null;
   /**
     * The current element, which will
     * be returned on each iteration.
     * @var array
     * @access private
     */
   var $currentElement = null;
   /**
     * The row counter.
     * @var int
     * @access private
     */
   var $rowCounter = null;
   /**
     * The delimiter for the csv file.
     * @var str
     * @access private
     */
   var $delimiter = null;
   /**
     * The enclosure for the csv file.
     * @var str
     * @access private
     */
   var $enclosure = '"';
   /**
     * Specifies if headers should be read and used.
     * @var bool
     * @access private
     */
   var $withHeaders = false;
   /**
    * Contains the headers if headers are used.
    * @var array
    * @access private
    */
   var $header = array();


   /**
   * This is the constructor. It tries to open the csv file. 
   * The method throws an exception on failure.
   *
   * @access public
   * @param str $file The csv file.
   * @param bool $withHeaders Specify if file contains header and should be used.
   * @param str $delimiter The delimiter.
   * @param str $enclosure The enclosure.
   *
   * @throws Exception
   */
   function __construct($file, $withHeaders = true, $delimiter=',', $enclosure='"')
   {
       $this->filePointer = @fopen($file, 'r');
       if ($this->filePointer === false) 
       {
           throw new \LISE\Exception('The file "' . $file . '" cannot be read.');
       		//die('The file "' . $file . '" cannot be read.');
       }
       $this->delimiter = $delimiter;
       $this->enclosure = $enclosure;
       $this->withHeaders = $withHeaders;
   }

   /**
   * This method resets the file pointer.
   *
   * @access public
   */
   function rewind() {
       $this->rowCounter = 0;
       rewind($this->filePointer);
   }

   /**
   * This method returns the current csv row as a 2 dimensional array
   *
   * @access public
   * @return array The current csv row as a 2 dimensional array
   */
   function current() {
	   if ($this->withHeaders && $this->rowCounter == 0) {   	
       		$this->header = $this->currentElement;
       		$this->next();
	   }	   

       // check for invalid currentElement
       if (!is_array($this->currentElement)) {
       		var_dump($this->currentElement);
       		return $this->currentElement;
       }

	   // handle headers       
       if ($this->withHeaders) {
       		// apply headers to currentElement
			$tmp = array();       		
       		
       		foreach ($this->currentElement as $i => $value) {
       			// $tmp[$i] = $value; // uncomment this line to use indices as array keys
				if(isset($this->header[$i]))
					$tmp[$this->header[$i]] = $value;
       		}
       		$this->currentElement = $tmp;
       }
       $this->rowCounter++;
       return $this->currentElement;
   }  
   
   /**
   * This method returns the current row number.
   *
   * @access public
   * @return int The current row number
   */
   function key() {
       return $this->rowCounter;
   }

  /**
   * This method checks if the end of file is reached.
   *
   * @access public
   * @return boolean Returns true on EOF reached, false otherwise.
   */
   function next() {
       $this->currentElement = @fgetcsv($this->filePointer, $this->ROW_SIZE, $this->delimiter, $this->enclosure);
       // eof is reached <=> result of fgetcsv is false 
       return $this->currentElement !== FALSE;
   }

   /**
     * This method checks if the next row is a valid row.
     *
     * @access public
     * @return boolean If the next row is a valid row.
     */
   function valid() {
       if (!$this->next()) {
           $this->tearDrop();
           return false;
       }
       return true;
   }
   
   /**
    * This method closes all open files and shuts this object down.
    * 
    * @access public
    * @return void no result
    */
   function tearDown() {
   	   fclose($this->filePointer);
   }
}
?>