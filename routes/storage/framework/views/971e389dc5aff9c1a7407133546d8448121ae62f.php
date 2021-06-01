<?php $__env->startSection("script_header"); ?>
    <script>
        var userIdToken = "<?php echo e($api_token); ?>";
        var userIdKey = "<?php echo e($userIdKey); ?>";
        var roomIdx ="<?php echo e($room["roomIdx"]); ?>";
        var is_freeze = <?php if($room["frozen"] == "off"): ?><?php echo e(0); ?><?php else: ?><?php echo e(1); ?><?php endif; ?>;
        var chatHistoryNum = 0;
        var filterWordArr = 'ㅋㅌ,카톡,틱톡,http,www,co.kr,net,com,kr,net,org,abcgame,scoregame,스코어게임,스게,abc게임,자지,보지,섹스,쎅스,씨발,시발,병신,븅신,개세,개새자지,출장,섹파,자위,8아,18놈,18새끼,18년,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,포경,ㅅㅂㄹㅁ,만남,전국망,대행,자살,스게,점수게임,모히또,토크온,페이스북,페북,매장,8394'.split(',');
        <?php if(!empty($profile)): ?>
        var levels = "<?php echo e($profile); ?>";
        var level_images = JSON.parse(levels.replace(/&quot;/g,'"'));
        <?php endif; ?>
        var total_num = 0;
        var is_repeatChat = false;
        var lastMsgTime = new Date().getTime();
        var sumMsgTerm = 0;
        var msgTermArr = new Array();
        var msgTermIdx = 0;
        var msgStopTime = 10;
        var blackListArr = ''.split(',');
        var is_scroll_lock = false;
        var is_scroll_lock_room = false;
        var is_super = false;
        var is_admin = <?php if($manager == 1): ?> true <?php else: ?> false <?php endif; ?>;
        var is_manager = <?php if(in_array($userIdKey,explode(",",$room["manager"]))): ?><?php echo e(true); ?><?php else: ?><?php echo e(0); ?><?php endif; ?>;
        var fixed = "<?php echo e($room["roomandpicture"]["fixed"]); ?>";
        var room_name ="<?php echo e($room["room_connect"]); ?>";
        var is_forceFreeze = false;
        var roomInfo = '{"roomIdx":"'+roomIdx+'","roomType":"<?php if($room["type"] == 1): ?><?php echo e('normal'); ?><?php else: ?><?php echo e('premium'); ?><?php endif; ?>","roomTitle":"<?php echo e($room["room_connect"]); ?>","roomDesc":"<?php echo e($room["description"]); ?>","roomPublic":"<?php if($room["public"] == 1): ?><?php echo e('public'); ?><?php else: ?><?php echo e('private'); ?><?php endif; ?>","joinLevel":"0","joinPoint":"0","maxUser":"<?php echo e($room["max_connect"]); ?>","curUser":"0","useridKey":"<?php echo e($room["roomandpicture"]["userIdKey"]); ?>","nickname":"<?php echo e($room["roomandpicture"]["nickname"]); ?>","level":"<?php echo e($room["roomandpicture"]["leve"]); ?>","sex":"<?php echo e($room["roomandpicture"]["sex"]); ?>","profile":"<?php echo e($room["roomandpicture"]["image"]); ?>","regDate":"<?php echo e($room["roomandpicture"]["created_date"]); ?>","manager":"<?php echo e($room["manager"]); ?>","fixMember":"<?php echo e($room["roomandpicture"]["fixed"]); ?>","recomCnt":"50"}';
        var cur_bet = "";
        <?php if(!empty($cur_bet)): ?>
        cur_bet  = "<?php echo e($cur_bet); ?>";
        <?php endif; ?>
        var next_round = <?php echo e($next_round); ?>;
        var chatRoom_recomCnt = <?php echo e($room["recommend"]); ?>;
        var level = "<?php echo e($room["roomandpicture"]["level"]); ?>";
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("header"); ?>
<div id="header">
    <div class="winLose">
        <?php if(empty($win_room)): ?>
            전체 : <span class="totalWinCnt" rel="0">0</span>승 <span class="totalLoseCnt" rel="0">0</span>패 / <span class="winFix" rel="0">0</span>연승 &nbsp;&nbsp; 파워볼 : <span class="powerballWinCnt" rel="0">0</span>승
            <span class="powerballLoseCnt" rel="0">0</span>패 &nbsp;&nbsp; 숫자합 : <span class="numberWinCnt" rel="0">0</span>승 <span class="numberLoseCnt" rel="0">0</span>패
        <?php else: ?>
            전체 : <span class="totalWinCnt" rel="<?php echo e($win_room->total->win); ?>"><?php echo e($win_room->total->win); ?></span>승 <span class="totalLoseCnt" rel="<?php echo e($win_room->total->lose); ?>"><?php echo e($win_room->total->lose); ?></span>패 / <span class="winFix" rel="<?php echo e($win_room->current_win); ?>"><?php echo e($win_room->current_win); ?></span>연승 &nbsp;&nbsp; 파워볼 : <span class="powerballWinCnt" rel="<?php echo e($win_room->pb->win); ?>"><?php echo e($win_room->pb->win); ?></span>승
            <span class="powerballLoseCnt" rel="<?php echo e($win_room->pb->lose); ?>"><?php echo e($win_room->pb->lose); ?></span>패 &nbsp;&nbsp; 숫자합 : <span class="numberWinCnt" rel="<?php echo e($win_room->nb->win); ?>"><?php echo e($win_room->nb->win); ?></span>승 <span class="numberLoseCnt" rel="<?php echo e($win_room->nb->lose); ?>"><?php echo e($win_room->nb->lose); ?></span>패
        <?php endif; ?>

    </div>
    <h2 id="roomTitle" class="tit"><?php echo e($room["room_connect"]); ?></h2>
    <p id="roomDesc" class="desc"><?php echo e($room["description"]); ?></p>
    <div class="profile"><img src="<?php if(empty($room["roomandpicture"]["image"])): ?><?php echo e('https://www.powerballgame.co.kr/images/profile.png'); ?><?php else: ?><?php echo e($room["roomandpicture"]["image"]); ?><?php endif; ?>" /></div>
