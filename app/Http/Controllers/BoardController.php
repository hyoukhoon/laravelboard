<?php

namespace App\Http\Controllers;
use App\Models\Board;
use App\Models\FileTables;
use App\Models\Memos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    
    public function index($multi = "free"){
        $boards = Board::where('multi',$multi)
                        ->where('status',1)
                        ->orderBy('bid','desc')->paginate(20);
        return view('boards.index', ['boards' => $boards, 'multi' => $multi]);
    }

    public function show($bid,$page)
    {
        Board::find($bid)->increment('cnt');
        $boards = Board::findOrFail($bid);
        $boards->content = htmlspecialchars_decode($boards->content);
        $boards->pagenumber = $page??1;
        $attaches = FileTables::where('pid',$bid)->where('code','boardattach')->where('status',1)->get();

        $memos = Memos::where('bid', $bid)->where('status',1)
                        ->orderBy('id', 'asc')
                        ->get();

        return view('boards.view', ['boards' => $boards, 'attaches' => $attaches, 'memos' => $memos]);
    }

    public function imgpop($imgfile)
    {
        return view('boards.imgpop', ['imgfile' => $imgfile]);
    }

    public function summernote($multi, $bid = null)
    {
        if($bid){
            $boards = Board::findOrFail($bid);
        }else{
            $boards = array();
        }
        return view('boards.summernote', ['multi' => $multi, 'boards' => $boards]);
    }

    public function write($multi,$bid=null)
    {
        if(auth()->check()){
            $boards = array();
            $attaches = array();
            $bid = $bid??0;
            if($bid){
                $boards = Board::findOrFail($bid);
                $attaches = FileTables::where('pid',$bid)->where('status',1)->where('code','boardattach')->get();
                return view('boards.write', ['multi' => $multi, 'bid' => $bid, 'boards' => $boards, 'attaches' => $attaches]);
            }else{
                return view('boards.write', ['multi' => $multi, 'bid' => $bid, 'boards' => $boards, 'attaches' => $attaches]);
            }
        }else{
            return redirect()->back()->withErrors('로그인 하십시오.');
        }
    }

    public function create(Request $request)
    {
        $form_data = array(
            'subject' => $request->subject,
            'content' => $request->content,
            'userid' => Auth::user()->userid,
            'email' => Auth::user()->email,
            'multi' => $request->multi??'free',
            'status' => 1
        );

        if(auth()->check()){
            $rs=Board::create($form_data);
            FileTables::where('pid', $request->pid)->where('userid', Auth::user()->userid)->wherein('code',['boardattach','editorattach'])->update(array('pid' => $rs->bid));
            return response()->json(array('msg'=> "succ", 'bid'=>$rs->bid), 200);
        }
    }

    public function update(Request $request)
    {
        $form_data = array(
            'subject' => $request->subject,
            'content' => $request->content
        );

        if(auth()->check()){
            $boards = Board::findOrFail($request->bid);
            if(Auth::user()->userid==$boards->userid){
                $attaches = FileTables::where('pid',$request->bid)->where('status',1)->where('code','editorattach')->get();
                foreach($attaches as $att){//file_tables에 있는 파일명이 본문에 있는지 확인해서 없으면 삭제한다.
                    if(!strpos($request->content, $att->filename)){
                        unlink(public_path('images')."/".$att->filename);
                        FileTables::where('id', $att->id)->update(array('status' => 0));
                    }
                }
                Board::where('bid', $request->bid)->update($form_data);
                return response()->json(array('msg'=> "succ", 'bid'=>$request->bid), 200);
            }else{
                return response()->json(array('msg'=> "fail", 200));
            }
        }
    }

    public function saveimage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);

        if(auth()->check()){
            $image = $request->file('file');
            $new_name = rand().'_'.time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $fid = rand();
            $form_data = array(
                'pid' => $request->pid,
                'userid' => Auth::user()->userid,
                'code' => $request->code,
                'filename' => $new_name
            );
            $rs=FileTables::create($form_data);
            return response()->json(array('msg'=> "등록했습니다.", 'result'=>'succ', 'fn'=>$new_name, 'fid'=>$fid), 200);
        }else{
            return response()->json(array('msg'=> "로그인 하십시오", 'result'=>'fail'), 200);
        }
    }

    public function deletefile(Request $request)
    {
        $image = $request->fn;
        if(unlink(public_path('images')."/".$image)){
            FileTables::where('filename', $image)->where('code', $request->code)->where('userid', Auth::user()->userid)->update(array('status' => 0));
        }

        return response()->json(array('msg'=> "succ", 'fn'=>$image, 'fid'=>substr($image,0,10)), 200);
    }

    public function delete($bid,$page)
    {
        $boards = Board::findOrFail($bid);
        if(Auth::user()->userid==$boards->userid){
            $attaches = FileTables::where('pid',$bid)->where('status',1)->get();
            foreach($attaches as $att){
                unlink(public_path('images')."/".$att->filename);
                FileTables::where('id', $att->id)->update(array('status' => 0));
            }
            $boards->delete();
            return redirect('/boards/'.$boards->multi.'?page='.$page);
        }else{
            return redirect('/boards/show/'.$bid.'/'.$page);
        }
    }

    public function memoup(Request $request)
    {
        $insert_data = new Memos();
        $insert_data->memo = $request->memo;
        $insert_data->bid = $request->bid;
        $insert_data->pid = $request->pid??null;
        $insert_data->userid = Auth::user()->userid;

        if(auth()->check()){
            $rs = $insert_data->save();
            if($rs){
                Board::find($request->bid)->increment('memo_cnt');//부모글의 댓글 갯수 업데이트
                Board::where('bid', $request->bid)->update([//부모글의 댓글 날짜 업데이트
                    'memo_date' => date('Y-m-d H:i:s')
                ]);
                if($request->memo_file){
                    FileTables::where('filename', $request->memo_file)->where('userid', Auth::user()->userid)->where('code','memoattach')->update(array('pid' => $rs->bid));
                }
            }

            return response()->json(array('msg'=> "succ", 'num'=>$rs), 200);
        }
    }
}
