const _MSG_DO_CONFIRM = "실행할까요?";
const _MSG_DELETE_CONFIRM = "삭제할까요?";
const _MSG_DELETE_ALL_CONFIRM = "정말 모든 내역을 삭제할까요?";
const _MSG_CONFIRM_REQ_BANK_INFO = "입금계좌 안내를 받으시겠습니까?";
const _MSG_CONFIRM_SIGNUP = "회원가입 신청을 하시겠습니까?";
const _MSG_NO_BANK_INFO = "등록된 계좌 없음, 관리자 문의";
const _MSG_SRVER_ERR = "잠시 후 재시도, 문제 지속 시 관리자 문의";
const _MSG_NO_MONEY_REQUIRED = "금액입력 누락!";
const _BTN_DELETE = "삭제하기";
const _BTN_OK = "확인";
// modal window
const _MODAL_TITLE_INFO = "알림";
const _MODAL_TITLE_ERR = "에러";
// 문의작성
const _MSG_CATEGORY_REQUIRED = "분류 누락";
const _MSG_CONTENTS_REQUIRED = "내용 누락";
// 쪽지
const _MSG_IMPORTANT_MSG_RECEIVED = "중요도가 높은 쪽지를 수신했습니다.";
// 로그인
const _MSG_USERNAME_REQUIRED = "회원아이디 입력 누락";
const _MSG_PWD_REQUIRED = "비밀번호 입력 누락";
const _MSG_CAPCHTA_REQUIRED = "보안코드 입력 누락";
// 추천인
const _MSG_PARENT_USERNAME_REQUIRED = "추천인 이름 입력 누락";
// const _MSG_PARKING = "장시간 미사용 알람! 확인 버튼을 누르세요.";
// 충전신청
const _MSG_MONEY_REQUIRED = "금액 누락";
// EA
const _MSG_KEYWORD_REQUIRED = "검색어는 2자 이상 입력해 주세요";
const _MSG_WD_REQUIRED = "전환금액 입력 누락";
const _MSG_WD_CONFIRM = "정말 신청할까요?";
const _MSG_USER_EDIT_CONFIRM = "저장할까요?";
// 배팅관련
const _MSG_BET_SUCCESS_MSG_TITLE = "배팅성공";
const _MSG_BET_SUCCESS_MSG = "배팅이 완료되었습니다.";
const _MSG_BET_BTN_TITLE = "배팅하기";
const _MSG_BET_BTN_CONFIRM = "배팅할까요?";
const _MSG_BET_BTN_CONFIRM_RNO = "회차";
const _MSG_BET_FAIL_MSG_TITLE = "배팅실패";
const _MSG_BET_FAIL_NO_MONEY = "잔고부족";
const _MSG_BET_FAIL_MSG_SERVER_ERR = "서버 에러, 나중에 재시도!";
const _MSG_BET_FAIL_MSG_RETRY_LATER = "나중에 다시 시도";
const _MSG_BET_FAIL_MSG_TIME_LIMIT = "이번 회차 배팅 마감되었습니다.";
const _MSG_BET_FAIL_MSG_REQ_PICK = "배팅할 픽을 선택";
const _MSG_BET_FAIL_MSG_MIN_LIMIT = "최소 배팅 금액 100";
const _MSG_BET_END_TITLE = "배팅마감";
const _MSG_BET_END_NEXT = "다음 라운드 준비중";
const _MSG_BET_DELETE_ALL = "모든 배팅 내역이 삭제됩니다. 정말 삭제합니까?";
const _MSG_BET_FAIL_SERVER_ERR = "네트워크 에러, 잠시후 재시도";
const _MSG_BET_FAIL_BET_FULL = "배팅 금액 초과";
const _MSG_BET_FAIL_NOT_WORK = "배팅 불가";
var _isBetEnd = false;
var powerball_remain,speedkeno_remain = 0;
const _M_SEC = 55;

