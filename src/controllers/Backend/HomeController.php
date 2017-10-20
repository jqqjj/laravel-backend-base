<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Facades\Documents;
use App\Helpers\BytesFormat;
use App\Facades\Captcha;
use Illuminate\Support\Facades\Artisan;
use App\Exceptions\BackendException;
use App\Facades\BackendMessage as Message;

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
        if(empty($clean)){
            throw new BackendException(10000,"请选择清理类型");
        }
        if(!empty($clean['data'])){
            Artisan::call("cache:clear");
        }
        if(!empty($clean['template'])){
            Artisan::call("view:clear");
        }
        if(!empty($clean['config'])){
            Artisan::call("clear-compiled");
            Artisan::call("config:clear");
            Artisan::call("route:clear");
        }
        return Message::json(0,"清理完成");
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
        
        $server = $request->server();
        return view('backend.home.message',[
            'msg'=>!empty($msg) ? $msg : '操作失败',
            'url'=>!empty($url) ? $url : (!empty($server['HTTP_REFERER']) ? $server['HTTP_REFERER'] : route('adminindex')),
            'label'=>!empty($label) ? $label : "点击继续",
            'type'=>'error',
            'links'=>$request->input("_links"),
        ]);
    }
}
