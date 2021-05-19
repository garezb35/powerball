var socketOption = {};
socketOption['reconnect'] = true;
socketOption['force new connection'] = true;
socketOption['sync disconnect on unload'] = true;
var whisperNick = getCookie('whisperNick');
var is_manager = false;
if('WebSocket' in window)
{
    socketOption['transports'] = ['websocket'];
}

var socket =  null;
$(document).on('click','a.uname',userLayerHandler);

$(document).click(function(){
    $('#userLayer:visible').hide();
});
$(document).ready(function(){

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
    });
    if(browser_ws == true)
    {
        connect();
        socket.on('receive',function(data){
            receiveProcess(data);
        });

        socket.on('reconnect',function(){
            printSystemMsg('guide','채팅서버와의 접속이 종료되었습니다. 3초 후에 재접속합니다.');
            setTimeout(function(){
                connect();
            },3000);
        });
    }
    else
    {
        if(device == 'MOBILE')
        {
            printSystemMsg('system','해당 브라우저에서는 채팅서비스를 이용할 수 없습니다. <a href="market://details?id=com.android.chrome">크롬 브라우저</a>를 이용해주시기 바랍니다.');
            printSystemMsg('guide','<a href="market://details?id=com.android.chrome">모바일 크롬 브라우저 다운로드</a> 바로가기');
        }
        else
        {
            printSystemMsg('system','해당 브라우저에서는 채팅서비스를 이용할 수 없습니다. <a href="https://www.google.co.kr/chrome/browser/features.html" target="_blank">[크롬 브라우저]</a>를 이용해주시기 바랍니다.');
            printSystemMsg('guide','<a href="https://www.google.co.kr/chrome/browser/features.html" target="_blank">크롬 브라우저 다운로드</a> 바로가기');
        }
    }

    $('#sendBtn').click(function(){
        sendMsg();
    });
    $(window).on("unload",function(e){
        if(browser_ws == true)
        {
            socket.disconnect();
        }
    });
    $('#msg').bind('keypress',function(event){
        if((event.keyCode || event.which) == 13)
        {
            $('#sendBtn').click();
        }
        else if((event.keyCode || event.which) == 34 && !$('#msg').val())
        {
            if(whisperNick)
            {
                event.preventDefault();
                $('#msg').val('"'+whisperNick+' ');
            }
        }
    });

    $('#msg').bind('keydown',function(event){
        if((event.keyCode || event.which) == 38)
        {
            event.preventDefault();

            var chatMsg = getChatHistory(chatHistoryNum);
            if(chatMsg)
            {
                $(this).val(chatMsg);
                chatHistoryNum++;
            }
        }
        else if((event.keyCode || event.which) == 40)
        {
            event.preventDefault();

            var chatMsg = getChatHistory(chatHistoryNum-2);
            if(chatMsg)
            {
                $(this).val(chatMsg);
                chatHistoryNum--;
            }
            else
            {
                $(this).val('');
                chatHistoryNum = 0;
            }
        }
    });

    $('#msg').focus(function(){
        $('.input-chatting .label').hide();
    });
    $('#msg').blur(function(){
        if(!$(this).val())
        {
            $('.input-chatting .label').show();
        }
    });

// sound
    if(!getCookie('powerballResultSound'))
    {
        setCookie('powerballResultSound','on');
    }

    $(document).on('click','#roomList .tit,#roomList .thumb,.joinRoom',function(){

        var roomIdx = $(this).attr('rel');
        chatRoomPop = window.open('','chatRoom','width=5px,height=5px,status=no,scrollbars=no,toolbar=no');

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/checkActiveRoom',
            data:{api_token:userIdToken,room:$(this).attr("rel")},
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

    $('#room-tab').on('shown.bs.tab', function (e) {
        $.ajax({
            dataType:"json",
            type: "post",
            url: "/api/getChatRooms"
        }).done(function(data) {
            if(data.status == 1){
                compileJson("#chat-item","#roomList",data.list,1)
            }
        });
    })
})

$(window).ready(windowResize);
$(window).bind('resize',windowResize);

function browserIEChk()
{
    var word;
    var version = 'N/A';

    var agent = navigator.userAgent.toLowerCase();
    var name = navigator.appName;

    // IE old version ( IE 10 or Lower )
    if(name == 'Microsoft Internet Explorer')
    {
        word = 'msie ';
    }
    else
    {
        if(agent.search('trident') > -1)	// IE 11
        {
            word = 'trident/.*rv:';
        }
        else if(agent.search('edge/') > -1)	// Microsoft Edge
        {
            word = 'edge/';
        }
    }

    var reg = new RegExp(word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})");

    if(reg.exec(agent) != null) version = RegExp.$1 + RegExp.$2;

    if(version != 'N/A' && version <= 10)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function connect(type = "public")
{
    try{
        printSystemMsg('guide','채팅서버에 접속중입니다. 잠시만 기다려주세요.');
        printSystemMsg('system','접속이 원활하지 않을경우 <a href="https://www.google.co.kr/chrome/browser/features.html" target="_blank">[크롬 브라우저]</a>를 이용해주시기 바랍니다.');
        if(socket == null)
        {
            socket = io.connect('http://cake6978.com:3000/'+type,socketOption);
        }
        sendProcess('login');
    }
    catch(e){
        printSystemMsg('error',e);
    }
}

function sendProcess(type,data)
{
    if(type == 'login')
    {
        var login_packet = {
            'header' : {
                'version' : '1.0',
                'type' : type
            },
            'body' : {
                'cmd' : 'LOGIN',
                'userToken' : userIdKey,
                'roomIdx' : this.roomIdx
            }
        }
        socket.emit('send',login_packet);
    }
    else
    {
        var packet = {
            'header' : {
                'version' : '1.0',
                'type' : type
            },

            'body' : data
        };

        socket.emit('send',packet);
    }
}

