<?php
namespace CGBetterForms;

class ModuleReference
{
    private $_module_name;

    public function __construct( $mod_name )
    {
        $this->_module_name = trim( $mod_name );
        if( !$this->_module_name ) throw new \LogicException('Cannot initialize a '.__CLASS__.' with an empty value');
    }

    protected function get_mod()
    {
        $mod = \cms_utils::get_module( $this->_module_name );
        if( !$mod ) throw new \RuntimeException("Module {$this->_module_name} is referenced but not available");
        return $mod;
    }

    public function __get( $key )
    {
        if( $key == 'name' ) return $this->_module_name;


        throw new \LogicException("$key is not a gettable member of ".__CLASS__);
    }

    public function __set( $key, $val )
    {
        throw new \LogicException("$key is not a settable member of ".__CLASS__);
    }

    public function __invoke( $args )
    {
        // called as $reference()->something.
        return $this->get_mod();
    }

    public function __call( $method, $args )
    {
        // called like $reference->something()
        return call_user_func_array( [ $this->get_mod(), $method ], $args );
    }
}
