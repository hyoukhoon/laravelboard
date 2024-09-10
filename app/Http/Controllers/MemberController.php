<?php

namespace App\Http\Controllers;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class MemberController extends Controller
{
    public function login(){
        return view('member.login');
    }

    public function idfind(){
        return view('member.idfind');
    }

    public function signup()
    {
        return view('member.signup');
    }

    public function signupok(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|min(4)|max(20)',
            'email' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)
                                                            ->letters()
                                                            ->numbers()
                                                            ->symbols()]
        ]);
        
        if ($validator->fails()) {
            return response()->json(array('msg'=> "필수값이 빠졌거나 비밀번호 규칙을 위반했습니다.", 'result'=>false), 200);
            exit;
        }

        $rs1 = Members::where('email',$request->email)->count();
        $rs2 = Members::where('username',$request->username)->count();

        if ($rs1 or $rs2) {
            return response()->json(array('msg'=> "닉네임이나 이메일이 이미 사용중입니다. 다른 닉네임이나 이메일을 입력해 주세요.", 'result'=>false), 200);
            exit;
        }

        $passwd = $request->password;
        $passwd = hash('sha512',$passwd);
        $uid = explode("@",$request->email);
        $form_data = array(
            'userid' => $uid[0],
            'email' => $request->email,
            'passwd' => $passwd,
            'username' => $request->username
        );

        $rs = Members::create($form_data);
        
        if($rs){
            return response()->json(array('msg'=> "가입해 주셔서 감사합니다.", 'result'=>true), 200);
        }else{
            return response()->json(array('msg'=> "실패했습니다. 관리자에게 문의해주세요.", 'result'=>false), 200);
        }
    }

    public function emailcheck(Request $request){
        $email = $request->email;
        
        $rs = Members::where('email',$email)->count();
        if($rs){
            return response()->json(array('msg'=> "이미 사용중인 이메일입니다.", 'result'=>false), 200);
        }else{
            return response()->json(array('msg'=> "사용할 수 있는 이메일입니다.", 'result'=>true), 200);
        }
    }

    public function usernamecheck(Request $request){
        $username = $request->username;
        
        $rs = Members::where('username',$username)->count();
        if($rs){
            return response()->json(array('msg'=> "이미 사용중인 닉네임입니다.", 'result'=>false), 200);
        }else{
            return response()->json(array('msg'=> "사용할 수 있는 닉네임입니다.", 'result'=>true), 200);
        }
    }

    public function finduserid(Request $request){
        $username = $request->username;
        
        $rs = Members::where('username', $username)->first();
        if($rs){
            return response()->json(array('msg'=> $username."님의 아이디는 ".$rs->userid." 입니다", 'result'=>true), 200);
        }else{
            return response()->json(array('msg'=> "아이디가 없는 이름입니다.", 'result'=>false), 200);
        }
    }

    public function loginok(Request $request){

        $validated = $request->validate([
            'email' => 'required',
            'passwd' => 'required',
        ]);
        
        $email = $request->email;
        $passwd = $request->passwd;
        $passwd = hash('sha512',$passwd);
        $remember = $request->remember;
        $loginInfo = array(
            'email' => $email,
            'passwd' => $passwd
        );

        $ismember = Members::where($loginInfo)->first();
        if($ismember){
            $istatus = Members::where($loginInfo)->where('status',1)->first();
            if($istatus){
                Auth::login($ismember, $remember);
                return redirect("/");
            }else{
                return redirect() -> route('auth.login')->with('loginFail', '로그인 할 수 없는 계정입니다. 관리자에게 문의 하십시오.');
            }
        }else{
            return redirect() -> route('auth.login')->with('loginFail', '아이디나 비밀번호가 틀렸습니다.');
        }
    }

    public function adminloginok(Request $request){

        $validated = $request->validate([
            'email' => 'required',
            'passwd' => 'required',
        ]);
        
        $email = $request->email;
        $passwd = $request->passwd;
        $passwd = hash('sha512',$passwd);
        $remember = $request->remember;
        $loginInfo = array(
            'email' => $email,
            'passwd' => $passwd
        );

        $ismember = Members::where($loginInfo)->first();
        if($ismember){
            Auth::login($ismember, $remember);
            return redirect() -> route('adminarea.index');
        }else{
            return redirect('/adminarea/login');
        }
    }

    public function logout(){
        auth() -> logout();
        return redirect('/');
    }
}
