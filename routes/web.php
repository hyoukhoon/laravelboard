<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
});

//게시판
Route::get('/boards/{multi?}', [BoardController::class, 'index'])->name('boards.index');
Route::get('/boards/show/{id}/{page}', [BoardController::class, 'show'])->name('boards.show');

Route::middleware('auth') -> group(function (){
    Route::get('/boards/write/{multi}/{bid?}', [BoardController::class, 'write'])->name('boards.write');
    Route::post('/boards/create', [BoardController::class, 'create'])->name('boards.create');
    Route::post('/boards/saveimage', [BoardController::class, 'saveimage'])->name('boards.saveimage');
    Route::post('/boards/deletefile', [BoardController::class, 'deletefile'])->name('boards.deletefile');
    Route::get('/boards/imgpop/{imgfile}', [BoardController::class, 'imgpop'])->name('boards.imgpop');
});

//회원
Route::get('/login', [MemberController::class, 'login'])->name('auth.login');
Route::get('/signup', [MemberController::class, 'signup'])->name('auth.signup');
Route::post('/signupok', [MemberController::class, 'signupok'])->name('auth.signupok');
Route::post('/emailcheck', [MemberController::class, 'emailcheck'])->name('auth.emailcheck');
Route::post('/loginok', [MemberController::class, 'loginok']) -> name('auth.loginok');
Route::post('/logout', [MemberController::class, 'logout']) -> name('auth.logout');