<?php

namespace App\Http\Controllers;
use App\Models\Board;
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

        return view('boards.view', ['boards' => $boards]);
    }

    public function write($multi)
    {
        if(auth()->check()){
            return view('boards.write', ['multi' => $multi]);
        }else{
            return redirect()->back()->withErrors('로그인 하십시오.');
        }
    }

    public function create(Request $request)
    {
        // $request->validate([
        //     'afile' => 'required|image|max:2048'
        // ]);
        $image = $request->file('afile');
        $new_name = rand().'_'.time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);

        $form_data = array(
            'subject' => $request->subject,
            'content' => $request->content,
            'userid' => Auth::user()->userid,
            'email' => Auth::user()->email,
            'multi' => $request->multi??'free',
            'status' => 1,
            'attachfiles' => $new_name
        );

        if(auth()->check()){
            $rs=Board::create($form_data);
            return response()->json(array('msg'=> "succ", 'bid'=>$rs->bid), 200);
        }
    }
}
