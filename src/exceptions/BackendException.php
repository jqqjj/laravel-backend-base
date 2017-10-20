<?php

namespace App\Exceptions;

use Exception;

class BackendException extends Exception
{
    private $data;
    
    public function __construct($code, $message="", array $data=[])
    {
        parent::__construct($message,$code);
        $this->data = $data;
    }
    
    public function getData()
    {
        return $this->data;
    }
}