function setGameTimer(count, betLeft) {
    var start = Date.now();
    var elapsed = 0;
    var lastRest;
    var roundTimer = setInterval(() => {
        elapsed = Math.floor((Date.now() - start) / 1000);
        var rest = count - elapsed; // 남은 게임시간
        var betRest = betLeft - elapsed; // 남은 배팅시간
        if(!_isBetEnd) { // 배팅마감전에만
            var timeStr;
            if(betRest != lastRest && betRest > 0) { // sec가 변경된 경우에만 표시
                timeStr = _MSG_BET_END_TITLE + " " + ("0" + (parseInt(betRest / 60))).slice(-2) + ":" + ("0" + (betRest % 60)).slice(-2);
                //console.log(timeStr);
            } else if(betRest <= 0) { // 배팅끝
                //console.log("배팅마감");
                timeStr = _MSG_BET_END_TITLE;
                _isBetEnd = true;
                $(".bet-end-count").addClass("bet-end");
            }
            $(".bet-end-count").text(timeStr);
            lastRest = betRest;
        }
        if(rest <= 0) { // 이번게임종료
            _isBetEnd = true;
            //console.log('다음라운드 준비중');
            $(".bet-end-count").removeClass("bet-end");
            $(".bet-end-count").text(_MSG_BET_END_NEXT);
            clearInterval(roundTimer);
            roundTimer = null;
            _lastDateIdx = $("#bet-round-dateidx").val();
            _lastRoundNo = $("#bet-round-no").val();
            setTimeout(() => {
                loadGame();
            }, intRand(2000, 5000));
        }
    }, 200); // per 2/10sec
}


function ladderTimer(remain,divId)
{
	if(remainTime == 0)
	{
		remainTime = remain;

		if(divId != ""){
            var roundNum = parseInt($('#timeRound').text())+1;
            if(roundNum == 289) roundNum = 1;

            $('#timeRound').text(roundNum);

            roundNum = null;

            if($('#powerballPointBetGraph').length)
            {
                setTimeout(function(){
                    $('#powerballPointBetGraph .oddChart .oddBar').animate({width:'0px'},1000,function(){
                        $(this).next().text('0%');
                    });
                    $('#powerballPointBetGraph .oddChart .oddPer').animate({right:'-7px'},1000);

                    $('#powerballPointBetGraph .evenChart .evenBar').animate({width:'0px'},1000,function(){
                        $(this).next().text('0%');
                    });
                    $('#powerballPointBetGraph .evenChart .evenPer').animate({left:'-7px'},1000);
                },3000);
            }
        }
	}

	remainTime--;
    if(divId != ""){
        var remain_i = Math.floor(remainTime / 60);
        var remain_s = Math.floor(remainTime % 60);
        if(remain_i < 10) remain_i = '0' + remain_i;
        if(remain_s < 10) remain_s = '0' + remain_s;

        $('#'+divId).find('.minute').text(remain_i);
        $('#'+divId).find('.second').text(remain_s);

        remain_i = null;
        remain_s = null;
    }
}

function powerTimer(remain){
    if(powerball_remain == 0)
    {
        powerball_remain = remain;
    }
    powerball_remain--;
}

function speedTimer(remain){
    if(speedkeno_remain == 0)
    {
        speedkeno_remain = remain;
    }
    speedkeno_remain--;
}

function getRemainTime(times,type=2){
    var date = new Date(times * 1000);

    var g_nMinute = 4 - (date.getMinutes() + type) % 5;
    var g_nSecond = _M_SEC - date.getSeconds();
    --g_nSecond;
    if (g_nSecond < 0)
    {
        --g_nMinute;
        if (g_nMinute < 0)
            g_nMinute = 4;
        g_nSecond = 60 + g_nSecond;
    }
    return g_nMinute * 60 + g_nSecond;
}
function heightResize()
{
    if($('body').height() < 500)
    {
        var resizeHeight = 500;
    }
    else
    {
        var resizeHeight = $('body').height();
    }

    try{
        $('#mainFrame', window.parent.document).height(resizeHeight);
    }
    catch(e){}
}

// user layer handler
function userLayerHandler(e)
{
    var target = $(e.target);

    if(target.is('a'))
    {
        if(target.attr('rel').substring(0,5) == 'guest')
        {
            $('#userLayer').hide();
        }
        else
        {
            eval(setUserLayer(target.attr('rel'),target.attr('title'),e));
            $('#userLayer').show();
        }
        e.stopPropagation();
    }
    else if(target.parent().is('a'))
    {
        if(target.parent().attr('rel').substring(0,5) == 'guest')
        {
            $('#userLayer').hide();
        }
        else
        {
            eval(setUserLayer(target.parent().attr('rel'),target.parent().attr('title'),e));
            $('#userLayer').show();
        }
        e.stopPropagation();
    }
}

