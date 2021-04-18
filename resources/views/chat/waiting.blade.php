@extends('includes.empty_header')
@section("script_header")
    <script>
        var userIdToken = "{{$api_token}}";
        var userIdKey = "{{$userIdKey}}";
        var roomIdx ="lobby";
        var is_admin = false;
        var is_freeze = 'off';
        var chatHistoryNum = 0;
        var filterWordArr = 'ㅋㅌ,카톡,틱톡,http,www,co.kr,net,com,kr,net,org,abcgame,scoregame,스코어게임,스게,abc게임,자지,보지,섹스,쎅스,씨발,시발,병신,븅신,개세,개새자지,출장,섹파,자위,8아,18놈,18새끼,18년,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,포경,ㅅㅂㄹㅁ,만남,전국망,대행,자살,스게,점수게임,모히또,토크온,페이스북,페북,매장,8394'.split(',');
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
<div id="container" style="width: 958px;">
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
                <li id="room-{{$best["roomIdx"]}}">
                    <div class="thumb">
                        <img src="@if(!empty($best["roomandpicture"]["image"])){{$best["roomandpicture"]["image"]}}@else{{'https://simg.powerballgame.co.kr/images/profile.png'}}@endif" class="roomImg">
{{--                        <div class="winFixCnt">5</div>--}}
                    </div>
                    <div class="inner">
                        <span class="winLose @if(($best["win"]-$best["lose"]) ==0){{'draw'}}@endif @if(($best["win"]-$best["lose"]) > 0){{'win'}}@endif @if(($best["win"]-$best["lose"]) < 0){{'lose'}}@endif"><span>{{$best["win"]}}</span>승 <span>{{$best["lose"]}}</span>패</span>
                        @if(!empty($best["current_win"]))<span class="winFix"><span>{{$best["current_win"]}}</span>연승</span>@endif
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
                            <img src="{{$best["roomandpicture"]["get_user_class"]["value3"]}}" width="23" height="23">
                            <a href="#" onclick="return false;" title="{{$best["roomandpicture"]["nickname"]}}" rel="965ff7b3c3d2d1ac75dca49048998589" class="uname">{{$best["roomandpicture"]["nickname"]}}</a>
                        </div>
                        <a href="#" onclick="return false;" rel="{{$best["roomIdx"]}}" class="enterBtn">채팅방 입장하기</a>
                    </div>
                </li>
            @endif
        </ul>
        <ul id="roomList" class="roomList">
            @if(!empty($list))
                @foreach($list as $value)
                    <li id="room-{{$value["roomIdx"]}}">
                        <div class="thumb">
                            <img src="@if(!empty($value["roomandpicture"]["image"])){{$value["roomandpicture"]["image"]}}@else{{'https://simg.powerballgame.co.kr/images/profile.png'}}@endif" class="roomImg">
                            {{--                        <div class="winFixCnt">5</div>--}}
                        </div>
                        <div class="inner">
                            <span class="winLose @if(($value["win"]-$value["lose"]) ==0){{'draw'}}@endif @if(($value["win"]-$value["lose"]) > 0){{'win'}}@endif @if(($value["win"]-$value["lose"]) < 0){{'lose'}}@endif"><span>{{$value["win"]}}</span>승 <span>{{$value["lose"]}}</span>패</span>
                            @if(!empty($value["current_win"]))<span class="winFix"><span>{{$value["current_win"]}}</span>연승</span>@endif
                            <span class="tit">{{$value["room_connect"]}}</span>
                            <div class="desc">{{$value["description"]}}</div>
                        </div>
                        <div class="userCntBox">
                            <div class="userCnt"><span class="curCnt">{{$value["members"]}}</span> / <span class="maxCnt">{{$value["max_connect"]}}</span></div>
                            <div class="date">{{getDiffTimes($best["created_at"])}}전</div>
                        </div>
                        <div class="line">&nbsp;</div>
                        <div class="userInfo">
                            <div class="user">
                                <img src="{{$value["roomandpicture"]["get_user_class"]["value3"]}}" width="23" height="23">
                                <a href="#" onclick="return false;" title="{{$value["roomandpicture"]["nickname"]}}" rel="965ff7b3c3d2d1ac75dca49048998589" class="uname">{{$value["roomandpicture"]["nickname"]}}</a>
                            </div>
                            <a href="#" onclick="return false;" rel="{{$value["roomIdx"]}}" class="enterBtn">채팅방 입장하기</a>
                        </div>
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
				<img src="{{$level["value3"]}}" width="23" height="23">
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

<div class="modal" id="creatingWindow">
    <div class="modal-dialog modal-sm-custom" role="document">
        <div class="modal-content">
            <div class="modal-header jin-gradient">
                <h5 class="modal-title light-medium text-white" id="exampleModalLabel">채팅방 개설하기</h5>
                <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' =>'App\Http\Controllers\ChatController@createRoom', 'method' => 'post',"id"=>"form-room"]) !!}
                   <table class="table table-borderless">
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">방제목</span>
                           </td>
                           <td class="border-top-none align-middle">
                               {!! Form::hidden('api_token',$api_token,["id"=>'api_token']); !!}
                               {!! Form::text('roomTitle', '', array_merge(['class' => 'form-control pr-0 pl-0 pt-1 pb-1 border-round-none border-input','placeholder'=>"제목을 입력해주세요",'autocomplete'=>"off","id"=>"roomTitle"],["required"])) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">설명</span>
                           </td>
                           <td class="border-top-none align-middle">
                               {!! Form::text('roomDesc', '', ['class' => 'form-control pr-0 pl-0 pt-1 pb-1 border-round-none border-input','autocomplete'=>"off"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">방종류</span>
                           </td>
                           <td class="border-top-none align-middle">
                               {!! Form::select('roomType',['normal' => '일반','premium' => '프리미엄'],null,['class'=>"custom-select no-height border-input"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">공개여부</span>
                           </td>
                           <td class="border-top-none align-middle">
                               {!! Form::select('roomPublic',['public' => '전체공개','private' => '비공개'],null,['class'=>"custom-select no-height border-input"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">참여인원</span>
                           </td>
                           <td class="border-top-none align-middle">
                               {!! Form::select('maxUser',['50' => '50명','100' => '100명','200' => '200명','300' => '300명','500' => '500명','1000' => '1,000명'],null,['class'=>"custom-select no-height border-input"]) !!}
                           </td>
                       </tr>
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">일반개설권</span>
                           </td>
                           <td class="border-top-none align-middle">
                               <span class="text-danger font-weight-bold">{{$normal_count}}개</span>
                           </td>
                       </tr>
                       <tr>
                           <td class="border-top-none align-middle">
                               <span class="light-medium">프리미엄 개설권</span>
                           </td>
                           <td class="border-top-none align-middle">
                               <span class="text-danger font-weight-bold">{{$premium_count}}개</span>
                           </td>
                       </tr>
                   </table>
                <div class="text-center">
                    {!! Form::submit("확인",["class"=>"btn btn-jin-gradient border-round-none pr-5 pl-5 btn-sm create_room"]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@include("chat.chat-waiting")
@endsection
