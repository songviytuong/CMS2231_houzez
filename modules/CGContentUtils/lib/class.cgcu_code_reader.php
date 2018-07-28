<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide various additional utilities
#  for dealing with content pages.
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

class cgcu_code_reader
{
    private $_filename;
    private $_error = '';
    private $_data;

    public function __construct($filename)
    {
        if( !file_exists($filename) ) throw new \Exception('File Not Found '.$filename);

        $reader = new XMLReader();
        $tmp = $reader->open($filename);
        if( !$tmp ) throw new Exception('Unable to open XML File '.$fn);

        $this->_filename = $filename;
        $this->_scan($reader);
    }


    public function get_error()
    {
        return $this->_error;
    }


    public function get_data()
    {
        return $this->_data;
    }


    public function get_record($name)
    {
        if( !is_array($this->_data) || count($this->_data) == 0 ) return;

        for( $i = 0; $i < count($this->_data); $i++ ) {
            if( $this->_data[$i]['name'] == $name ) return $this->_data[$i];
        }
    }


    protected function _scan(XMLReader& $reader)
    {
        $have_code_export = 0;
        $cur_element = '';
        $cur_key = '';
        $this->_data = array();
        $cur_data = array();

        while( $reader->read() && $this->_error == '' ) {
            switch( $reader->nodeType ) {
            case XMLREADER::ELEMENT:
            {
                switch( $reader->localName ) {
                case 'cmsms_code_export':
                    $have_code_export++;
                    break;

                case 'userdefined_tag':
                case 'module_template':
                    if( !$have_code_export ) {
                        $this->_error = 'error_invalid_format';
                    }
                    else if( $cur_element != '' ) {
                        $this->_error = 'error_broken_xml';
                    }
                    else {
                        $cur_element = $reader->localName;
                        $cur_data['type'] = $reader->localName;
                    }
                    break;

                case 'description':
                case 'use_wysiwyg':
                case 'module':
                case 'name':
                case 'template':
                case 'code':
                    $cur_key = $reader->localName;
                    if( !$have_code_export ) {
                        $this->_error = 'error_invalid_format';
                    }
                    else if( $cur_element == '' ) {
                        $this->_error = 'error_broken_xml';
                    }
                    else {
                        $cur_data[$reader->localName] = $reader->value;
                    }
                    break;
                }
            }
            break;

            case XMLREADER::TEXT:
            {
                if( $cur_key != '' ) {
                    $cur_data[$cur_key] = $reader->value;
                    $cur_key = '';
                }
            }
            break;

            case XMLREADER::CDATA:
            {
                if( $cur_key != '' ) {
                    $cur_data[$cur_key] = $reader->value;
                    $cur_key = '';
                }
            }

            case XMLREADER::END_ELEMENT:
            {
                switch( $reader->localName ) {
                case 'cmsms_code_export':
                    $have_code_export--;
                    break;

                case 'userdefined_tag':
                case 'module_template':
                    if( !$have_code_export ) {
                        $this->_error = 'error_invalid_format';
                    }
                    else if( $cur_element != $reader->localName ) {
                        $this->_error = 'error_broken_xml';
                    }

                    // make sure we have all the data.
                    if( !$this->_error ) {
                        switch( $cur_data['type'] ) {
                        case 'userdefined_tag':
                            if( !isset($cur_data['name']) || empty($cur_data['name']) ||
                                !isset($cur_data['code']) ) {
                                $this->_error = 'error_broken_xml';
                            }
                            break;

                        case 'module_template':
                            if( !isset($cur_data['module']) || empty($cur_data['module']) ||
                                !isset($cur_data['name']) || empty($cur_data['name']) ||
                                !isset($cur_data['template']) || empty($cur_data['template']) ) {
                                $this->_error = 'error_broken_xml';
                            }
                            break;
                        }
                    }

                    if( !$this->_error ) {
                        // got a complete record.
                        $this->_data[] = $cur_data;
                        $cur_data = array();
                        $cur_key = '';
                        $cur_element = '';
                    }
                    break;
                }
            }
            break;
            }
        } // while
    } // function

} // end of class

#
# EOF
#
?>