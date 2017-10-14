<?php


namespace App\Http\Business;

use App\Model\RolePermissions;
use Illuminate\Support\Facades\Validator;
use App\Facades\Pagination;

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
        ]);
        if ($validator->fails()) {
            return false;
        }
        
        $builder = new RolePermissions();
        $builder->role_id = $data['role_id'];
        $builder->permission = $data['permission'];
        
        return $builder->save() ? $builder : false;
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