<?php


namespace App\Http\Business;

use App\Model\RolePermissions;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;
use App\Exceptions\BackendException;

class RolePermissionsBusiness
{
    public function getList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $builder = RolePermissions::select($select_columns);
        
        if(!empty($relatives)){
            $builder->with($relatives);
        }
        if(!empty($condition['role_id'])){
            $builder->where('role_id',$condition['role_id']);
        }
        
        return Pagination::make($builder,$condition);
    }
    
    public function getDetail($id, array $select_columns = ['*'], array $relatives = [])
    {
        $builder = RolePermissions::select($select_columns);
        if(!empty($relatives)){
            $builder->with($relatives);
        }
        return $builder->find($id);
    }
    
    public function store($data)
    {
        $validator = Validator::make($data, [
            'role_id' => ['required','integer'],
            'permission'=>['required','string'],
        ],[
            'required'=>":attribute 不能为空",
            'integer'=>":attribute 输入不正确",
            "string"=>":attribute 输入不正确",
        ],[
            'role_id'=>'角色ID',
            'permission'=>'权限',
        ]);
        if ($validator->fails()) {
            throw new BackendException(1000,$validator->messages()->first());
        }
        
        $builder = new RolePermissions();
        foreach(array_intersect_key($data, array_flip([
            'role_id',
            'permission',
        ])) as $key=>$value){
            $builder->$key = $value;
        }
        
        $builder->save();
        
        return $builder;
    }
    
    public function delete($id)
    {
        $builder = RolePermissions::find($id);
        if(empty($builder)){
            return false;
        }
        return $builder->delete();
    }
}