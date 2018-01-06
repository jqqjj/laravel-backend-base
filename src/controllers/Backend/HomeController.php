<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Facades\Documents;
use App\Helpers\BytesFormat;
use App\Facades\Captcha;
use App\Facades\Human;
use Illuminate\Support\Facades\Artisan;
use App\Exceptions\BackendException;
use App\Facades\BackendMessage as Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Business\AdminBusiness;

class HomeController extends Controller
{
    public function index()
    {
        return view('backend.home.index');
    }
    
    public function dashboard(BytesFormat $bytes_format)
    {
        //取得数据库版本
        $pdo = DB::connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();
        
        //统计上传文件的文件夹大小
        $bytes_size = Documents::getPublicPathSize(config("backend.public_upload_path"));
        
        return view('backend.home.dashboard',[
            'db_version'=>$version,
            'format_size'=>$bytes_format->format($bytes_size),
        ]);
    }
    
    public function clearcache(Request $request)
    {
        if($request->isMethod('get')){
            return view('backend.home.clearcache');
        }
        
        $clean = $request->input("clean");
        if(empty($clean) || !is_array($clean)){
            throw new BackendException(10000,"请选择清理类型");
        }
        if(in_array('data', $clean)){
            Artisan::call("cache:clear");
            Human::clearTrash();
        }
        if(in_array('template', $clean)){
            Artisan::call("view:clear");
        }
        if(in_array('config', $clean)){
            Artisan::call("clear-compiled");
            Artisan::call("config:clear");
            Artisan::call("route:clear");
        }
        return Message::json(0,"清理完成");
    }
    
    public function profile(Request $request,AdminBusiness $b_admin)
    {
        $profile = Auth::guard('backend')->user();
        
        if($request->isMethod('get')){
            return view('backend.home.profile',['profile'=>$profile]);
        }
        
        $params = $request->all();
        
        $validator = Validator::make($params, [
            'nick_name' => ['max:20'],
            'email' => ['required','email'],
        ], [
            'required' => ':attribute 不能为空',
            'between' => ':attribute 长度应在 :min - :max 之间',
            'max' => ':attribute 不能超过 :max 字',
            'email' => ':attribute 格式不正确',
        ], [
            'nick_name'=>'昵称',
            'email'=>'邮箱',
            'old_password'=>'旧密码',
            'new_password'=>'新密码',
        ]);
        $validator->sometimes("old_password",['required'],function($input){
            return !empty($input['new_password']);
        });
        $validator->sometimes("new_password",['required','between:6,32'],function($input){
            return !empty($input['new_password']) || !empty($input['old_password']);
        });
        if ($validator->fails()) {
            return Message::error($validator->messages()->first());
        }
        
        $id = Auth::guard('backend')->id();
        
        //检查邮箱是否被使用
        if(!empty($params['email'])){
            $exsist_admin_email = $b_admin->getList(['email'=>trim($params['email'])]);
            if(count($exsist_admin_email) && $exsist_admin_email[0]->admin_id!=$id){
                return Message::error("邮箱已被使用");
            }
        }
        
        if(!empty($params['old_password'])){
            if(!Auth::guard('backend')->attempt(['admin_id' => $id, 'password' => $params['old_password']],false,false)){
                return Message::error("原始密码不正确");
            }
        }
        
        $save_data = [];
        $save_data['nick_name'] = $params['nick_name'];
        if(!empty($params['email'])){
            $save_data['email'] = $params['email'];
        }
        if(!empty($params['new_password'])){
            $save_data['password'] = $params['new_password'];
        }
        
        $b_admin->update($id, $save_data);
        
        return Message::success("资料修改成功");
    }
    
    public function captcha(Request $request)
    {
        $path = $request->get('path');
        $content = Captcha::generate($path);
        return response($content, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
    
    public function successMessage(Request $request)
    {
        $forward = $request->get('_forward');
        
        $msg = $request->get('msg');
        $url = !empty($forward['url']) ? $forward['url'] : '';
        $label = !empty($forward['label']) ? $forward['label'] : '';
        
        $server = $request->server();
        return view('backend.home.message',[
            'msg'=>!empty($msg) ? $msg : '操作成功',
            'url'=>!empty($url) ? $url : (!empty($server['HTTP_REFERER']) ? $server['HTTP_REFERER'] : route('adminindex')),
            'label'=>!empty($label) ? $label : "点击继续",
            'type'=>'success',
            'links'=>$request->input("_links"),
        ]);
    }
    
    public function errorMessage(Request $request)
    {
        $forward = $request->get('_forward');
        
        $msg = $request->get('msg');
        $url = !empty($forward['url']) ? $forward['url'] : '';
        $label = !empty($forward['label']) ? $forward['label'] : '';
        
        return view('backend.home.message',[
            'msg'=>!empty($msg) ? $msg : '操作失败',
            'url'=>!empty($url) ? $url : "",
            'label'=>!empty($label) ? $label : "返回上一页",
            'type'=>'error',
            'links'=>$request->input("_links"),
        ]);
    }
}
