<?php

function smarty_function_barcode($params, &$smarty) {
    
    $gCms = CmsApp::get_instance();
    $config = $gCms->GetConfig();

    $file_name = isset($params['file_name']) ? $params['file_name'] : "BARCODE";
    $alt = isset($params['alt']) ? $params['alt'] : 'BARCODE';
    $title = isset($params['title']) ? $params['title'] : 'BARCODE';
    $content = isset($params['content']) ? $params['content'] : "ABC-1234";
    $cache_url = $config['uploads_path'] . '/_CGSmartImage/barcode/';

    if (!file_exists($cache_url)) {
        cge_dir::mkdirr($cache_url);
    }
    if (!is_file(cms_join_path($cache_url, '/index.html')))
        file_put_contents(cms_join_path($cache_url, '/index.html'), '');

    if (!file_exists(cms_join_path($cache_url, $file_name . '.png'))) {
        generate_barcode($content, cms_join_path($cache_url, $file_name . '.png'));
    } else {
        $file = $file_name . '.png';
        if (file_exists(cms_join_path($cache_url, $file))) {
            
        }
    }
    $tmp = $config['uploads_url'] . '/_CGSmartImage/barcode/' . $file;
    if (isset($params['assign'])) {
        $smarty->assign(trim($params['assign']), $tmp);
        return;
    }
    // Read image path, convert to base64 encoding
    $imageData = base64_encode(file_get_contents($tmp));
    // Format the image SRC:  data:{mime};base64,{data};
    $src = 'data: ' . mime_content_type($tmp) . ';base64,' . $imageData;
    echo '<img src="' . $src . '" alt="' . $alt . '" title="' . $title . '">';
}