<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create(){
    	return view('sessions.create');
    }

    public function store(Request $request){
    	$credentials = $this->validate($request,[
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    	]);

    	if (Auth::attempt($credentials,$request->has('remember'))) {
    		//登录成功后的相关操作
    		session()->flash('success','欢迎回来！');
            $fallback = route('users.show',Auth::user());
    		return redirect()->intended($fallback);
    	} else {
    		//登录失败后的相关操作
    		session()->flash('danger','宁配登录吗');
    		return redirect()->back()->withInput();
    	}
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success','快滚吧宁');
        return redirect('login');
    }

    public function __construct(){
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
}
