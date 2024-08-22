<?php

namespace App\Http\Controllers;
use App\Models\Classrooms;
use App\Models\FileTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function classroom(){
        $contents = DB::table('classrooms')
                    ->join('file_tables', 'classrooms.id', '=', 'file_tables.pid')
                    ->select('classrooms.*', 'file_tables.filename')
                    ->get();
        return view('blog.classroom', ['contents' => $contents]);
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
        if(Auth::user()->memberlevels<10){
            return redirect()->back()->withErrors('권한이 없습니다.');
            exit;
        }
        $form_data = array(
            'subject' => $request->subject,
            'contents' => $request->content,
            'userid' => Auth::user()->email,
            'status' => 1
        );

        if(auth()->check()){
            $rs=Classrooms::create($form_data);
            FileTables::where('pid', $request->pid)->where('userid', Auth::user()->userid)->wherein('code',['classroom'])->update(array('pid' => $rs->id));
            return response()->json(array('msg'=> "succ", 'bid'=>$rs->id), 200);
        }
    }

}
?>