function printSystemMsg(type,msg)
{
    if(type == 'system')
    {
        $('#msgBox').append('<li><p class="msg-system">'+msg+'</p></li>');
    }
    else if(type == 'guide')
    {
        $('#msgBox').append('<li><p class="msg-guide">'+msg+'</p></li>');
    }
    else if(type == 'auto')
    {
        $('#msgBox').append('<li><p class="msg-auto">'+msg+'</p></li>');
    }
    else if(type == 'auto2')
    {
        $('#msgBox').append('<li><p class="msg-auto2">'+msg+'</p></li>');
    }
    else if(type == 'auto3')
    {
        $('#msgBox').append('<li><p class="msg-auto3">'+msg+'</p></li>');
    }
    else if(type == 'auto4')
    {
        $('#msgBox').append('<li><p class="msg-auto4">'+msg+'</p></li>');
    }
    else if(type == 'macro')
    {
        $('#msgBox').append('<li><p class="msg-macro">'+msg+'</p></li>');
    }
    else if(type == 'notice')
    {
        $('#msgBox').append('<li><p class="msg-notice">'+msg+'</p></li>');
    }
    else if(type == 'powerballResult_odd')
    {
        $('#msgBox').append('<li><p class="msg-odd">'+msg+'</p></li>');
    }
    else if(type == 'powerballResult_even')
    {
        $('#msgBox').append('<li><p class="msg-even">'+msg+'</p></li>');
    }
    else if(type == 'admin')
    {
        $('#msgBox').append('<li class="admin"><span style="position:relative;"><img src="https://simg.powerballgame.co.kr/images/class/M30.gif" orgLevel="M30"/></span> <strong><a href="#" onclick="return false;" title="운영자" class="uname">운영자</a></strong> '+msg+'</li>');
    }

    setScroll();
}

function setScroll()
{
    if($('#msgBox').is(':hidden') == false)
    {
        if(is_scroll_lock == false)
        {
            $('#msgBox').scrollTop($('#msgBox')[0].scrollHeight);
        }
    }
}

