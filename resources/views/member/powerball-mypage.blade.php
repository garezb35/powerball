@extends('includes.empty_header')

@section("header")
    @include('member/member-menu')
@endsection
@section("content")
    <div class="content">
        <div class="memberBox">
            <div class="titBox">
                <table class="table">
                    <colgroup>
                        <col width="120px">
                        <col width="120px" style="background-color:#fff;">
                        <col style="background-color:#fff;">
                        <col width="135px" style="background-color:#fff;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th rowspan="6" class="tit">계정 정보</th>
                        <td>아이디</td>
                        <td colspan="2">{{$user["loginId"]}}</td>
                    </tr>
                    <tr>
                        <td>비밀번호</td>
                        <td>변경일 :
                            <span class="highlight">{{$user["updated_at"]}}</span>
                        </td>
                        <td class="position-relative">
                    <span>
                        <a href="#" onclick="window.open('/password/reset','_blank','width=600,height=600');return false;" class="btn btn_buyoutline btn-sm">비밀번호 변경</a>
                    </span>
                        </td>
                    </tr>
                    <tr>
                        <td>이름</td>
                        <td colspan="2">{{$user["name"]}}</td>
                    </tr>
                    <tr>
                        <td>성별</td>
                        <td colspan="2">{{$user["sex"]}}</td>
                    </tr>
                    <tr>
                        <td>휴대폰번호</td>
                        <td colspan="2">휴대폰번호는
                            <span class="highlight">암호화되어 저장</span>되므로 확인할 수 없으며 오직 비밀번호 찾기 용도로만 사용됩니다.
                        </td>
                    </tr>
                    <tr>
                        <td>이메일</td>
                        <td colspan="2">{{$user["email"]}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="titBox">
                <table class="table">
                    <colgroup>
                        <col width="120px">
                        <col width="120px" style="background-color:#fff;">
                        <col width="*" style="background-color:#fff;">
                        <col width="135px" style="background-color:#fff;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th class="tit">인증 정보</th>
                        <td>실명인증</td>
                        <td>
                            <span class="noneMsg">ⓘ 실명인증을 해주시기 바랍니다.</span>
                        </td>
                        <td class="position-relative">
                    <span>
                        <a href="#" class="btn btn_buyoutline btn-sm" onclick="oknamePop();return false;">실명 인증하기</a>
                    </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="titBox">
                <table class="table">
                    <colgroup>
                        <col width="120px">
                        <col width="120px" style="background-color:#fff;">
                        <col width="*" style="background-color:#fff;">
                        <col width="*" style="background-color:#fff;">
                        <col width="210px" style="background-color:#fff;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th rowspan="4" class="tit">커뮤니티 정보</th>
                        <td>닉네임</td>
                        <td class="position-relative" colspan="2">
                            <img src="{{$avata}}" width="30" height="30" style="position:absolute;top:16px;">
                            <span style="margin-left:28px;">{{$user["nickname"]}}</span>
                        </td>
                        <td>
                            <div>
                                <span class="haveBox btn-outline-dark btn btn-sm disabled">보유
                                    <strong class="number">{{$item_count["NICKNAME_RIGHT"] ?? 0}}</strong>개
                                </span>
                                <a href="{{route("market")}}" class="btn_buy btn btn-sm">구매</a>
                                <a href="#" onclick="window.open('{{route('modify')}}?type=nickname','_blank','width=600,height=600');return false;" class="btn_set btn btn_buyoutline btn-sm">변경</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>패밀리닉네임</td>
                        <td class="position-relative" colspan="2">
                            <span class="noneMsg">{{$user["familynickname"] ?? "ⓘ 패밀리닉네임을 등록 해주시기 바랍니다."}}</span>
                        </td>
                        <td>
                            <div>
                                <span class="haveBox btn-outline-dark btn btn-sm disabled">보유
                                    <strong class="number">{{$item_count["FAMILY_NICKNAME_LICENSE_BREAD"] ?? 0}}</strong>개
                                </span>
                                <a href="{{route("market")}}" class="btn_buy btn btn-sm">구매</a>
                                <a href="#" onclick="window.open('{{route('modify')}}?type=family','_blank','width=600,height=600');return false;" class="btn_set btn btn_buyoutline btn-sm">변경</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>오늘의한마디</td>
                        <td class="position-relative" colspan="2">
                            <span class="noneMsg">{{$user["today_word"] ?? "ⓘ 오늘의한마디를 등록 해주시기 바랍니다."}}</span>
                        </td>
                        <td>
                            <div>
                                <span class="haveBox btn-outline-dark btn btn-sm disabled">보유
                                    <strong class="number">{{$item_count["WORD_TODAY"] ?? 0}}</strong>개
                                </span>
                                <a href="{{route("market")}}" class="btn_buy btn btn-sm">구매</a>
                                <a href="#" onclick="window.open('{{route('modify')}}?type=today','_blank','width=600,height=600');return false;" class="btn_set btn btn_buyoutline btn-sm">변경</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>프로필이미지</td>
                        <td class="position-relative" colspan="2">
                            <img src="{{$user["image"]}}" id="profileImgArea" style="width:150px;height:150px;border:1px solid #c8c8c8;">
                            <div style="position:absolute;bottom:20px;left:185px;font-size:11px;">
                                이미지 사이즈는 150 x 150 이상으로 올리시기 바랍니다.
                                <br>
                                업로드시 이미지는 150 x 150 으로 최적화됩니다.
                                <br>
                                업로드 최대 용량은 1MB 입니다.
                            </div>
                        </td>
                        <td class="align-top">
                            <div>
                                <span class="haveBox btn btn-outline-dark btn-sm disabled">보유
                                    <strong class="number">{{$item_count["PROFILE_IMAGE_RIGHT"] ?? 0}}</strong>개
                                </span>
                                <a href="{{route("market")}}" class="btn_buy btn btn-sm">구매</a>
                                <a href="#" onclick="window.open('{{route('modify')}}?type=profile-img','_blank','width=600,height=600');return false;" class="btn_set btn btn_buyoutline btn-sm">변경</a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="titBox">
                <table class="table">
                    <colgroup>
                        <col width="120px">
                        <col width="120px" style="background-color:#fff;">
                        <col style="background-color:#fff;">
                        <col width="80px" style="background-color:#fff;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th rowspan="3" class="tit">보안 정보</th>
                        <td>2차비밀번호</td>
                        <td>
                            <span class="noneMsg">ⓘ 2차비밀번호를 설정 해주시기 바랍니다.</span>
                        </td>
                        <td class="position-relative">
                        <span>
                            <a href="#" onclick="windowOpen('/?view=memberSecurity&amp;type=securityPasswd','memberSecurity',600,600,'auto');return false;" class="btn_set  btn_buyoutline btn btn-sm">설정하기</a>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td>인증IP</td>
                        <td>
                            <span class="noneMsg">ⓘ 인증IP를 등록 해주시기 바랍니다.</span>
                        </td>
                        <td class="position-relative">
                        <span>
                            <a href="#" onclick="windowOpen('/?view=memberSecurity&amp;type=authIp','memberSecurity',600,600,'auto');return false;" class="btn_set  btn_buyoutline btn btn-sm">설정하기</a>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td>해외IP차단</td>
                        <td>
                            <span class="noneMsg">ⓘ 모든 IP에서 로그인 가능합니다.</span>
                        </td>
                        <td class="position-relative">
                    <span >
                        <a href="#" onclick="windowOpen('/?view=memberSecurity&amp;type=foreignIpBan','memberSecurity',600,600,'auto');return false;" class="btn_set btn_buyoutline btn btn-sm">설정하기</a>
                    </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="titBox">
                <table class="table">
                    <colgroup>
                        <col width="120px">
                        <col width="120px" style="background-color:#fff;">
                        <col style="background-color:#fff;">
                        <col width="105px" style="background-color:#fff;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th rowspan="4" class="tit">보유 정보</th>
                        <td>코인</td>
                        <td>
                            <span class="number">{{$user["coin"]}}</span>코인
                        </td>
                        <td class="position-relative">
                            <span >
                                <a href="{{route('member')}}?type=charge" class="btn_set btn btn_buyoutline btn-sm">충전하기</a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>당근</td>
                        <td>
                            <span class="number">{{$user["bullet"]}}</span>개
                        </td>
                        <td class="position-relative">
                            <span>
                                <a href="{{route("market")}}" class="btn_buy btn btn-outline-secondary btn-sm">&nbsp;&nbsp;구매&nbsp;&nbsp;</a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>건빵</td>
                        <td>
                            <span class="number">{{$user["bread"]}}</span>개
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

