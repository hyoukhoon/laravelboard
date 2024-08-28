<?php

namespace App\Http\Controllers;
use App\Models\Classrooms;
use App\Models\FileTables;
use App\Models\Memos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function classroom(){
        $contents = Classrooms::where('status',1)
                    ->orderBy('id','desc')->paginate(10);
        $cates = DB::table('categories')->get();
        return view('blog.classroom', ['contents' => $contents, 'cates' => $cates]);
    }

    public function classview($id,$page)
    {
        Classrooms::find($id)->increment('cnt');
        $cls = Classrooms::findOrFail($id);
        $cls->contents = htmlspecialchars_decode($cls->contents);
        $cls->pagenumber = $page??1;
        $attaches = FileTables::where('pid',$id)->where('code','classroom')->where('status',1)->get();
        $cates = DB::table('categories')->get();
        return view('blog.classview', ['cls' => $cls, 'attaches' => $attaches, 'cates' => $cates]);
    }

    public function classwrite(){
        if(Auth::user()->memberlevels<10){
            return view('blog.classroom');
        }else{
            $cates = DB::table('categories')->get();
            return view('blog.classwrite', ['id' => 0, 'cates' => $cates]);
        }
    }

    public function classmodify($id){
        if(Auth::user()->memberlevels<10){
            return view('blog.classroom');
        }else{
            $cls = Classrooms::findOrFail($id);
            $attaches = FileTables::where('pid',$id)->where('code','classroom')->where('status',1)->get();
            $cates = DB::table('categories')->get();
            return view('blog.classmodify', ['id' => $id, 'cls' => $cls, 'attaches' => $attaches, 'cates' => $cates]);
        }
    }

    public function summernote($code, $id = null)
    {
        $cls = array();
        if($id)$cls = Classrooms::findOrFail($id);
        return view('blog.summernote', ['code' => $code, 'cls' => $cls]);
    }

    public function classcreate(Request $request)
    {
        if(Auth::user()->memberlevels<10){
            return redirect()->back()->withErrors('권한이 없습니다.');
            exit;
        }
        
        $filename =  FileTables::where('pid',$request->pid)->where('status',1)->value('filename')??"";
        $form_data = array(
            'cate' => $request->cate,
            'subject' => $request->subject,
            'tags' => $request->tags,
            'shorts' => $request->shorts,
            'contents' => $request->content,
            'thumbnail' => $filename,
            'userid' => Auth::user()->email,
            'status' => 1
        );

        if(auth()->check()){
            $rs=Classrooms::create($form_data);
            FileTables::where('pid', $request->pid)->where('userid', Auth::user()->userid)->wherein('code',['classroom'])->update(array('pid' => $rs->id));
            return response()->json(array('msg'=> "succ", 'id'=>$rs->id), 200);
        }
    }

    public function classupdate(Request $request)
    {

        if(auth()->check()){
            $filename = "";
            $cls = Classrooms::findOrFail($request->id);
            if(Auth::user()->email==$cls->userid){

                $attaches = FileTables::where('pid',$request->id)->where('status',1)->where('code','classroom')->orderBy('id','asc')->get();
                foreach($attaches as $att){//file_tables에 있는 파일명이 본문에 있는지 확인해서 없으면 삭제한다.
                    if(!strpos($request->content, $att->filename)){
                        unlink(public_path('images')."/".$att->filename);
                        FileTables::where('id', $att->id)->update(array('status' => 0));
                    }else{
                        if(!$filename)$filename = $att->filename;
                    }
                }

                $form_data = array(
                    'cate' => $request->cate,
                    'subject' => $request->subject,
                    'tags' => $request->tags,
                    'shorts' => $request->shorts,
                    'contents' => $request->content,
                    'thumbnail' => $filename,
                    'userid' => Auth::user()->email,
                    'username' => Auth::user()->username,
                    'status' => 1
                );
                Classrooms::where('id', $request->id)->update($form_data);
                return response()->json(array('msg'=> "succ", 'id'=>$request->id), 200);
            }else{
                return response()->json(array('msg'=> "fail", 200));
            }
        }
    }

    public function classdelete($id){
        if(Auth::user()->memberlevels<10){
            return view('blog.classroom');
        }else{
            $cls = Classrooms::findOrFail($id);
            $attaches = FileTables::where('pid',$id)->where('status',1)->where('code','classroom')->orderBy('id','asc')->get();
            foreach($attaches as $att){//file_tables에 있는 파일명이 본문에 있는지 확인해서 없으면 삭제한다.
                unlink(public_path('images')."/".$att->filename);
                FileTables::where('id', $att->id)->update(array('status' => 0));
            }
            $cls->delete();
            return redirect('/classroom');
        }
    }

    public function memoup(Request $request)
    {
        $form_data = array(
            'memo' => $request->memo,
            'bid' => $request->id,
            'pid' => $request->pid??null,
            'userid' => Auth::user()->userid
        );

        if(auth()->check()){
            $rs=Memos::create($form_data);
            if($rs){
                Classrooms::find($request->id)->increment('memo_cnt');//부모글의 댓글 갯수 업데이트
                Classrooms::where('bid', $request->id)->update([//부모글의 댓글 날짜 업데이트
                    'memo_date' => date('Y-m-d H:i:s')
                ]);
                if($request->memo_file){
                    FileTables::where('filename', $request->memo_file)->where('userid', Auth::user()->userid)->where('code','memoattach')->update(array('pid' => $rs->id));
                }
            }

            return response()->json(array('msg'=> "succ", 'num'=>$rs), 200);
        }
    }

}
?>