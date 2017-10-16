<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Facades\BackendMessage as Message;
use App\Facades\Human;
use App\Facades\Captcha;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::guard('backend')->check()){
            return redirect()->route("adminindex");
        }
        return view('backend.login.index',['captcha'=>Human::check()]);
    }
    
    public function login(Request $reqeust)
    {
        $name = $reqeust->get('username');
        $password = $reqeust->get('password');
        $remember = $reqeust->get('remember');
        $captcha = $reqeust->get('captcha');
        if(!Human::check() && !Captcha::validate("adminlogin",$captcha)){
            return Message::error('验证码不正确', ['label'=>'','url'=>route('adminlogin')]);
        }
        if (Auth::guard('backend')->attempt(['name' => $name, 'password' => $password,'enabled'=>1],(bool)$remember)) {
            return redirect()->route("adminindex");
        }
        elseif (Auth::guard('backend')->attempt(['name' => $name, 'password' => $password],false,false)) {
            return Message::error('账号被冻结', ['label'=>'','url'=>route('adminlogin')]);
        }
        else{
            return Message::error('账号或者密码错误', ['label'=>'','url'=>route('adminlogin')]);
        }
    }
    
    public function logout()
    {
        Auth::guard('backend')->logout();
        return redirect()->route("adminlogin");
    }
}