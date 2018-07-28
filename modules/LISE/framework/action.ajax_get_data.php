<?php

$status = true;
$action = "";

$core_actions_get = array(
    'half-map'
);

$core_actions_post = array(
    'houzez_half_map_listings'
);

if (!empty($_GET['action']) && in_array($_GET['action'], $core_actions_get)) {
    $status = true;
    $action = $_GET['action'];
}

if (!empty($_POST['action']) && in_array($_POST['action'], $core_actions_post)) {
    $status = true;
    $action = $_POST['action'];
}

if ($status) {
    $action = strtolower($action);
    switch ($action) {
        case 'houzez_half_map_listings';
            houzez_half_map_listings();
            break;
    }
}

function houzez_half_map_listings() {

    $db = \cge_utils::get_db();

    $query = 'SELECT R.*,T.title as TType FROM ' . CMS_DB_PREFIX . 'houzez_realestate R';
    $where = array();
    $qparms = array();
    $joins = array();

    $joins[] = CMS_DB_PREFIX . 'houzez_realestate_type T ON T.id = R.type';

    if ($_POST['min_price'] || $_POST['max_price']) {
        $where[] = " R.price >=" . better_strip_tags($_POST['min_price']);
        $where[] = " R.price <=" . better_strip_tags($_POST['max_price']);
    }

    $expr = ' AND ';
    if (isset($obj['useor']) && $obj['useor'])
        $expr = ' OR ';
    if (count($joins))
        $query .= ' LEFT JOIN ' . implode(' LEFT JOIN ', $joins);
    if (count($where))
        $query .= ' WHERE ' . implode($expr, $where);

//    $offset = 0;
//    $limit = 100000;
//    if ($obj['limit'] > 0) {
//        $limit = (int) $obj['limit'];
//        $offset = (int) $obj['offset'];
//    }

    $arr = array();
    $arr['getProperties'] = TRUE;
    $dbresult = $db->SelectLimit($query);
    while ($dbresult && $row = $dbresult->FetchRow()) {
        $arr['properties'][] = array(
            'id' => $row['real_id'],
            'title' => $row['title'],
            'sanitizetitle' => $row['sanitizetitle'],
            'lat' => $row['lat'],
            'lng' => $row['lng'],
            'bedrooms' => $row['bedrooms'],
            'bathrooms' => $row['bathrooms'],
            'address' => $row['address'],
            'thumbnail' => '<img width="385" height="258" src="http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-385x258.jpg" class="attachment-houzez-property-thumb-image size-houzez-property-thumb-image wp-post-image" alt="" srcset="http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-385x258.jpg 385w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-300x202.jpg 300w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-768x516.jpg 768w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-1024x688.jpg 1024w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-150x101.jpg 150w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10-350x235.jpg 350w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/new-york-10.jpg 1170w" sizes="(max-width: 385px) 100vw, 385px" />"',
            'url' => 'http://houzez01.favethemes.com/property/design-place-apartment/',
            'prop_meta' => '<p><span>Beds: ' . $row['bedrooms'] . '</span><span>Baths: ' . $row['bathrooms'] . '</span><span>Sq Ft: 3890</span></p>',
            'type' => $row['TType'],
            'images_count' => 7,
            'price' => '<span class="item-price">$' . number_format($row['price'], 2) . '</span>',
            'icon' => 'http://sandbox.favethemes.com/houzez/wp-content/uploads/2016/02/x1-apartment.png',
            'retinaIcon' => 'http://sandbox.favethemes.com/houzez/wp-content/uploads/2016/02/x2-apartment.png'
        );

        $arr['html'][] = '<div id="' . $row['real_id'] . '" class="item-wrap infobox_trigger item-luxury-family-home">
    <div class="property-item table-list">
        <div class="table-cell">
            <div class="figure-block">
                <figure class="item-thumb">

                    <div class="label-wrap label-right hide-on-list">
                        <span class="label-status label-status-7 label label-default"><a href="http://houzez01.favethemes.com/status/for-sale/">For Sale</a></span><span class="label label-default label-color-288"><a href="http://houzez01.favethemes.com/label/open-house/">Open House</a></span> </div>

                    <div class="price hide-on-list"><span class="item-price">$670,000.00</span><span class="item-sub-price">$1,300.00/mo</span></div>
                    <a class="hover-effect" href="http://houzez01.favethemes.com/property/luxury-family-home-4-2/">
                        <img width="385" height="258" src="http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-385x258.jpg" class="attachment-houzez-property-thumb-image size-houzez-property-thumb-image wp-post-image" alt="" srcset="http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-385x258.jpg 385w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-300x202.jpg 300w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-768x516.jpg 768w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-1024x688.jpg 1024w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-150x101.jpg 150w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06-350x235.jpg 350w, http://houzez01.favethemes.com/wp-content/uploads/2016/03/chicago-06.jpg 1170w" sizes="(max-width: 385px) 100vw, 385px"> </a>
                    <ul class="actions">

                        <li>

                            <span class="add_fav" data-placement="top" data-toggle="tooltip" data-original-title="Favorite" data-propid="6845"><i class="fa fa-heart-o"></i></span>
                        </li>

                        <li>
                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="(7) ">
                                <i class="fa fa-camera"></i>
                            </span>
                        </li>

                        <li>
                            <span id="compare-link-6845" class="compare-property" data-propid="6845" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare">
                                <i class="fa fa-plus"></i>
                            </span>
                        </li>
                    </ul>
                </figure>
            </div>
        </div>
        <div class="item-body table-cell">

            <div class="body-left table-cell">
                <div class="info-row">
                    <div class="label-wrap hide-on-grid">
                        <span class="label-status label-status-7 label label-default"><a href="http://houzez01.favethemes.com/status/for-sale/">For Sale</a></span><span class="label label-default label-color-288"><a href="http://houzez01.favethemes.com/label/open-house/">Open House</a></span> </div>
                    <h2 class="property-title"><a href="http://houzez01.favethemes.com/property/luxury-family-home-4-2/">' . $row['title'] . '</a></h2><address class="property-address">S Western Ave</address> </div>
                <div class="info-row amenities hide-on-grid">
                    <p><span>Beds: 4</span><span>Baths: 2</span><span>Sq Ft: 1200</span></p>
                    <p>Single Family Home</p>
                </div>

                <div class="info-row date hide-on-grid">
                    <p class="prop-user-agent"><i class="fa fa-user"></i> <a href="http://houzez01.favethemes.com/agencies/all-american-real-estate/">All American Real Estate</a> </p>
                    <p><i class="fa fa-calendar"></i>8 months ago</p>
                </div>

            </div>
            <div class="body-right table-cell hidden-gird-cell">

                <div class="info-row price"><span class="item-price">$' . number_format($row['price'], 2) . '</span><span class="item-sub-price">$1,300.00/mo</span></div>

                <div class="info-row phone text-right">
                    <a href="http://houzez01.favethemes.com/property/luxury-family-home-4-2/" class="btn btn-primary">Details <i class="fa fa-angle-right fa-right"></i></a>
                </div>
            </div>

            <div class="table-list full-width hide-on-list">
                <div class="cell">
                    <div class="info-row amenities">
                        <p><span>Beds: 4</span><span>Baths: 2</span><span>Sq Ft: 1200</span></p>
                        <p>Single Family Home</p>

                    </div>
                </div>
                <div class="cell">
                    <div class="phone">
                        <a href="http://houzez01.favethemes.com/property/luxury-family-home-4-2/" class="btn btn-primary"> Details <i class="fa fa-angle-right fa-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="item-foot date hide-on-list">
        <div class="item-foot-left">
            <p class="prop-user-agent"><i class="fa fa-user"></i> <a href="http://houzez01.favethemes.com/agencies/all-american-real-estate/">All American Real Estate</a> </p>
        </div>

        <div class="item-foot-right">
            <p class="prop-date"><i class="fa fa-calendar"></i>8 months ago</p>
        </div>
    </div>

</div>';
    }


    $arr['propHtml'] = implode($arr['html'], '');
    $arr['min_price'] = ($_POST['min_price']) ? better_strip_tags($_POST['min_price']) : 1200;
    $arr['max_price'] = ($_POST['max_price']) ? better_strip_tags($_POST['max_price']) : 1600;
    echo json_encode($arr);
}

function better_strip_tags($str) {
    $str = str_replace("$", "", $str);
    $str = str_replace(",", "", $str);
    return $str;
}

?>