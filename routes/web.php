<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\MemberController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//게시판
Route::get('/boards', [BoardController::class, 'index'])->name('boards.index');
Route::get('/boards/show/{id}/{page}', [BoardController::class, 'show'])->name('boards.show');

//회원
Route::get('/login', [MemberController::class, 'login'])->name('auth.login');
Route::get('/signup', [MemberController::class, 'signup'])->name('auth.signup');