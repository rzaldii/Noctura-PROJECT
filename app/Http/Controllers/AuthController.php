<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {

    }

}

