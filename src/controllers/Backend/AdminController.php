<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Business\AdminBusiness;
use App\Http\Business\RoleBusiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Facades\BackendMessage as Message;
use App\Facades\Pagination;
use App\Helpers\Referer;

class AdminController extends Controller
{
    public function index(Request $req, AdminBusiness $admin_business)
    {
        /*排序相关*/
        $condition = $req->all();
        $sort_condition = Pagination::sortFilter($req->all(),[
            'admin_id',
            'name',
            'nick_name',
            'email',
            'enabled',
            'last_login_time',
            'created_at',
            'updated_at',
        ]);
        
        $list = $admin_business->getList(array_merge($condition,$sort_condition));
        return view('backend.admin.index',['list'=>$list]);
    }
    
    public function edit(Request $req, AdminBusiness $b_admin,RoleBusiness $b_role)
    {
        $admin_id = $req->input("id");
        $admin = $b_admin->getDetail($admin_id,['*'], ['roles']);
        if(Auth::guard('backend')->id()>1){
            if($admin_id != Auth::guard('backend')->id()){
                return Message::error("权限不足");
            }
        }
        if(empty($admin)){
            return Message::error("您的请求出错啦!");
        }
        
        //角色列表
        $role_list = $b_role->getList(['sort_type'=>'asc']);
        //用户的角色
        $admin_roles = [];
        foreach ($admin->roles as $role){
            array_push($admin_roles,$role->role_id);
        }
        
        return view('backend.admin.edit',[
            'admin'=>$admin,
            'role_list'=>$role_list,
            'admin_roles'=>$admin_roles,
        ]);
    }
    
    public function update(Request $req,AdminBusiness $b_admin,RoleBusiness $b_role)
    {
        $admin_id = $req->input("id");
        $referer = $req->input("_referer");
        $params = $req->all();
        $update_admin = $b_admin->getDetail($admin_id,['*'], ['roles']);
        if(Auth::guard('backend')->id()>1){
            if($admin_id != Auth::guard('backend')->id()){
                return Message::error("权限不足");
            }
        }
        if(empty($update_admin)){
            return Message::error("您的请求出错啦!");
        }
        
        $validator = Validator::make($params, [
            'name' => ['required','between:4,16'],
            'email' => ['required','email'],
        ], [
            'required' => ':attribute 不能为空',
            'between' => ':attribute 长度应在 :min - :max 之间',
            'max' => ':attribute 长度不能超过 :max 字',
        ], [
            'name'=>'登录名称',
            'email'=>'电子邮箱',
            'password'=>"密码",
            'nick_name'=>'昵称',
        ]);
        $validator->sometimes("password",['required','between:6,32'],function($input){
            return !empty($input['resetpwd']) && !empty($input['password']) && strlen($input['password'])>0;
        });
        $validator->sometimes("nick_name",['required','max:20'],function($input){
            return !empty($input['nick_name']);
        });
        if ($validator->fails()) {
            return Message::error($validator->messages()->first());
        }
        
        $save_data = [];
        //检查名称是否被使用
        $exsist_admin = $b_admin->getList(['name'=>trim($params['name'])]);
        if(count($exsist_admin) && $exsist_admin[0]->admin_id!=$admin_id){
            return Message::error("登录名称已被使用");
        }
        $save_data['name'] = trim($params['name']);
        
        //检查邮箱是否被使用
        $exsist_admin_email = $b_admin->getList(['email'=>trim($params['email'])]);
        if(count($exsist_admin_email) && $exsist_admin_email[0]->admin_id!=$admin_id){
            return Message::error("邮箱已被使用");
        }
        $save_data['email'] = trim($params['email']);
        
        if(!empty($params['resetpwd']) && !empty($params['password'])){
            $save_data['password'] = $params['password'];
        }
        //检查角色
        if(!empty($params['role_ids']) && !is_array($params['role_ids'])){
            return Message::error("角色分配不正确");
        }
        if(!empty($params['role_ids'])){
            foreach($params['role_ids'] as $role_id){
                $role = $b_role->getDetail($role_id);
                if(empty($role)){
                    return Message::error("角色分配不正确");
                }
            }
        }
        $save_data['enabled'] = !empty($params['enabled']) ? 1 : 0;//冻结
        $save_data['nick_name'] = trim($params['nick_name']);//昵称
        
        if(!$b_admin->update($admin_id,$save_data)){
            return Message::error("更新失败");
        }
        //清除旧角色
        foreach($update_admin->roles as $role){
            $update_admin->roles()->detach($role->role_id);
        }
        //保存角色
        if(!empty($params['role_ids'])){
            foreach($params['role_ids'] as $role_id){
                $update_admin->roles()->attach($role_id);
            }
        }
        return Message::success("更新成功",['label'=>'返回上一页','url'=>(new Referer)->get($referer, route('adminlist'))]);
    }
    
