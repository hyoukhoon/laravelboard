<?php

namespace App\Http\Controllers;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Classrooms;
use App\Models\FileTables;
use App\Models\Memos;
use Illuminate\Support\Facades\DB;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        if(Auth::user()->memberlevels<10){
            return view('adminarea.login');
        }else{
            return view('adminarea.index');
        }
    }

    public function classroom(){
        if(Auth::user()->memberlevels<10){
            return view('adminarea.login');
        }else{
            $cls = Classrooms::where('status',1)
                    ->orderBy('id','desc')->get();
            return view('adminarea.classroom', ['cls' => $cls]);
        }
    }

    public function logout(){
        auth() -> logout();
        return redirect() -> route('boards.index');
    }
}
