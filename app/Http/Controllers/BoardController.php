<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index(){
        $boards = Board::orderBy('bid','desc')->paginate(20);
        return view('boards.index', ['boards' => $boards, 'boardTitle' => '게시판 목록']);
    }

    public function show($bid,$page)
    {
        Board::find($bid)->increment('cnt');
        $boards = Board::findOrFail($bid);
        $boards->content = htmlspecialchars_decode($boards->content);
        $boards->pagenumber = $page??1;

        return view('boards.view', ['boards' => $boards, 'boardTitle' => '게시판 보기']);
    }

    public function write()
    {
        if(auth()->check()){
            return view('boards.write', ['boardTitle' => '게시판 보기']);
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
            'multi' => $request->content??'free',
            'status' => 1
        );

        if(auth()->check()){
            $rs=Board::create($form_data);
            return response()->json(array('msg'=> "succ", 'bid'=>$rs->bid), 200);
        }
    }
}
