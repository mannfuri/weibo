<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        //create方法只允许guest访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credential = $this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);

        if(Auth::attempt($credential,$request->has('remember'))){
            session()->flash('success', '欢迎回来！');
            return redirect()->intended(route('users.show',Auth::User()));
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '退出成功！');
        return redirect()->route('home');
    }
}