</div>
<div id="container" style="width:100%">
    <div class="leftArea">
        <div class="category">
            <ul class="cate">
                <li class="custom">방장 <em class="on"><?php echo e($room["roomandpicture"]["name"]); ?></em></li>
                <li class="custom"><span><?php echo e(getDiffTimes($room["created_at"])); ?>전</span></li>
                <li class="custom">접속자 <span id="chatRoom_topUserCnt" class="on">0</span>명</li>
                <li class="custom">추천수 <span id="chatRoom_recomCnt" class="on"><?php echo e(number_format($room["recommend"])); ?></span></li>
                <li class="custom">누적 당근수 <span id="totalBulletCnt" rel="<?php echo e(number_format($room["bullet"])); ?>" class="on"><?php echo e(number_format($room["bullet"])); ?></span></li>
            </ul>
        </div>
        <div class="mainBanner">

        </div>
        <div id="recomLogBox"></div>
        <div id="bulletLogBox"></div>
        <div id="managerLogBox"></div>
        <ul class="msgBox" id="msgBox">

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

            <div id="pointBetBox" style="position:absolute;width:100%;bottom:37px;">
                <?php echo $__env->make("pick/pick1", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    나의 당근 <span class="bullet" id="bullet" rel="0" giftcnt="0">0</span>개 <span class="bar">|</span> <span class="txt">보유 수량 한도 내에서  <span class="important">방장에게 선물</span>할 수 있으며, 부족할 경우 당근 구매 후 선물 가능합니다. <a href="/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket" target="_blank" class="important">당근 구매하기</a></span>
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
            <ul class="pl-2 bott-menu" style="height: 39px;background: #ebeded;">
                <?php if($manager == 0 && $admin == 0): ?>
                    <li><a href="#" onclick="return false;" id="btn_giftBullet">당근 선물하기</a></li>
                    <li><a href="#" onclick="return false;" id="btn_recom">추천하기</a></li>
                    <li><a href="#" onclick="chatManager('clearChat');return false;">방청소</a></li>
                    <li><a href="#" onclick="return false;" id="btn_sound">사운드 끄기</a></li>

                    <li><a href="#" onclick="return false;" id="btn_favorite">즐겨찾기</a></li>
                    <li class="right"><a href="#" onclick="return false;" id="btn_pointBet">픽 열기</a></li>
                <?php else: ?>

                    <?php if($room["frozen"] == "off"): ?>
                        <li><a href="#" onclick="return false;" id="btn_freezeOn">얼리기</a></li>
                    <?php else: ?>
                        <li><a href="#" onclick="return false;" id="btn_freezeOff">녹이기</a></li>
                    <?php endif; ?>

                    <li><a href="#" onclick="chatManager('clearChat');return false;">방청소</a></li>
                    <li><a href="#"  id="btn_chatRoomSetting" data-target="#modify-chatroom" data-toggle="modal">설정</a></li>
                    <li><a href="#" onclick="return false;" id="btn_chatRoomClose">삭제</a></li>
                    <li><a href="#" onclick="return false;" id="btn_call">호출</a></li>
                    <li><a href="#" onclick="return false;" id="btn_sound">사운드 끄기</a></li>

                    <li class="right"><a href="#" onclick="return false;" id="btn_pointBet">픽 열기</a></li>
                <?php endif; ?>


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
            <a href="#" onclick="return false;" id="btn_exit" class="exit">채팅방 나가기</a>
            <?php if($room["badge"] >=5): ?>
                <div style="position:absolute;top:0;right: 194px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다">
                    <img src="/assets/images/powerball/badge/badge5.png" width="37" height="53">
                </div>
            <?php endif; ?>
            <?php if($room["badge"] >=10): ?>
                <div style="position:absolute;top:0;right: 167px;z-index:96;" title="일주일 내에 10연승 기록이 있습니다">
                    <img src="/assets/images/powerball/badge/badge10.png" width="37" height="53">
                </div>
            <?php endif; ?>
            <?php if($room["badge"] >=15): ?>
                <div style="position:absolute;top:0;right: 140px;z-index:96;" title="일주일 내에 15연승 기록이 있습니다">
                    <img src="/assets/images/powerball/badge/badge15.png" width="37" height="53">
                </div>
            <?php endif; ?>
            <?php if($room["badge"] >=20): ?>
                <div style="position:absolute;top:0;right: 114px;z-index:96;" title="일주일 내에 20연승 기록이 있습니다">
                    <img src="/assets/images/powerball/badge/badge20.png" width="37" height="53">
                </div>
            <?php endif; ?>
        </div>
        <div style="margin: 8px">
            <?php echo $__env->make('chat.countdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
        <div class="resultBox">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="connection-tab" data-toggle="tab" href="#connection" role="tab" aria-controls="connection" aria-selected="true">접속자 <span id="chatRoom_userCnt">0</span>명</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="pick-tab" data-toggle="tab" href="#pick" role="tab" aria-controls="pick" aria-selected="false">방장픽 정보</a>
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
<div id="pickSound"></div>
<div class="modal"  id="modify-chatroom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header jin-gradient">
                <h5 class="modal-title light-medium text-white">채팅방 설정</h5>
                <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="align-middle"><span class="light-medium">방제목</span></td>
                        <td class="align-middle">
                            <input type="text" autocomplete="off" name="roomTitle" id="current_roomTitle" maxlength="40" value="<?php echo e($room["room_connect"]); ?>" class="form-control pr-0 pl-0 pt-1 pb-1 border-round-none border-input">
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">설명</span></td>
                        <td class="align-middle"><input name="roomDesc" id="current_roomDesc" cols="30" rows="2" maxlength="40" value="<?php echo e($room["description"]); ?>" class="form-control pr-0 pl-0 pt-1 pb-1 border-round-none border-input"></td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">방종류</span></td>
                        <td class="align-middle">
                            <?php if($room["type"] == 1 ): ?>
                            일반
                            <?php else: ?>
                                프리미엄
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">공개여부</span></td>
                        <td class="align-middle">
                            <select name="roomPublic" id="current_roomPublic" class="custom-select no-height border-input">
                                <option value="1" <?php if($room["public"] == 1 ): ?><?php echo e('selected'); ?><?php endif; ?>>전체공개</option>
                                <option value="2" <?php if($room["public"] == 2 ): ?><?php echo e('selected'); ?><?php endif; ?>>비공개</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle"><span class="light-medium">참여인원</span></td>
                        <td class="align-middle"><?php echo e($room["max_connect"]); ?>명</td>
                    </tr>
                </table>
                <div class="text-center">
                    <a href="#" id="btn_modifyChatRoom" type="button" class="btn btn-jin-gradient border-round-none pr-5 pl-5 btn-sm create_room">채팅방 수정</a>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php echo $__env->make("chat.view-list", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("chat.opener-picks", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/chat/view.blade.php ENDPATH**/ ?>