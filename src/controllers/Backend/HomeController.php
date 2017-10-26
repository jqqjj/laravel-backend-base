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
    
    public function changePassword(Request $request,AdminBusiness $b_admin)
    {
        $params = $request->all();
        
        $validator = Validator::make($params, [
            'new_password' => ['required','between:6,32'],
            'old_password' => ['required'],
        ], [
            'required' => ':attribute 不能为空',
            'between' => ':attribute 长度应在 :min - :max 之间',
        ], [
            'old_password'=>'旧密码',
            'new_password'=>'新密码',
        ]);
        if ($validator->fails()) {
            return Message::error($validator->messages()->first());
        }
        $id = Auth::guard('backend')->id();
        if(Auth::guard('backend')->attempt(['admin_id' => $id, 'password' => $params['old_password']],false,false)){
            $b_admin->update($id, ['password'=>$params['new_password']]);
            return Message::success("修改密码成功");
        }else{
            return Message::error("原始密码不正确");
        }
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