// user layer set
function setUserLayer(useridKey,nickname,e)
{
    var str = '';

    if(this.userIdKey != useridKey)
    {
        str += '<ul>';

        if(roomIdx != 'lobby' && is_admin && useridKey != 'dc5de9ce5f7cfb22942da69e58156b68' && useridKey != '98fcb9f71155698ab70389d897d7345b' && useridKey != JSON.parse(roomInfo).useridKey)
        {
            str += '<li><a href="#" onclick="adminCmd(\'fixMemberOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">고정멤버임명</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'fixMemberOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">고정멤버해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'managerOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">매니저임명</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'managerOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">매니저해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'muteOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'muteOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리 해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'kickOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'kickOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴 해제</span></a></li>';
        }
        else if(roomIdx != 'lobby' && is_manager && useridKey != 'dc5de9ce5f7cfb22942da69e58156b68' && useridKey != '98fcb9f71155698ab70389d897d7345b' && useridKey != JSON.parse(roomInfo).useridKey)
        {
            str += '<li><a href="#" onclick="adminCmd(\'muteOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'muteOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리 해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'kickOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'kickOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴 해제</span></a></li>';
        }

        str += '<li><a href="#" onclick="chatManager(\'friendList\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">친구추가</span></a></li>';
        str += '<li><a href="#" onclick="chatManager(\'blackList\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">블랙리스트</span></a></li>';
        str += '</ul>';
    }

    $('#unickname').html(nickname);

    $('#userLayer .ubody').remove();

    if(str)
    {
        $('#userLayer').append('<div class="ubody">'+str+'</div>');
    }

    var bettingStr = '';

    // $.ajax({
    //     type:'POST',
    //     dataType:'json',
    //     url:'/',
    //     data:{
    //         view:'action',
    //         action:'bettingResultLayer',
    //         useridKey:useridKey
    //     },
    //     timeout:1000,
    //     success:function(data,textStatus){
    //
    //         bettingStr += '<ul>';
    //         bettingStr += '<li>올킬 - <span class="'+data.totalWinClass+'">'+data.totalWinFix+'</span>연승</li>';
    //         bettingStr += '<li>파워볼홀짝 - <span class="'+data.powerballOddEvenWinClass+'">'+data.powerballOddEvenWinFix+'</span>연승, <span class="win">'+data.powerballOddEvenWin+'</span>승<span class="lose">'+data.powerballOddEvenLose+'</span>패('+data.powerballOddEvenRate+')</li>';
    //         bettingStr += '<li>파워볼언더오버 - <span class="'+data.powerballUnderOverWinClass+'">'+data.powerballUnderOverWinFix+'</span>연승, <span class="win">'+data.powerballUnderOverWin+'</span>승<span class="lose">'+data.powerballUnderOverLose+'</span>패('+data.powerballUnderOverRate+')</li>';
    //         bettingStr += '<li>숫자합홀짝 - <span class="'+data.numberOddEvenWinClass+'">'+data.numberOddEvenWinFix+'</span>연승, <span class="win">'+data.numberOddEvenWin+'</span>승<span class="lose">'+data.numberOddEvenLose+'</span>패('+data.numberOddEvenRate+')</li>';
    //         bettingStr += '<li>숫자합언더오버 - <span class="'+data.numberUnderOverWinClass+'">'+data.numberUnderOverWinFix+'</span>연승, <span class="win">'+data.numberUnderOverWin+'</span>승<span class="lose">'+data.numberUnderOverLose+'</span>패('+data.numberUnderOverRate+')</li>';
    //         bettingStr += '</ul>';
    //
    //         $('#userLayer .game').html(bettingStr);
    //
    //         // layer position
    //         var layerTop = 0;
    //         var layerBottom = $('body').height() - e.pageY - $('#userLayer').height();
    //
    //         if(layerBottom < 0)
    //         {
    //             layerTop = e.pageY - $('#userLayer').height();
    //         }
    //         else
    //         {
    //             layerTop = e.pageY;
    //         }
    //
    //         $('#userLayer').css({'left':e.pageX + 10,'top':layerTop});
    //     },
    //     error:function (xhr,textStatus,errorThrown){
    //         alert('error'+(errorThrown?errorThrown:xhr.status));
    //     }
    // });
}


$(document).ready(function(){
    $(".hiddenBorard").click(function(){
        if($(this).attr("rel") == "hidden")
            $(".boardBox").hide();
        else
            $(".boardBox").show();
    })
    $("body").ajaxError(
        function(e,request) {
            if (request.status == 401) {
                alert("로그아웃상태이므로 요청을 수락할수 없습니다.");
            }
        }
    );
    // user layer
    $(document).on('click','a.uname',userLayerHandler);

    $(document).click(function(){
        $('#userLayer:visible').hide();
    });
})

