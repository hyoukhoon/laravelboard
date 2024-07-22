<?php

namespace App\Http\Controllers;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function login(){
        return view('member.login');
    }

    public function signup()
    {
        return view('member.signup');
    }

    public function signupok(Request $request){
        // $validated = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'passwd' => 'required'
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'passwd' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/signup')
                        ->withErrors($validator)
                        ->withInput();
        }

        $passwd = $request->password;
        $passwd = hash('sha512',$passwd);
        $uid = explode("@",$request->email);
        $form_data = array(
            'userid' => $uid[0],
            'email' => $request->email,
            'passwd' => $passwd,
            'name' => $request->name,
            'username' => $request->name
        );

        $ms = Members::where('email',$request->email)->count();
        if($ms){
            return response()->json(array('msg'=> "이미 사용중인 이메일입니다.", 'result'=>false), 200);
            exit;
        }

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
            Auth::login($ismember, $remember);
            return redirect() -> route('boards.index');
        }else{
            return redirect() -> route('auth.login')->with('loginFail', '아이디나 비밀번호가 틀렸습니다.');
        }
    }

    public function logout(){
        auth() -> logout();
        return redirect() -> route('boards.index');
    }
}
