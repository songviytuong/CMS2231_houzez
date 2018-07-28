<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://cmsmadesimple.sf.net
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

function smarty_cms_function_random_image_selective($params, &$smarty) {
	if(empty($params['dir']))
		$dirn = "uploads/images";
	else
		$dirn = $params['dir'];

	if(empty($params['include']))
		$preInc = "";
	else
		$preInc = $params['include'];

        if(empty($params['exclude']))
                $preExc = "thumb_";
        else
                $preExc = $params['exclude'];

	$myDir = dir($dirn);
        if( ! $myDir ) 
        {
           return "<!-- Directory does not exist -->";
        }
        while( $name = $myDir->read() ) {  
		if(substr($name,0,strlen($preInc)) == $preInc && substr($name,0,strlen($preExc)) != $preExc && $name != "." && $name != "..") {
			$images[] = $name;
		}
        }
        $myDir->close();

        $randimage = rand(0,count($images)-1);

	return $dirn . "/" . $images[$randimage];
}

function smarty_cms_help_function_random_image_selective() {
	?>
	<h3>What does this do?</h3>
	<p>Grabs a random image from the image directory specified</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{random_image_selective dir="images/albums"}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(optional)</em>dir - directory containing the images.</li>
 <li><em>(optional)</em>include - prefix of images you want to include in the random pool of images</li>
 <li><em>(optional)</em>exclude - prefix of images you want to exclude from the random pool of images (defaults to thumb_)</li>
	</ul>
	</p>
	<?php
}

function smarty_cms_about_function_random_image_selective() {
	?>
	<p>Author: Aaron King &lt;Ezerick@gmail.com&gt;, based on the original Random Image tag created by Robert Campbell&lt;rob@techcom.dyndns.org&gt;</p>
	<p>Version: 1.0</p>
	<p>
	Change History:<br/>
	Inital Release of 1.0
	</p>
	<?php
}
?>
