<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public  function showLinkRequestForm(Request $request){

        if(!Auth::check()){
            echo "<script>alert('로그인 후 이용가능합니다..');window.history.go(-1);</script>";
            return;
        }
        $user = Auth::user();
        if(!empty($request->password) && !empty($request->current) && !empty($request->password_confirmation)){
            $this->validate($request, [
                'current' => 'required|min:3|max:50',
                'password' => 'required|confirmed|min:8|same:password_confirmation'
            ],
            [
                'password.required'=> '영문 대/소문자, 숫자, 특수문자 사용가능합니다. 최소 8자이상 입력하세요.', // custom message,
                'password.min'=> '영문 대/소문자, 숫자, 특수문자 사용가능합니다. 최소 8자이상 입력하세요.', // custom message
                'password.confirmed'=> '비밀번호가 일치하지 않습니다.'
            ]);


            if(!Hash::check($request->current,$user->password))
            {
                echo "<script>alert('현재 비밀번호가 일치하지 않습니다.');window.history.back()</script>";
                return;
            }
            $user->password = Hash::make($request->password);
            $user->save();
            echo "<script>alert('성공적으로 변경되었습니다. 변경된 암호는 ".$request->password."입니다');window.close()</script>";
            return;
        }
        $userToken = Auth::user()->token;
        return view('auth/passwords/email' , ["token"=>$userToken]);
    }
}
