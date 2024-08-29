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
        $memos = DB::table('memos')
                ->leftJoinSub('select pid, filename from file_tables where code=\'classmemo\' and status=1', 'f', 'memos.id', 'f.pid')
                ->select('memos.*', 'f.filename')
                ->where('memos.code', 'classroom')->where('memos.bid', $id)->where('memos.status',1)
                ->orderByRaw('IFNULL(memos.pid,memos.id), memos.pid ASC')
                ->orderBy('memos.id', 'asc')
                ->get();
        return view('blog.classview', ['cls' => $cls, 'attaches' => $attaches, 'cates' => $cates, 'memos' => $memos]);
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
            'code' => 'classroom',
            'bid' => $request->bid,
            'pid' => $request->pid??null,
            'userid' => Auth::user()->userid
        );

        if(auth()->check()){
            $rs=Memos::create($form_data);
            if($rs){
                Classrooms::find($request->bid)->increment('memo_cnt');
                Classrooms::where('id', $request->bid)->update([
                    'memo_date' => date('Y-m-d H:i:s')
                ]);
                if($request->memo_file){
                    FileTables::where('filename', $request->memo_file)->where('userid', Auth::user()->userid)->where('code','classmemo')->update(array('pid' => $rs->id));
                }
            }

            return response()->json(array('msg'=> "succ", 'num'=>$rs), 200);
        }
    }

    public function memodeletefile(Request $request)
    {
        if(FileTables::where('id', $request->fid)->where('userid', Auth::user()->userid)->update(array('status' => 0))){
            unlink(public_path('images')."/".$request->fn);
        }
        return response()->json(array('msg'=> "succ", 'fn'=>$request->fn, 'fid'=>$request->fid), 200);
    }

    public function memodelete(Request $request)
    {
        $data = Memos::findOrFail($request->id);
        if(Auth::user()->userid==$data->userid){
            $rs = Memos::where('id', $request->id)->update(array('status' => 0));
            if($rs){
                Classrooms::find($request->bid)->decrement('memo_cnt');
                $fs=FileTables::where('pid', $data->id)->get();
                if($fs){
                    foreach($fs as $f){
                        if(FileTables::where('id', $f->id)->where('userid', Auth::user()->userid)->update(array('status' => 0))){
                            unlink(public_path('images')."/".$f->filename);
                        }
                    }
                }
            }
            return response()->json(array('msg'=> "succ", 'num'=>$rs), 200);
        }else{
            return response()->json(array('msg'=> "fail"), 200);
        }
    }

    public function memomodi(Request $request)
    {
        $memos = Memos::findOrFail($request->memoid);
        if(Auth::user()->userid==$memos->userid){
            $attaches = FileTables::where('pid',$memos->id)->where('code','classmemo')->where('status',1)->first();
            if($attaches){
                $attfile=true;
            }else{
                $attfile=false;
            }
            return response()->json(array('msg'=> "succ", 'memos'=>$memos, 'att'=>$attaches, 'attfile'=>$attfile), 200);
        }else{
            return response()->json(array('msg'=> "fail"), 200);
        }
    }

    public function memomodifyup(Request $request)
    {
        $memos = Memos::findOrFail($request->memoid);
        if(Auth::user()->userid==$memos->userid){
            $form_data = array(
                'memo' => $request->memo
            );
            Memos::where('id', $request->memoid)->update($form_data);
            return response()->json(array('msg'=> "succ", 'data'=>$request->memoid), 200);
        }else{
            return response()->json(array('msg'=> "fail"), 200);
        }
    }

}
?>