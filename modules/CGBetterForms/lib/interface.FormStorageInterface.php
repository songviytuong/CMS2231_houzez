<?php
namespace CGBetterForms;

interface FormStorageInterface
{
    public static function table_name();
    public function Save( Form $form );
    public function list_all();
    public function load( $name );
    public function load_by_id( $id );
    public function exists( $name );
}