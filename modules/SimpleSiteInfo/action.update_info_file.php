<?php
#-------------------------------------------------------------------------
# Module: SimpleSiteInfo
# Author: Noel McGran, Rolf Tjassens
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2016 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/simplesiteinfo
#-------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#-------------------------------------------------------------------------

if ( !cmsms() ) exit;

$local_key = substr( $this->getPreference('SimpleSiteInfoPwd'), 20 );

$remote_key = isset($params['key']) ? $params['key'] : '';

$request = 'WRONG';
if ( $local_key == $remote_key ) $request = 'CORRECT';

if ( !empty ( cmsms()->config['debug'] ) ) $this->Audit( 1, $this->Lang('friendlyname'), 'DEBUG - Update data request received using the ' . $request . ' key' );

if ( (strlen($remote_key)) != 4 ) die;

if ( $request == 'CORRECT' ) $this->UpdateInfoFile();

exit;

?>