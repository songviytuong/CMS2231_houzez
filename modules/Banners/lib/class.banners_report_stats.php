<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Banners (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management, display,
#  and tracking of banner images.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
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

class banners_report_stats extends cge_report_base
{
    private $_page_count = -1;

    public function &get_module()
    {
        return cge_utils::get_module('Banners');
    }

    public function get_name()
    {
        return $this->get_module()->Lang('title_stats_report');
    }

    public function get_description()
    {
        return $this->get_module()->Lang('desc_stats_report');
    }

    protected function get_page_template()
    {
        return 'statreport_template';
    }

    protected function get_pagelimit()
    {
        return $this->get_module()->GetPreference('statreport_linesperpage',40);
    }

    protected function get_page_count()
    {
        if( $this->_page_count > 0 ) return $this->_page_count;

        $db = cmsms()->GetDb();

        $query = 'SELECT count(banner_id) FROM '.cms_db_prefix().'module_banners';
        $tmp = $db->GetOne($query);
        if( $tmp ) {
            $pagecount = (int)($tmp / $this->get_pagelimit());
            if( $tmp % $this->get_pagelimit() != 0 ) $pagecount++;
            $this->_page_count = (int)($pagecount);
            return $pagecount;
        }

        return -1;
    }

    protected function get_page_data($page_number)
    {
        if( $page_number < 0 || $page_number > $this->get_page_count() ) return FALSE;

        $db = cmsms()->GetDb();
        $query = 'SELECT b.*,count(h.banner_id) AS hits,c.name as category
               FROM '.cms_db_prefix().'module_banners AS b
               LEFT JOIN '.cms_db_prefix().'module_banners_categories c
                 ON b.category_id = c.category_id
               LEFT JOIN '.cms_db_prefix().'module_banners_hits AS h
                 ON b.banner_id = h.banner_id GROUP BY banner_id';
        $offset = $page_number * $this->get_pagelimit();
        $dbr = $db->SelectLimit( $query, $this->get_pagelimit(), $offset );
        if( !$dbr ) return FALSE;

        $rows = array();
        while( $dbr && ($row = $dbr->FetchRow()) ) {
            $rows[] = $row;
        }
        $dbr->Close();

        return $rows;
    }

} // end of class

#
# EOF
#
?>