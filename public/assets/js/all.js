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
var stated = 0;
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
	remainTime = powerballDiff();
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

                    $('#powerballPointBetGraph .evenChart .evenBar').animate({width:'0px'},1000,function(){
                        $(this).next().text('0%');
                    });
                },3000);
            }
        }
	}

	// remainTime--;
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
    if(stated ==0 )
        $('#mainFrame', window.parent.document).height(500);
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
        stated++;
    }
    catch(e){}
}

function onlyNumber()
{
    if((event.keyCode < 48) || (event.keyCode > 57))
    {
        event.returnValue = false;
    }
}


$(document).ready(function(){
    $(".hiddenBorard").click(function(){
        if($(this).attr("rel") == "hidden")
        {
            $(".boardBox").hide();
            $("#banner_main_area").hide();
        }
        else
        {
            $(".boardBox").show();
            $("#banner_main_area").show();
        }
    })
    $.ajaxSetup({
        statusCode: {
            401: function(){

                // Redirec the to the login page.
                alert("로그아웃상태이므로 요청을 수락할수 없습니다.");

            }
        }
    });


    $(".gnb").css({"display":"block"})
    heightResize();

    $(document).on('click','#roomList .tit,#roomList .thumb,.joinRoom,#chatRoomList li  ',function(){
        var roomIdx = $(this).attr('rel');
        chatRoomPop = window.open('','chatRoom','width=5px,height=5px,status=no,scrollbars=no,toolbar=no');

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/checkActiveRoom',
            data:{api_token:userIdToken,room:roomIdx},
            success:function(data,textStatus){
                if(data.status == 1)
                {
                    chatRoomPop = window.open('/discussion?token='+data.token,'chatRoom','width=500px,height=500px,status=no,scrollbars=no,toolbar=no');
                    chatRoomPop.focus();
                }
                else
                {
                    if(data.code == 'needPasswd')
                    {
                        if(chatRoomPop != null)
                        {
                            chatRoomPop.close();
                        }

                        var topPos = ($(window).height() - 180) / 2;
                        var leftPos = ($(window).width() - 250) / 2;

                        $('#modal_passwordInput').css({'top':topPos+'px','left':leftPos+'px'});
                        $('.modalLayer').show();
                        $('#modal_passwordInput').show(function(){
                            $(this).find('.input').val('');
                            $(this).find('.input').focus();
                            $(this).find('.btn_join').attr('rel',roomIdx);
                        });
                    }
                    else
                    {
                        if(chatRoomPop != null)
                        {
                            chatRoomPop.close();
                        }
                        alert(data.msg);
                    }
                }
            }
        });
    });
})



function ajaxBestPickster()
{
    if($('#bestPicksterList').is(':hidden')){
        if($('#bestPicksterList .content').text().trim() !=""){
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/getWinners',
                success:function(result,textStatus){
                    compileJson("#pickster-list","#bestPicksterList .content",result,1,false);
                    $( "#bestPicksterList" ).slideDown(300);
                }
            }).fail(function(xhr){
                console.log(xhr)
            });
        }
        else
            $( "#bestPicksterList" ).slideDown(300);
    }

    else{
        $( "#bestPicksterList" ).slideUp(300);
    }
}

function toggleMiniView(){
  if($(".pick-screeen").hasClass("d-none")){
    $(".pick-screeen").removeClass("d-none")
    $(".miniView").text("게임닫기")
  }
  else {
    $(".pick-screeen").addClass("d-none")
    $(".miniView").text("게임열기")
  }
  heightResize()
}

function togglePickView(){
  if($(".pick-part").hasClass("d-none")){
    $(".pick-part").removeClass("d-none")
    $(".pick-btns").text("픽닫기")
  }
  else {
    $(".pick-part").addClass("d-none")
    $(".pick-btns").text("픽열기")
  }
  heightResize()
}
