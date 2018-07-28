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
use \CGExtensions\reports\tabular_report_cellfmt as cellfmt;
use \CGExtensions\reports\tabular_report_defn_column as coldefn;
use \CGExtensions\reports\tabular_report_defn_group as group;
use \CGExtensions\reports\tabular_report_defn_group_line as grpline;

if( !isset($gCms) ) exit();
if( !$this->CheckPermission('Banners Manager') ) exit;

$data = array();
$data['sql'] = 'SELECT b.*,count(h.banner_id) AS hits,c.name as category
                FROM '.cms_db_prefix().'module_banners AS b
                LEFT JOIN '.cms_db_prefix().'module_banners_categories c
                ON b.category_id = c.category_id
                LEFT JOIN '.cms_db_prefix().'module_banners_hits AS h
                ON b.banner_id = h.banner_id GROUP BY b.banner_id
                ORDER BY c.name ASC';
$data['limit'] = (int) $this->GetPreference('statreport_linesperpage',40);

$query = new \CGExtensions\query\sql_query($data);
$report = new \CGExtensions\reports\tabular_report_defn;
$report->set_query($query);
$report->set_title($this->Lang('title_stats_report'));
$report->set_description($this->ProcessTemplateFromData($this->Lang('desc_stats_report')));
$report->define_column(new coldefn('category',$this->Lang('category')));
$report->define_column(new coldefn('name',$this->Lang('banner')));
$report->define_column(new coldefn('url',$this->Lang('url')));
$report->define_column(new coldefn('created',$this->Lang('created'),'{$val|date_format:\'%x\'}'));
$report->define_column(new coldefn('last_impression',$this->Lang('last_impression')));
$report->define_column(new coldefn('expires',$this->Lang('expires'),'{$val|date_format:\'%x\'}'));
$report->define_column(new coldefn('num_impressions',$this->Lang('impressions'),'{$val}',coldefn::ALIGN_RIGHT));
$report->define_column(new coldefn('hits',$this->Lang('hits'),'',coldefn::ALIGN_RIGHT));
$report->set_content_columns(array('category','name','url','created','expires','last_impression','num_impressions','hits'));
$grp = new group('category');
$grp->add_header_line(
    new grpline(
        array('category'=>$this->Lang('category'),'name'=>$this->Lang('name'),'url'=>$this->Lang('url'),'created'=>$this->Lang('created'),
              'last_impression'=>$this->Lang('last_impression'),'expires'=>$this->Lang('expires'),
              'num_impressions'=>new cellfmt('num_impressions',$this->Lang('impressions'),cellfmt::ALIGN_RIGHT),
              'hits'=>new cellfmt('hits',$this->Lang('hits'),cellfmt::ALIGN_RIGHT) )
        ));
$grp->add_footer_line(
    new grpline(
        array('expires'=>new cellfmt('expires',$this->Lang('total').':',cellfmt::ALIGN_RIGHT),
              'num_impressions'=>new cellfmt('num_impressions','{$grp_sum}',cellfmt::ALIGN_RIGHT),
        'hits'=>new cellfmt('hits','{$grp_sum}',cellfmt::ALIGN_RIGHT) )
        ));
$report->add_group($grp);


$generator = new \Banners\html_report_generator($report);
$generator->set_alias('statistics_report');
$generator->generate();
$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
echo $generator->get_output();
exit;

#
# EOF
#
?>