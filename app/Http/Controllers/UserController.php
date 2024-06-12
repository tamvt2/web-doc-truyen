<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index() {
        return view('admin.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    public function show() {
        return view('admin.register', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    public function register(RegisterRequest $request) {
        $user = User::create($request->validated());
        if ($user) {
            return redirect('login')->with('success', "Account successfully registered.");
        } else {
            return redirect('register')->with('error', "Account error registered");
        }
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ])) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('welcome');
            } else {
                return redirect()->route('home');
            }
        }
        Session::flash('error', 'Email hoặc Password không chính xác');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
