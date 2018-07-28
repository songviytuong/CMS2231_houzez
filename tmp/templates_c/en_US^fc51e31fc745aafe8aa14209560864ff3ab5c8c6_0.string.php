<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:10:52
  from "fc51e31fc745aafe8aa14209560864ff3ab5c8c6" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f91ac39a001_57175619',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f91ac39a001_57175619 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_sitename')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.sitename.php';
if (!is_callable('smarty_function_title')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.title.php';
if (!is_callable('smarty_function_root_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.root_url.php';
if (!is_callable('smarty_modifier_truncate')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_function_modified_date')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.modified_date.php';
if (!is_callable('smarty_function_uploads_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.uploads_url.php';
?>

<base href="http://houzez.dev/" />
<?php if ($_smarty_tpl->tpl_vars['CustomGS']->value['slogan_content']) {
$_smarty_tpl->_assignInScope('slogan_content', ((string)$_smarty_tpl->tpl_vars['CustomGS']->value['slogan_content']) ,false ,32);
} else {
$_smarty_tpl->_assignInScope('slogan_content', "The Official Website" ,false ,32);
}
if ($_smarty_tpl->tpl_vars['CustomGS']->value['site_name']) {
$_smarty_tpl->_assignInScope('site_name', ((string)$_smarty_tpl->tpl_vars['CustomGS']->value['site_name']) ,false ,32);
} else {
ob_start();
echo smarty_function_sitename(array(),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('site_name', $_prefixVariable1 ,false ,32);
}
if (isset($_smarty_tpl->tpl_vars['pagetitle']->value) && !empty($_smarty_tpl->tpl_vars['pagetitle']->value)) {?><title><?php if ($_smarty_tpl->tpl_vars['CustomGS']->value['slogan_active'] != 1) {
echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['site_name']->value;
} else {
echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
}?></title><?php } elseif (isset($_smarty_tpl->tpl_vars['meta_title']->value) && !empty($_smarty_tpl->tpl_vars['meta_title']->value)) {?><title><?php echo $_smarty_tpl->tpl_vars['meta_title']->value;?>
</title><?php } else { ?><title><?php if ($_smarty_tpl->tpl_vars['page_alias']->value == 'home' || $_smarty_tpl->tpl_vars['page_alias']->value == 'under-construction') {
echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
} else {
echo smarty_function_title(array(),$_smarty_tpl);?>
 - <?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
}?></title><?php }?><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<link rel="shortcut icon" href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/favicon.ico" />
<meta name="Generator" content="Lee Peace"/>
<meta http-equiv="Expires" content="0"/>
<meta name="Resource-type" content="Document"/>
<meta name="Language" content="Vietnamese, English"/>
<meta name="Keywords" content="<?php if (!empty($_smarty_tpl->tpl_vars['meta_keywords']->value)) {
echo $_smarty_tpl->tpl_vars['meta_keywords']->value;
} else {
echo $_smarty_tpl->tpl_vars['CustomGS']->value['meta_keywords'];
}?>"/>
<meta name="Description" content="<?php if (!empty($_smarty_tpl->tpl_vars['meta_description']->value)) {
echo smarty_modifier_truncate(preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['meta_description']->value),'160','',false);
} else {
echo smarty_modifier_truncate(preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['CustomGS']->value['meta_description']),'160','',false);
}?>"/>
<meta name="Identifier-URL" content="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
" />
<meta name="Original-source" content="<?php if (isset($_smarty_tpl->tpl_vars['canonical']->value)) {
echo $_smarty_tpl->tpl_vars['canonical']->value;
} elseif (isset($_smarty_tpl->tpl_vars['content_obj']->value)) {
echo $_smarty_tpl->tpl_vars['content_obj']->value->GetURL();
}?>" />
<link href="<?php if ($_smarty_tpl->tpl_vars['page_alias']->value == "product-detail") {
echo smarty_function_root_url(array(),$_smarty_tpl);?>
/<?php echo $_GET['page'];
} elseif (isset($_smarty_tpl->tpl_vars['canonical']->value)) {
echo $_smarty_tpl->tpl_vars['canonical']->value;
} elseif (isset($_smarty_tpl->tpl_vars['content_obj']->value)) {
echo $_smarty_tpl->tpl_vars['content_obj']->value->GetURL();
}?>" rel="canonical"/>
<meta name="Revised" content="<?php echo smarty_function_modified_date(array('format'=>"%d/%m/%Y - %H:%M:%S"),$_smarty_tpl);?>
" />
<meta name="Robots" content="index, follow"/>
<meta name="Revisit-After" content="1 days"/>
<meta name="Rating" content="search engine optimization"/>
<meta name="Copyright" content="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['CustomGS']->value['copyright'])===null||$tmp==='' ? 'Webmaster Designer by songviytuong' : $tmp);?>
"/>
<meta name="Distribution" content="Global"/>
<meta name="Classification" content="Seo"/>
<link rel="author" href="<?php echo $_smarty_tpl->tpl_vars['CustomGS']->value['google_plus'];?>
" />
<!--Lee Peace-->
<!-- Social: Facebook -->
<?php if ($_smarty_tpl->tpl_vars['page_alias']->value == 'home' || $_smarty_tpl->tpl_vars['page_alias']->value == 'under-construction') {?><meta property="og:url" content="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
"/><?php } else { ?><meta property="og:url" content="<?php echo \CGExtensions\smarty_plugins::smarty_function_get_current_url(array(),$_smarty_tpl);?>
"/><?php }?>
<meta name="format-detection" content="telephone=yes">
<meta property="og:type" content="website" /> 
<meta property="og:image" content="<?php if (!empty($_smarty_tpl->tpl_vars['meta_image']->value) && !empty($_smarty_tpl->tpl_vars['meta_image']->value)) {
echo $_smarty_tpl->tpl_vars['meta_image']->value;
} else {
echo smarty_function_uploads_url(array(),$_smarty_tpl);?>
/<?php echo $_smarty_tpl->tpl_vars['CustomGS']->value['meta_image'];
}?>"/>
<meta property="og:title" content="<?php if ($_smarty_tpl->tpl_vars['page_alias']->value == 'home' || $_smarty_tpl->tpl_vars['page_alias']->value == 'under-construction') {
echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
} elseif (isset($_smarty_tpl->tpl_vars['meta_title']->value) && !empty($_smarty_tpl->tpl_vars['meta_title']->value)) {
echo $_smarty_tpl->tpl_vars['meta_title']->value;
} else {
echo smarty_function_title(array(),$_smarty_tpl);?>
 - <?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
}?>"/>
<meta property="og:description" content="<?php if (!empty($_smarty_tpl->tpl_vars['meta_description']->value)) {
echo smarty_modifier_truncate(preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['meta_description']->value),'160','',false);
} else {
echo smarty_modifier_truncate(preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['CustomGS']->value['meta_description']),'160','',false);
}?>"/>
<meta property="og:site_name" content="<?php if (!empty($_smarty_tpl->tpl_vars['pagetitle']->value)) {
echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['site_name']->value;
} else {
echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
}?>"/>
<meta property="fb:app_id" content="<?php echo $_smarty_tpl->tpl_vars['CustomGS']->value['app_id_facebook'];?>
" /> 
<!-- End Social: Facebook -->

