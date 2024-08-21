<?php

namespace App\Http\Controllers;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function classroom(){
        return view('blog.classroom');
    }

    public function classview(){
        return view('blog.classview');
    }

    public function logout(){
        auth() -> logout();
        return redirect() -> route('boards.index');
    }
}
