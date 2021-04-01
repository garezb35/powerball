@extends('includes.empty_header')
@section("content")
    <style>
        body {position:absolute;width:100%;height:100%;background:url(https://simg.powerballgame.co.kr/images/bg_loading.png);overflow:hidden;}
        .contentBox {position:absolute;top:50%;left:50%;margin-top:-80px;margin-left:-175px;width:350px;height:160px;text-align:center;}
        .contentBox .txt {margin-top:20px;font-size:11px;font-family:dotum;color:#0D568C;}
    </style>
    <div class="contentBox">
        <div><img src="{{Request::root()}}/assets/images/logo.png"></div>
        <div class="txt">중복 로그인으로 인해 이전 접속을 종료합니다.</div>
    </div>
@endsection
