<?php
$lang['addtemplate']='Agiuntar in template';
$lang['areyousure']='Es ti segir che ti vuls stizzar quai?';
$lang['dbtemplates']='Templates da la banca da datas';
$lang['default']='Standart';
$lang['deletetemplate']='Stizzar template';
$lang['edittemplate']='Editar template';
$lang['filename']='Num da datoteca';
$lang['filetemplates']='Templates da datotecas';
$lang['help']='	<h3>What does this do?</h3>
	<p>Menu Manager is a module for abstracting menus into a system that's easily usable and customizable.  It abstracts the display portion of menus into smarty templates that can be easily modified to suit the user's needs. That is, the menu manager itself is just an engine that feeds the template. By customizing templates, or make your own ones, you can create virtually any menu you can think of.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{menu}</code>.  The parameters that it can accept are listed below.</p>
	<h3>Why do I care about templates?</h3>
	<p>Menu Manager uses templates for display logic.  It comes with three default templates called cssmenu.tpl, minimal_menu.tpl and simple_navigation.tpl. They all basically create a simple unordered list of pages, using different classes and ID's for styling with CSS.</p>
	<p>Note that you style the look of the menus with CSS. Stylesheets are not included with Menu Manager, but must be attached to the page template separately. For the cssmenu.tpl template to work in IE you must also insert a link to the JavaScript in the head section of the page template, which is necessary for the hover effect to work in IE.</p>
	<p>If you would like to make a specialized version of a template, you can easily import into the database and then edit it directly inside the CMSMS admin.  To do this:
		<ol>
			<li>Click on the Menu Manager admin.</li>
			<li>Click on the File Templates tab, and click the Import Template to Database button next to i.e. simple_navigation.tpl.</li>
			<li>Give the template copy a name.  We'll call it "Test Template".</li>
			<li>You should now see the "Test Template" in your list of Database Templates.</li>
		</ol>
	</p>
	<p>Now you can easily modify the template to your needs for this site.  Put in classes, id's and other tags so that the formatting is exactly what you want.  Now, you can insert it into your site with {menu template='Test Template'}. Note that the .tpl extension must be included if a file template is used.</p>
	<p>The parameters for the $node object used in the template are as follows:
		<ul>
			<li>$node->id -- Content ID</li>
			<li>$node->url -- URL of the Content</li>
			<li>$node->accesskey -- Access Key, if defined</li>
			<li>$node->tabindex -- Tab Index, if defined</li>
			<li>$node->titleattribute -- Description or Title Attribute (title), if defined</li>
			<li>$node->hierarchy -- Hierarchy position, (e.g. 1.3.3)</li>
			<li>$node->depth -- Depth (level) of this node in the current menu</li>
			<li>$node->prevdepth -- Depth (level) of the node that was right before this one</li>
			<li>$node->haschildren -- Returns true if this node has child nodes to be displayed</li>
			<li>$node->menutext -- Menu Text</li>
			<li>$node->alias -- Page alias</li>
			<li>$node->target -- Target for the link.  Will be empty if content doesn't set it.</li>
			<li>$node->index -- Count of this node in the whole menu</li>
			<li>$node->parent -- True if this node is a parent of the currently selected page</li>
		</ul>
	</p>';
$lang['help_loadprops']='Use this parameter when using advanced properties in your menu manager template.  This parameeter will force the loading of all content properties for each node (such as extra1, image, thumbnail, etc).  and will dramatically increase the number of queries required to build a menu, and increase memory requirements, but will allow for much more advanced menus';
$lang['help_number_of_levels']='This setting will only allow the menu to only display a certain number of levels deep.';
$lang['help_template']='The template to use for displaying the menu.  Templates will come from the database templates unless the template name ends with .tpl, in which case it will come from a file in the MenuManager templates directory (defaults to simple_navigation.tpl)';
$lang['importtemplate']='Importar il template en la banca da datas';
$lang['menumanager']='Administraziun da menus';
$lang['newtemplate']='Nov num dal template';
$lang['nocontent']='Endatà nagin cuntegn!';
$lang['notemplatename']='Endatà nagin num dal template.';
$lang['readonly']='be leger';
$lang['templatecontent']='Cuntegn dal template';
$lang['templatenameexists']='I exista gia in template cun il medem num';
$lang['this_is_default']='Template da menu da standart';
?>