<!-- Social: Twitter -->
<meta name="twitter:card" content="<?php echo $_smarty_tpl->tpl_vars['CustomGS']->value['twittercard'];?>
">
<meta name="twitter:site" content="<?php echo $_smarty_tpl->tpl_vars['CustomGS']->value['twittersite'];?>
">
<meta name="twitter:creator" content="<?php echo $_smarty_tpl->tpl_vars['CustomGS']->value['twittercreator'];?>
">
<?php if ($_smarty_tpl->tpl_vars['page_alias']->value == 'home' || $_smarty_tpl->tpl_vars['page_alias']->value == 'under-construction') {?>
<meta name="twitter:url" content="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
" />
<?php } else { ?>
<meta name="twitter:url" content="<?php echo \CGExtensions\smarty_plugins::smarty_function_get_current_url(array(),$_smarty_tpl);?>
" />
<?php }?>
<meta name="twitter:title" content="<?php if (!empty($_smarty_tpl->tpl_vars['pagetitle']->value)) {
echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['site_name']->value;
} elseif (isset($_smarty_tpl->tpl_vars['meta_title']->value) && !empty($_smarty_tpl->tpl_vars['meta_title']->value)) {
echo $_smarty_tpl->tpl_vars['meta_title']->value;
} else {
echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
}?>">
<meta name="twitter:description" content="<?php if (!empty($_smarty_tpl->tpl_vars['meta_description']->value)) {
echo smarty_modifier_truncate(preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['meta_description']->value),'160','',false);
} else {
echo smarty_modifier_truncate(preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['CustomGS']->value['meta_description']),'160','',false);
}?>">
<meta name="twitter:image:src" content="<?php if (!empty($_smarty_tpl->tpl_vars['meta_image']->value) && !empty($_smarty_tpl->tpl_vars['meta_image']->value)) {
echo $_smarty_tpl->tpl_vars['meta_image']->value;
} else {
echo smarty_function_root_url(array(),$_smarty_tpl);?>
/images/twitter.jpg<?php }?>">
<!-- End Social: Twitter -->
<meta itemprop="ratingValue" content="" />
<meta itemprop="ratingCount" content="" />
<meta itemprop="price" content="" />

<link href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/images/touch-icons/touch-icon-ipad.png" rel="apple-touch-icon" sizes="76X76"/>
<link href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/images/touch-icons/apple-touch-icon-precomposed.png" rel="apple-touch-icon-precomposed"/>
<link href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/images/touch-icons/apple-touch-icon.png" rel="apple-touch-icon"/>
<link href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/images/touch-icons/touch-icon-iphone-retina.png" rel="apple-touch-icon" sizes="120X120"/>
<link href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/images/touch-icons/touch-icon-ipad-retina.png" rel="apple-touch-icon" sizes="152X152"/>

<meta name="idev" content="<?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
"/>
<meta name="dcterms.title" content="<?php if (!empty($_smarty_tpl->tpl_vars['pagetitle']->value)) {
echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['site_name']->value;
} else {
echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['slogan_content']->value;
}?>"/>
<meta name="dcterms.creator" content="<?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
"/>
<meta name="dcterms.type" content="Text"/>
<meta name="MobileOptimized" content="width"/>
<meta name="HandheldFriendly" content="true"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /><?php }
}
