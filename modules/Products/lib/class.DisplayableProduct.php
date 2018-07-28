<?php
namespace Products;

class DisplayableProduct extends Product
{
    private $_ddata = [ 'notpretty'=>null, 'hierpage'=>null, 'detailpage'=>null, 'detailtemplate'=>null, 'curpage'=>null ];
    private $_cache_fields;
    private $_cache_cats;

    public function __construct( Product $in, array $params = null)
    {
        $mod = \cms_utils::get_module(MOD_PRODUCTS);
        $this->from_array( $in->to_array() );
        if( !is_null($params) ) {
            $this->_ddata['curpage'] = \cge_param::get_int($params,'curpage');
            $this->_ddata['detailpage'] = \cge_param::get_int($params,'detailpage');
            $this->_ddata['notpretty'] = \cge_param::get_string($params,'notpretty');
            $this->_ddata['hierpage'] = \cge_param::get_string($params,'hierpage');
            if( $this->_ddata['curpage'] < 1 ) throw new \LogicException('An invalid curpage was passed to'.__METHOD__);
        }
    }

    public function __get($key)
    {
        $mod = \cms_utils::get_module(MOD_PRODUCTS);

        switch( $key )
        {
        case 'curpage':
            return (int) $this->_ddata['curpage'];

        case 'detailpage':
            if( $this->_ddata['detailpage'] > 0 ) return $this->_ddata['detailpage'];
            return $this->_ddata['curpage'];

        case 'detailtemplate':
            return $this->_ddata['detailtemplate'];

        case 'price':
            $out = $mod->get_adjusted_price( $this, parent::__get('price') );
            return $out;

        case 'file_location':
            return \product_utils::get_product_upload_url( $this->id );

        case 'hierarchy_id':
            return $this->first_hierarchy;
            break;

        case 'hierpage':
        case 'hierarchy_page':
            return $this->_ddata['hierpage'];

        case 'breadcrumb':
            if( ($tmp = $this->hierarchy_id) ) return \hierarchy_ops::get_breadcrumb('prod',$tmp,$this->hierarchy_page);
            break;

        case 'detail_page':
            return $this->_ddata['detailpage'];

        case 'detail_url':
        case 'canonical':
            $pretty = (!$this->notpretty || strpos($this->notpretty,'details') !== FALSE) ? $this->pretty_detail_url() : null;
            $parms = [ 'productid'=>$this->id ];
            if( $this->detailtemplate ) $parms['detailtemplate'] = $this->detailtemplate;
            return $mod->create_url( 'p_', 'details', $this->detailpage, $parms, false, false, $pretty );

        case 'fields':
            // this is a merge of the fielddefs and products.
            if( !$this->_cache_fields ) {
                $fieldvals = $this->field_vals;
                if( !count($fieldvals) ) return;
                $defs = \product_utils::get_fielddefs();
                foreach( $fieldvals as $fid => $value ) {
                    if( !isset($defs[$fid]) ) continue;
                    $rec = $defs[$fid];
                    $rec->value = $value;
                    $this->_cache_fields[$rec->name] = $rec;
                }
            }
            return $this->_cache_fields;

        case 'categories':
            // this is a merge of the full category info
            if( !$this->_cache_cats ) {
                $member_cats = parent::__get('categories');
                if( !$member_cats ) return;
                $allcats = \product_utils::get_full_categories();
                if( !$allcats ) return;
                foreach( $member_cats as $catid ) {
                    if( !isset($allcats[$catid]) ) continue;
                    $rec = $allcats[$catid];
                    $this->_cache_cats[] = $rec;
                }
            }
            return $this->_cache_cats;

        case 'album':
            return $this->get_extra('album');

        case 'product_name':
            return parent::__get('name');

        default:
            return  parent::__get($key);
        }
    }

    public function __isset($key)
    {
        return true;
    }

    // creates a product detail url.
    protected function pretty_detail_url()
    {
        $module = \cms_utils::get_module(MOD_PRODUCTS);
        $db = \CmsApp::get_instance()->GetDB();

        $pretty_url = null;
        $prefix = $module->GetPreference('urlprefix');
        if( $this->url ) {
            // if we have a url slug we just prepend the prefix (if we have any)
            if( $prefix && !endswith($prefix,'/') ) $prefix .= '/';
            $pretty_url = "{$prefix}{$this->url}";
        }
        else {
            // no urlslug, so build the url based on the prefix, the alias, and the hierarchy stuff.
            $pretty_url = ($prefix)?$prefix:$module->GetName();
            $usereturnid = ((int) $module->GetPreference('detailpage') < 1 );
            $done = false;
            if( $module->GetPreference('usehierpathurls',0) && !empty($this->alias) && $this->hierarchy_id > 0 ) {
                $tmp = \hierarchy_ops::get_hierarchy_info($this->hierarchy_id);
                if( $tmp ) {
                    $tmp2 = explode(' | ',$tmp['long_name']);
                    for( $i = 0; $i < count($tmp2); $i++ ) {
                        $tmp2[$i] = munge_string_to_url($tmp2[$i]);
                    }
                    $path = implode('/',$tmp2);

                    $pretty_url .= '/details';
                    if( $usereturnid ) $pretty_url .= "/$returnid";
                    if( !empty($path) ) $pretty_url .= "/$path";
                    $pretty_url .= "/".$this->alias;
                    $done = true;
                }
            }

            if( !$done ) {
                // old pretty urls... "$prefix/id/$returnid/$something"
                $pretty_url .= '/'.$this->id;
                if( $usereturnid ) $pretty_url .= '/'.$this->detailpage;
                $alias = $this->alias;
                if( empty($alias) ) $alias = \product_utils::make_alias($this->name);
                $pretty_url .= "/$alias";
            }
        }
        return $pretty_url;
    }
}
