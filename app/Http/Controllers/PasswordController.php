<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
        //填写表单页面
    {
        return view('auth.password.email');

    }

    public function sendResetLinkEmail(Request $request)
        //处理表单提交，成功的话就发送邮件，附带 Token 的链接
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;

        $user = User::where('email', $email)->first();

        //邮箱为空就返回前页,并输出danger信息
        if (is_null($user)) {
            session()->flash('danger','邮箱未注册');
            return redirect()->back()->withInput();
        }

        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        DB::table('password_resets')->updateOrInsert(['email'=>$email],
            ['email'=>$email,
            'token' =>Hash::make($token),
            'created_at'=>new Carbon]);

        Mail::send('emails.reset_link', compact('token'), function ($message) use ($email) {
            $message->to($email)->subject("忘记密码");
        });

        session()->flash('success', '重置邮件发送成功，请查收');
        return redirect()->back();
    }

    public function showResetForm()
        //显示更新密码表单,内置token
    {

    }

    public function reset()
        //对提交的token和email进行验证,验证成功更新密码
    {

    }


}
