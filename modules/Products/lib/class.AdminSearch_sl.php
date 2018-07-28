<?php
namespace Products;

/* note, class cannot be named AdminSearch_slave as the filename then conflicts with that in the AdminSearch module, resulting in an error */
final class AdminSearch_sl extends \AdminSearch_slave
{
    public function get_name()
    {
        $mod = \cms_utils::get_module(MOD_PRODUCTS);
        return $mod->Lang('adminsearch_lbl');
    }

    public function get_description()
    {
        $mod = \cms_utils::get_module(MOD_PRODUCTS);
        return $mod->Lang('adminsearch_desc');
    }

    public function check_permission()
    {
        $userid = get_userid();
        return check_permission($userid,'Modify Products');
    }

    public function get_matches()
    {
        $orec = [ 'title'=>null,'description'=>null,'edit_url'=>null,'text'=>null ];
        $mod = \cms_utils::get_module(MOD_PRODUCTS);
        $db = $mod->GetDb();
        $term = '%'.$this->get_text().'%';

        $fielddefs = \product_utils::get_fielddefs(true);
        $cols = [ 'P.*' ];
        $joins = $where = $parms = [];
        $where[] = 'P.product_name LIKE ?'; $parms[] = $term;
        $where[] = 'P.details LIKE ?'; $parms[] = $term;

        if( count($fielddefs) ) {
            $idx = 1;
            foreach( $fielddefs as $one ) {
                if( !in_array($one->type, ['textbox','textarea','imagetext','file']) ) continue;
                $tmp = "FV".$idx;
                $fdid = $one->id;
                $cols[] = "$tmp.value";
                $joins[] = 'LEFT JOIN '.ProductStorage::product_fieldvals_table_name()." $tmp ON P.id = $tmp.product_id AND $tmp.fielddef_id = $fdid";
                $where[] = "$tmp.value LIKE ?";
                $parms[] = $term;
                $idx++;
            }
        }

        // build the query
        $sql = 'SELECT '.implode(',',$cols).' FROM '.ProductStorage::product_table_name().' P';
        if( count($joins) ) $sql .= ' ' . implode(' ',$joins);
        if( count($where) ) $sql .= ' WHERE '.implode(' OR ',$where);
        $sql .= 'ORDER BY P.modified_date DESC';
        $dbr = $db->GetArray($sql, $parms );
        if( !is_array($dbr) || !count($dbr) ) return;

        $out = [];
        foreach( $dbr as $row ) {
            foreach( $row as $key => $val ) {
                if( ($pos = strpos($val,$this->get_text())) ) {
                    // use the first occurrance
                    $start = max(0,$pos - 50);
                    $end = min(strlen($val),$pos+50);
                    $text = substr($val,$start,$end-$start);
                    $text = cms_htmlentities($text);
                    $text = str_replace($this->get_text(),'<span class="search_oneresult">'.$this->get_text().'</span>',$text);
                    $text = str_replace("\r",'',$text);
                    $text = str_replace("\n",'',$text);
                    break;
                }
            }
            $rec = $orec;
            $rec['title'] = $row['product_name'];
            $rec['description'] = \AdminSearch_tools::summarize( $row['details'] );
            $rec['edit_url'] = $mod->create_url( 'm1_', 'editproduct', '', [ 'compid'=>$row['id'] ] );
            $rec['text'] = $text;
            $out[] = $rec;
        }
        return $out;
    }
} // end of class