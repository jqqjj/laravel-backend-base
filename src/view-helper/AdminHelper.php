<?php


namespace App\Http\ViewHelper;

use Illuminate\Support\Facades\Auth;
use App\Model\Admin;

class AdminHelper
{
    public function autoname($admin = null)
    {
        $adminModel = $this->_getAdmin($admin);
        return $adminModel->nick_name ? : $adminModel->name;
    }
    
    public function nickname($admin = null)
    {
        $adminModel = $this->_getAdmin($admin);
        return $adminModel->nick_name;
    }
    
    public function name($admin = null)
    {
        $adminModel = $this->_getAdmin($admin);
        return $adminModel->name;
    }
    
    private function _getAdmin($admin)
    {
        if($admin instanceof Admin){
            return $admin;
        }elseif(!empty($admin)){
            return Admin::withTrashed()->findOrFail($admin);
        }else{
            return Auth::guard("backend")->user();
        }
    }
}