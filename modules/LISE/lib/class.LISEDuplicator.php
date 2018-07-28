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

class LISEDuplicator 
{

	#---------------------
	# Constants
	#---------------------
	
	const MOD_PREFIX = 'LISE';
	const PLACEHOLDER = 'PLACE_HOLDER___';

	#---------------------
	# Attributes
	#---------------------

	private $src;
	private $dst;
	private $modname;
	private static $_invalid = array('.', '..');

	#---------------------
	# Magic methods
	#---------------------		
		
	public function __construct($modname = self::PLACEHOLDER) 
	{
		$this->modname = self::MOD_PREFIX . $modname;
		$this->src = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'duplicate';
		$this->dst = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . $this->modname;
	}

	#---------------------
	# Set/Get
	#---------------------		
	
	public function SetModule($name)
	{
		$this->modname = $name;
	}
	
	public function SetSource($name)
	{
		$this->src = $name;
	}

	public function SetDestination($name)
	{
		$this->dst = $name;
	}	
	
	#---------------------
	# Runner
	#---------------------
	
	public function Run()
	{
		$this->CopyRecursive($this->src, $this->dst);
		$this->Rename();
		$this->FixModulefile();
		return $this->modname;
	}
		
	#---------------------
	# File handling methods
	#---------------------		

	private final function CopyRecursive($src, $dst) 
	{
		$dir = opendir($src); // <- Throw exception on failure?
		@mkdir($dst); // <- Throw exception on failure?
		
		while(false !== ( $file = readdir($dir)) ) {
		
			if (in_array($file, self::$_invalid)) continue; // <- Skip stuff we never allow to copy

			if ( is_dir($src . DIRECTORY_SEPARATOR . $file) ) { 
				$this->CopyRecursive($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file); 
			} 
			else { 
				@copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file); // <- Throw exception on failure?
			} 
		} 
		
		closedir($dir); 
	}
	
	private final function Rename() 
	{
		@rename($this->dst . DIRECTORY_SEPARATOR . self::PLACEHOLDER . '.php', 
			$this->dst . DIRECTORY_SEPARATOR . $this->modname .'.module.php'); // <- Throw exception on failure?
	}
	
	private final function FixModulefile() 
	{
		$filename = $this->dst . DIRECTORY_SEPARATOR . $this->modname .'.module.php';

		// Replacements
		$_contents = file_get_contents($filename); // <- Throw exception on failure?
		$_contents = str_replace(self::PLACEHOLDER, $this->modname, $_contents);
	
		// Write file
		$fh = @fopen($filename, 'w');
		fwrite($fh, $_contents); // <- Throw exception on failure?
		fclose($fh);	
	}	
	
} // end of class