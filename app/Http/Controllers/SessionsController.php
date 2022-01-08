<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
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

        if(Auth::attempt($credential)){
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show',Auth::User());
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
        }

    }
}
