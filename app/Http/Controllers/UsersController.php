<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            //所有动作都要登录
            //除了以下三个动作
            'except' => ['show', 'create', 'store']
        ]);


        $this->middleware('guest', [
            //以下方法，只有访客可以访问，登录用户不可访问
            'only' => ['create','store']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', '注册成功。');
        Auth::login($user);
        return redirect()->route('users.show',$user);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request,[
            'name'=> 'required|max:50',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '更新信息成功');
        return redirect()->route('users.show',$user);
    }

    public function index()
    {
        $users = User::paginate(6);
        return view('users.index',compact('users'));
    }
}
