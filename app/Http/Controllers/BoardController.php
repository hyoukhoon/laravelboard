<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(){
        $boards = Board::orderBy('bid','desc')->paginate(20);
        return view('boards.index', compact('boards'));
    }

    public function show($bid,$page)
    {
        Board::find($bid)->increment('cnt');
        $boards = Board::findOrFail($bid);
        $boards->content = htmlspecialchars_decode($boards->content);
        $boards->pagenumber = $page;

        return view('boards.view', ['boards' => $boards]);
    }

    public function write()
    {
        if(auth()->check()){
            return view('boards.write');
        }else{
            return redirect()->back()->withErrors('로그인 하십시오.')
        }
    }
}
