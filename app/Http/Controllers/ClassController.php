<?php

namespace App\Http\Controllers;
use App\Models\Classrooms;
use App\Models\FileTables;
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

    public function summernote($code)
    {
        return view('blog.summernote', ['code' => $code]);
    }

    public function classcreate(Request $request)
    {
        $form_data = array(
            'subject' => $request->subject,
            'content' => $request->content,
            'userid' => Auth::user()->email,
            'status' => 1
        );

        if(auth()->check()){
            $rs=Classrooms::create($form_data);
            FileTables::where('pid', $request->pid)->where('userid', Auth::user()->userid)->wherein('code',['classroom'])->update(array('pid' => $rs->id));
            return response()->json(array('msg'=> "succ", 'bid'=>$rs->bid), 200);
        }
    }

}
?>