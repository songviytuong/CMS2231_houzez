<?php

if( !isset($gCms) ) exit();
if( !$this->CheckPermission('Modify Products') ) return;
if( !isset($params['prodid']) ) return;

$this->SetCurrentTab('products');
$product = $this->GetProductStorage()->get_by_id( \cge_param::get_int($params,'prodid') );
$skel = new \Products\ProductAttribute();
$attribs = [ $skel ];
if( $product->attribs ) $attribs = $product->attribs;

if( isset($params['cancel']) ) {
    $this->SetMessage($this->Lang('operation_cancelled'));
    $this->RedirectTotab($id);
}
if( isset($params['copyattribs']) ) {
    if( !isset($params['copyfrom']) || $params['copyfrom'] < 1 ) {
        echo $this->ShowErrors($this->Lang('error_missingparam'));
    }
    else {
        $product2 = $this->GetProductStorage()->get_by_id( \cge_param::get_int( $params, 'copyfrom') );
        $attribs = $product2->attribs;
        echo $this->ShowMessage($this->Lang('msg_optionscopied'));
    }
}
if( isset($params['submit']) ) {
    try {
        products_attrib::delete_by_product($params['prodid']);
        if( isset($params['sku']) && isset($params['text']) ) {
            // we have some options.
            $attribs = [];
            $keys = [ 'text','adjustment','sku','qoh','notes' ];
            for( $i = 0; $i < count($params['sku']); $i++ ) {
                $rec = [ 'product_id'=>(int)$params['prodid'] ] ;
                foreach( $keys as $key ) {
                    $rec[$key] = $params[$key][$i];
                }
                $attrib = new \Products\ProductAttribute();
                $attrib->from_array($rec);
                $attribs[] = $attrib;
            }
            $product->set_attributes( $attribs );
        }
        
        products_highlights::delete_by_product($params['prodid']);
        if (isset($params['highlight'])) {
            // we have some options.
            $highlights = [];
            $keys = ['highlight'];
            for ($i = 0; $i < count($params['highlight']); $i++) {
                $rec = [ 'product_id'=>(int)$params['prodid'] ] ;
                foreach ($keys as $key) {
                    $rec[$key] = $params[$key][$i];
                }
                $highlight = new \Products\ProductHighlights();
                $highlight->from_array($rec);
                $highlights[] = $highlight;
            }
            $product->set_highlights($highlights);
        }
        
        $this->GetProductStorage()->save( $product );

        $this->SetMessage($this->Lang('msg_options_saved'));
        $this->RedirectToTab($id);
    }
    catch( CmsException $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}
else {
  $tmp = products_attrib::load_by_product($params['prodid']);
  if( is_array($tmp) && count($tmp) ) {
	$attribs = $tmp;
  }
}


// get a list of products (except this one) with options
// todo: use productStorage method.
$query = 'SELECT DISTINCT P.id,P.product_name FROM '.cms_db_prefix().'module_products_attribs A
          LEFT JOIN '.cms_db_prefix().'module_products P
          ON A.product_id = P.id WHERE A.product_id != ?
          ORDER BY product_name ASC';
$tmp = $db->GetArray($query,[ $product->id ]);
if( is_array($tmp) && count($tmp) ) {
  $t2 = array();
  foreach( $tmp as $rec ) {
	$t2[$rec['id']] = $rec['product_name'];
  }
  $smarty->assign('products_with_attribs',$t2);
}

$smarty->assign('product',$product);
$smarty->assign('sku_is_required',$this->GetPreference('skurequired',0));
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_edit_attribs','',array('prodid'=>$params['prodid'])));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('skel_row',$skel);
$smarty->assign('attribs',$attribs);
echo $this->CGProcessTemplate('admin_edit_attribs.tpl');

#
# EOF
#