<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:47:05
  from "E:\xampp\htdocs\public_html\cms_version2\cms2231_houzez\lib\assets\templates\cmsms-error-console.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f9a29106a66_78277635',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d9d1230a97fc1a12b7054206eae8a209b5e78be' => 
    array (
      0 => 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\assets\\templates\\cmsms-error-console.tpl',
      1 => 1514740694,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f9a29106a66_78277635 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>CMS - Error console</title>
		<meta name="robots" content="noindex, nofollow" />
        <style>
			body {
				min-width: 900px;
				font-family: sans-serif;
				color: #232323;
				line-height: 1.3;
				font-size: 12px;
				background: #f6f6f6
			}
			a {
				color: #232323;
				outline: 0;
				text-decoration: none;
				font-weight: bold;
			}
			.logo {
				padding: 20px 0;
				text-align: center;
				width: 75%;
				margin: auto;
			}
			#wrapper {
				width: 75%;
				background: #fff;
				border: 1px solid #d5d5d5;
				margin: auto;
				padding: 15px 25px;
				-webkit-box-shadow: 0 10px 18px -6px #646464;
				-moz-box-shadow: 0 10px 18px -6px #646464;
				-o-box-shadow: 0 10px 18px -6px #646464;
				-ms-box-shadow: 0 10px 18px -6px #646464;
				box-shadow: 0 10px 18px -6px #646464;
			}
			#wrapper h1 {
				margin: 0;
				color: #ddd;
				font-size: 112px;
				font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans serif;
			}
			#wrapper .info {
				float: left;
				font-size: 16px;
				color: #c3c3c3;
				margin-top: -10px;
				margin-left: 180px;
			}
			#wrapper pre {
				background: #232323;
				border-left: 10px solid #d5d5d5;
				color: #6aa94c;
				font-family: Consolas, 'Andale Mono WT', 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', 'Courier New', monospace;
				padding: 15px;
				overflow: auto;
				word-wrap: break-word;
				border-radius: 6px
			}
			#wrapper .error-message {
				background: #EED3D7;
				border-radius: 6px;
				padding: 10px;
				font-weight: normal;
				border: 1px solid #ecb2ba;
			}
			#wrapper span.important {
				color: #B94A48;
				font-weight: bold;
				text-transform: uppercase
			}
			#wrapper .btn {
				display: inline-block;
				padding: 6px 12px;
				margin-bottom: 0;
				font-size: 14px;
				line-height: 20px;
				text-align: center;
				color: #fff;
				border-radius: 4px;
				text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
				background-color: #FAA732;
				background-image: -moz-linear-gradient(top, #FBB450, #F89406);
				background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#FBB450), to(#F89406));
				background-image: -webkit-linear-gradient(top, #FBB450, #F89406);
				background-image: -o-linear-gradient(top, #FBB450, #F89406);
				background-image: linear-gradient(to bottom, #FBB450, #F89406);
				background-repeat: repeat-x;
				border-color: #F89406 #F89406 #AD6704;
				border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffbb450', endColorstr='#fff89406', GradientType=0);
				filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
			}
			#wrapper .btn a {
				color: #fff;
			}
			.clear {
				clear: both;
			}
        </style>
        <?php echo '<script'; ?>
 language="javascript">
			function toggle() {
				var el = document.getElementById("show");
				var trace = document.getElementById("open");
				if (el.style.display == "block") {
					el.style.display = "none";
					trace.innerHTML = "View Full Trace &darr;";
				} else {
					el.style.display = "block";
					trace.innerHTML = "Close Full Trace &uarr;";
				}
			}
        <?php echo '</script'; ?>
>
    </head>
    <body>
        
        <br/><br/><br/>
        <div id="wrapper">
            <h1>Oops!</h1>
            <p class="info"><?php echo $_smarty_tpl->tpl_vars['contact_info']->value;?>
</p>
            <div class="clear"></div>
           
			<?php if ($_smarty_tpl->tpl_vars['loggedin']->value) {?>
				<div class="error">
					<h2 class="error-message"><span class="important">Error:</span> at line <?php echo $_smarty_tpl->tpl_vars['e_line']->value;?>
 in file <?php echo $_smarty_tpl->tpl_vars['e_file']->value;?>
:</h2>
					<p class="message">
						<strong>Message:</strong>
					</p>
					<pre><?php echo $_smarty_tpl->tpl_vars['e_message']->value;?>
</pre>
					<p class="message btn">
						<a id="open" href="javascript:toggle();">View Full Trace &darr;</a>
					</p>
					<pre id="show" style="display: none;"><?php echo $_smarty_tpl->tpl_vars['e_trace']->value;?>
</pre>
				</div>
			<?php }?>
        </div>
    </body>
</html>
<?php }
}
