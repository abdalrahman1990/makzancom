<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashbord(){

        return view('admin.dashbord');
    }

    public function login(){

        return view('admin.auth.login');
    }
}
