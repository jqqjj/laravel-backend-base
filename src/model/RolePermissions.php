<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Roles;

class RolePermissions extends Model
{
    protected $table = 'role_permissions';
    protected $primaryKey = 'role_permission_id';
    
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'role_id')->withTimestamps();
    }
}
