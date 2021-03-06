@extends('includes.empty_header')
@section("script_header")
    <script>
        var userIdToken = "{{$api_token}}";
        var userIdKey = "{{$userIdKey}}";
        var roomIdx ="{{$room["roomIdx"]}}";
        var is_freeze = @if($room["frozen"] == "off"){{0}}@else{{1}}@endif;
        var chatHistoryNum = 0;
        @if(!empty($profile))
        var levels = "{{$profile}}";
        var level_images = JSON.parse(levels.replace(/&quot;/g,'"'));
        level_images[30] = "/assets/images/powerball/class/M23.gif"
        @endif
        var total_num = 0;
        var bullet = {{$bullet}};
        var is_repeatChat = false;
        var lastMsgTime = new Date().getTime();
        var sumMsgTerm = 0;
        var msgTermArr = new Array();
        var msgTermIdx = 0;
        var msgStopTime = 10;
        var blackListArr = ''.split(',');
        var is_scroll_lock = false;
        var is_scroll_lock_room = false;
        var is_header = @if($manager == 1) true @else false @endif;
        var is_manager = @if(in_array($userIdKey,explode(",",$room["manager"]))){{true}}@else{{0}}@endif;
        var fixed = "{{$room["roomandpicture"]["fixed"]}}";
        var room_name ="{{$room["room_connect"]}}";
        var is_forceFreeze = false;
        var roomInfo = '{"roomIdx":"'+roomIdx+'","roomType":"@if($room["type"] == 1){{'normal'}}@else{{'premium'}}@endif","roomTitle":"{{$room["room_connect"]}}","roomDesc":"{{$room["description"]}}","roomPublic":"@if($room["public"] == 1){{'public'}}@else{{'private'}}@endif","joinLevel":"0","joinPoint":"0","maxUser":"{{$room["max_connect"]}}","curUser":"0","useridKey":"{{$room["roomandpicture"]["userIdKey"]}}","nickname":"{{$room["roomandpicture"]["nickname"]}}","level":"{{$room["roomandpicture"]["leve"]}}","sex":"{{$room["roomandpicture"]["sex"]}}","profile":"{{$room["roomandpicture"]["image"]}}","regDate":"{{$room["roomandpicture"]["created_date"]}}","manager":"{{$room["manager"]}}","fixMember":"{{$room["roomandpicture"]["fixed"]}}","recomCnt":"50"}';
        var cur_bet = "";
        @if(!empty($cur_bet))
        cur_bet  = "{{$cur_bet}}";
        @endif
        var next_round = {{$next_round}};
        var chatRoom_recomCnt = {{$room["recommend"]}};
        var level = "{{$room["roomandpicture"]["level"]}}";
        var prohited = "{{$prohited}}";
        var node = "{{$node}}";
    </script>
@endsection
@section("header")
<div id="header">
    <div class="winLose">
        @if(empty($win_room))
            ?????? : <span class="totalWinCnt" rel="0">0</span>??? <span class="totalLoseCnt" rel="0">0</span>??? / <span class="winFix" rel="0">0</span>?????? &nbsp;&nbsp; ????????? : <span class="powerballWinCnt" rel="0">0</span>???
            <span class="powerballLoseCnt" rel="0">0</span>??? &nbsp;&nbsp; ????????? : <span class="numberWinCnt" rel="0">0</span>??? <span class="numberLoseCnt" rel="0">0</span>???
        @else
            ?????? : <span class="totalWinCnt" rel="{{$win_room->total->win}}">{{$win_room->total->win}}</span>??? <span class="totalLoseCnt" rel="{{$win_room->total->lose}}">{{$win_room->total->lose}}</span>??? / <span class="winFix" rel="{{$win_room->current_win}}">{{$win_room->current_win}}</span>?????? &nbsp;&nbsp; ????????? : <span class="powerballWinCnt" rel="{{$win_room->pb->win}}">{{$win_room->pb->win}}</span>???
            <span class="powerballLoseCnt" rel="{{$win_room->pb->lose}}">{{$win_room->pb->lose}}</span>??? &nbsp;&nbsp; ????????? : <span class="numberWinCnt" rel="{{$win_room->nb->win}}">{{$win_room->nb->win}}</span>??? <span class="numberLoseCnt" rel="{{$win_room->nb->lose}}">{{$win_room->nb->lose}}</span>???
        @endif

    </div>
    <h2 id="roomTitle" class="tit">{{$room["room_connect"]}}</h2>
    <p id="roomDesc" class="desc">{{$room["description"]}}</p>
    <div class="profile"><img src="@if(empty($room["roomandpicture"]["image"])){{'https://www.powerballgame.co.kr/images/profile.png'}}@else{{$room["roomandpicture"]["image"]}}@endif" /></div>
