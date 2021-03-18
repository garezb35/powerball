@extends('includes.empty_header')
@section("header")
<div id="header">
    <div class="winLose">
        전체 : <span class="totalWinCnt" rel="8">8</span>승 <span class="totalLoseCnt" rel="0">0</span>패 / <span class="winFix" rel="8">8</span>연승 &nbsp;&nbsp; 파워볼 : <span class="powerballWinCnt" rel="0">0</span>승
        <span class="powerballLoseCnt" rel="0">0</span>패 &nbsp;&nbsp; 숫자합 : <span class="numberWinCnt" rel="8">8</span>승 <span class="numberLoseCnt" rel="0">0</span>패
    </div>
    <h2 id="roomTitle" class="tit">✅슬램덩크 레전드 강백호 ✅</h2>
    <p id="roomDesc" class="desc">1:1 개인프젝, 단체 프젝 환영</p>
    <div class="profile"><img src="https://sfile.powerballgame.co.kr/profileImg/0306b44123062d60109cac22f164f1ab.gif?1596615578" /></div>
</div>
<div id="container">
    <div class="leftArea">
        <div class="category">
            <ul class="cate">
                <li>방장 <em class="on">보테가R</em></li>
                <li><span class="bar"></span><em>1시간전</em></li>
                <li><span class="bar"></span>접속자 <em id="chatRoom_topUserCnt" class="on">78</em>명</li>
                <li><span class="bar"></span>추천수 <em id="chatRoom_recomCnt" class="on">114</em></li>
                <li><span class="bar"></span>누적 총알수 <em id="totalBulletCnt" rel="2970" class="on">2,970</em></li>
            </ul>
        </div>
        <div class="mainBanner">
            <a href="http://qootoon.com/3c31ef24" target="_blank"><img src="https://simg.powerballgame.co.kr/ad/toptoon_728_90_1.jpg" style="display: none !important;"></a>
        </div>
        <div id="recomLogBox"></div>
        <div id="bulletLogBox"></div>
        <div id="managerLogBox"></div>
        <ul class="msgBox" id="msgBox" style="height: 379px;">
            <li><p class="msg-system">방장에 의해 채팅방이 청소 되었습니다.</p></li>
            <li>
                <p class="recom">
                    <img src="https://simg.powerballgame.co.kr/images/class/M2.gif" width="23" height="23"> <strong>
                    <a href="#" class="uname nick" title="가양라끄빌" rel="ff514efc5a8dcccb6f9f7af184d0ba30">가양라끄빌</a></strong> 님이 대화방을 
                    <img src="https://simg.powerballgame.co.kr/chat/images/bl_recom.png" width="18" height="18" class="icon"> <span>추천</span> 하였습니다.
                </p>
            </li>
            <li><div class="pick nonnn"></div></li>
            <li><p class="msg-pick"> 방장이 <span>02월08일-1062889</span>회차 <span> [숫자합] 패스</span> 을 선택하셨습니다.</p></li>
            <li><p class="msg-system"><span>광고, 비방, 비매너, 카톡, 개인정보, 계좌</span> 발언시 차단됩니다.</p></li>
            <li class="manager">
                <img src="https://simg.powerballgame.co.kr/chat/images/mark_manager.gif" width="16" height="16"> 
                <img src="https://simg.powerballgame.co.kr/images/class/M14.gif" width="23" height="23">
                <strong>
                    <a href="#" class="uname nick" title="수향이" rel="0824432fc26f58b601d86c301d3cf56e">수향이</a>
                </strong> ㅌㅌ
            </li>
            <li class="opener">
                <img src="https://simg.powerballgame.co.kr/chat/images/mark_opener.gif" width="16" height="16"> 
                <img src="https://simg.powerballgame.co.kr/images/class/M15.gif" width="23" height="23"> 
                <strong><a href="#" class="uname nick" title="보테가R" rel="cb7df5ba2a8f6787d8de4015f1a6465e">보테가R</a></strong> 
                팸장 :: 보테가 :: 프로젝트 ::    [ ++ 출 45 만원 ++ 뱃후 ++&gt; 80.1 대기중 ]
            </li>
            <li><div class="bulletBox"><div class="cnt">20</div><img src="https://simg.powerballgame.co.kr/images/bullet1.png"></div></li>
            <li><p class="msg-gift"><span>우주최강</span> 님이 <span>보테가R</span> 님에게 <span>총알 10개</span>를 선물하셨습니다.</p></li>
        </ul>
        <div class="menuBox">
            <div id="helpBox">
                <ul>
                    <li class="tit">명령어 안내</li>
                    <li>/얼리기 : 채팅창 얼리기</li>
                    <li>/녹이기 : 채팅창 녹이기</li>
                    <li>/방청소 : 채팅창 지우기</li>
                    <li>/설정 : 채팅방 설정</li>
                    <li>/삭제 : 채팅방 삭제</li>
                    <li>/벙어리 : 채팅 등록 금지</li>
                    <li>/벙어리해제 : 채팅 등록 가능</li>
                    <li>/강퇴 : 강제 퇴장</li>
                    <li class="none">/강퇴해제 : 강제 퇴장 해제</li>
                </ul>
            </div>

            <div id="pointBetBox" style="position:absolute;width:100%;bottom:25px;">
                @include("pick/pick1")
            </div>
            <div id="layer-emoticonBox">
                <div class="title">
                    이모티콘 <span class="bar">|</span> <span class="txt">이모티콘은 <span class="important">프리미엄 채팅방</span>이거나 <span class="important">이모티콘 사용권</span> 보유시 사용하실 수 있습니다. <a href="/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket" target="_blank" class="important">아이템 구매하기</a></span>
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
                    나의 총알 <span class="bullet" id="bullet" rel="40" giftcnt="0">40</span>개 <span class="bar">|</span> <span class="txt">보유 수량 한도 내에서  <span class="important">방장에게 선물</span>할 수 있으며, 부족할 경우 총알 구매 후 선물 가능합니다. <a href="/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket" target="_blank" class="important">총알 구매하기</a></span>
                </div>
                <div class="content">
                    <div>
                        <ul>
                            <li><span rel="50" class="opt">50개</span></li>
                            <li><span rel="100" class="opt">100개</span></li>
                            <li><span rel="300" class="opt">300개</span></li>
                            <li><span rel="500" class="opt">500개</span></li>
                            <li class="input"><input type="text" name="inputCnt" id="inputCnt" placeholder="직접입력" onkeypress="onlyNumber();" class="opt"></li>
                        </ul>
                    </div>
                    <div class="btnBox">
                        <div class="gift"><span>선물하기</span></div>
                        <div class="reset"><span>취소</span></div>
                    </div>
                </div>
            </div>
            <ul>
                <li><a href="#" onclick="return false;" id="btn_giftBullet">총알 선물하기</a></li>
                <li><a href="#" onclick="return false;" id="btn_recom">추천하기</a></li>
                <li><a href="#" onclick="chatManager('clearChat');return false;">방청소</a></li>
                <li><a href="#" onclick="return false;" id="btn_sound">사운드 끄기</a></li>
                <li class="emoticon"><a href="#" onclick="return false;" id="btn_emoticon">이모티콘</a></li>
                <li><a href="#" onclick="return false;" id="btn_favorite">즐겨찾기</a></li>
                <li class="right"><a href="#" onclick="return false;" id="btn_pointBet">픽 열기</a></li>
            </ul>
        </div>
        <div class="inputBox">
            <div class="input">
                <fieldset><input type="text" name="msg" id="msg" autocomplete="off"></fieldset>
            </div>
            <a id="sendBtn" class="btns" href="#" onclick="return false;"></a>
        </div>
    </div>
    <div class="rightArea">
        <div class="btns">	
            <a href="#" onclick="return false;" id="btn_exit" class="exit">채팅방 나가기</a>
        </div>
        <div style="margin: 8px">
            @include('chat.countdown')
            @include('chat.oddChart')
        </div>
        <div class="resultBox">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="connection-tab" data-toggle="tab" href="#connection" role="tab" aria-controls="connection" aria-selected="true">접속자 <span id="chatRoom_userCnt">22</span>명</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="pick-tab" data-toggle="tab" href="#pick" role="tab" aria-controls="pick" aria-selected="false">방장픽 정보</a>
                </li>
            </ul>
            <div class="tab-content content" id="myTabContent">
                <div class="tab-pane fade" id="connection" role="tabpanel" aria-labelledby="connection-tab">
                    <div class="userListBox" id="userList">
                        <ul class="userList" id="connectOpenerList">
                            <li id="u-59cfc4aaf1cb00550f5cf8f109c06a8e">
                                <img src="https://sfile.powerballgame.co.kr/profileImg/59cfc4aaf1cb00550f5cf8f109c06a8e.gif?1573740223" class="profile mark">
                                <span class="icon_opener">방장</span>
                                <img src="https://simg.powerballgame.co.kr/images/class/M20.gif" width="23" height="23">
                                <a href="#" onclick="return false;" title="대표복구" rel="59cfc4aaf1cb00550f5cf8f109c06a8e" class="uname">대표복구</a>
                                <div class="todayMsg">
                                    <div class="inn">
                                        <p>
                                            <span>복구해드립니다^^</span>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="userList" id="connectManagerList">
                        </ul>
                        <ul class="userList" id="connectUserList">
                            <li id="u-036ecf6d877ec89ed8111417a5f1c1c3">
                                <img src="https://www.powerballgame.co.kr/profileImg/036ecf6d877ec89ed8111417a5f1c1c3.jpg?1445665748" class="profile">
                                <img src="https://simg.powerballgame.co.kr/images/class/M28.gif" width="23" height="23">
                                <a href="#" onclick="return false;" title="모니터링요원" rel="036ecf6d877ec89ed8111417a5f1c1c3" class="uname">모니터링요원</a>
                                <div class="todayMsg">
                                    <div class="inn">
                                        <p>
                                            <span>개인정보 발언시 차단</span>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li id="u-35656d70d4845d0e89745d7762fd7d2e">
                                <img src="https://www.powerballgame.co.kr/images/profile.png" class="profile">
                                
                                <img src="https://simg.powerballgame.co.kr/images/class/M15.gif" width="23" height="23">
                                <a href="#" onclick="return false;" title="왕수박" rel="35656d70d4845d0e89745d7762fd7d2e" class="uname">왕수박</a>
                                
                            </li>
                            <li id="u-7708d9f79d44c8e0f1ac1dd6c999e40b">
                                <img src="https://www.powerballgame.co.kr/images/profile.png" class="profile mark">
                                <span class="icon_fixMember">고정</span>
                                <img src="https://simg.powerballgame.co.kr/images/class/M13.gif" width="23" height="23">
                                <a href="#" onclick="return false;" title="이쁜미실이" rel="7708d9f79d44c8e0f1ac1dd6c999e40b" class="uname">이쁜미실이</a>
                            </li>
                            <li id="u-b05dea204cd799f7b3086b62c59a9eb1">
                                <img src="https://www.powerballgame.co.kr/images/profile.png" class="profile mark">
                                <span class="icon_fixMember">고정</span>
                                <img src="https://simg.powerballgame.co.kr/images/class/M12.gif" width="23" height="23">
                                <a href="#" onclick="return false;" title="어디로가" rel="b05dea204cd799f7b3086b62c59a9eb1" class="uname">어디로가</a>
                                
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="pick" role="tabpanel" aria-labelledby="pick-tab">
                    <ul class="resultList" id="resultList">
                        <li id="pick-1063070" style="display: list-item;">
                            <div class="num">
                                02월08일<br />
                                1063070회
                            </div>
                            <div class="rs ready"></div>
                            <div class="blank"></div>
                            <div class="pick" oddeven_powerball="" oddeven_number="" underover_powerball="" underover_number="" period=""></div>
                            <div class="pickResultText"></div>
                        </li>
                        <li id="pick-1063069" regdate="0">
                            <div class="num">
                                02월08일<br />
                                1063069회
                            </div>
                            <div class="rs eooom"></div>
                            <div class="blank"></div>
                            <div class="pick onnnn" oddeven_powerball="o" oddeven_number="n" underover_powerball="n" underover_number="n" period="n"><span class="lose_tl"></span></div>
                            <div class="pickResultText"><span class="win">0</span>승<span class="bar">/</span><span class="lose">1</span>패</div>
                        </li>
                        <li id="pick-1063068" regdate="2021-02-08 16:12:53">
                            <div class="num">
                                02월08일<br />
                                1063068회
                            </div>
                            <div class="rs eeuum"></div>
                            <div class="blank"></div>
                            <div class="pick nnonn" oddeven_powerball="n" oddeven_number="n" underover_powerball="o" underover_number="n" period="n"><span class="lose_bl"></span></div>
                            <div class="pickResultText"><span class="win">0</span>승<span class="bar">/</span><span class="lose">1</span>패</div>
                        </li>
                        <li id="pick-1063067" regdate="2021-02-08 16:07:53" class="win_all">
                            <div class="num">
                                02월08일<br />
                                1063067회
                            </div>
                            <div class="rs ooous"></div>
                            <div class="blank"></div>
                            <div class="pick nnonn" oddeven_powerball="n" oddeven_number="n" underover_powerball="o" underover_number="n" period="n"></div>
                            <div class="pickResultText"><span class="win">1</span>승<span class="bar">/</span><span class="lose">0</span>패</div>
                        </li>
                        <li id="pick-1063066" regdate="2021-02-08 16:02:52">
                            <div class="num">
                                02월08일<br />
                                1063066회
                            </div>
                            <div class="rs eeuob"></div>
                            <div class="blank"></div>
                            <div class="pick" oddeven_powerball="" oddeven_number="" underover_powerball="" underover_number="" period=""></div>
                            <div class="pickResultText"><div style="width: 60px; text-align: center;">개설전</div></div>
                        </li>
                        
                    </ul>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection