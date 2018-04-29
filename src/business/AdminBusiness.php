<?php

namespace App\Http\Business;

use App\Model\Admin;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;
use App\Exceptions\BusinessException;

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
        if(isset($condition['enabled'])){
            $builder->where('enabled',$condition['enabled']);
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
        
        $validator = Validator::make($data, [
            'name' => ['sometimes','required','between:4,16'],
            'password' => ['sometimes','required','between:6,32'],
            'nick_name' => ['sometimes','max:50'],
            'email' => ['sometimes','required','email'],
            'enabled' => ['sometimes','required','in:0,1'],
            'last_login_ip' => ['sometimes','required','ip'],
            'last_login_time' => ['sometimes','required','date_format:"Y-m-d H:i:s"'],
        ],[
            'required'=>":attribute 不能为空",
            "between"=>":attribute 字数必须大于:min小于:max",
            "in"=>":attribute 选项不正确",
            'email'=>":attribute 格式不正确",
            "max"=>":attribute 不得多于:max字数",
            'ip'=>":attribute 格式不正确",
            'date_format'=>":attribute 格式不正确",
        ],[
            'name'=>'登录名称',
            'password'=>'登录密码',
            'nick_name'=>'昵称',
            'email'=>'电子邮件',
            'enabled'=>'是否冻结',
            'last_login_ip'=>'最后登录IP',
            'last_login_time'=>'最后登录时间',
        ]);
        if ($validator->fails()) {
            throw new BusinessException(1000,$validator->messages()->first());
        }
        
        foreach(array_intersect_key($data, array_flip([
            'name',
            'password',
            'nick_name',
            'email',
            'enabled',
            'last_login_ip',
            'last_login_time',
        ])) as $key=>$value){
            $builder->$key = $value;
        }
        if(!empty($data['password'])){
            $builder->password = bcrypt($data['password']);
        }
        
        $builder->save();
        
        return $builder;
    }
    
    public function store($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required','between:4,16'],
            'password' => ['required','between:6,32'],
            'nick_name' => ['sometimes','required','max:50'],
            'email' => ['required','email'],
            'enabled' => ['sometimes','required','in:0,1'],
            'last_login_ip' => ['sometimes','required','ip'],
            'last_login_time' => ['sometimes','required','date_format:"Y-m-d H:i:s"'],
        ],[
            'required'=>":attribute 不能为空",
            "between"=>":attribute 字数必须大于:min小于:max",
            "in"=>":attribute 选项不正确",
            'email'=>":attribute 格式不正确",
            "max"=>":attribute 不得多于:max字数",
            'ip'=>":attribute 格式不正确",
            'date_format'=>":attribute 格式不正确",
        ],[
            'name'=>'登录名称',
            'password'=>'登录密码',
            'nick_name'=>'昵称',
            'email'=>'电子邮件',
            'enabled'=>'是否冻结',
            'last_login_ip'=>'最后登录IP',
            'last_login_time'=>'最后登录时间',
        ]);
        if ($validator->fails()) {
            throw new BusinessException(1000,$validator->messages()->first());
        }
        
        $builder = new Admin();
        foreach(array_intersect_key($data, array_flip([
            'name',
            'password',
            'nick_name',
            'email',
            'enabled',
            'last_login_ip',
            'last_login_time',
        ])) as $key=>$value){
            $builder->$key = $value;
        }
        if(!empty($data['password'])){
            $builder->password = bcrypt($data['password']);
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
