<?php


namespace App\Http\ViewHelper;

use Illuminate\Support\Facades\Auth;

class AdminHelper
{
    private $admin;
    
    public function __construct()
    {
        $this->admin = Auth::guard("backend")->user();
    }
    
    public function autoname()
    {
        return $this->admin->nick_name ? : $this->admin->name;
    }
    
    public function nickname()
    {
        return $this->admin->nick_name;
    }
    
    public function name()
    {
        return $this->admin->name;
    }
}