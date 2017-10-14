<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Roles;

class Admin extends Authenticatable
{
    //使用软删除
    use SoftDeletes;
    
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    
    public function hasPermission($expression)
    {
        $permissions = [];
        foreach ($this->roles()->get() as $role){
            $permissions = array_merge($permissions,$role->permissions()->pluck('permission')->toArray());
        }
        return array_intersect(explode('|', $expression),$permissions) || $this->admin_id==1;
    }
    
    public function roles()
    {
        return $this->belongsToMany(Roles::class,'admin_roles','admin_id','role_id')->withTimestamps();
    }
}
