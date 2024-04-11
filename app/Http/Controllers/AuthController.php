<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //TODO go to login.blade.php
    public function goToLoginPage() {
        return view('login');
    }

    //TODO go to register.blade.php
    public function goToRegisterPage() {
        return view('register');
    }

    //TODO go to dashboard
    public function goToDashboard() {

        // dd(Auth::user());
        if(Auth::user()->role == 'admin') {
            // dd('admin');
            return redirect()->route('category#goToCategoryListPage');
        } else
        return redirect()->route('user#goToHomePage');

    }


}
