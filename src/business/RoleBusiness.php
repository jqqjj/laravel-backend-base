<?php


namespace App\Http\Business;

use App\Model\Roles;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;
use App\Exceptions\BusinessException;

class RoleBusiness
{
    public function getList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $builder = Roles::select($select_columns);
        
        if(!empty($relatives)){
            $builder->with($relatives);
        }
        if(!empty($condition['role_name'])){
            $builder->where('role_name',$condition['role_name']);
        }
        
        return Pagination::make($builder,$condition);
    }
    
    public function update($id,$data)
    {
        $builder = Roles::find($id);
        if(empty($builder)){
            return false;
        }
        
        $validator = Validator::make($data, [
            'role_name' => ['sometimes','required','max:50'],
            'remark' => ['sometimes','max:255'],
        ],[
            'required'=>":attribute不能为空",
            "max"=>":attribute 不得多于:max字数",
        ],[
            'role_name'=>'角色名称',
            'remark'=>'描述',
        ]);
        if ($validator->fails()) {
            throw new BusinessException(1000,$validator->messages()->first());
        }
        
        foreach(array_intersect_key($data, array_flip([
            'role_name',
            'remark',
        ])) as $key=>$value){
            $builder->$key = $value;
        }
        $builder->save();
        
        return $builder;
    }
    
    public function getDetail($id, array $select_columns = ['*'], array $relatives = [])
    {
        $builder = Roles::select($select_columns);
        if(!empty($relatives)){
            $builder->with($relatives);
        }
        return $builder->find($id);
    }
    
    public function store($data)
    {
        $validator = Validator::make($data, [
            'role_name' => ['required','max:50'],
            'remark' => ['sometimes','max:255'],
        ],[
            'required'=>":attribute不能为空",
            "max"=>":attribute 不得多于:max字数",
        ],[
            'role_name'=>'角色名称',
            'remark'=>'描述',
        ]);
        if ($validator->fails()) {
            throw new BusinessException(1000,$validator->messages()->first());
        }
        
        $builder = new Roles();
        foreach(array_intersect_key($data, array_flip([
            'role_name',
            'remark',
        ])) as $key=>$value){
            $builder->$key = $value;
        }
        $builder->save();
        
        return $builder;
    }
    
    public function delete($id)
    {
        $builder = Roles::find($id);
        
        if(empty($builder)){
            return false;
        }
        //清理角色的权限数据
        foreach ($builder->permissions as $each){
            $each->delete();
        }
        //解除与管理员的关系
        foreach ($builder->admins as $admin){
            $builder->admins()->detach($admin->admin_id);
        }
        
        return $builder->delete();
    }
}