    public function add(AdminBusiness $b_admin,RoleBusiness $b_role)
    {
        $admin = $b_admin->getDetail(Auth::guard('backend')->id(),['*'], ['roles']);
        //角色列表
        $role_list = $b_role->getList(['sort_type'=>'asc']);
        //用户的角色
        $admin_roles = [];
        foreach ($admin->roles as $role){
            array_push($admin_roles,$role->role_id);
        }
        
        return view('backend.admin.add',[
            'role_list'=>$role_list,
            'admin_roles'=>$admin_roles,
        ]);
    }
    
    public function store(Request $req,AdminBusiness $b_admin,RoleBusiness $b_role)
    {
        $referer = $req->input("_referer");
        $params = $req->all();
        
        $validator = Validator::make($params, [
            'name' => ['required','between:4,16'],
            'email' => ['required','email'],
            'password' => ['required','between:6,32'],
        ], [
            'required' => ':attribute 不能为空',
            'between' => ':attribute 长度应在 :min - :max 之间',
            'max' => ':attribute 长度不能超过 :max 字',
        ], [
            'name'=>'登录名称',
            'email'=>'电子邮箱',
            'password'=>'密码',
            'nick_name'=>'昵称',
        ]);
        $validator->sometimes("nick_name",['required','max:20'],function($input){
            return !empty($input['nick_name']);
        });
        if ($validator->fails()) {
            return Message::error($validator->messages()->first());
        }
        
        //检查名称是否被使用
        $exsist_admin_name = $b_admin->getList(['name'=>trim($params['name'])]);
        if(count($exsist_admin_name)){
            return Message::error("登录名称已被使用");
        }
        //检查邮箱是否被使用
        $exsist_admin = $b_admin->getList(['email'=>trim($params['email'])]);
        if(count($exsist_admin)){
            return Message::error("邮箱已被使用");
        }
        //检查角色
        if(!empty($params['role_ids']) && !is_array($params['role_ids'])){
            return Message::error("角色分配不正确");
        }
        if(!empty($params['role_ids'])){
            foreach($params['role_ids'] as $role_id){
                $role = $b_role->getDetail($role_id);
                if(empty($role)){
                    return Message::error("角色分配不正确");
                }
            }
        }
        
        $save_data = [];
        $save_data['name'] = trim($params['name']);
        $save_data['email'] = trim($params['email']);
        $save_data['password'] = $params['password'];
        $save_data['enabled'] = !empty($params['enabled']) ? 1 : 0;//冻结
        $save_data['nick_name'] = trim($params['nick_name']);//昵称
        $new_admin = $b_admin->store($save_data);
        if(!$new_admin){
            return Message::error("添加失败");
        }
        //保存角色
        if(!empty($params['role_ids'])){
            foreach($params['role_ids'] as $role_id){
                $new_admin->roles()->attach($role_id);
            }
        }
        return Message::success("添加成功",['label'=>'返回上一页','url'=>(new Referer)->get($referer, route('adminlist'))]);
    }
    
    public function deletebatch(Request $req,AdminBusiness $b_admin)
    {
        if(Auth::guard('backend')->id()>1){
            return Message::error("权限不足");
        }
        $input = $req->all();
        if(empty($input['id']) || !is_array($input['id'])){
            return Message::error("请选择需要删除的数据");
        }
        foreach ($input['id'] as $admin_id){
            $b_admin->delete($admin_id);
        }
        return Message::success("删除成功");
    }
}
