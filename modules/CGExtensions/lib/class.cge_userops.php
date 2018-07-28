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
 * Utility methods to deal with admin users.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * Utility methods to deal with admin users.
 *
 * @package CGExtensions
 */
final class cge_userops
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * A function to return an expanded list of user id's given an input list
     * if one of the id's specified is negative, it is assumed to be a group id
     * and is expanded to its members.
     *
     * @param mixed $useridlist A comma separated string, or an array of userid's or negative group id's.
     * @return array
     */
    static public function expand_userlist($useridlist)
    {
        $users = array();

        if( !is_array($useridlist) ) $useridlist = explode(',',$useridlist);
        if( !count($useridlist) ) return $users;

        $userops = UserOperations::get_instance();
        foreach( $useridlist as $oneuid ) {
            if( $oneuid < 0 ) {
                // assume its a group id
                // and get all the uids for that group
                $groupusers = $userops->LoadUsersInGroup($oneuid * -1);
                foreach( $groupusers as $oneuser ) {
                    $users[] = $oneuser->id;
                }
            }
            else {
                $users[] = $oneuid;
            }
        }

        $users = array_unique($users);
        return $users;
    }


    /**
     * Retrieve an associative array containing a list of CMSMS admin groups that
     * is suitable for formatting in a dropdown.
     *
     * @param boolean $inclnone Flag indicating whether "none" should be the first item.
     * @return array
     */
    public static function get_grouplist($inclnone = TRUE)
    {
        static $list;
        if( !is_array($list) ) {
            $ops = CmsApp::get_instance()->GetGroupOperations();
            $groups = $ops->LoadGroups();
            $mod = cms_utils::get_module(MOD_CGEXTENSIONS);
            $list = array();
            if( $inclnone ) $list[-1] = $mod->Lang('none');
            foreach( $groups as $onegroup ) {
                if( !$onegroup->active ) continue;
                $list[$onegroup->id] = $onegroup->name;
            }
        }
        return $list;
    }


    /**
     * Get all of the known email addresses for an admin group id
     *
     * @param int $groupid The CMSMS admin group id
     * @return string[]
     */
    public static function expand_group_emails($groupid)
    {
        if( $groupid <= 0 ) return;

        $emails = array();
        $ops = UserOperations::get_instance();
        $list = $ops->LoadUsersInGroup($groupid);
        if( is_array($list) && count($list) ) {
            foreach( $list as $oneuser ) {
                if( $oneuser->active && $oneuser->email != '' && !in_array($oneuser->email,$emails) ) $emails[] = $oneuser->email;
            }
        }

        if( count($emails) == 0 ) return;
        return $emails;
    }


    /**
     * Get a list of email addresses matching a uid list
     *
     * @param int[] $list The list of CMSMS admin UIDs
     * @return string[]
     */
    static public function get_uid_emails($list)
    {
        if( !is_array($list) ) $list = array($list);

        $userops = UserOperations::get_instance();
        $allusers = $userops->LoadUsers();
        $emails = array();
        foreach( $list as $uid ) {
            $uid = (int)$uid;
            if( $uid < 1 ) continue;

            // find it.
            foreach( $allusers as $rec ) {
                if( $rec->id != $uid ) continue;
                if( !$rec->active ) continue;
                if( !$rec->email ) continue;
                $emails[] = $rec->email;
                break;
            }
        }

        if( count($emails) ) return $emails;
    }


    /**
     * Get the email address (if any) for the specified uid
     * If no uid is specified, use the currently logged in admin uid
     *
     * @param int $uid The desired CMSMS admin user id.  If no userid is provided, the currently logged in admin user account (if any) is used.
     * @return string
     */
    static public function get_uid_email($uid = null)
    {
        $uid = (int)$uid;
        if( $uid < 1 ) $uid = get_userid(false);
        if( $uid < 1 ) return;

        $out = self::get_uid_emails(array($uid));
        if( count($out) == 1 ) return $out[0];
    }

    /**
     * Given an admin Userid get his member groups (if any)
     *
     * @param int $uid The admin userid
     * @return int[] Array of integer groups, or null.
     */
    static public function get_admin_membergroups($uid)
    {
        $uid = (int) $uid;
        if( $uid < 1 ) return;

        $db = cmsms()->GetDb();
        $query = 'SELECT DISTINCT group_id FROM '.cms_db_prefix().'user_groups WHERE user_id = ?';
        $tmp = $db->GetCol($query,array($uid));
        return $tmp;
    }

    /**
     * Given an array of userids,  get a hash of uids and usernames
     * suitable for use in a dropdown.
     *
     * @param int[] $uid_list
     * @return array
     */
    static public function get_userlist(array $uid_list = null)
    {
        $ops = UserOperations::get_instance();
        $allusers = $ops->LoadUsers();

        if( !count($allusers) ) return;
        $out = [];
        foreach( $allusers as $user ) {
            if( is_null($uid_list) || in_array($user->id,$uid_list) ) $out[$user->id] = $user->username;
        }
        return $out;
    }
} // end of class

#
# EOF
#
?>