function sendMsg()
{
    if($('#msg').val().trim())
    {
        if(is_admin != true && is_freeze == 'on')
        {
            printSystemMsg('guide','채팅창을 녹이기 전까지 채팅 입력이 제한됩니다.');
            return false;
        }

        // chat history set
        setChatHistory($('#msg').val().trim());

        if(is_admin == false)
        {
            var filterMsg = $('#msg').val().toLowerCase();

            for(i=0;i<filterWordArr.length;i++)
            {
                if(filterMsg.indexOf(filterWordArr[i]) != -1)
                {
                    printSystemMsg('guide','해당 단어 <span class="yellow">[' + filterWordArr[i] + ']</span> (은)는 입력 금지어입니다.');
                    $('#msg').val('');
                    return false;
                }
            }
        }

        // english check
        if(is_admin == false && $('#msg').val().substring(0,1) != '"' && $('#msg').val().substring(0,1) != '/')
        {
            var englishPt = /[a-zA-Z]/;
            if(englishPt.test($('#msg').val()))
            {
                printSystemMsg('guide','<span class="yellow">영문</span> 은 입력할 수 없습니다.');
                $('#msg').val('');
                return false;
            }
        }

        // special character
        if(is_admin == false && $('#msg').val().substring(0,1) != '"' && $('#msg').val().substring(0,1) != '/')
        {
            var normalCharPt = /[가-힣ㄱ-ㅎㅏ-ㅣ0-9'"\[\]{}!\^()<>\,\.\/?|\\~`\-_\=\+;:\s]/gi;
            var msgChk = $('#msg').val().replace(normalCharPt,'');

            if(msgChk)
            {
                printSystemMsg('guide','<span class="yellow">특수문자</span> 는 입력할 수 없습니다.');
                $('#msg').val('');
                return false;
            }

            var decimalPt = /&#[0-9]{1,4}/g;
            if(decimalPt.test($('#msg').val()))
            {
                printSystemMsg('guide','<span class="yellow">특수문자</span> 는 입력할 수 없습니다.');
                $('#msg').val('');
                return false;
            }
        }

        if(is_admin == false)
        {
            if(is_repeatChat == true)	// 도배 체크
            {
                var remindTime = msgStopTime - ((new Date().getTime() - lastMsgTime) / 1000);
                printSystemMsg('guide','[도배금지] ' + parseInt(remindTime) + '초간 채팅이 제한됩니다.');
                return false;
            }
            else if(repeatChatFilter() == true)
            {
                return false;
            }
        }

        if(is_admin == false && $('#msg').val().length > 50)
        {
            printSystemMsg('guide','<span class="yellow">50자 이상</span> 은 입력할 수 없습니다.');
            $('#msg').val('');
            return false;
        }

        if($('#msg').val().substring(0,1) == '"')
        {
            if($('#msg').val().indexOf(' ') != -1)
            {
                var tnick = $('#msg').val().substring(1,$('#msg').val().indexOf(' '));
            }
            else
            {
                var tnick = $('#msg').val().substring(1);
            }
            var msg = $('#msg').val().substring($('#msg').val().indexOf(' ')+1);

            if(tnick)
            {
                setCookie('whisperNick',tnick,1);
                whisperNick = tnick;
            }

            var data = {
                roomIdx : this.roomIdx,
                tnickname : tnick,
                msg : msg
            };

            sendProcess('WHISPER',data);
        }
        else if($('#msg').val().substring(0,1) == '/')
        {
            if($('#msg').val().indexOf(' ') != -1)
            {
                var cmd = $('#msg').val().substring(1,$('#msg').val().indexOf(' '));
            }
            else
            {
                var cmd = $('#msg').val().substring(1);
            }

            // cmd
            switch(cmd)
            {
                case '공지':
                    cmd = 'notice';
                    break;

                case '고정공지':
                    cmd = 'fixnoticeOn';
                    break;

                case '고정공지해제':
                    cmd = 'fixnoticeOff';
                    break;

                case '도움말':
                    cmd = 'help';
                    break;

                case '방청소':
                    cmd = 'clear';
                    break;

                case '강제새로고침':
                    cmd = 'forceRefresh';
                    break;

                case '벙어리':
                    cmd = 'muteOn';
                    break;

                case '벙어리시간':
                    cmd = 'muteOnTime';
                    break;

                case '벙어리해제':
                    cmd = 'muteOff';
                    break;

                case '아이피차단':
                    cmd = 'banipOn';
                    break;

                case '아이피차단해제':
                    cmd = 'banipOff';
                    break;

                case '얼리기':
                    cmd = 'freezeOn';
                    break;

                case '녹이기':
                    cmd = 'freezeOff';
                    break;

                case '훈련병채팅':
                    cmd = 'unloginchatOn';
                    break;

                case '훈련병채팅해제':
                    cmd = 'unloginchatOff';
                    break;

                case '운영자':
                    cmd = 'admin';
                    break;
            }

            if(cmd != 'fixnoticeOn' && cmd != 'fixnoticeOff' && cmd != 'help' && cmd != 'clear' && cmd != 'forceRefresh' && cmd != 'freezeOn' && cmd != 'freezeOff' && cmd != 'unloginchatOn' && cmd != 'unloginchatOff')
            {
                if($('#msg').val().indexOf(' ') == -1 || ($('#msg').val().indexOf(' ') != -1 && !$('#msg').val().substring($('#msg').val().indexOf(' ')+1)))
                {
                    alert('내용을 입력하세요.');
                    $('#msg').focus();
                    return false;
                }
            }

            var msg = $('#msg').val().substring($('#msg').val().indexOf(' ')+1);

            if(msg.substring(0,1) == '/')
            {
                msg = '';
            }

            var data = {
                cmd : cmd,
                roomIdx : this.roomIdx,
                tnickname : tnick,
                msg : msg
            };

            sendProcess('CMDMSG',data);
        }
        else
        {
            var data = {
                roomIdx : this.roomIdx,
                msg : $('#msg').val()
            };

            sendProcess('MSG',data);
        }
    }

    $('#msg').val('');
    $('#msg').focus();
}

function receiveProcess(data)
{
    var hPacket = data.header;
    var bPacket = data.body;
    if(hPacket.type == "notice_pick"){
        let pick = bPacket.pick.split(",");
        if(pick.length == 2){
            pick[0] = pick[0] ?? 0;
            pick[1] = pick[1] ?? 0;
            let sum = parseInt(pick[0])+parseInt(pick[1]);
            sum = sum ==0 ? 1 : sum
            $('#powerballPointBetGraph .oddChart .oddBar').animate({width:(pick[0]*100/sum).toFixed(0)+'px'},1000,function(){
                $(this).next().text((pick[0]*100/sum).toFixed(0)+'%');
            });

            $('#powerballPointBetGraph .evenChart .evenBar').animate({width:(pick[1]*100/sum).toFixed(0)+'px'},1000,function(){
                $(this).next().text((pick[1]*100/sum).toFixed(0)+'%');
            });
        }
    }

    if(hPacket.type == 'LOGIN')
    {
        switch(bPacket.cmd)
        {
            case 'ERROR':
                switch(bPacket.type)
                {
                    case 'DUPLICATE':

                        printSystemMsg('guide','중복 로그인으로 인해 이전 접속을 종료합니다.');
                        socket.disconnect();
                        document.location.href = '/chat?state=doubled_display';
                        break;
                }
                break;

            case 'CONNECTUSER':
                if(roomIdx == 'channel1')
                {
                    $('#connectUserCnt').attr('rel',bPacket.connectUserCnt).text($.number(bPacket.connectUserCnt));
                }
                else if(roomIdx == 'channel2')
                {
                    $('#connectUserCnt').attr('rel',bPacket.connectUserCnt).text($.number(bPacket.connectUserCnt));
                }
                break;

            default:
                $('#msgBox').html('');
                printSystemMsg('guide','채팅서버에 접속 되었습니다.');
                break;
        }
    }
    else if(hPacket.type == 'CMDMSG')
    {
        switch(bPacket.cmd)
        {
            case 'notice':
                printSystemMsg('system',bPacket.msg);
                break;

            case 'fixnoticeOn':
                fixNotice('on',bPacket.msg);
                break;

            case 'fixnoticeOff':
                fixNotice('off');
                break;

            case 'help':
                chatManager('help');
                break;

            case 'clear':
                $('#msgBox').html('');
                printSystemMsg('system','운영자에 의해 채팅방이 청소 되었습니다.');
                break;

            case 'forceRefresh':
                top.window.location.reload();
                break;

            case 'muteOn':
                printSystemMsg('system','<span>'+bPacket.msg+'</span> 님이 <span>5분</span> 동안 벙어리 되었습니다.');
                if(bPacket.tuseridKey == this.useridKey)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'muteOnTime':
                var bPacketArr = bPacket.msg.split(' ');
                var tnickname = bPacketArr[0];
                var muteTime = bPacketArr[1];
                if(!muteTime) muteTime = 1;
                printSystemMsg('system','<span>'+tnickname+'</span> 님이 <span>'+muteTime+'시간</span> 동안 벙어리 되었습니다.');
                if(bPacket.tuseridKey == this.useridKey)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'muteOff':
                printSystemMsg('system','<span>'+bPacket.msg+'</span> 님이 벙어리 해제 되었습니다.');
                if(bPacket.tuseridKey == this.useridKey)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'banipOn':
                printSystemMsg('system','<span>'+bPacket.msg+'</span> 님이 접속 차단 되었습니다.');
                if(bPacket.tuseridKey == this.useridKey)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'banipOff':
                printSystemMsg('system','<span>'+bPacket.msg+'</span> 님이 접속 차단이 해제 되었습니다.');
                if(bPacket.tuseridKey == this.useridKey)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'freezeOn':
                chatManager('freezeOn');
                break;

            case 'freezeOff':
                chatManager('freezeOff');
                break;

            case 'unloginchatOn':
                printSystemMsg('system','훈련병 채팅이 활성화 되었습니다.');
                break;

            case 'unloginchatOff':
                printSystemMsg('system','훈련병 채팅이 비활성화 되었습니다.');
                break;

            case 'autoLevelUp':
                printSystemMsg('auto','<span>'+bPacket.nick+'</span> 님이 <span>'+bPacket.levelName+'</span>로 진급하셨습니다.');

                if(bPacket.levelName == '하사')
                {
                    printSystemMsg('auto','하사 진급 보너스로 <span>채팅방 개설권</span>이 지급되었습니다.');
                }
                break;

            case 'powerballResult':
                if(getCookie('powerballResultSound') == 'on')
                {
                    // $('#powerballResultSound').jPlayer('play');
                }
                printSystemMsg('powerballResult_'+bPacket.powerballOddEven,'<span>['+bPacket.date+'-'+bPacket.round+'회]</span> 파워볼 결과 [<span class="b">'+bPacket.powerball+'</span>][<span class="b">'+bPacket.powerballOddEvenMsg+'</span>][<span class="b">'+bPacket.powerballUnderOverMsg+'</span>]');
                printSystemMsg('powerballResult_'+bPacket.numberOddEven,'<span>['+bPacket.date+'-'+bPacket.round+'회]</span> 숫자합 결과 [<span class="b">'+bPacket.numberSum+'</span>][<span class="b">'+bPacket.numberOddEvenMsg+'</span>][<span class="b">'+bPacket.numberUnderOverMsg+'</span>][<span class="b">'+bPacket.numberPeriodMsg+'</span>]');
                setTimeout(function(){
                    $('#msgBox').removeClass('gasBg');
                },5000);
                break;

            case 'powerballPointGraph':
                updatePointBetGraph(bPacket);
                break;

            case 'powerballChatRoomList':
                if(typeof parent.updateChatRoomList != 'undefined')
                {
                    parent.updateChatRoomList(bPacket.result);
                }
                break;

            case 'bettingWin':
                if(bPacket.type == 'oddEven')
                {
                    printSystemMsg('auto','<span>'+bPacket.nickList+'</span> 님이 <span>['+bPacket.date+'-'+bPacket.round+'회차] ['+bPacket.resultMsg+']</span> 맞추셨습니다.');
                }
                else if(bPacket.type == 'underOver')
                {
                    printSystemMsg('auto2','<span>'+bPacket.nickList+'</span> 님이 <span>['+bPacket.date+'-'+bPacket.round+'회차] ['+bPacket.resultMsg+']</span> 맞추셨습니다.');
                }
                else if(bPacket.type == 'period')
                {
                    printSystemMsg('auto3','<span>'+bPacket.nickList+'</span> 님이 <span>['+bPacket.date+'-'+bPacket.round+'회차] ['+bPacket.resultMsg+']</span> 맞추셨습니다.');
                }
                break;

            case 'winFixCntNoti':
                if(bPacket.type == 'winFixCnt10')
                {
                    printSystemMsg('macro','<span>'+bPacket.nickname+'</span> 님이 <span>10연승 달성</span> 하셨습니다.');
                }
                else if(bPacket.type == 'winFixCnt20')
                {
                    printSystemMsg('macro','<span>'+bPacket.nickname+'</span> 님이 <span>20연승 달성</span> 하셨습니다.');
                }
                break;

            case 'macro':
                if(bPacket.type == 'link')
                {
                    printSystemMsg('system',bPacket.message);
                }
                else
                {
                    printSystemMsg('macro',bPacket.message);
                }
                break;

            case 'gift':
                printItemMsg(bPacket.type,bPacket.cnt,bPacket.nickname,bPacket.tnickname);
                break;

            case 'memberJoinNoti':
                var englishPt = /[a-zA-Z]/;
                if(englishPt.test(bPacket.nickname))
                {
                }
                else
                {
                    printSystemMsg('notice','환영합니다! <span>'+bPacket.nickname+'</span> 님이 회원가입 하셨습니다.');
                }
                break;

            case 'boardNoti':
                printSystemMsg('notice','<span>'+bPacket.nickname+'</span> 님이 <span>분석픽공유</span> 게시판에 글을 등록 하셨습니다. <a href="/bbs/board.php?bo_table=pick&wr_id='+bPacket.wr_id+'" target="mainFrame">[보기]</a>');
                break;

            case 'muteOffNoti':
                printSystemMsg('system','<span>'+bPacket.nickname+'</span> 님이 벙어리 해제 되었습니다.');
                if(bPacket.useridKeyList)
                {
                    var useridKeyListArr = bPacket.useridKeyList.split(',');

                    for(var i=0;i<useridKeyListArr.length;i++)
                    {
                        if(useridKeyListArr[i] == this.useridKey)
                        {
                            updateState('muteOff');
                            break;
                        }
                    }
                }
                break;


            case 'admin':
                printSystemMsg('admin',bPacket.msg);
                break;

            case 'badgeCntNoti':
                printSystemMsg('notice','<span>'+bPacket.nickname+'</span> 님이 <span>'+bPacket.badgeCnt+'연승 달성</span>으로 <a href="/?view=market" target="mainFrame">['+bPacket.badgeCnt+'연승 훈장]</a>을 획득하였습니다.');
                break;

            case 'scopesightNoti':
                var scopesightWinCnt = bPacket.type.replace('scopesightWin','');
                var bonusPoint = $.number(scopesightWinCnt * 1000);
                $('#msgBox').append('<li><img src="https://simg.powerballgame.co.kr/images/scopesight'+scopesightWinCnt+'.gif"></li>');
                $('#msgBox').append('<li><p class="msg-notice"><span>[조준경] '+bPacket.nickname+'</span>님이 <span>'+scopesightWinCnt+'연승</span> 적중하셨습니다.<br><span>'+bPacket.nickname+'</span>님의 채팅방 입장하기 <a href="#" onclick="return false;" class="joinRoom" rel="'+bPacket.roomIdx+'">[입장하기]</a></p></li>');
                setTimeout(function(){
                    setScroll();
                },500);
                break;
        }
    }
    else if(hPacket.type == 'INITMSG')
    {
        compileJson("#users","#connectList",bPacket.connectList,1,false);
        total_num = bPacket.connectList.length;
        $("#connectUserCnt").html(number_format(total_num.toString()));
        $('#msgBox').empty();
        for(var i in bPacket.msgList)
        {
            var dataInfo = bPacket.msgList[i];
            printChatMsg(dataInfo.level,dataInfo.sex,dataInfo.mark,dataInfo.id,dataInfo.nickname,dataInfo.msg,dataInfo.item,dataInfo.winFixCnt);
        }

        printSystemMsg('guide','<span>'+roomName(bPacket.roomIdx)+'</span>에 입장 하셨습니다.');
        printSystemMsg('system','<span>광고, 비방, 비매너, 개인정보 발언</span> 채팅시 차단됩니다.');

        if(bPacket.freezeOnOff == 'on')
        {
            chatManager('freezeOn');
        }

        fixNotice(bPacket.fixNoticeOnOff,bPacket.fixNoticeMsg);
    }
    else if(hPacket.type == 'MSG')
    {
        printChatMsg(bPacket.level,bPacket.sex,bPacket.mark,bPacket.id,bPacket.nickname,bPacket.msg,bPacket.item,bPacket.winFixCnt);
    }
    else if(hPacket.type == 'WHISPER')
    {
        printWhisperChatMsg(bPacket.level,bPacket.sex,bPacket.mark,bPacket.iddl ,bPacket.nickname,bPacket.msg,bPacket.tnickname,bPacket.item);
    }
    else if(hPacket.type == 'MEMO')
    {
        parent.memoNoti();
    }
    else if(hPacket.type == 'NOTICE')
    {
        switch(bPacket.type)
        {
            case 'AUTHKEY_NOTMATCHED':
                printSystemMsg('system','패킷 암호화 오류입니다. 다시 로그인 하시기 바랍니다.');
                socket.disconnect();
                break;

            case 'DISCONNECTED':
                printSystemMsg('guide','접속이 끊어졌습니다. 재접속 해주시기 바랍니다.');
                break;

            case 'MUTEMSG':
                printSystemMsg('guide','회원님은 벙어리 상태입니다.<span> ['+getDiff(bPacket.diff)+' 후 채팅 가능]</span>');
                break;

            case 'BAN':
                printSystemMsg('guide','운영자에 의해 강제 퇴장 되었습니다.');
                break;

            case 'BANIPON':
                printSystemMsg('guide','운영자에 의해 접속이 차단 되었습니다.');
                socket.disconnect();
                break;

            case 'BANIPMSG':
                printSystemMsg('guide','접속이 차단되어 접속할 수 없습니다.');
                socket.disconnect();
                document.location.href = '/?view=chatStateMsg&type=banIp';
                break;

            case 'FREEZEMSG':
                printSystemMsg('guide','채팅창을 녹이기 전까지 채팅 입력이 제한됩니다.');
                break;

            case 'CREATECHATROOMMSG':
                if(bPacket.roomType == 'normal')
                {
                    printSystemMsg('auto','<span>'+bPacket.nickname+'</span>님이 일반 채팅방 "<span>'+bPacket.roomTitle+'</span>" 을 개설하였습니다. <a href="#" onclick="return false;" class="joinRoom" rel="'+bPacket.roomIdx+'">[입장하기]</a>');
                }
                else if(bPacket.roomType == 'premium')
                {
                    printSystemMsg('auto4','<span>'+bPacket.nickname+'</span>님이 프리미엄 채팅방 "<span>'+bPacket.roomTitle+'</span>" 을 개설하였습니다. <a href="#" onclick="return false;" class="joinRoom" rel="'+bPacket.roomIdx+'">[입장하기]</a>');
                }
                break;
        }
    }
    else if(hPacket.type == 'ERROR')
    {
        switch(bPacket.type)
        {
            case 'NOT_ALLOW_SELF':
                printSystemMsg('guide','자신에게는 귓말을 할 수 없습니다.');
                break;

            case 'NOT_ALLOW_WHISPER':
                printSystemMsg('guide','귓말은 운영자에게만 가능합니다.');
                break;

            case 'NOT_EXIST_TARGET':
                printSystemMsg('guide','상대방은 접속 상태가 아닙니다.');
                break;

            case 'PERMISSION_DENIED':
                printSystemMsg('guide','권한이 없습니다.');
                break;

            case 'NOT_LOGIN':
                compileJson("#users","#connectList",bPacket.connectList,0,false);
                if(typeof bPacket.connectList != "undefined"){
                    total_num = bPacket.connectList.length;
                    $("#connectUserCnt").html(number_format(total_num.toString()));
                    $('#msgBox').empty();
                    for(var i in bPacket.msgList)
                    {
                        var dataInfo = bPacket.msgList[i];
                        printChatMsg(dataInfo.level,dataInfo.sex,dataInfo.mark,dataInfo.id,dataInfo.nickname,dataInfo.msg,dataInfo.item,dataInfo.winFixCnt);
                    }
                }
                printSystemMsg('guide','채팅에 참여하려면 로그인이 필요합니다.');
                break;

            case 'BULLET_NEED':
                printSystemMsg('guide','당근이 부족합니다.');
                break;

            case 'BISCUIT_NEED':
                printSystemMsg('guide','건빵이 부족합니다.');
                break;

            case 'NEED_ITEM_PICKSTER':
                printSystemMsg('guide','<span>픽스터 이용권</span> 아이템이 필요합니다. <a href="/?view=market" target="mainFrame">[구매하기]</a>');
                break;
        }
    }
    else if(hPacket.type == "ListUser"){
        if(typeof bPacket.users != "undefined"){
            var ss = new Array();
            ss[0] = bPacket.users;
            compileJson("#users","#connectList",ss,2,false);
            total_num = total_num+1;
            $("#connectUserCnt").html(number_format(total_num.toString()));
        }

    }
    else if(hPacket.type == "LeaveUserId")
    {
        total_num = total_num-1;
        if(total_num < 0)
            total_num = 1;
        $("#"+bPacket.userIdKey).remove();
        $("#connectUserCnt").html(number_format(total_num.toString()));
    }
}

function browserWsChk()
{
    var result = false;
    // 안드로이드
    if(navigator.userAgent.indexOf('Android') != -1)
    {
        if(navigator.userAgent.indexOf('Chrome') != -1)
        {
            result = true;
        }
        else if(navigator.userAgent.indexOf('Opera/9') != -1)
        {
            result = true;
        }
        else if(navigator.userAgent.indexOf('Firefox/16') != -1)
        {
            result = true;
        }
        else
        {
            result = false;
        }
    }
    else
    {
        result = true;
    }
    return result;
}

function setChatHistory(msg)
{
    if(getChatHistory(0) == msg)
    {
        chatHistoryNum = 0;
        return false;
    }

    var chatHistory = '';
    if(getCookie('CHATHISTORY'))
    {
        chatHistory = msg + '|::|'+getCookie('CHATHISTORY');
    }
    else
    {
        chatHistory = msg;
    }

    setCookie('CHATHISTORY',chatHistory,60*60*24);
    chatHistoryNum = 0;

    chatHistory = null;
}

function getChatHistory(num)
{
    if(getCookie('CHATHISTORY'))
    {
        var chatHistoryArr = getCookie('CHATHISTORY').split('|::|');

        if(chatHistoryArr[num])
        {
            return chatHistoryArr[num];
        }
    }
}

function setCookie(name,value,expiredays)
{
    var todayDate = new Date();
    todayDate.setDate( todayDate.getDate() + expiredays );
    document.cookie = name + '=' + escape( value ) + '; path=/; expires=' + todayDate.toGMTString() + ';'
}

// get cookie
function getCookie(name)
{
    var nameOfCookie = name + '=';
    var x = 0;
    while ( x <= document.cookie.length ){
        var y = (x+nameOfCookie.length);
        if ( document.cookie.substring( x, y ) == nameOfCookie ) {
            if ( (endOfCookie=document.cookie.indexOf( ';', y )) == -1 )
                endOfCookie = document.cookie.length;
            return unescape( document.cookie.substring( y, endOfCookie ) );
        }
        x = document.cookie.indexOf( ' ', x ) + 1;
        if ( x == 0 )
            break;
    }
    return '';
}
function roomName(roomIdx)
{
    var returnName = '';

    switch(roomIdx)
    {
        case 'channel1':
            returnName = '연병장';
            break;

        case 'channel2':
            returnName = '생활관';
            break;
    }

    return returnName;
}


function fixNotice(state,msg)
{
    if(state == 'on')
    {
        $('#fixNoticeBox').show();
    }
    else if(state == 'off')
    {
        $('#fixNoticeBox').hide();
    }

    if(msg)
    {
        $('#fixNoticeBox .msg').html(msg);

    }
}

function chatManager(type,nick)
{
    if(type == 'refresh')
    {
        location.reload();
    }
    else if(type == 'clearChat')
    {
        if($('#msgBox').is(':hidden') == false)
        {
            $('#msgBox').html('');
            printSystemMsg('guide','채팅창을 지웠습니다.');
        }
    }
    else if(type == 'popupChat')
    {
        windowOpen('/chat.php','chatPopup',330,575,'no');
    }
    else if(type == 'help')
    {
        if($('#helpBox').css('display') == 'none')
        {
            $('#helpBox').show();
        }
        else
        {
            $('#helpBox').hide();
        }
    }
    else if(type == 'whisper')
    {
        setCookie('whisperNick',nick,1);
        whisperNick = nick;

        $('#msg').focus();
        $('#msg').val('"'+nick+' ');
    }
    else if(type == 'memo')
    {
        windowOpen('/memo?type=write&nickname='+nick,600,600,550);
    }
    else if(type == 'muteOn' || type == 'muteOff' || type == 'banOn' || type == 'banipOn' || type == 'banipOff')
    {
        $('#msg').val('/'+type+' '+nick);
        $('#sendBtn').click();
    }
    else if(type == 'muteOnTime1')	// 벙어리(1시간)
    {
        $('#msg').val('/muteOnTime '+nick+' 1');
        $('#sendBtn').click();
    }
    else if(type == 'muteOnTime')	// 벙어리(영구)
    {
        $('#msg').val('/'+type+' '+nick+' 10000');
        $('#sendBtn').click();
    }
    else if(type == 'freezeOn')
    {
        printSystemMsg('system','운영자가 채팅창을 얼렸습니다.');
        is_freeze = 'on';
    }
    else if(type == 'freezeOff')
    {
        printSystemMsg('system','운영자가 채팅창을 녹였습니다.');
        is_freeze = 'off';
    }
    else if(type == 'friendList')
    {
        if(confirm('['+nick+']님을 친구 추가하시겠습니까?'))
        {
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/addFriend',
                data:{
                    nickname:nick,
                    api_token : userIdToken,
                    type:"friend",
                },
                success:function(data,textStatus){
                    if(data.status == 1)
                    {
                        alert('['+data.friendNickname+']님을 친구 추가했습니다.');
                    }
                    else
                    {
                        alert(data.msg);
                    }
                }
            });
        }
    }
    else if(type == 'blackList')
    {
        if(confirm('['+nick+']님을 블랙리스트에 추가하시겠습니까?'))
        {
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/addFriend',
                data:{
                    type:"block",
                    nickname:nick,
                    api_token : userIdToken
                },
                success:function(data,textStatus){
                    if(data.status == 1)
                    {
                        blackListArr.push(data.blackUseridKey);
                        alert('['+data.blackNickname+']님을 블랙리스트에 추가했습니다.');
                    }
                    else
                    {
                        alert(data.msg);
                    }
                }
            });
        }
    }
}

