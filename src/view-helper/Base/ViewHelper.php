<?php


namespace App\Http\ViewHelper\Base;

use RuntimeException;

class ViewHelper
{
    private $_alias = [];
    private $_instances = [];
    
    public function __construct()
    {
        $this->_alias = config("backend.helpers");
    }
    
    public function __call($name, $arguments)
    {
        return $this->_getHelperInstance($name,$arguments);
    }
    
    private function _getHelperInstance($helper_name,$arguments)
    {
        if(!key_exists($helper_name, $this->_alias)){
            throw new RuntimeException("ViewHelper '{$helper_name}' doesn't exists.");
        }
        
        if(!isset($this->_instances[$helper_name])){
            $this->_instances[$helper_name] = app()->make($this->_alias[$helper_name], $arguments);
        }
        
        return $this->_instances[$helper_name];
    }
}