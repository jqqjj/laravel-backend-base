<?php


namespace App\Http\Business;

use App\Model\Roles;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;
use App\Exceptions\BackendException;

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
        if(!empty($data['role_name'])){
            $builder->role_name = $data['role_name'];
        }
        if(!empty($data['remark'])){
            $builder->remark = $data['remark'];
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
            'role_name' => ['required','between:1,50'],
        ],[
            'required'=>":attribute不能为空",
            "between"=>":attribute字数必须大于:min小于:max",
            "max"=>":attribute必须不多于:max字数",
        ]);
        $validator->sometimes("remark",["max:255"],function($input){
            return !empty($input['remark']);
        });
        if ($validator->fails()) {
            throw new BackendException(1000,$validator->messages()->first());
        }
        
        $builder = new Roles();
        $builder->role_name = $data['role_name'];
        if(isset($data['remark'])){
            $builder->remark = $data['remark'];
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