function repeatChatFilter()
{
    var totalTime = 0;
    var curDate = new Date();

    msgTermArr[msgTermIdx % 8] = curDate.getTime() - lastMsgTime;
    lastMsgTime = curDate.getTime();
    msgTermIdx++;

    for(var i=0;i<msgTermArr.length;i++)
    {
        totalTime += msgTermArr[i];
    }

    if(msgTermArr.length == 8 && totalTime < 5 * 1000)
    {
        is_repeatChat = true;
        printSystemMsg('guide','[도배금지] ' + msgStopTime + '초간 채팅이 제한됩니다.');
        setTimeout(clearRepeatChat,msgStopTime * 1000);
        return true;
    }
    else
    {
        return false;
    }
}

function clearRepeatChat()
{
    msgTermIdx = 0;
    msgTermArr = new Array();
    is_repeatChat = false;
}


function printChatMsg(level,sex,mark,useridKey,nickname,msg,item,winFixCnt)
{
    // black list
    if((','+blackListArr.join()+',').indexOf(','+useridKey+',') != -1)
    {
        return;
    }

    var msgLength = $('#msgBox li').length;

    if(msgLength > 150)
    {
        for(i=0;i<msgLength-150;i++)
        {
            $('#msgBox li').eq(i).remove();
        }
    }

    msgLength = null;

    var addClass = '';
    if(level == 30)
    {
        addClass = ' class="admin"';
    }
    else if(level == 29)
    {
        addClass = ' class="devadmin"';
    }

    var itemView = '';
    var gasmaskClass = '';
    var levelImg = sex+level;
    if(item)
    {
        if(item.indexOf('superChat') != -1)
        {
            addClass = ' class="superchat"';
        }

        if(item.indexOf('levelupx4') != -1)
        {
            itemView = '<span style="position:absolute;left:-3px;z-index:-1;"><img src="/assets/images/powerball/levelupx4.gif" width="29" height="23"></span>';
        }
        else if(item.indexOf('levelupx2') != -1)
        {
            itemView = '<span style="position:absolute;left:-3px;z-index:-1;"><img src="/assets/images/powerball/levelupx2.gif" width="29" height="23"></span>';
        }

    }

    var familyNick = '';
    var familyNickView = '';
    var badgeCnt = '';
    if(item)
    {
        if(item.indexOf('familyNick') != -1 || item.indexOf('badge') != -1)
        {
            var itemArr = item.split('#::#');

            for(var i=0;i<itemArr.length;i++)
            {
                if(itemArr[i].indexOf('familyNick') != -1)
                {
                    familyNick = itemArr[i].replace('familyNick_','');
                }
                else if(itemArr[i].indexOf('badge') != -1)
                {
                    var badgeCnt = itemArr[i].replace('badge','');
                    itemView += '<span style="position:absolute;left:-3px;bottom:-9px;z-index:99;"><div class="sp-badge'+badgeCnt+'" title="'+badgeCnt+'연승 훈장"></div></span>';
                }
            }

            familyNickView = '<span class="familyNick">'+familyNick+'</span>';
        }
    }

    var markView = '';
    if(mark == 'pickster')
    {
        markView = '<img src="https://simg.powerballgame.co.kr/images/bl_pickster.gif" width="16" height="16" class="king" title="베스트픽스터"> ';
    }

    if(level == 30)
    {
        $('#msgBox').append('<li><p class="msg-admin">'+msg+'</p></li>');
    }
    else
    {
        // 연승 표현
        var winFixCntView = '';
        if(winFixCnt > 0)
        {
            winFixCntView = '<span style="position:absolute;right:-3px;bottom:-9px;z-index:99;"><div class="sp-win'+winFixCnt+'" title="'+winFixCnt+'연승"></div></span>';
        }

        $('#msgBox').append('<li'+addClass+'>'+markView+'<span style="position:relative;"><img src="'+level_images[level]+'" width="23" height="23" orgLevel="'+sex+level+'"'+gasmaskClass+'/>'+itemView+winFixCntView+'</span> <strong><a href="#" onclick="return false;" title="'+nickname+'" rel="'+useridKey+'" class="uname">'+familyNickView+nickname+'</a></strong> '+msg+'</li>');
    }

    addClass = null;

    setScroll();
}

