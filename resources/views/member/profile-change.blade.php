@extends('includes.empty_header')
@section("content")
<div class="modifyBox">
    <div class="title">프로필이미지 변경하기</div>
    <div class="content">
        <div style="margin:10px;font-size:11px;line-height:18px;">
            이미지 사이즈는 <span class="highlight">150 x 150 이상</span>으로 올리시기 바랍니다.<br>
            업로드시 이미지는 <span class="highlight">150 x 150 으로 최적화</span>됩니다.<br>
            업로드 <span class="highlight">최대 용량은 1MB</span> 입니다.
        </div>
    </div>


    <form name="profileForm" id="profileForm" method="post" enctype="multipart/form-data" action="/uploadImage">
        @csrf
        <input type="hidden" id="token" name="api_token" value="{{ $user["api_token"] }}">
        <input type="hidden" name="actionType" value="profile-img">
        <div>
            <table class="table">
                <colgroup>
                    <col width="140px">
                    <col width="225px" style="background-color:#fff;">
                    <col style="background-color:#fff;">
                </colgroup>
                <tbody><tr>
                    <td class="tit">프로필이미지</td>
                    <td class="realtive" colspan="2"><img src="{{$user["image"]}}" id="profileImgArea" style="width:150px;height:150px;border:1px solid #c8c8c8;margin-right:5px;"> <input type="file" name="profileImg" id="profileImg" accept="image/*" onchange="imgCheck()"></td>
                </tr>
                <tr>
                    <td class="tit">프로필이미지 초기화</td>
                    <td colspan="2"><a href="#" onclick="profileImgInit();return false;" class="btn_set">프로필이미지 초기화</a> - 초기화한 아이템은 복구되지 않습니다.</td>
                </tr>
            </tbody></table>
        </div>

        <div class="btnBox">
            <input type="submit" class="confirm" value="확인">
            <a href="#" onclick="inputReset();return false;" class="cancel">취소</a>
        </div>

    </form>

</div>
@endsection