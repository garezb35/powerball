@extends('includes.empty_header')
@section("script_header")
    <script>
        var userIdToken = "{{$api_token}}";
        var userIdKey = "{{$userIdKey}}";
        var roomIdx ="lobby";
        var is_admin = false;
        var is_freeze = 'off';
        var chatHistoryNum = 0;
        var filterWordArr = "{{$prohited}}".split(',');
        @if(!empty($profile))
        var levels = "{{$profile}}";
        var level_images = JSON.parse(levels.replace(/&quot;/g,'"'));
        @endif
        var total_num = 0;
        var is_repeatChat = false;
        var lastMsgTime = new Date().getTime();
        var sumMsgTerm = 0;
        var msgTermArr = new Array();
        var msgTermIdx = 0;
        var msgStopTime = 10;
        var blackListArr = ''.split(',');
        var level = "{{$u_level}}";
    </script>
@endsection
@section("header")
<div id="header">
    <h2>채팅대기실</h2>
    <ul class="wrm">
        <li class="tot"><a href="javascript:void(0)">전체(<span id="chatRoomCnt">{{$room_count}}</span>)</a><span class="bar"></span></li>
        <li class="favs"><a class="@if(Request::get("rtype") =="favor"){{'on'}}@endif" href="{{route("room_wait")}}?rtype=favor">즐겨찾기(<span id="bookmark_room_count">{{$favor_count}}</span>)</a></li>
    </ul>
