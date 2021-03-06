@extends('includes.empty_header')
@section("content")
<div class="modifyBox">
    <div class="title">오늘의한마디 변경하기</div>
    <div class="content">
        <div style="margin:10px;font-size:11px;line-height:18px;">
            <span class="highlight">욕설이나 미풍양속에 어긋나는 닉네임</span>은 사용할 수 없으며 변경하더라도 제한될 수 있습니다.
        </div>
    </div>

    <form method="POST">
        @csrf
        <input type="hidden" id="token" value="{{ $user["api_token"] }}">
        <input type="hidden" id="actionType" value="todayMsg">
        <div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="130px">
                    <col width="145px" style="background-color:#fff;">
                </colgroup>
                <tbody><tr>
                    <td class="tit">오늘의한마디</td>
                    <td><input type="text" id="todayMsg" value="{{$user["today_word"]}}"  maxlength="8" autocomplete="off"></td>
                </tr>
            </tbody></table>
        </div>

        <div class="btnBox">
            <a href="#" onclick="inputCheck();return false;" class="confirm">확인</a>
            <a href="#" onclick="inputReset();return false;" class="cancel">취소</a>
        </div>
    </form>
</div>
@endsection