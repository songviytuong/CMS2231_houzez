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
 * This file defines the template report generator class.
 *
 * @package CGExtensions
 * @category Reports
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\reports;

/**
 * This class generates a report by first generating a series of structured data
 * then passing the entire report output through to a single smarty template.
 */
class template_report_generator extends data_report_generator
{
    /**
     * @ignore
     */
    private $_template;

    /**
     * @ignore
     */
    private $_data = array('structure'=>array());

    /**
     * @ignore
     */
    private $_rec;

    /**
     * Set the template to use for formatting the report.
     *
     * If a string ending with .tpl is provided then a file template for the current module is assumed.
     * Otherwise, a database template for the current module is assumed.
     * If no current module (i.e: the request is not for a module action) can be determined, then
     * The smarty 'file' resource is assumed.
     *
     * @param string $tpl
     */
    public function set_template($tpl)
    {
        $this->_template = trim($tpl);
    }

    /**
     * Get the template to use for formatting the report.
     *
     * @return string
     */
    protected function get_template()
    {
        return $this->_template;
    }

    /**
     * @ignore
     */
    protected function start()
    {
        // todo: throw an exception if there is no template
    }

    /**
     * Get the output of the report.
     *
     * @return mixed the actual output format depends upon the template that is provided.
     */
    public function get_output()
    {
        $out = null;
        $data = parent::get_output();
        if( !is_array($data) ) return $out;

        $smarty = cmsms()->GetSmarty();
        $smarty->assign('report_data',$data);
        $actionmodule = $smarty->get_template_vars('actionmodule');
        if( $actionmodule ) {
            $mod = cms_utils::get_module($actionmodule);
            if( is_object($mod) ) {
                if( endswith($this->get_template(),'.tpl') ) {
                    $out = $mod->ProcessTemplate($this->get_template());
                }
                else {
                    $out = $mod->ProcessTemplateFromDatabase($this->get_template());
                }
            }
        }
        else {
            $out = $smarty->fetch('file:'.$template);
        }
        return $out;
    }
} // end of class

?>