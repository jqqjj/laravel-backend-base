<?php

namespace App\Http\Business;

use App\Model\Admin;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;

class AdminBusiness
{
    public function getList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $builder = Admin::select($select_columns);
        
        if(!empty($condition['admin_id'])){
            $builder->where('admin_id',$condition['admin_id']);
        }
        if(!empty($condition['name'])){
            $builder->where('name',$condition['name']);
        }
        if(!empty($condition['email'])){
            $builder->where('email',$condition['email']);
        }
        
        if(!empty($relatives)){
            $builder->with($relatives);
        }
        
        return Pagination::make($builder,$condition);
    }
    
    public function getDetail($id, array $select_columns = ['*'], array $relatives = [])
    {
        $builder = Admin::select($select_columns);
        if(!empty($relatives)){
            $builder->with($relatives);
        }
        return $builder->find($id);
    }
    
    public function update($id,$data)
    {
        $builder = Admin::find($id);
        if(empty($builder)){
            return false;
        }
        if(!empty($data['name'])){
            $builder->name = $data['name'];
        }
        if(!empty($data['email'])){
            $builder->email = $data['email'];
        }
        if(isset($data['nick_name'])){
            $builder->nick_name = $data['nick_name'];
        }
        if(isset($data['enabled'])){
            $builder->enabled = $data['enabled'] ? 1 : 0;
        }
        if(!empty($data['password'])){
            $builder->password = bcrypt($data['password']);
        }
        if(!empty($data['remember_token'])){
            $builder->remember_token = $data['remember_token'];
        }
        if(!empty($data['last_login_ip'])){
            $builder->last_login_ip = $data['last_login_ip'];
        }
        if(!empty($data['last_login_time'])){
            $builder->last_login_time = $data['last_login_time'];
        }
        return $builder->save() ? $builder : false;
    }
    
    public function store($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required','between:4,16'],
            'email' => ['required','email'],
            'password' => ['required','between:6,32'],
        ]);
        if ($validator->fails()) {
            return false;
        }
        
        $builder = new Admin();
        $builder->name = $data['name'];
        $builder->email = $data['email'];
        $builder->password = bcrypt($data['password']);
        if(!empty($data['nick_name'])){
            $builder->nick_name = $data['nick_name'];
        }
        if(isset($data['enabled'])){
            $builder->enabled = $data['enabled'] ? 1 : 0;
        }
        if(!empty($data['remember_token'])){
            $builder->remember_token = $data['remember_token'];
        }
        if(!empty($data['last_login_ip'])){
            $builder->last_login_ip = $data['last_login_ip'];
        }
        if(!empty($data['last_login_time'])){
            $builder->last_login_time = $data['last_login_time'];
        }
        return $builder->save() ? $builder : false;
    }
    
    public function delete($id)
    {
        if($id==1){/*超级管理员不能被删除*/
            return false;
        }
        $admin = Admin::find($id);
        if(empty($admin)){
            return false;
        }
        //清理角色数据
        foreach($admin->roles as $role){
            $admin->roles()->detach($role->role_id);
        }
        return $admin->delete();
    }
}
