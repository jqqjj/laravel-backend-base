<?php

/**
 * 权限辅助
 */

namespace App\Http\ViewHelper;

use App\Helpers\Permission;

class PermissionHelper
{
    private $permission;
    
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
    
    public function __call($name, $arguments)
    {
        return $this->permission->{$name}(...$arguments);
    }
}