<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{

    public function loginShow(){
        return view('admin.pages.auth.login');
    }
    public function login(LoginRequest $request){
        $credentials = $request->validated();
        $loginField = filter_var($credentials['login_id'], FILTER_VALIDATE_EMAIL) ? 'email':'username';
        $attempt = [
            $loginField => $credentials['login_id'],
            'password' => $credentials['password'],
        ];

        if(Auth::attempt($attempt)){
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }
        return back()->withErrors([
            'login_id' => 'Wrong account or password',
        ])->withInput();
    }
    public function Logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/admin/login')->with('info', 'You are logout');
    }
}
