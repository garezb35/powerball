<div class="box-chatting">
    <div class="btn-etc mb-2">
        <span class="cnt">
            <div class="sp-bl_pp"></div>
            <span id="connectUserCnt" rel="5310">5,310</span>명
            <span id="loginUserCnt"></span>
        </span>
        <ul class="ul-1">
            <li>
                <a href="#" onclick="chatManager('popupChat');return false;" title="새창" class="sp-btn_chat1"></a>
            </li>
            <li style="background-color: rgb(243, 243, 243);">
                <a href="#" onclick="fontZoom(1);return false;" title="글씨크게" class="sp-btn_chat2"></a>
            </li>
            <li style="background-color: rgb(243, 243, 243);">
                <a href="#" onclick="fontZoom(-1);return false;" title="글씨작게" class="sp-btn_chat3"></a>
            </li>
            <li style="background-color: rgb(243, 243, 243);">
                <a href="#" onclick="chatManager('clearChat');return false;" title="채팅창 지우기" class="sp-btn_chat4"></a>
            </li>
            <li style="background-color: rgb(243, 243, 243);">
                <a href="#" onclick="chatManager('refresh');return false;" title="새로고침" class="sp-btn_chat5"></a>
            </li>
            <li>
                <a href="#" onclick="return false;" id="soundBtn" title="소리끄기" class="sp-btn_chat_sound on"></a>
            </li>
        </ul>
    </div>

    <div class="table-type-1">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="chatroomListBox-tab" data-toggle="tab" data-bs-toggle="tab" href="#chatTap" role="tab" aria-controls="home" aria-selected="true">연병장</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="room-tab" data-toggle="tab" data-bs-toggle="tab" href="#roomTap" role="tab" aria-controls="profile" aria-selected="false">방채팅</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="connect-tab" data-toggle="tab" data-bs-toggle="tab" href="#connectTap" role="tab" aria-controls="contact" aria-selected="false">접속자</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rule-tab" data-toggle="tab" data-bs-toggle="tab" href="#ruleTap" role="tab" aria-controls="contact" aria-selected="false">채팅규정</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="chatTap" role="tabpanel" aria-labelledby="home-tab">
            <div id="chatListBox" style="position:relative;">
                <ul class="list-chatting" id="msgBox" style="height: 387px;">
                    <li class="superchat"><span style="position:relative;"><img src="https://simg.powerballgame.co.kr/images/class/M16.gif" width="23" height="23" orglevel="M16"><span style="position:absolute;left:-3px;z-index:-1;"><img src="https://simg.powerballgame.co.kr/images/levelupx2.gif" width="29" height="23"></span><span style="position:absolute;right:-3px;bottom:-9px;z-index:99;"><div class="sp-win2" title="2연승"></div></span></span> <strong><a href="#" onclick="return false;" title="사잇돌님" rel="be508d4e93329b1c2df2a95225987650" class="uname"><span class="familyNick"></span>사잇돌님</a></strong> 폐암걸리겠다</li>
                    <li class="superchat"><span style="position:relative;"><img src="https://simg.powerballgame.co.kr/images/class/M16.gif" width="23" height="23" orglevel="M16"><span style="position:absolute;left:-3px;z-index:-1;"><img src="https://simg.powerballgame.co.kr/images/levelupx2.gif" width="29" height="23"></span><span style="position:absolute;right:-3px;bottom:-9px;z-index:99;"><div class="sp-win2" title="2연승"></div></span></span> <strong><a href="#" onclick="return false;" title="사잇돌님" rel="be508d4e93329b1c2df2a95225987650" class="uname"><span class="familyNick"></span>사잇돌님</a></strong> 담배만 줫나피네</li>
                    <li>
                        <p class="msg-guide"><span>연병장</span>에 입장 하셨습니다.</p>
                    </li>
                    <li>
                        <p class="msg-system"><span>광고, 비방, 비매너, 개인정보 발언</span> 채팅시 차단됩니다.</p>
                    </li>
                    <li><span style="position:relative;"><img src="https://simg.powerballgame.co.kr/images/class/M8.gif" width="23" height="23" orglevel="M8"><span style="position:absolute;right:-3px;bottom:-9px;z-index:99;"><div class="sp-win1" title="1연승"></div></span></span> <strong><a href="#" onclick="return false;" title="구구쩜구" rel="08a12639f8ec1c4387a9101dcd481108" class="uname">구구쩜구</a></strong> 어마무시하네 ㅋ</li>
                    <li>
                        <p class="msg-auto"><span>A딩동댕중학교</span>님이 일반 채팅방 "<span>⭐️ 딩 중 구 간 파 악 끝 ⭐️</span>" 을 개설하였습니다. <a href="#" onclick="return false;" class="joinRoom" rel="404d96c362cee42ffbaac9757405902a">[입장하기]</a></p>
                    </li>
                    <li>
                        <p class="msg-auto"><span>바다새우님</span>님이 일반 채팅방 "<span>바다새우 = 1차모집♥</span>" 을 개설하였습니다. <a href="#" onclick="return false;" class="joinRoom" rel="cfea90aaf3d330a7b1eaf30d699a48e1">[입장하기]</a></p>
                    </li>
                    <li>
                        <p class="msg-auto"><span>체리블라썸님</span>님이 일반 채팅방 "<span>⭐ 1등 수익 ⭐</span>" 을 개설하였습니다. <a href="#" onclick="return false;" class="joinRoom" rel="262dd929aadab6fbd1c3f6e19abde24e">[입장하기]</a></p>
                    </li>
                    <li><span style="position:relative;"><img src="https://simg.powerballgame.co.kr/images/class/M15.gif" width="23" height="23" orglevel="M15"><span style="position:absolute;right:-3px;bottom:-9px;z-index:99;"><div class="sp-win2" title="2연승"></div></span></span> <strong><a href="#" onclick="return false;" title="대구은행님" rel="0d11b96c76f6eb192e3967c18fec2b34" class="uname">대구은행님</a></strong> 대구은행 4연승 ㅅㅅㅅㅅ5연타 딱대기 프젝모집중 방입장 ㄱㄱ</li>
                </ul>
                <p class="input-chatting">
                    <input type="text" name="msg" id="msg" class="input-1" autocomplete="off" placeholder="내용을 입력해주세요...">
                    <input type="button" class="input-2 sp-btn_enter" id="sendBtn">
                    <a href="#" class="scrollBottom" id="scrollBottom" style="display: none;"></a>
                </p>
            </div>
        </div>
        <div class="tab-pane fade" id="connectTap" role="tabpanel" aria-labelledby="profile-tab">
            <div id="connectListBox">
                <ul class="list-connect" id="connectList" style="height: 446px;">
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/class/M30.gif" width="23" height="23">
                        <a href="#" onclick="return false;" title="운영자" rel="dc5de9ce5f7cfb22942da69e58156b68" class="uname">운영자</a>
                        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;"></span>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/class/M23.gif" width="23" height="23">
                        <a href="#" onclick="return false;" title="타짜선생" rel="4964ca8d4b8466216b0eff7285a49a4d" class="uname">타짜선생</a>
                        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">10시간전</span>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/class/M23.gif" width="23" height="23">
                        <a href="#" onclick="return false;" title="타짜선생" rel="4964ca8d4b8466216b0eff7285a49a4d" class="uname">타짜선생</a>
                        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">10시간전</span>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/class/M23.gif" width="23" height="23">
                        <a href="#" onclick="return false;" title="타짜선생" rel="4964ca8d4b8466216b0eff7285a49a4d" class="uname">타짜선생</a>
                        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">10시간전</span>
                    </li>
                    <li>
                        <img src="https://simg.powerballgame.co.kr/images/class/M23.gif" width="23" height="23">
                        <a href="#" onclick="return false;" title="타짜선생" rel="4964ca8d4b8466216b0eff7285a49a4d" class="uname">타짜선생</a>
                        <span style="position:absolute;right:10px;font-weight:normal;font-size:11px;color:#a29c9b;">10시간전</span>
                    </li>
                </ul>

            </div>
        </div>
        <div class="tab-pane fade" id="roomTap" role="tabpanel" aria-labelledby="contact-tab">
            <div id="roomListBox" style="display: block;">
                <div style="background-color:#F5F5F5;height:25px;line-height:25px;border:1px solid #CECECE;border-top:none;text-align:right;padding-right:5px;font-weight:bold;font-size:12px;"><a href="#" onclick="openChatRoom();return false;">채팅대기실</a></div>
                <ul class="list-room" id="roomList" style="height: 420px;">
                    <li class="bgYellow">
                        <div class="thumb red" rel="912b4c40acaf4f8a63a91e8eb813926d">
                            <img src="https://sfile.powerballgame.co.kr/profileImg/66f4f115a64a31e4f71c7955b768c6a0.gif?1611893330" class="roomImg">
                            <div class="winFixCnt" style="z-index:100;">6</div>
                        </div>
                        <div class="title">
                            <span class="win"><span>6</span>승</span> <span class="lose"><span>0</span>패</span> <span class="bar">|</span>
                            <a href="#" class="tit" rel="912b4c40acaf4f8a63a91e8eb813926d" title="⭐기적의 연승섯다⭐" onclick="return false;">⭐기적의 연승섯다⭐</a>
                            <span class="date">33분전</span>
                        </div>
                        <div class="sub">
                            <span class="b">45</span> / <span>300</span> <span class="opener">
                            <img src="https://simg.powerballgame.co.kr/images/class/M18.gif" width="23" height="23">
                            <a href="#" onclick="return false;" title="연승섯다" rel="66f4f115a64a31e4f71c7955b768c6a0" class="uname">연승섯다</a></span>
                        </div>
                    </li>
                </ul>
             </div>
        </div>

        <div class="tab-pane fade" id="ruleTap" role="tabpanel" aria-labelledby="contact-tab">
            <div id="ruleBox" style="height: 445px; ">
                <div class="borderBox">
                    <div class="tit">벙어리 사유</div>
                    <ul>
                        <li>- 한 화면에 두번 이상 같은 글 반복 작성</li>
                        <li>- 상대 비방, 반말 또는 욕설</li>
                        <li>- 비매너 채팅</li>
                        <li>- 회원간 싸움 및 분란 조장</li>
                        <li>- 결과 거짓 중계</li>
                        <li>- 운영진의 판단하에 운영정책에 위배되는 행위</li>
                    </ul>
                </div>
                <div class="borderBox">
                    <div class="tit">접속 차단 사유</div>
                    <ul>
                        <li>- 개인정보 발언 및 공유</li>
                        <li>- 타 사이트 홍보 및 발언</li>
                        <li>- 불법 프로그램 홍보</li>
                        <li>- 운영진 및 사이트 비방</li>
                        <li>- 지속적인 비매너 채팅</li>
                        <li>- 부모 및 성적 관련 욕설</li>
                    </ul>
                </div>
                <div class="borderBox">
                    <div class="tit">파워볼게임 간편주소</div>
                    <ul>
                        <li>- powerballgame.co.kr</li>
                        <li>- 파워볼게임.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
