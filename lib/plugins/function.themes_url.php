<?php
function smarty_function_themes_url($params, &$smarty)
{
    $config = CmsApp::get_instance()->GetConfig();
    $out = $config->smart_themes_url();
    if (isset($params['assign'])) {
        $smarty->assign(trim($params['assign']), $out);
        return;
    }
    return $out;
}

function smarty_cms_about_function_themes_url() {
?>
    <p>Author: Lee Peace songviytuong@gmail.com;</p>
    <p>Change History:</p>
    <ul>
        <li>None</li>
    </ul>
<?php
}
?>