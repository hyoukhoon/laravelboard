<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function login(){
        return view('member.login');
    }

    public function signup()
    {
        return view('member.signup');
    }
}
