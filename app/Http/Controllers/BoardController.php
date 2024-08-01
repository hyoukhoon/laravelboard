<?php

namespace App\Http\Controllers;
use App\Models\Board;
use App\Models\FileTables;
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
        $attaches = FileTables::where('pid',$bid)->where('status',1)->get();

        return view('boards.view', ['boards' => $boards, 'attaches' => $attaches]);
    }

    public function imgpop($imgfile)
    {
        return view('boards.imgpop', ['imgfile' => $imgfile]);
    }

    public function summernote()
    {
        return view('boards.summernote');
    }

    public function write($multi,$bid=null)
    {
        if(auth()->check()){
            $boards = array();
            $attaches = array();
            $bid = $bid??0;
            if($bid){
                $boards = Board::findOrFail($bid);
                $attaches = FileTables::where('pid',$bid)->where('status',1)->get();
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
        // $image = $request->file('afile');
        // $new_name = null;
        // if($image){
        //     $new_name = rand().'_'.time().'.'.$image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $new_name);
        // }

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
            FileTables::where('pid', $request->pid)->where('code', $request->code)->where('userid', Auth::user()->userid)->update(array('pid' => $rs->bid));
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
}