</div>
<div id="container" style="width:100%">
    <div class="leftArea">
        <div class="category">
            <ul class="cate">
                <li class="custom">?????? <em class="on">{{$room["roomandpicture"]["name"]}}</em></li>
                <li class="custom"><span>{{getDiffTimes($room["created_at"])}}???</span></li>
                <li class="custom">????????? <span id="chatRoom_topUserCnt" class="on">0</span>???</li>
                <li class="custom">????????? <span id="chatRoom_recomCnt" class="on">{{number_format($room["recommend"])}}</span></li>
                <li class="custom">?????? ????????? <span id="totalBulletCnt" rel="{{number_format($room["bullet"])}}" class="on">{{number_format($room["bullet"])}}</span></li>
            </ul>
        </div>
        <div class="mainBanner">
{{--            <a href="http://qootoon.com/3c31ef24" target="_blank"><img src="https://simg.powerballgame.co.kr/ad/toptoon_728_90_1.jpg" ></a>--}}
        </div>
        <div id="recomLogBox"></div>
        <div id="bulletLogBox"></div>
        <div id="managerLogBox"></div>
        <ul class="msgBox" id="msgBox">

        </ul>
        <div class="menuBox">
            <div id="helpBox">
                <ul>
                    <li class="tit">????????? ??????</li>
                    <li>/????????? : ????????? ?????????</li>
                    <li>/????????? : ????????? ?????????</li>
                    <li>/????????? : ????????? ?????????</li>
                    <li>/?????? : ????????? ??????</li>
                    <li>/?????? : ????????? ??????</li>
                    <li>/????????? : ?????? ?????? ??????</li>
                    <li>/??????????????? : ?????? ?????? ??????</li>
                    <li>/?????? : ?????? ??????</li>
                    <li class="none">/???????????? : ?????? ?????? ??????</li>
                </ul>
            </div>

            <div id="pointBetBox" style="position:absolute;width:100%;bottom:37px;">
                @include("pick/pick1")
            </div>
            <div id="layer-emoticonBox">
                <div class="title">
                    ???????????? <span class="bar">|</span> <span class="txt">??????????????? <span class="important">???????????? ?????????</span>????????? <span class="important">???????????? ?????????</span> ????????? ???????????? ??? ????????????. <a href="/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket" target="_blank" class="important">????????? ????????????</a></span>
                </div>
                <div class="content">
                    <div>
                        <ul class="emoticon">
                            <li class="dog1" rel="&amp;1_1"></li><li class="dog2" rel="&amp;1_2"></li><li class="dog3" rel="&amp;1_3"></li><li class="dog4" rel="&amp;1_4"></li><li class="dog5" rel="&amp;1_5"></li><li class="dog6" rel="&amp;1_6"></li><li class="dog7" rel="&amp;1_7"></li><li class="dog8" rel="&amp;1_8"></li><li class="dog9" rel="&amp;1_9"></li><li class="dog10" rel="&amp;1_10"></li><li class="dog11" rel="&amp;1_11"></li><li class="dog12" rel="&amp;1_12"></li><li class="dog13" rel="&amp;1_13"></li><li class="dog14" rel="&amp;1_14"></li><li class="dog15" rel="&amp;1_15"></li><li class="dog16" rel="&amp;1_16"></li><li class="dog17" rel="&amp;1_17"></li><li class="cat1" rel="&amp;2_1"></li><li class="cat2" rel="&amp;2_2"></li><li class="cat3" rel="&amp;2_3"></li><li class="cat4" rel="&amp;2_4"></li><li class="cat5" rel="&amp;2_5"></li><li class="cat6" rel="&amp;2_6"></li><li class="cat7" rel="&amp;2_7"></li><li class="cat8" rel="&amp;2_8"></li><li class="cat9" rel="&amp;2_9"></li><li class="cat10" rel="&amp;2_10"></li><li class="cat11" rel="&amp;2_11"></li><li class="cat12" rel="&amp;2_12"></li><li class="cat13" rel="&amp;2_13"></li><li class="cat14" rel="&amp;2_14"></li><li class="cat15" rel="&amp;2_15"></li><li class="cat16" rel="&amp;2_16"></li><li class="cat17" rel="&amp;2_17"></li><li class="lion1" rel="&amp;3_1"></li><li class="lion2" rel="&amp;3_2"></li><li class="lion3" rel="&amp;3_3"></li><li class="lion4" rel="&amp;3_4"></li><li class="lion5" rel="&amp;3_5"></li><li class="lion6" rel="&amp;3_6"></li><li class="lion7" rel="&amp;3_7"></li><li class="lion8" rel="&amp;3_8"></li><li class="lion9" rel="&amp;3_9"></li><li class="lion10" rel="&amp;3_10"></li><li class="lion11" rel="&amp;3_11"></li><li class="lion12" rel="&amp;3_12"></li><li class="lion13" rel="&amp;3_13"></li><li class="lion14" rel="&amp;3_14"></li><li class="lion15" rel="&amp;3_15"></li><li class="lion16" rel="&amp;3_16"></li><li class="lion17" rel="&amp;3_17"></li><li class="panda1" rel="&amp;4_1"></li><li class="panda2" rel="&amp;4_2"></li><li class="panda3" rel="&amp;4_3"></li><li class="panda4" rel="&amp;4_4"></li><li class="panda5" rel="&amp;4_5"></li><li class="panda6" rel="&amp;4_6"></li><li class="panda7" rel="&amp;4_7"></li><li class="panda8" rel="&amp;4_8"></li><li class="panda9" rel="&amp;4_9"></li><li class="panda10" rel="&amp;4_10"></li><li class="panda11" rel="&amp;4_11"></li><li class="panda12" rel="&amp;4_12"></li><li class="panda13" rel="&amp;4_13"></li><li class="panda14" rel="&amp;4_14"></li><li class="panda15" rel="&amp;4_15"></li><li class="panda16" rel="&amp;4_16"></li><li class="fox1" rel="&amp;5_1"></li><li class="fox2" rel="&amp;5_2"></li><li class="fox3" rel="&amp;5_3"></li><li class="fox4" rel="&amp;5_4"></li><li class="fox5" rel="&amp;5_5"></li><li class="fox6" rel="&amp;5_6"></li><li class="fox7" rel="&amp;5_7"></li><li class="fox8" rel="&amp;5_8"></li><li class="fox9" rel="&amp;5_9"></li><li class="fox10" rel="&amp;5_10"></li><li class="fox11" rel="&amp;5_11"></li><li class="fox12" rel="&amp;5_12"></li><li class="fox13" rel="&amp;5_13"></li><li class="fox14" rel="&amp;5_14"></li><li class="fox15" rel="&amp;5_15"></li><li class="fox16" rel="&amp;5_16"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="layer-bulletBox">
                <div class="title">
                    ?????? ?????? <span class="bullet" id="bullet" rel="0" giftcnt="0">0</span>??? <span class="bar">|</span> <span class="txt">?????? ?????? ?????? ?????????  <span class="important">???????????? ??????</span>??? ??? ?????????, ????????? ?????? ?????? ?????? ??? ?????? ???????????????. <a href="/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket" target="_blank" class="important">?????? ????????????</a></span>
                </div>
                <div class="content">
                    <div>
                        <ul>
                            <li><span rel="50" class="opt">50???</span></li>
                            <li><span rel="100" class="opt">100???</span></li>
                            <li><span rel="300" class="opt">300???</span></li>
                            <li><span rel="500" class="opt">500???</span></li>
                            <li class="input"><input type="text" name="inputCnt" id="inputCnt" placeholder="????????????" onkeypress="onlyNumber();" class="opt"></li>
                        </ul>
                    </div>
                    <div class="btnBox">
                        <div class="gift"><span>????????????</span></div>
                        <div class="reset"><span>??????</span></div>
                    </div>
                </div>
            </div>
            <ul class="pl-2 bott-menu" style="height: 39px;background: #ebeded;">
                @if($manager == 0 && $admin == 0 && $is_admin == 0)
                    <li><a href="#" onclick="return false;" id="btn_giftBullet">?????? ????????????</a></li>
                    <li><a href="#" onclick="return false;" id="btn_recom">????????????</a></li>
                    <li><a href="#" onclick="chatManager('clearChat');return false;">?????????</a></li>
                    <li><a href="#" onclick="return false;" id="btn_sound">????????? ??????</a></li>
{{--                    <li class="emoticon"><a href="#" onclick="return false;" id="btn_emoticon">????????????</a></li>--}}
                    <li><a href="#" onclick="return false;" id="btn_favorite">????????????</a></li>
                    <li class="right"><a href="#" onclick="return false;" id="btn_pointBet">??? ??????</a></li>
                @else
{{--                    <li><a href="#" onclick="return false;" id="btn_help">?????????</a></li>--}}
                    @if($room["frozen"] == "off")
                        <li ><a href="#" onclick="return false;" id="btn_freezeOn" >?????????</a></li>
                    @else
                        <li style="background:url(/assets/images/pick/present.png);background-size:100%;background-repeat:no-repeat"><a href="#" onclick="return false;" id="btn_freezeOff">?????????</a></li>
                    @endif

                    <li><a href="#" onclick="chatManager('clearChat');return false;">?????????</a></li>
                    <li><a href="#"  id="btn_chatRoomSetting" data-target="#modify-chatroom" data-toggle="modal">??????</a></li>
                    <li><a href="#" onclick="return false;" id="btn_chatRoomClose">??????</a></li>
                    <li><a href="#" onclick="return false;" id="btn_call">??????</a></li>
                    <li><a href="#" onclick="return false;" id="btn_sound">????????? ??????</a></li>
{{--                    <li class="emoticon"><a href="#" onclick="return false;" id="btn_emoticon">????????????</a></li>--}}
                    <li class="right"><a href="#" onclick="return false;" id="btn_pointBet">??? ??????</a></li>
                @endif


            </ul>
        </div>
        <div class="inputBox">
            <div class="input">
                <fieldset><input type="text" name="msg" id="msg" autocomplete="off"></fieldset>
            </div>
            <a id="sendBtn" class="btns" href="#" onclick="return false;"></a>
        </div>
    </div>
    <div class="rightArea" style="background: #f0f2f2">
        <div class="btns">
            <a href="#" onclick="return false;" id="btn_exit" class="exit">????????? ?????????</a>
            @if($room["badge"] >=5)
                <div style="position:absolute;top:0;right: 194px;z-index:96;" title="????????? ?????? 5?????? ????????? ????????????">
                    <img src="/assets/images/powerball/badge/badge5.png" width="37" height="53">
                </div>
            @endif
            @if($room["badge"] >=10)
                <div style="position:absolute;top:0;right: 167px;z-index:96;" title="????????? ?????? 10?????? ????????? ????????????">
                    <img src="/assets/images/powerball/badge/badge10.png" width="37" height="53">
                </div>
            @endif
            @if($room["badge"] >=15)
                <div style="position:absolute;top:0;right: 140px;z-index:96;" title="????????? ?????? 15?????? ????????? ????????????">
                    <img src="/assets/images/powerball/badge/badge15.png" width="37" height="53">
                </div>
            @endif
            @if($room["badge"] >=20)
                <div style="position:absolute;top:0;right: 114px;z-index:96;" title="????????? ?????? 20?????? ????????? ????????????">
                    <img src="/assets/images/powerball/badge/badge20.png" width="37" height="53">
                </div>
            @endif
        </div>
        <div style="margin: 8px">
            @include('chat.countdown')
{{--            @include('chat.oddChart')--}}
        </div>
        <div class="resultBox">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="connection-tab" data-toggle="tab" href="#connection" role="tab" aria-controls="connection" aria-selected="true">????????? <span id="chatRoom_userCnt">0</span>???</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="pick-tab" data-toggle="tab" href="#pick" role="tab" aria-controls="pick" aria-selected="false">????????? ??????</a>
                </li>
            </ul>
            <div class="tab-content content" id="myTabContent">
                <div class="tab-pane fade" id="connection" role="tabpanel" aria-labelledby="connection-tab">
                    <div class="userListBox" id="userList">
                        <ul class="userList" id="connectOpenerList">

                        </ul>
                        <ul class="userList" id="connectManagerList">

                        </ul>
                        <ul class="userList" id="connectUserList">

                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="pick" role="tabpanel" aria-labelledby="pick-tab">
                    <ul class="resultList" id="resultList">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="callSound"></div>