function windowResize()
{
    var msgBoxHeight = $('body').height();
    $('#msgBox').height(msgBoxHeight-190);
    $('#connectList').height(msgBoxHeight-160);
    $('#roomList').height(msgBoxHeight-185);
    $('#ruleBox').height(msgBoxHeight-203);
    msgBoxHeight = null;
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

    if(loginYN == 'Y' && this.userIdKey != useridKey)
    {
        str += '<ul>';
        str += '<li><a href="#" onclick="giftPops(\''+useridKey+'\',\'bullet\');return false;"><em class="ico"></em><span class="txt">당근 선물하기</span></a></li>';
        str += '<li><a href="#" onclick="chatManager(\'memo\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">쪽지 보내기</span></a></li>';

        if(roomIdx != 'lobby' && is_admin)
        {
            str += '<li><a href="#" onclick="chatManager(\'muteOn\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리(5분)</span></a></li>';
            str += '<li><a href="#" onclick="chatManager(\'muteOnTime1\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리(1시간)</span></a></li>';
            str += '<li><a href="#" onclick="chatManager(\'muteOnTime\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리(영구)</span></a></li>';
            str += '<li><a href="#" onclick="chatManager(\'muteOff\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리해제</span></a></li>';
            str += '<li><a href="#" onclick="chatManager(\'banipOn\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">아이피차단</span></a></li>';
            str += '<li><a href="#" onclick="chatManager(\'banipOff\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">아이피차단해제</span></a></li>';
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

    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/bettingResultLayer',
        data:{
            useridKey:useridKey
        },
        timeout:1000,
        success:function(r,textStatus){
            if(r.status == 1){
                let data = r.result;
                bettingStr += '<ul>';
                bettingStr += '<li>현재연승 - <span class="'+data.totalWinClass+'">'+data.totalWinFix+'</span>연승</li>';
                bettingStr += '<li>파워볼홀짝 - <span class="'+data.powerballOddEvenWinClass+'">'+data.powerballOddEvenWinFix+'</span>연승, <span class="win">'+data.powerballOddEvenWin+'</span>승<span class="lose">'+data.powerballOddEvenLose+'</span>패('+data.powerballOddEvenRate+')</li>';
                bettingStr += '<li>파워볼언더오버 - <span class="'+data.powerballUnderOverWinClass+'">'+data.powerballUnderOverWinFix+'</span>연승, <span class="win">'+data.powerballUnderOverWin+'</span>승<span class="lose">'+data.powerballUnderOverLose+'</span>패('+data.powerballUnderOverRate+')</li>';
                bettingStr += '<li>숫자합홀짝 - <span class="'+data.numberOddEvenWinClass+'">'+data.numberOddEvenWinFix+'</span>연승, <span class="win">'+data.numberOddEvenWin+'</span>승<span class="lose">'+data.numberOddEvenLose+'</span>패('+data.numberOddEvenRate+')</li>';
                bettingStr += '<li>숫자합언더오버 - <span class="'+data.numberUnderOverWinClass+'">'+data.numberUnderOverWinFix+'</span>연승, <span class="win">'+data.numberUnderOverWin+'</span>승<span class="lose">'+data.numberUnderOverLose+'</span>패('+data.numberUnderOverRate+')</li>';
                bettingStr += '<li>숫자합대중소 - <span class="'+data.numberPeriodWinClass+'">'+data.numberPeriodWinFix+'</span>연승, <span class="win">'+data.numberPeriodWin+'</span>승<span class="lose">'+data.numberPeriodLose+'</span>패('+data.numberPeriodRate+')</li>';

                bettingStr += '</ul>';

                $('#userLayer .game').html(bettingStr);

                // layer position
                var layerTop = 0;
                var layerBottom = $('body').height() - e.pageY - $('#userLayer').height();

                if(layerBottom < 0)
                {
                    layerTop = e.pageY - $('#userLayer').height();
                }
                else
                {
                    layerTop = e.pageY;
                }

                $('#userLayer').css({'left':e.pageX + 10,'top':layerTop});
            }
        },error:function(xhr){
            console.log(xhr)
        }
    });
}

