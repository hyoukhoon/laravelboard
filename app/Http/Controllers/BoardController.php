<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(){
        $boards = Board::orderBy('bid','desc')->paginate(20);
        return view('boards.index', compact('params'));
    }
}