<div class="modal"  id="modify-chatroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header jin-gradient">
                <h5 class="modal-title light-medium text-white">????????? ??????</h5>
                <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="align-middle"><span class="light-medium">?????????</span></td>
                        <td class="align-middle">
                            <input type="text" autocomplete="off" name="roomTitle" id="current_roomTitle" maxlength="40" value="{{$room["room_connect"]}}" class="form-control pr-0 pl-0 pt-1 pb-1 border-round-none border-input">
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">??????</span></td>
                        <td class="align-middle"><input name="roomDesc" id="current_roomDesc" cols="30" rows="2" maxlength="40" value="{{$room["description"]}}" class="form-control pr-0 pl-0 pt-1 pb-1 border-round-none border-input"></td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">?????????</span></td>
                        <td class="align-middle">
                            @if($room["type"] == 1 )
                            ??????
                            @else
                                ????????????
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">????????????</span></td>
                        <td class="align-middle">
                            <select name="roomPublic" id="current_roomPublic" class="custom-select no-height border-input">
                                <option value="1" @if($room["public"] == 1 ){{'selected'}}@endif>????????????</option>
                                <option value="2" @if($room["public"] == 2 ){{'selected'}}@endif>?????????</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">????????????</span></td>
                        <td class="align-middle">{{$room["max_connect"]}}???</td>
                    </tr>
                </table>
                <div class="text-center">
                    <a href="#" id="btn_modifyChatRoom" type="button" class="btn btn-jin-gradient border-round-none pr-5 pl-5 btn-sm create_room">????????? ??????</a>
                </div>
            </div>
        </div>
    </div>
</div>
    @include("chat.view-list")
    @include("chat.opener-picks")
@endsection
