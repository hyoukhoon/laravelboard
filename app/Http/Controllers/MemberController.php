<?php

namespace App\Http\Controllers;
use App\Models\Members;
use Illuminate\Http\Request;

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
        $passwd = $request->password;
        $passwd = hash('sha512',$passwd);
        $form_data = array(
            'email' => $request->email,
            'passwd' => $passwd,
            'name' => $request->name,
            'username' => $request->name
        );

        $rs=Members::create($form_data);
        
        if($rs){
            return response()->json(array('msg'=> "가입해 주셔서 감사합니다.", 'result'=>true), 200);
        }else{
            return response()->json(array('msg'=> "실패했습니다. 관리자에게 문의해주세요.", 'result'=>false), 200);
        }
    }
}
