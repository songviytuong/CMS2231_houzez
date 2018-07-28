<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
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
if (!isset($gCms)) exit;

// this may be used for frontend and backend.
$out = null;
$all = 0;

try {
    $all = \cge_param::get_bool($_GET,'all');
    $categories = $this->GetCategories();
    if( !is_array($categories) || !count($categories) ) throw new \LogicException('No categories for ajax_category_autocomplete');
    if( $all ) {
        $out = $categories;
    } else {
        $term = \cge_param::get_string($_GET,'term');
        if( !$term ) throw new \RuntimeException('Input term not specified');

        $out = [];
        foreach( $categories as $cat ) {
            if( stripos( $cat->long_name, $term ) !== FALSE ) $out[] = [ 'label' => $cat->long_name, 'value' => $cat->id ];
        }
        if( !count($out) ) $out = null;
    }
}
catch( \Exception $e ) {
    @trigger_error('CompanyDirectory - ajax_category_autocomplete: '.$e->GetMessage());
    \cge_utils::log_exception($e);
}

\cge_utils::send_ajax_and_exit($out);

#
# EOF
#