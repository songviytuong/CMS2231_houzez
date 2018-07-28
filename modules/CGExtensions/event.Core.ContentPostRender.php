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

cge_headers::output_headers();

$config = \CmsApp::get_instance()->GetConfig();
if( $config['debug'] ) return;
$pretty_html = \cge_param::get_bool($config,'cge_prettyhtml',false);
$min_html = \cge_param::get_bool($config,'cge_minhtml',false);
if( !$pretty_html && !$min_html ) return; // do nothin

$in = $params['content'];
if( strpos('</body>',$in) === FALSE ) $in = str_replace('</html>','</body></html>',$in);
$the_head_parm = -1; $the_body_parm = -1; $the_comments_parm = 3;
if( $pretty_html ) {
    $the_head_parm = 1;
    $the_body_parm = 4;
}
if( $min_html ) {
    $the_comments_parm = 1;
}

$page_top = $page_bottom = $page_middle = $head_section = $body_section = null;
$matches = null;
$do_parse = 0;
if( preg_match('/<head.?>/i',$in,$matches,PREG_OFFSET_CAPTURE) ) {
    $page_top = substr($in,0,$matches[0][1]+strlen($matches[0][0]));
    if( $the_head_parm < 1 ) $page_top = trim(str_replace("\n",'',$page_top));
    $in = substr($in,$matches[0][1]+strlen($matches[0][0]));
}
if( preg_match('~</head>\s*?<\s*body[^>]*>~i',$in,$matches,PREG_OFFSET_CAPTURE) ) {
    $page_middle = substr($in,$matches[0][1],strlen($matches[0][0]));
    $head_section = substr($in,0,$matches[0][1]);
    $in = $body_section = substr($in,$matches[0][1]+strlen($matches[0][0]));
    $do_parse = 1;
}
if( preg_match('+</(body|html)>+i',$in,$matches,PREG_OFFSET_CAPTURE) ) {
    $page_bottom = substr($in,$matches[0][1]);
    $body_section = substr($in,0,$matches[0][1]);
}
if( !$do_parse ) return;

require_once(__DIR__.'/lib/htmLawed.php');
$out = $page_top;
if( $the_head_parm < 0 ) {
    // minified head output
    $head_section = preg_replace('/>\s+</','><',$head_section);
    $head_section = trim(str_replace("\n",'',$head_section));
}
$out .= $head_section;
$html_conf = array('tidy'=>$the_body_parm,'schemes'=>'*:*','comments'=>$the_comments_parm);
//$html_conf = array('tidy'=>$the_body_parm,'schemes'=>'*: mailto,http,https,ftp,file,tel');
$out .= $page_middle.htmLawed($body_section,$html_conf).'</body></html>';
if( $the_comments_parm > 0 ) {
   $out = preg_replace('/<!--(.*?)-->/','',$out);
}
$params['content'] = $out;

#
# EOF
#
