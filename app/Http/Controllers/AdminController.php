<?php

namespace App\Http\Controllers;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Classrooms;
use App\Models\Category;
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
            $cls = Classrooms::orderBy('id','desc')->paginate(20);;
            $cates = DB::table('categories')->get();
            return view('adminarea.classroom', ['cls' => $cls,'cates' => $cates]);
        }
    }

    public function logout(){
        auth() -> logout();
        return redirect() -> route('boards.index');
    }

    public function cateup(Request $request)
    {
        $codes = DB::table('categories')->orderBy('code','desc')->first();
        $code = $codes->code + 1;
        $form_data = array(
            'name' => $request->catename,
            'code' => $code
        );

        if(auth()->check()){
            $rs=Category::create($form_data);
            return response()->json(array('result'=> true, 'msg'=>'생성했습니다.'), 200);
        }
    }
}
