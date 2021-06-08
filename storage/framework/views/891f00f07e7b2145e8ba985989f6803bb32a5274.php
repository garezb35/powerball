<div class="box-chatting">
    <div class="btn-etc">
        <span class="cnt">
            <div class="sp-bl_pp"></div>
            <span id="connectUserCnt" rel=""></span>명
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
                <a class="nav-link active" id="chatroomListBox-tab" data-toggle="tab" data-bs-toggle="tab" href="#chatTap" role="tab" aria-controls="home" aria-selected="true">채팅</a>
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
                <ul class="list-chatting" id="msgBox">

                </ul>
                <p class="input-chatting">
                    <input type="text" name="msg" id="msg" class="input-1" autocomplete="off" placeholder="메세지를 입력해주세요 (최대 40자)">
                    <input type="hidden" class="input-2 sp-btn_enter" id="sendBtn">
                    <a href="#" class="scrollBottom" id="scrollBottom" style="display: none;"></a>
                </p>
            </div>
        </div>
        <div class="tab-pane fade" id="connectTap" role="tabpanel" aria-labelledby="profile-tab">
            <div id="connectListBox">
                <ul class="list-connect" id="connectList">

                </ul>

            </div>
        </div>
        <div class="tab-pane fade" id="roomTap" role="tabpanel" aria-labelledby="contact-tab">
            <div id="roomListBox" style="display: block;">
                <div style="background-color:#F5F5F5;height:25px;line-height:25px;border:1px solid #CECECE;border-top:none;text-align:right;padding-right:5px;font-weight:bold;font-size:12px;"><a href="#" onclick="openChatRoom();return false;">채팅대기실</a></div>
                <ul class="list-room" id="roomList" style="height: 420px;">

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
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('chat.chat-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Analyse/chat-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/chat/box-chatting.blade.php ENDPATH**/ ?>