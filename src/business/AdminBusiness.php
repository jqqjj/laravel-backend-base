<?php

namespace App\Http\Business;

use App\Model\Admin;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;
use App\Exceptions\BackendException;

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
        if(!empty($condition['nick_name'])){
            $builder->where('nick_name',$condition['nick_name']);
        }
        if(!empty($condition['keyword'])){
            $builder->where(function($query) use ($condition){
                $query->where('email',"like","%{$condition['keyword']}%")
                    ->orWhere('name',"like","%{$condition['keyword']}%")
                    ->orWhere('nick_name',"like","%{$condition['keyword']}%");
            });
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
        $builder->save();
        
        return $builder;
    }
    
    public function store($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required','between:4,16'],
            'email' => ['required','email'],
            'password' => ['required','between:6,32'],
        ],[
            'required'=>":attribute不能为空",
            "between"=>":attribute字数必须大于:min小于:max",
            'email'=>":attribute格式不正确",
            "max"=>":attribute必须不多于:max字数",
        ],[
            'name'=>'登录名称',
            'password'=>'登录密码',
            'nick_name'=>'昵称',
            'email'=>'电子邮件',
        ]);
        $validator->sometimes("nick_name",["max:50"],function($input){
            return !empty($input['nick_name']);
        });
        if ($validator->fails()) {
            throw new BackendException(1000,$validator->messages()->first());
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
        $builder->save();
        
        return $builder;
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