function memoSend(tuseridKey,memoid)
{
    var data = {
        cmd : 'memo',
        roomIdx : this.roomIdx,
        tuseridKey : tuseridKey
    };
    sendProcess('MEMO',data);
}


function openChatRoom()
{
    chatRoomPop = window.open('/chatRoom','chatRoom','width=958px,height=565px,status=no,scrollbars=no,toolbar=no');
}

function windowOpen(src,target,width,height,scroll)
{
    var wid = (screen.availWidth - width) / 2;
    var hei = (screen.availHeight - height) / 2;
    var opt = 'width='+width+',height='+height+',top='+hei+',left='+wid+',resizable=no,status=no,scrollbars='+scroll;
    window.open(src,target,opt);
}


function giftPops(useridKey,type)
{
    windowOpen('/giftBox?useridKey='+useridKey+'&type='+type,'gift',420,400,'no');
}

function giftManager(type,tuseridKey,cnt)
{
    var data = {
        cmd : 'gift',
        type : type,
        roomIdx : this.roomIdx,
        tuseridKey : tuseridKey,
        cnt : cnt,
        api_token:userIdToken
    };

    $.ajax({
        dataType:"json",
        type: "post",
        url: "/api/sendGift",
        data:data
    }).done(function(data) {
        if(data.status == 1){
            alert(data.msg);
            sendProcess('GIFT',data.list);
        }
        else{
            alert(data.msg);
        }
    });
}

