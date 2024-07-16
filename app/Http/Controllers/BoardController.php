<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(){
        $boards = Board::orderBy('bid','desc');
        print_r($boards);
        return view('boards.index', compact('boards'));
    }
}
