<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;

Route::get('/', function () {
    return view('/blog/index');
});

//Classroom
Route::get('/classroom', [ClassController::class, 'classroom'])->name('classroom.classroom');
Route::get('/classview/{id}/{page}', [ClassController::class, 'classview'])->name('classroom.classview');
Route::get('/classwrite', [ClassController::class, 'classwrite'])->name('classroom.classwrite');
Route::get('/classmodify/{id}', [ClassController::class, 'classmodify'])->name('classroom.classwrite');
Route::post('/classcreate', [ClassController::class, 'classcreate'])->name('classroom.classcreate');
Route::post('/classupdate', [ClassController::class, 'classupdate'])->name('classroom.classupdate');
Route::get('/blog/summernote/{code}/{id}', [ClassController::class, 'summernote'])->name('blog.summernote');


//Admin
Route::get('/adminarea/login', function () {
    return view('/adminarea/login');
});
Route::get('/adminarea', [AdminController::class, 'index'])->name('adminarea.index');
Route::get('/adminarea/classroom', [AdminController::class, 'classroom'])->name('adminarea.classroom');

// Route::get('/', function () {
//     return view('welcome');
// });

//게시판
Route::get('/boards/{multi?}', [BoardController::class, 'index'])->name('boards.index');
Route::get('/boards/show/{id}/{page}', [BoardController::class, 'show'])->name('boards.show');

Route::middleware('auth') -> group(function (){
    Route::get('/boards/write/{multi}/{bid?}', [BoardController::class, 'write'])->name('boards.write');
    Route::post('/boards/create', [BoardController::class, 'create'])->name('boards.create');
    Route::post('/boards/saveimage', [BoardController::class, 'saveimage'])->name('boards.saveimage');
    Route::post('/boards/deletefile', [BoardController::class, 'deletefile'])->name('boards.deletefile');
    Route::get('/boards/imgpop/{imgfile}', [BoardController::class, 'imgpop'])->name('boards.imgpop');
    Route::post('/boards/update', [BoardController::class, 'update'])->name('boards.update');
    Route::get('/boards/delete/{bid}/{page}', [BoardController::class, 'delete'])->name('boards.delete');
    Route::get('/boards/summernote/{multi}/{bid?}', [BoardController::class, 'summernote'])->name('boards.summernote');
    Route::post('/boards/memoup', [BoardController::class, 'memoup'])->name('boards.memoup');
    Route::post('/boards/memomodi', [BoardController::class, 'memomodi'])->name('boards.memomodi');
    Route::post('/boards/memomodifyup', [BoardController::class, 'memomodifyup'])->name('boards.memomodifyup');
    Route::post('/boards/memodeletefile', [BoardController::class, 'memodeletefile'])->name('boards.memodeletefile');
    Route::post('/boards/memodelete', [BoardController::class, 'memodelete'])->name('boards.memodelete');
});

//회원
Route::get('/login', [MemberController::class, 'login'])->name('auth.login');
Route::get('/signup', [MemberController::class, 'signup'])->name('auth.signup');
Route::post('/signupok', [MemberController::class, 'signupok'])->name('auth.signupok');
Route::post('/emailcheck', [MemberController::class, 'emailcheck'])->name('auth.emailcheck');
Route::post('/loginok', [MemberController::class, 'loginok']) -> name('auth.loginok');
Route::post('/adminloginok', [MemberController::class, 'adminloginok']) -> name('admin.loginok');
Route::post('/logout', [MemberController::class, 'logout']) -> name('auth.logout');