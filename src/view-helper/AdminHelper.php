<?php


namespace App\Http\ViewHelper;

use Illuminate\Support\Facades\Auth;
use App\Model\Admin;

class AdminHelper
{
    private $admin;
    
    public function __construct($admin = null)
    {
        if($admin instanceof Admin){
            $this->admin = $admin;
        }elseif(!empty($admin)){
            $this->admin = Admin::findOrFail($admin);
        }else{
            $this->admin = Auth::guard("backend")->user();
        }
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