function printItemMsg(type,cnt,nickname,tnickname)
{
    if(type == 'bullet')
    {
        var bulletImg = '';
        if(cnt < 30)
        {
            bulletImg = 'bullet1.png';
        }
        else if(cnt < 50)
        {
            bulletImg = 'bullet2.png';
        }
        else if(cnt < 100)
        {
            bulletImg = 'bullet3.png';
        }
        else if(cnt < 300)
        {
            bulletImg = 'bullet4.png';
        }
        else if(cnt < 500)
        {
            bulletImg = 'bullet5.png';
        }
        else if(cnt < 1000)
        {
            bulletImg = 'bullet6.png';
        }
        else if(cnt < 3000)
        {
            bulletImg = 'bullet7.png';
        }
        else if(cnt < 5000)
        {
            bulletImg = 'bullet8.png';
        }
        else
        {
            bulletImg = 'bullet9.png';
        }

        var itemMsg = '<div class="bulletBox"><div class="cnt">'+cnt+'</div></div>';

        $('#msgBox').append('<li>'+itemMsg+'</li>');
        $('#msgBox').append('<li><p class="msg-gift"><span>'+nickname+'</span> 님이 <span>'+tnickname+'</span> 님에게 <span>총알 '+cnt+'개</span>를 선물하셨습니다.</p></li>');
    }
    else if(type == 'biscuit')
    {
        var biscuitImg = '';
        if(cnt < 30)
        {
            biscuitImg = 'biscuit1.png';
        }
        else if(cnt < 50)
        {
            biscuitImg = 'biscuit2.png';
        }
        else if(cnt < 100)
        {
            biscuitImg = 'biscuit3.png';
        }
        else if(cnt < 300)
        {
            biscuitImg = 'biscuit4.png';
        }
        else if(cnt < 500)
        {
            biscuitImg = 'biscuit5.png';
        }
        else
        {
            biscuitImg = 'biscuit6.png';
        }

        var itemMsg = '<div class="bulletBox"><div class="cnt">'+cnt+'</div><img src="https://simg.powerballgame.co.kr/images/'+biscuitImg+'"/></div>';

        $('#msgBox').append('<li>'+itemMsg+'</li>');
        $('#msgBox').append('<li><p class="msg-gift"><span>'+nickname+'</span> 님이 <span>'+tnickname+'</span> 님에게 <span>건빵 '+cnt+'개</span>를 선물하셨습니다.</p></li>');
    }
    else if(type == 'autoGiftBiscuit')
    {
        var itemMsg = '<div class="autoGiftBox"><img src="https://simg.powerballgame.co.kr/images/biscuit1.png"/></div>';

        $('#msgBox').append('<li>'+itemMsg+'</li>');
        $('#msgBox').append('<li><p class="msg-autoGift">지속적인 <span>픽 참여</span>로 <span>'+tnickname+'</span> 님에게 <span>건빵 '+cnt+'개</span>가 지급되었습니다.</p></li>');
    }

    setScroll();
}