</div>
<div id="container" style="width: 100%">
    <div class="leftArea">
        <div class="category">
            <ul class="order">
                <li><a class="@if(empty(Request::get("rtype")) || Request::get("rtype") =="winRate"){{'on'}}@endif" href="{{route("room_wait")}}?rtype=winRate">승률순</a></li>
                <li><a class="@if(Request::get("rtype") =="userCnt"){{'on'}}@endif" href="{{route("room_wait")}}?rtype=userCnt">참여자순</a></li>
                <li><a class="@if(Request::get("rtype") =="recommend"){{'on'}}@endif" href="{{route("room_wait")}}?rtype=recommend">추천순</a></li>
                <li><a class="@if(Request::get("rtype") =="latest"){{'on'}}@endif" href="{{route("room_wait")}}?rtype=latest">최신순</a></li>

            </ul>
        </div>
        <div class="mainBanner">
            <a href="http://qootoon.com/3c31ef24" target="_blank">
                <img src="https://simg.powerballgame.co.kr/ad/toptoon_728_90_1.jpg" style="display: none !important;">
            </a>
        </div>
        <ul id="bestList" class="roomList best">
            @if(!empty($best) && !empty($best["roomandpicture"]))
                @php
                $win = 0;
                $lose = 0;
                $current_win = 0;
                if(!empty($best["winning_history"])){
                    $parsed = json_decode($best["winning_history"]);
                    $win = $parsed->total->win ;
                    $lose = $parsed->total->lose;
                    $current_win = $parsed->current_win;
                }
                @endphp
                <li id="room-{{$best["roomIdx"]}}">
                    <div class="thumb">
                        <img src="@if(!empty($best["roomandpicture"]["image"])){{$best["roomandpicture"]["image"]}}@else{{'https://simg.powerballgame.co.kr/images/profile.png'}}@endif" class="roomImg">
                    </div>
                    <div class="inner">
                        <span class="winLose @if(($win-$lose) ==0){{'draw'}}@endif @if(($win-$lose) > 0){{'win'}}@endif @if(($win-$lose) < 0){{'lose'}}@endif"><span>{{$win}}</span>승 <span>{{$lose}}</span>패</span>
                        @if(!empty($current_win))<span class="winFix"><span>{{$current_win}}</span>연승</span>@endif
                        <span class="tit">{{$best["room_connect"]}}</span>
                        <div class="desc">{{$best["description"]}}</div>
                    </div>
                    <div class="userCntBox">
                        <div class="userCnt"><span class="curCnt">{{$best["members"]}}</span> / <span class="maxCnt">{{$best["max_connect"]}}</span></div>
                        <div class="date">{{getDiffTimes($best["created_at"])}}전</div>
                    </div>
                    <div class="line">&nbsp;</div>
                    <div class="userInfo">
                        <div class="user">
                            <img src="{{$best["roomandpicture"]["get_user_class"]["value3"]}}" width="30" height="30">
                            <a href="#" onclick="return false;" title="{{$best["roomandpicture"]["nickname"]}}" rel="965ff7b3c3d2d1ac75dca49048998589" class="uname">{{$best["roomandpicture"]["nickname"]}}</a>
                        </div>

                        <a href="#" onclick="return false;" rel="{{$best["roomIdx"]}}" class="enterBtn">채팅방 입장하기</a>
                    </div>

                    @if(!empty($best["roomandpicture"]["win_date"]))
                        @if($best["roomandpicture"]["win_date"] >= date('Y-m-d', strtotime('-7 days', strtotime('now'))))
                            @if(!empty($best["roomandpicture"]["winning_history"]))
                                @php $decoded_winhistory = $best["roomandpicture"]["badge"]; @endphp
                                @if(!empty($decoded_winhistory) && $decoded_winhistory > 4)
                                    {{winningItem($decoded_winhistory)}}
                                @endif
                            @endif

                        @endif
                    @endif
{{--                    @if($best["roomandpicture"]["badge"] >=5)--}}
{{--                        <div style="position:absolute;top:0;right: 280px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다">--}}
{{--                            <img src="/assets/images/powerball/badge/badge5.png" width="37" height="53">--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if($best["roomandpicture"]["badge"] >=10)--}}
{{--                        <div style="position:absolute;top:0;right: 253px;z-index:96;" title="일주일 내에 10연승 기록이 있습니다">--}}
{{--                            <img src="/assets/images/powerball/badge/badge10.png" width="37" height="53">--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if($best["roomandpicture"]["badge"] >=15)--}}
{{--                        <div style="position:absolute;top:0;right: 226px;z-index:96;" title="일주일 내에 15연승 기록이 있습니다">--}}
{{--                            <img src="/assets/images/powerball/badge/badge15.png" width="37" height="53">--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if($best["roomandpicture"]["badge"] >=20)--}}
{{--                        <div style="position:absolute;top:0;right: 199px;z-index:96;" title="일주일 내에 20연승 기록이 있습니다">--}}
{{--                            <img src="/assets/images/powerball/badge/badge20.png" width="37" height="53">--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </li>
            @endif
        </ul>
        <ul id="roomList" class="roomList">
            @if(!empty($list))
                @foreach($list as $value)
                    @php
                        $win = 0;
                        $lose = 0;
                        $current_win = 0;
                        if(!empty($value["winning_history"])){
                            $parsed = json_decode($value["winning_history"]);
                            $win = $parsed->total->win ;
                            $lose = $parsed->total->lose ;
                            $current_win = $parsed->current_win;
                        }
                    @endphp
                    <li id="room-{{$value["roomIdx"]}}">
                        <div class="thumb">
                            <img src="@if(!empty($value["roomandpicture"]["image"])){{$value["roomandpicture"]["image"]}}@else{{'https://simg.powerballgame.co.kr/images/profile.png'}}@endif" class="roomImg">
                        </div>
                        <div class="inner">
                            <span class="winLose @if(($win-$lose) ==0){{'draw'}}@endif @if(($win-$lose) > 0){{'win'}}@endif @if(($win-$lose) < 0){{'lose'}}@endif"><span>{{$win}}</span>승 <span>{{$lose}}</span>패</span>
                            @if(!empty($current_win))<span class="winFix"><span>{{$current_win}}</span>연승</span>@endif
                            <span class="tit">{{$value["room_connect"]}}</span>
                            <div class="desc">{{$value["description"]}}</div>
                        </div>
                        <div class="userCntBox">
                            <div class="userCnt"><span class="curCnt">{{$value["members"]}}</span> / <span class="maxCnt">{{$value["max_connect"]}}</span></div>
                            <div class="date">{{getDiffTimes($value["created_at"])}}전</div>
                        </div>
                        <div class="line">&nbsp;</div>
                        <div class="userInfo">
                            <div class="user">
                                <img src="{{$value["roomandpicture"]["get_user_class"]["value3"]}}" width="30" height="30">
                                <a href="#" onclick="return false;" title="{{$value["roomandpicture"]["nickname"]}}" rel="965ff7b3c3d2d1ac75dca49048998589" class="uname">{{$value["roomandpicture"]["nickname"]}}</a>
                            </div>
                            <a href="#" onclick="return false;" rel="{{$value["roomIdx"]}}" class="enterBtn">채팅방 입장하기</a>
                        </div>
                        @if(!empty($value["roomandpicture"]["win_date"]))
                            @if($value["roomandpicture"]["win_date"] >= date('Y-m-d', strtotime('-7 days', strtotime('now'))))
                                @if(!empty($value["roomandpicture"]["winning_history"]))
                                    @php $decoded_winhistory = $value["roomandpicture"]["badge"]; @endphp
                                    @if(!empty($decoded_winhistory) && $decoded_winhistory > 4)

                                        {{winningItem($decoded_winhistory)}}
                                    @endif
                                @endif

                            @endif
                        @endif
{{--                        @if($value["badge"] >=5)--}}
{{--                            <div style="position:absolute;top:0;right: 280px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다">--}}
{{--                                <img src="/assets/images/powerball/badge/badge5.png" width="37" height="53">--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if($value["badge"] >=10)--}}
{{--                            <div style="position:absolute;top:0;right: 253px;z-index:96;" title="일주일 내에 10연승 기록이 있습니다">--}}
{{--                                <img src="/assets/images/powerball/badge/badge10.png" width="37" height="53">--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if($value["badge"] >=15)--}}
{{--                            <div style="position:absolute;top:0;right: 226px;z-index:96;" title="일주일 내에 15연승 기록이 있습니다">--}}
{{--                                <img src="/assets/images/powerball/badge/badge15.png" width="37" height="53">--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        @if($value["badge"] >=20)--}}
{{--                            <div style="position:absolute;top:0;right: 199px;z-index:96;" title="일주일 내에 20연승 기록이 있습니다">--}}
{{--                                <img src="/assets/images/powerball/badge/badge20.png" width="37" height="53">--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        <div style="position:absolute;top:0;right:257px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다"><img src="https://simg.powerballgame.co.kr/images/badge5.png" width="46" height="68"></div>--}}
{{--                        <div style="position:absolute;top:0;right:257px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다"><img src="https://simg.powerballgame.co.kr/images/badge5.png" width="46" height="68"></div>--}}
{{--                        <div style="position:absolute;top:0;right:257px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다"><img src="https://simg.powerballgame.co.kr/images/badge5.png" width="46" height="68"></div>--}}
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="rightArea">
        <div class="btns">
            <a href="#"  id="btn_createChatRoomBox" class="create" data-toggle="modal" data-target="#creatingWindow">채팅방 개설하기</a></span>
            <a href="#" onclick="return false;" id="btn_joinMyChatRoom" class="myroom">나의 채팅방 입장하기</a>
        </div>
        <div class="myInfo">
			<div class="tit">내정보</div>
			<div class="inner">
				<img src="{{$level["value3"]}}" width="30" height="30">
				<a href="#" onclick="return false;" title="{{$user["nickname"]}}" rel="{{$user["userIdKey"]}}" class="uname">{{$user["nickname"]}}</a>
			</div>
        </div>
        <div class="userList">
            <div class="tit">대기실 <span id="lobby_userCnt"></span>명</div>
            <ul id="lobbyUser">

            </ul>
        </div>
    </div>
</div>

<div class="modal" id="security_dialog">
    <div class="modal-dialog modal-sm-custom" role="document">
        <div class="modal-content">
            <div class="modal-header jin-gradient">
                <h6 class="modal-title font-weight-bold text-white" id="exampleModalLabel">비밀번호입력</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="unique"/>
                <input type="password" name="roomPasswd" onkeypress="onlyNumber();" maxlength="4" id="roomPasswd" class="form-control mb-2" style="width: 200px;margin: auto">
                <p class="tip">비밀번호를 입력하세요.</p>
                <div class="text-center">
                    <a href="#" onclick="return false;" class="btn-jin-greenoutline btn ml-2 pl-3 pr-3" rel=""  id="btn_joinPasswd">입장하기</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="creatingWindow">
    <div class="modal-dialog modal-sm-custom" role="document">
        <div class="modal-content">
            <div class="modal-header jin-gradient">
                <h5 class="modal-title light-medium text-white" id="exampleModalLabel">채팅방 개설하기</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' =>'App\Http\Controllers\ChatController@createRoom', 'method' => 'post',"id"=>"form-room"]) !!}
                   <table class="table table-bordered crttable">
                       <tr>
                           <td class="align-middle">
                               <span class="light-medium">방제목</span>
                           </td>
                           <td class="align-middle">
                               {!! Form::hidden('api_token',$api_token,["id"=>'api_token']); !!}
                               {!! Form::text('roomTitle', '', array_merge(['class' => 'form-control pr-0 pl-0 pt-1 pb-1  border-input','placeholder'=>"제목을 입력해주세요",'autocomplete'=>"off","id"=>"roomTitle"],["required"])) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="align-middle">
                               <span class="light-medium">설명</span>
                           </td>
                           <td class="align-middle">
                               {!! Form::text('roomDesc', '', ["id"=>"roomDesc",'class' => 'form-control pr-0 pl-0 pt-1 pb-1  border-input','autocomplete'=>"off"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="align-middle">
                               <span class="light-medium">방종류</span>
                           </td>
                           <td class="align-middle">
                               {!! Form::select('roomType',['normal' => '일반','premium' => '프리미엄'],null,['class'=>"custom-select no-height border-input"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class=" align-middle">
                               <span class="light-medium">공개여부</span>
                           </td>
                           <td class="align-middle">
                               {!! Form::select('roomPublic',['public' => '전체공개','private' => '비공개'],null,["id"=>"create_roomPublic",'class'=>"custom-select no-height border-input"]) !!}
                           </td>
                       </tr>
                       <tr id="modal_createChatRoom">
                           <td class="align-middle">
                               <span class="light-medium">비밀번호</span>
                           </td>
                           <td class="align-middle">
                                <span id="passwd" class="light-medium">채팅방 개설시 자동 생성됩니다. (숫자 4자리)</span>
                           </td>
                       </tr>
                       <tr>
                           <td class="align-middle">
                               <span class="light-medium">참여인원</span>
                           </td>
                           <td class="align-middle">
                               {!! Form::select('maxUser',['50' => '50명','100' => '100명','200' => '200명','300' => '300명','500' => '500명','1000' => '1,000명'],null,['class'=>"custom-select no-height border-input"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="align-middle">
                               <span class="light-medium">일반개설권</span>
                           </td>
                           <td class="align-middle">
                               <span class="text-danger font-weight-bold">{{$normal_count}}개</span>
                           </td>
                       </tr>
                       <tr>
                           <td class="align-middle">
                               <span class="light-medium">프리미엄 개설권</span>
                           </td>
                           <td class="align-middle">
                               <span class="text-danger font-weight-bold">{{$premium_count}}개</span>
                           </td>
                       </tr>
                   </table>
                <div class="text-center">
                    {!! Form::submit("확인",["class"=>"btn-jin-greenoutline btn ml-2 pl-5 pr-5 create_room"]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@include("chat.chat-waiting")
@endsection
