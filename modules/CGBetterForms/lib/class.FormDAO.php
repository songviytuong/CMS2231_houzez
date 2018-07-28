<?php
namespace CGBetterForms;

class FormDAO implements FormStorageInterface
{
    private $_db;
    private $_name_cache;

    public function __construct( $db )
    {
        $this->_db = $db;
    }

    public static function table_name()
    {
        return CMS_DB_PREFIX.'mod_cgbf_forms';
    }

    protected function _insert( Form $form )
    {
        $sql = 'INSERT INTO '.self::table_name().' (name, data, created, modified) VALUES (?,?,UNIX_TIMESTAMP(),UNIX_TIMESTAMP())';
        $this->_db->Execute( $sql, [ $form->name, serialize($form) ] );
    }

    protected function _update( Form $form )
    {
        $sql = 'UPDATE '.self::table_name().' SET name = ?, data = ?, modified = UNIX_TIMESTAMP() WHERE id = ?';
        $this->_db->Execute( $sql, [ $form->name, serialize($form), $form->id ] );
    }

    // form object cannot be altered and re-saved after saving.
    public function Save( Form $form )
    {
        if( $form->id < 1 ) {
            return $this->_insert( $form );
        }
        else {
            return $this->_update( $form );
        }
    }

    public function list_all()
    {
        $sql = 'SELECT id,name FROM '.self::table_name().' ORDER BY name ASC';
        $tmp = $this->_db->GetArray($sql);
        if( !$tmp || !count($tmp) ) return;

        $out = [];
        foreach( $tmp as $row ) {
            $out[$row['id']] = $row['name'];
        }
        return $out;
    }

    public function exists( $name )
    {
        if( ! $this->_name_cache ) {
            $this->_name_cache = [];
            $name = trim($name);
            if( !$name ) throw new \LogicException('Invalid form name passed to '.__METHOD__);

            $sql = 'SELECT id,name FROM '.self::table_name();
            $tmp = $this->_db->GetArray( $sql );
            if( count($tmp) ) $this->_name_cache = $tmp;
        }
        foreach( $this->_name_cache as $row ) {
            if( $row['name'] == $name ) return TRUE;
        }
    }

    public function load( $name )
    {
        $name = trim($name);
        if( !$name ) throw new \LogicException('Invalid form name passed to '.__METHOD__);

        $sql = 'SELECT * FROM '.self::table_name().' WHERE name = ?';
        $row = $this->_db->GetRow($sql,[ $name ]);
        if( !is_array($row) && !count($row) ) return;

        $obj = unserialize($row['data']);
        unset($row['data']);
        $obj->adjustPrivate( $row );
        return $obj;
    }

    public function load_by_id( $id )
    {
        $id = (int) $id;
        if( $id < 1 ) throw new \LogicException('Invalid form id passed to '.__METHOD__);

        $sql = 'SELECT * FROM '.self::table_name().' WHERE id = ?';
        $row = $this->_db->GetRow($sql,[ $id ]);
        if( !is_array($row) && !count($row) ) return;

        $obj = unserialize($row['data']);
        unset($row['data']);
        $obj->adjustPrivate( $row );
        return $obj;
    }

    public function delete( Form $form )
    {
        if( $form->id < 1 ) throw new \LogicException('Cannot delete a form that has not been saved');

        $sql = 'DELETE FROM '.self::table_name().' WHERE id = ?';
        $this->_db->Execute( $sql, [ $form->id] );
    }
} // end of class