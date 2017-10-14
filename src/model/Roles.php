<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\RolePermissions;
use App\Model\Admin;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    
    public function permissions()
    {
        return $this->hasMany(RolePermissions::class, 'role_id');
    }
    
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_roles', 'role_id', 'admin_id')->withTimestamps();
    }
}
