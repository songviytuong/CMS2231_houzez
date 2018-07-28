<?php
/**
 *
 * Copyright:
 *
 * MajorLabel - Guido Goluke
 * Web: www.majorlabel.nl
 * Email: info@majorlabel.nl
 *
 *
 * Authors:
 *
 * Guido Goluke, <info@majorlabel.nl>
 *  
 *
 * License:
 *-------------------------------------------------------------------------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
 *
 * ------------------------------------------------------------------------- */

switch($oldversion) {
	case "1":
		// delete toolbar files in the Ace library folder.
		// They've been moved to lib/js and lib/css
		$dir = __DIR__;
		unlink($dir.'/lib/Ace/src-min/toolbar.css');
		unlink($dir.'/lib/Ace/src-min/toolbar.js');
	break;	
	case "1.03":
		// Renames the JS and CSS file
		// Delete the old ones, new ones will be auto downloaded
		$dir = __DIR__;
		unlink($dir.'/lib/css/toolbar.css');
		unlink($dir.'/lib/js/toolbar.js');
	break;
}