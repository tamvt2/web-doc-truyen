<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
