<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Business\RoleBusiness;
use App\Http\Business\RolePermissionsBusiness;
use Illuminate\Support\Facades\Validator;
use App\Facades\BackendMessage as Message;
use App\Facades\Pagination;

class RoleController extends Controller
{
    public function index(Request $req,RoleBusiness $b_role)
    {
        /*排序相关*/
        $condition = Pagination::sortFilter($req->all(),[
            'role_id',
            'role_name',
            'updated_at',
            'created_at',
        ]);
        
        $role_list = $b_role->getList($condition);
        return view('backend.role.index',[
            'list'=>$role_list,
        ]);
    }
    
    public function edit(Request $req,RoleBusiness $b_role)
    {
        $id = $req->input('id');
        $detail = $b_role->getDetail($id, ['*'], ['permissions']);
        if(empty($detail)){
            return Message::error("您的请求出错啦!");
        }
        $role_permissions = $detail->permissions->pluck('permission')->toArray();
        $permissions = config('permissions');
        return view('backend.role.edit',[
            'detail'=>$detail,
            'role_permissions'=>$role_permissions,
            'permissions'=>$permissions,
        ]);
    }
    
    public function update(Request $req,RoleBusiness $b_role,RolePermissionsBusiness $b_role_permission)
    {
        $id = $req->input('id');
        $referer = $req->input("_referer");
        $params = $req->all();
        $detail = $b_role->getDetail($id, ['*'], ['permissions']);
        if(empty($detail)){
            return Message::error("您的请求出错啦!");
        }
        
        $save_data = [];
        if(!empty($params['role_name'])){
            //检查角色名是否被使用
            $exsist_role = $b_role->getList(['role_name'=>trim($params['role_name'])]);
            if(count($exsist_role) && $exsist_role[0]->role_id!=$id){
                return Message::error("角色名已存在");
            }
            $save_data['role_name'] = trim($params['role_name']);
        }
        if(!empty($params['role_desc'])){
            $save_data['remark'] = trim($params['role_desc']);
        }
        
        if(!$b_role->update($id, $save_data)){
            return Message::error("更新失败");
        }
        //清理权限
        foreach ($detail->permissions as $permission){
            $b_role_permission->delete($permission->role_permission_id);
        }
        //保存权限
        if(!empty($params['role_acl']) && is_array($params['role_acl'])){
            foreach ($params['role_acl'] as $acl){
                $b_role_permission->store([
                    'role_id'=>$detail->role_id,
                    'permission'=>$acl,
                ]);
            }
        }
        
        return Message::success("更新成功!",['label'=>'返回上一页','url'=>$referer?:route('rolelist')]);
    }
    
    public function add()
    {
        $permissions = config('permissions');
        return view('backend.role.add',[
            'permissions'=>$permissions,
        ]);
    }
    
    public function store(Request $req,RoleBusiness $b_role,RolePermissionsBusiness $b_role_permission)
    {
        $referer = $req->input("_referer");
        $params = $req->all();
        
        $validator = Validator::make($params, [
            'role_name' => ['required','between:1,16'],
        ], [
            'required' => ':attribute 不能为空',
            'between' => ':attribute 长度应在 :min - :max 之间',
        ], [
            'role_name'=>'角色名',
        ]);
        if ($validator->fails()) {
            return Message::error($validator->messages()->first());
        }
        
        //检查名称是否被使用
        $exsist_role = $b_role->getList(['role_name'=>trim($params['role_name'])]);
        if(count($exsist_role)){
            return Message::error("角色名已存在");
        }
        
        $permissions_config = config('permissions');
        $permissions = [];
        foreach($permissions_config as $config){
            $permissions = array_merge($permissions,$config['list']);
        }
        if(!empty($params['role_acl']) && is_array($params['role_acl'])){
            foreach ($params['role_acl'] as $acl){
                if(!key_exists($acl, $permissions)){
                    return Message::error("权限分配不正确");
                }
            }
        }
        
        $result = $b_role->store([
            'role_name'=>$params['role_name'],
            'remark'=>!empty($params['role_desc'])?$params['role_desc']:'',
        ]);
        if(!$result){
            return Message::error("操作失败");
        }
        if(!empty($params['role_acl']) && is_array($params['role_acl'])){
            foreach ($params['role_acl'] as $acl){
                $b_role_permission->store([
                    'role_id'=>$result->role_id,
                    'permission'=>$acl,
                ]);
            }
        }
        return Message::success("添加成功",['label'=>'返回一上页','url'=>$referer?:route('rolelist')],[['label'=>'继续添加','url'=>route('roleadd')]]);
    }
    
    public function deletebatch(Request $req,RoleBusiness $b_role)
    {
        $input = $req->all();
        if(empty($input['id']) || !is_array($input['id'])){
            return Message::error("请选择需要删除的数据");
        }
        foreach ($input['id'] as $id){
            $b_role->delete($id);
        }
        return Message::success("删除成功");
    }
}
