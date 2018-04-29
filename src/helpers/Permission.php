<?php

/**
 * 权限辅助
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Permission
{
    public function has($permission)
    {
        if(Auth::guard('backend')->guest()){
            return false;
        }
        
        return Auth::guard('backend')->user()->hasPermission($permission);
    }
}