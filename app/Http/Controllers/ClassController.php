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

    public function classwrite(){
        if(Auth::user()->memberlevels<10){
            return view('blog.classroom');
        }else{
            return view('blog.classwrite');
        }
    }

    public function summernote()
    {
        return view('blog.summernote');
    }

}
?>