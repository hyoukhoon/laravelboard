<?php

namespace App\Http\Controllers;
use App\Models\Members;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function mailSendSubmit(Request $request){
        $email = $request->email;
        $email = "handofgod@naver.com";
        $rs = Members::where('email', $email)->first();
        $passwdo = rand();
        $passwd = hash('sha512',$passwdo);
        Members::where('email', $email)->update(array('passwd' => $passwd));
    	$data_arr = array(
            'subject' => "[PHPBlog]문의하신 비밀번호를 보내드립니다.",
            'name' => "PHPBlogMaster",
            'emailAddr' => "phpblogmaster@gmail.com",
            'toemail' => $email,
            'content' => $passwdo
        );
        
        Mail::send('mail.mail_form', ['data_arr' => $data_arr], function($message) use ($data_arr){
            $message->to($data_arr['toemail'])->subject($data_arr['subject']);
            $message->from($data_arr['emailAddr']);
        });

        if($rs){
            return response()->json(array('msg'=> "입력하신 이메일로 비밀번호를 보내드렸습니다. 이메일을 확인해 주십시오. 이메일이 안오면 스팸함도 확인해 주십시오.", 'result'=>true), 200);
        }else{
            return response()->json(array('msg'=> "입력하신 아이디를 찾을 수 없습니다.", 'result'=>false), 200);
        }
    }
}
