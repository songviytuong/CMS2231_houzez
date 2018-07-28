<?php

function smarty_function_qrcode($params, &$smarty) {
    
    $gCms = CmsApp::get_instance();
    $config = $gCms->GetConfig();
    
    $file_name = isset($params['file_name']) ? $params['file_name'] : "QRCODE";
    $alt = isset($params['alt']) ? $params['alt'] : 'QRCODE';
    $title = isset($params['title']) ? $params['title'] : 'QRCODE';
    $size = isset($params['size']) ? $params['size'] : "3";
    $zoom = isset($params['zoom']) ? $params['zoom'] : "4";
    $content = isset($params['content']) ? $params['content'] : "http://www.google.com";
    $type = isset($params['type']) ? $params['type'] : '';
    $cache_url = $config['uploads_path'] . '/_CGSmartImage/qrcode/';
    
    if (!is_file(cms_join_path($cache_url, '/index.html')))
        file_put_contents(cms_join_path($cache_url, '/index.html'), '');
    if (!file_exists($cache_url)) {
        cge_dir::mkdirr($cache_url);
    }
    
    if (!file_exists(cms_join_path($cache_url, $file_name . '.png'))) {
        switch ($type) {
            case 'skypecall':
                // here our data 
                $skypeuser = isset($params['skypeuser']) ? $params['skypeuser'] : 'songviytuong';
                // we building raw data 
                $content = 'skype:' . urlencode($skypeuser) . '?call';
                // generating
                QRcode::png($content, $cache_url . 'skype.' . $file_name . '.png', QR_ECLEVEL_L, $size, $zoom);
                break;
            default:
                QRcode::png($content, $cache_url . $file_name . '.png', QR_ECLEVEL_L, $size, $zoom);
                break;
        }
    } else {
        $file = $file_name . '.png';
        if (file_exists(cms_join_path($cache_url, $file))) {
            
        }
    }
    
    $tmp = $config['uploads_url'] . '/_CGSmartImage/qrcode/' . $file;
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
