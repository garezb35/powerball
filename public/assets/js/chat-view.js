var socketOption = {};
var total_num = 0;
var is_repeatChat = false;
var lastMsgTime = new Date().getTime();
var sumMsgTerm = 0;
var msgTermArr = new Array();
var msgTermIdx = 0;
var msgStopTime = 10;
var emoticonTicket = false;
socketOption['reconnect'] = true;
socketOption['force new connection'] = true;
socketOption['sync disconnect on unload'] = true;
var powerball_result = new Array();
var next_result= new Array();
var pick_click = 0;
if('WebSocket' in window)
{
    socketOption['transports'] = ['websocket'];
}
var socket = null;
var browser_ws = browserWsChk();
$(document).on('click','a.uname',userLayerHandler);

$(document).click(function(){
    $('#userLayer:visible').hide();
});
$(document).ready(function() {
    // size init
    top.resizeTo(975, 780);
    windowResize();

    if(browser_ws == true)
    {
        connect();
    }

    socket.on('receive',function(data){
        receiveProcess(data);
    });

    socket.on('reconnect',function(){
        printSystemMsg('guide','채팅서버와의 접속이 종료되었습니다. 3초 후에 재접속합니다.');
        setTimeout(function(){
            connect();
        },3000);
    });

    $(window).on("unload",function(e){
        if(browser_ws == true)
        {
            socket.disconnect();
        }
    });

    $('#msg').click(function(){
        is_scroll_lock = false;
        setScroll();
    });

    $('#sendBtn').click(function(){
        sendMsg();
    });

    $('#btn_exit').click(function(){

            if(!confirm('채팅방을 나가시겠습니까?'))
            {
                return false;
            }
            else
            {
                location.href = "/chatRoom";
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
    if(!getCookie('chatRoomSoundOnOff'))
    {
        setCookie('chatRoomSoundOnOff','on');
    }

    $('#btn_pointBet').click(function(){
        $('#helpBox').slideUp();
        $('#layer-bulletBox').slideUp();
        $('#layer-emoticonBox').slideUp();
        $('#betBox').slideToggle('fast');
        if(pick_click % 2 == 0){
          $(this).text("픽 닫기")
          $(this).parent().css("background","url(/assets/images/pick/present.png)")
          $(this).parent().css("background-size","100%")
        }
        else{
          $(this).text("픽 열기")
          $(this).parent().css("background","#00b4b4")
        }
        pick_click++;
    });

    $('#btn_giftBullet').click(function() {
        $('#layer-bulletBox').slideToggle('fast');
        $('#betBox').slideUp();
        // 당근 reload
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/getBullet',
            data:{
                api_token:userIdToken
            },
            success:function(data,textStatus){
                if(data.status == 1)
                {
                    $('#bullet').attr('rel',data.bullet);
                    $('#bullet').html(data.bullet);
                }
                else
                {
                    alertifyByCommon(data.msg)
                }
            }
        });
    });
    $('#layer-bulletBox').find('.reset').click(function(){
        $('#layer-bulletBox').slideToggle('fast');
    });

    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/getChatPicks',
        data:{skip:0,limit:287,api_token:userIdToken,roomIdx:roomIdx},
        beforeSend: function() {
            moreLoad(1)
        },
        success:function(data,textStatus){
            if(data.status == 1){
                powerball_result = data.result.list;
                if(powerball_result.length > 0){
                    compileJson("#chat-pick-list","#resultList",data.result,2,false);
                }
                var month = (calcTime("+9").getMonth() + 1).toString();
                var date = calcTime("+9").getDate();
                var input  = new Array();
                input = {list: [{day_round:next_round,today:month+"월 "+date+"일",nnn:-1,betting_data:{content:cur_bet.replace(/&quot;/g,'"')}}] };
                compileJson("#chat-pick-list","#resultList",input,10,false);
            }
        },error:function(xhr){
            console.log(xhr)
        }
    });

    $('#btn_recom').click(function(){
        if(!confirm('현재 채팅방을 추천하시겠습니까?'))
        {
            return false;
        }

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/recommendChatRoom',
            data:{
                api_token:userIdToken,
                roomIdx:roomIdx
            },
            success:function(data,textStatus){
                if(data.status == 1)
                {
                    sendProcess('USERCMD', {cmd:"recommendChatRoom",roomIdx:roomIdx});
                }
                else if(data.status == -1){
                    alertifyByCommon(data.msg)
                    location.href = "/chatRoom";
                }
                else
                    alertifyByCommon(data.msg)
            }
        });
    });
    $('#btn_emoticon').click(function(){
        $('#helpBox').slideUp();
        $('#layer-bulletBox').slideUp();
        $('#pointBetFrame').slideUp();
        $('#layer-emoticonBox').slideToggle('fast');
    });

    $('#layer-emoticonBox .emoticon li').click(function(){

        if(is_super == false && emoticonTicket == false)
        {
            alertifyByCommon('[이모티콘 사용권] 아이템 보유시 사용 가능합니다.')
            return false;
        }

        var emoticonCode = $(this).attr('rel');
        $('#msg').val($('#msg').val()+'(#'+emoticonCode+')').focus();
    });
    $('#btn_favorite').click(function(){

        if(!confirm('방장을 즐겨찾기로 등록 하시겠습니까?'))
        {
            return false;
        }
        else
        {
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/setFavorite',
                data:{
                    api_token:userIdToken,
                    roomIdx:roomIdx
                },
                success:function(data,textStatus){
                    alertifyByCommon(data.msg);
                }
            });
        }
    });
    $('#msgBox').scroll(function(){
        var scrollChk = parseInt($(this)[0].scrollHeight) - parseInt($(this).scrollTop()) - parseInt($(this).outerHeight());

        if(scrollChk > 100)
        {
            is_scroll_lock = true;
        }
        else
        {
            is_scroll_lock = false;
        }
    });



    $('#callSound').jPlayer({
        ready: function (){
            $(this).jPlayer('setMedia',{
                mp3:'/assets/call/warning_short.mp3'
            });
        },
        swfPath:'/assets/jplayer/',
        supplied:'mp3'
    });

    $('#msgBox').scroll(function(){
        var scrollChk = parseInt($(this)[0].scrollHeight) - parseInt($(this).scrollTop()) - parseInt($(this).outerHeight());

        if(scrollChk > 100)
        {
            is_scroll_lock = true;
        }
        else
        {
            is_scroll_lock = false;
        }
    });

    // 사운드 끄기, 켜기
    $('#btn_sound').click(function(){
        if($(this).text() == '사운드 끄기')
        {
            $(this).text('사운드 켜기');
            setCookie('chatRoomSoundOnOff','off');
            $('#callSound').jPlayer('mute');
            $('#pickSound').jPlayer('mute');

            $(this).parent().css("background","url(/assets/images/pick/present.png)")
            $(this).parent().css("background-size","100%")
        }
        else
        {
            $(this).text('사운드 끄기');
            $(this).parent().css("background","#00b4b4")
            setCookie('chatRoomSoundOnOff','on');
            $('#callSound').jPlayer('unmute');
            $('#pickSound').jPlayer('unmute');
        }
    });

    if(getCookie('chatRoomSoundOnOff') == 'off')
    {
        $('#btn_sound').parent().css("background","url(/assets/images/pick/present.png)");
        $("#btn_sound").parent().css("background-size","100%")
        $("#btn_sound").text("사운드 켜기")
    }
    $('#btn_help').click(function(){
        $('#pointBetFrame').slideUp();
        $('#layer-emoticonBox').slideUp();
        $('#helpBox').slideToggle();
    });
    $(document).on('click','#btn_freezeOn',function(){
        if(is_freeze == false && (is_admin || is_manager))
        {
            adminCmd('freezeOn');
            $(this).siblings().removeClass('on');
            $(this).addClass('on');

            $('#btn_freezeOn').text('녹이기');
            $('#btn_freezeOn').attr('id','btn_freezeOff');

            $(this).parent().css("background","url(/assets/images/pick/present.png)")
            $(this).parent().css("background-size","100%")
            $(this).parent().css("background-repeat","no-repeat")
        }
    });

    // 채팅창 녹이기
    $(document).on('click','#btn_freezeOff',function(){
        if(is_freeze == true && (is_admin || is_manager))
        {
            adminCmd('freezeOff');
            $(this).siblings().removeClass('on');
            $(this).addClass('on');

            $('#btn_freezeOff').text('얼리기');
            $('#btn_freezeOff').attr('id','btn_freezeOn');
            $(this).parent().css("background","#00b4b4")
        }
    });

    $('#btn_call').click(function(){
        adminCmd('call');
    });

    $('#btn_chatRoomSetting').click(function(){
        if(is_admin)
        {
           $("#modify-chatroom").modal("show")
        }
        else
        {
            alertifyByCommon("권한이 없습니다.")
        }

        return false;
    });
    $('#current_roomPublic').change(function(){

        var chkVal = $('#current_roomPublic option:selected').val();

        if(chkVal == '2' && level < "09")
        {
            alertifyByCommon("비공개 채팅방 개설은 소위 계급 부터 가능합니다.")
            $(this).val('1');
            return false;
        }

        if(chkVal == '1')
        {
            $('#modal_chatRoomSetting').find('.passwd').hide();
        }
        else
        {
            $('#modal_chatRoomSetting').find('.passwd').show();
        }
    });
    // 채팅방 설정
    $('#btn_modifyChatRoom').click(function(){
        if(modifyRoom() == true)
        {
            $('#modify-chatroom').modal("hide");
        }
    });
    // 채팅방 삭제
    $('#btn_chatRoomClose').click(function(){
        if(is_admin)
        {
            if(confirm('채팅방을 삭제하시겠습니까?'))
            {
                adminCmd('closeRoom');
            }
        }
        else
        {
            alertifyByCommon('권한이 없습니다.');
        }

        return false;
    });
    $('#layer-bulletBox').find('.opt').click(function(){
        $('#layer-bulletBox').find('.opt').each(function(){
            $(this).removeClass('on');
        });
        $(this).addClass('on');

        if($(this).attr('type') != 'text')
        {
            $('#bullet').attr('giftCnt',$(this).attr('rel'));
            $('#inputCnt').val('');
        }
    });

    $('#layer-bulletBox').find('.btnBox .gift').click(function(){

        if($(this).find('span').hasClass('stop') == true)
        {
            return false;
        }

        var myBulletCnt = parseInt($('#bullet').attr('rel'));
        var giftCnt = parseInt($('#bullet').attr('giftCnt'));

        if(giftCnt == 0)
        {
            alertifyByCommon("선물할 당근 수량을 선택하세요.")
        }
        else if(myBulletCnt < giftCnt)
        {
            if(confirm('보유한 당근이 부족합니다. 당근을 구매하시겠습니까?'))
            {
                /*
                if(typeof(opener) != 'undefined')
                {
                    opener.top.mainFrame.location.href = '/?view=market';
                }
                else
                {
                    window.open('/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket','_blank','');
                }
                */
                window.open('/#http%3A%2F%2Fwww.powerballgame.co.kr%2F%3Fview%3Dmarket','_blank','');
            }
        }
        else if(confirm('방장에게 '+giftCnt+'개의 당근을 선물하시겠습니까?'))
        {
            $('#layer-bulletBox').find('.btnBox .gift span').addClass('stop').text('선물중');

            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/giveBullet',
                data:{
                    api_token:userIdToken,
                    gift:giftCnt,
                    tuseridKey:JSON.parse(roomInfo).useridKey,
                    roomIdx:roomIdx
                },
                success:function(data,textStatus){
                    if(data.status == 1)
                    {

                        $('#bullet').attr('rel',data.bullet);
                        $('#bullet').html(data.bullet);
                        opener.updateBullet(data.bullet)
                        giftManager('bullet',JSON.parse(roomInfo).useridKey,giftCnt);
                    }
                    else
                    {
                        alertifyByCommon(data.msg)
                    }

                    setTimeout(function(){
                        $('#layer-bulletBox').find('.btnBox .gift span').removeClass('stop').text('선물하기');
                    },1000);
                }
            });
        }
    });

    $('#inputCnt').keyup(function(){
        $('#bullet').attr('giftCnt',$(this).val());
    });

});



function connect()
{
    try{
        printSystemMsg('guide','채팅서버에 접속중입니다. 잠시만 기다려주세요.');

        if(socket == null)
        {
            socket = io.connect('http://203.109.14.130:3000/room',socketOption);
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
                'type' : 'login'
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

function receiveProcess(data)
{

    var hPacket = data.header;
    var bPacket = data.body;
    if(hPacket.type == 'LOGIN' || hPacket.type == 'DEFAULT')
    {
        switch(bPacket.cmd)
        {
            case 'ERROR':
                switch(bPacket.type)
                {
                    case 'DUPLICATE':
                        printSystemMsg('guide','중복 로그인으로 인해 이전 접속을 종료합니다.');
                        socket.disconnect();
                        document.location.href = '/?view=chatStateMsg&type=duplicate&logout='+bPacket.logout;
                        break;

                    case 'IPDUPLICATE':
                        printSystemMsg('guide','동일 아이피에서 접속이 확인되어 이전 접속을 종료합니다.');
                        socket.disconnect();
                        document.location.href = '/?view=chatStateMsg&type=ipDuplicate';
                        break;
                }
                break;

            /*
            case 'JOIN':
                is_connect = true;
                $('#msgBox').html('');
                printSystemMsg('guide','채팅서버에 접속 되었습니다.');
                fixNotice(bPacket.fixNotice,bPacket.fixNoticeMsg);
            break;
            */

            case 'JOINUSER':
                if(bPacket.useridKey == userIdKey)
                {
                    userPickList();
                }
                chatRoom_joinUser(bPacket,true);
                break;

            case 'EXITUSER':
                chatRoom_exitUser(bPacket);
                break;
        }
    }
    else if(hPacket.type == "LeaveUserId")
    {
        if(typeof bPacket.userIdKey !="undefined"){
            total_num = total_num-1;
            if(total_num < 0)
                total_num = 1;
            $("#u-"+bPacket.userIdKey).remove();
            $("#chatRoom_userCnt").html(number_format(total_num.toString()));
            $("#chatRoom_topUserCnt").html(number_format(total_num.toString()));
        }
    }
    else if(hPacket.type == "ListUser"){
        if(typeof bPacket.users != "undefined"){
            if(fixed.includes(bPacket.users.id)){
                if(bPacket.users.userType == 2)
                    bPacket.users.userType = 3;
                if(bPacket.users.userType == 5)
                    bPacket.users.userType = 4;
            }
            if(bPacket.users.userType == 1)
                compileJson("#view-list","#connectOpenerList",bPacket.users,2,false);
            else if(bPacket.users.userType == 2 || bPacket.users.userType == 4)
                compileJson("#view-list","#connectManagerList",bPacket.users,2,false);
            else
                compileJson("#view-list","#connectUserList",bPacket.users,2,false);
            total_num = total_num+1;
            $("#chatRoom_userCnt").html(number_format(total_num.toString()));
            $("#chatRoom_topUserCnt").html(number_format(total_num.toString()));
        }
    }
    else if(hPacket.type == "INIT"){
        if(is_super == false && is_admin == false && bPacket.users.length > JSON.parse(roomInfo).maxUser){
            alertifyByCommon("최대인원을 초과하였습니다.");
            socket.disconnect();
            window.history.go(-1);
        }
        $('#msgBox').empty();
        for(var i in bPacket.msgList)
        {
            var dataInfo = bPacket.msgList[i];
            printChatMsg(dataInfo.userType,dataInfo.level,dataInfo.sex,dataInfo.mark,dataInfo.id,dataInfo.nickname,dataInfo.msg,dataInfo.item);
        }
        printSystemMsg('guide','<span>'+room_name+'</span> 채팅방에 입장 하셨습니다.');
        printSystemMsg('system','<span>광고, 비방, 비매너, 카톡, 개인정보, 계좌</span> 발언시 차단됩니다.');
        printSystemMsg('system','<span>부모 및 가족 관련 욕설, 성적 모욕을 하는 행위</span>시 제재의 대상이 됩니다.');
        if(typeof bPacket.users != "undefined"){
            for(var i=0 ; i < bPacket.users.length ; i++ ){
                if(fixed.includes(bPacket.users[i].id)){
                    if(bPacket.users[i].userType == 2)
                        bPacket.users[i].userType = 3;
                    if(bPacket.users[i].userType == 5)
                        bPacket.users[i].userType = 4;
                }
                if(bPacket.users[i].userType == 1)
                    compileJson("#view-list","#connectOpenerList",bPacket.users[i],2,false);
                else if(bPacket.users[i].userType == 2 || bPacket.users[i].userType == 4)
                    compileJson("#view-list","#connectManagerList",bPacket.users[i],2,false);
                else
                    compileJson("#view-list","#connectUserList",bPacket.users[i],2,false);

            }
            total_num = bPacket.users.length;
            $("#chatRoom_userCnt").html(number_format(total_num.toString()));
            $("#chatRoom_topUserCnt").html(number_format(total_num.toString()));
        }

        if(bPacket.freezeOnOff == 'on')
        {
            chatManager('freezeOn');
            if(is_admin)
            {
                $('#btn_freezeOn').text('녹이기');
                $('#btn_freezeOn').attr('id','btn_freezeOff');
            }
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
                printSystemMsg('system','방장에 의해 채팅방이 청소 되었습니다.');
                break;

            case 'fixMemberOn':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 고정멤버 임명 되었습니다.');
                fixMemberOnOff('On',bPacket.tuseridKey);
                if(this.userIdKey == bPacket.tuseridKey && is_manager == false)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'fixMemberOff':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 고정멤버 해제 되었습니다.');
                fixMemberOnOff('Off',bPacket.tuseridKey);
                if(this.userIdKey == bPacket.tuseridKey)
                {
                    if(is_manager == true)
                    {
                        updateState('managerOn');
                    }
                    else
                    {
                        updateState(bPacket.cmd);
                    }
                }
                break;

            case 'managerOn':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 매니저 임명 되었습니다.');
                managerOnOff('On',bPacket.tuseridKey);
                if(this.userIdKey == bPacket.tuseridKey)
                {
                    is_manager = true;
                }
                break;

            case 'managerOff':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 매니저 해제 되었습니다.');
                managerOnOff('Off',bPacket.tuseridKey);
                if(this.userIdKey == bPacket.tuseridKey)
                {
                    is_manager = false;
                }
                break;

            case 'kickOn':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 강제 퇴장 되었습니다.');
                if(this.userIdKey == bPacket.tuseridKey)
                {
                    modalLayerControl('kick');
                }
                break;

            case 'kickOff':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 강제 퇴장 해제 되었습니다.');
                break;

            case 'muteOn':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 벙어리 되었습니다.');
                // if(this.useridKey == bPacket.tuseridKey)
                // {
                //     updateState(bPacket.cmd);
                // }
                break;

            case 'muteOnTime':
                var bPacketArr = bPacket.msg.split(' ');
                var tnickname = bPacketArr[0];
                var muteTime = bPacketArr[1];
                if(!muteTime) muteTime = 1;
                printSystemMsg('system','<span>'+tnickname+'</span> 님이 <span>'+muteTime+'시간</span> 동안 벙어리 되었습니다.');
                if(this.userIdKey == bPacket.tuseridKey)
                {
                    updateState(bPacket.cmd);
                }
                break;

            case 'muteOff':
                printSystemMsg('system','<span>'+bPacket.tnickname+'</span> 님이 벙어리 해제 되었습니다.');
                // if(this.userIdKey == bPacket.tuseridKey)
                // {
                //     updateState(bPacket.cmd);
                // }
                break;

            case 'freezeOn':
                is_freeze = true;
                chatManager('freezeOn');
                break;

            case 'freezeOff':
                is_freeze = false;
                chatManager('freezeOff');
                break;

            case 'recomChatRoom':
                printSystemMsg('recom','<img src="'+level_images[bPacket.level]+'" width="30" height="30"> <strong><a href="#" class="uname nick" title="'+bPacket.nickname+'" rel="'+bPacket.userIdKey+'">'+bPacket.nickname+'</a></strong> 님이 대화방을 <img src="/assets/images/powerball/like.png" width="18" height="18" class="icon"/> <span>추천</span> 하였습니다.');
                chatRoom_recomCnt++;
                $('#chatRoom_recomCnt').html(chatRoom_recomCnt);
                break;

            case "powerball-pick":
                var real_msg = "";
                var message1 = new Array();
                var message2 = new Array(0);
                var pick_label1 = "";
                var pick_label2 = "";
                cur_bet = JSON.stringify(bPacket.result);
                var new_pick = {};
                new_pick =  {list:[{day_round : bPacket.round,today:bPacket.date,nnn:-1,betting_data:{content:cur_bet}}]};
                compileJson("#chat-pick-list-cur","#pick-"+bPacket.round,new_pick,1,false);
                $("#msgBox").append("<li><div class='pick-room-manager pick nnonn'>"+$("#pick-"+bPacket.round).find(".pick").html()+"</div></li>")
                for(var p  in bPacket.result){
                    var o_result = bPacket.result
                    if(p == "pb_oe" || p == "pb_uo")
                    {
                        pick_label1 = "파워볼";
                        if(p == "pb_oe"){
                            if(o_result[p].pick == 1) message1.push("홀");
                            else message1.push("짝");
                        }
                        else{
                            if(o_result[p].pick == 1) message1.push("언더");
                            else message1.push("오버");
                        }
                    }
                    else{
                        pick_label2 = "숫자합";
                        if(p == "nb_oe"){
                            if(o_result[p].pick == 1) message2.push("홀");
                            else message2.push("짝");
                        }
                        else if(p == "nb_uo"){
                            if(o_result[p].pick == 1) message2.push("언더");
                            else message2.push("오버");
                        }
                        else{
                            if(o_result[p].pick == 1) message2.push("소");
                            if(o_result[p].pick == 2) message2.push("중");
                            if(o_result[p].pick == 3) message2.push("대");
                        }
                    }
                }

                if(pick_label1.trim() !="")
                    $("#msgBox").append("<li><p class=\"msg-pick\"> 방장이 <span>"+bPacket.date+"-"+bPacket.round+"</span>회차 <span> ["+pick_label1+"] "+message1.join(" ")+"</span> 을 선택하셨습니다.</p></li>");
                if(pick_label2.trim() !="")
                    $("#msgBox").append("<li><p class=\"msg-pick\"> 방장이 <span>"+bPacket.date+"-"+bPacket.round+"</span>회차 <span> ["+pick_label2+"] "+message2.join(" ")+"</span> 을 선택하셨습니다.</p></li>");
                if(getCookie('chatRoomSoundOnOff') == 'on')
                {
                    $('#pickSound').jPlayer('play');
                }
                break;
            case 'powerballResult':

                printSystemMsg('powerballResult_'+bPacket.powerballOddEven,'<span>['+bPacket.date+'-'+bPacket.round+'회]</span> 파워볼 결과 [<span class="b">'+bPacket.powerball+'</span>][<span class="b">'+bPacket.powerballOddEvenMsg+'</span>][<span class="b">'+bPacket.powerballUnderOverMsg+'</span>]');
                printSystemMsg('powerballResult_'+bPacket.numberOddEven,'<span>['+bPacket.date+'-'+bPacket.round+'회]</span> 숫자합 결과 [<span class="b">'+bPacket.numberSum+'</span>][<span class="b">'+bPacket.numberOddEvenMsg+'</span>][<span class="b">'+bPacket.numberUnderOverMsg+'</span>][<span class="b">'+bPacket.numberPeriodMsg+'</span>]');

                // 픽 결과 갱신
                gameResultRefresh(bPacket);
                break;

            case 'powerballPointGraph':
                updatePointBetGraph(bPacket);
                break;

            case 'bettingWin':
                printSystemMsg('auto','<span>'+bPacket.nickList+'</span> 님이 <span>['+bPacket.date+'-'+bPacket.round+'회차] ['+bPacket.resultMsg+']</span> 맞추셨습니다.');
                break;

            case 'bettingWinner':
                var winnerType = '';
                if(bPacket.type == 'totalWinner')
                {
                    winnerType = '올킬 연승왕';
                }
                else if(bPacket.type == 'oddEvenWinner')
                {
                    winnerType = '홀/짝 연승왕';
                }
                else if(bPacket.type == 'startPointWinner')
                {
                    winnerType = '시작방향 연승왕';
                }
                else if(bPacket.type == 'ladderCntWinner')
                {
                    winnerType = '사다리수 연승왕';
                }

                if(bPacket.beforeNickname)
                {
                    printSystemMsg('auto','<span>'+bPacket.newNickname+'</span> 님이 <span>'+bPacket.beforeNickname+'</span> 님을 제치고 새로운 <span>'+winnerType+'</span> 에 등극 하셨습니다.');
                }
                else
                {
                    printSystemMsg('auto','<span>'+bPacket.newNickname+'</span> 님이 새로운 <span>'+winnerType+'</span> 에 등극 하셨습니다.');
                }
                printSystemMsg('macro','<span>'+winnerType+'</span> 보상으로 <span>'+bPacket.newNickname+'</span> 님에게 <span>10,000 포인트</span> 가 지급되었습니다.');
                break;

            case 'macro':
                printSystemMsg('macro',bPacket.message);
                break;

            case 'gift':
                if(JSON.parse(roomInfo).nickname == bPacket.tnickname)
                {
                    printItemMsg(bPacket.type,bPacket.cnt,bPacket.nickname,bPacket.tnickname);
                    var totalBulletCnt = parseInt($('#totalBulletCnt').attr('rel')) + parseInt(bPacket.cnt);
                    $('#totalBulletCnt').attr('rel',totalBulletCnt).html(totalBulletCnt);
                    if(JSON.parse(roomInfo).useridKey == userIdKey){
                      bullet +=parseInt(bPacket.cnt);
                      opener.updateBullet(bullet)
                    }
                }
                break;

            case 'userPick':
                userPick(bPacket.pickDate,bPacket.pickRound);
                break;

            case 'call':
                if(getCookie('chatRoomSoundOnOff') == 'on')
                {
                    $('#callSound').jPlayer('play');
                }
                break;
        }
    }

    else if(hPacket.type == 'MSG')
    {
        printChatMsg(bPacket.userType,bPacket.level,bPacket.sex,bPacket.mark,bPacket.id,bPacket.nickname,bPacket.msg,bPacket.item);
    }
    else if(hPacket.type == 'WHISPER')
    {
        printWhisperChatMsg(bPacket.userType,bPacket.level,bPacket.sex,bPacket.mark,bPacket.useridKey,bPacket.nickname,bPacket.msg,bPacket.tnickname,bPacket.item);
    }
    else if(hPacket.type == 'MEMO')
    {
        parent.memoNoti(bPacket.memoid);
    }
    else if(hPacket.type == 'NOTICE')
    {
        switch(bPacket.type)
        {
            case 'AUTHKEY_NOTMATCHED':
                printSystemMsg('system','패킷 암호화 오류입니다. 다시 로그인 하시기 바랍니다.');
                break;

            case 'ACCESS_DENIED':
                printSystemMsg('system','접근 권한이 없습니다.');
                socket.disconnect();
                document.location.href = '/?view=chatStateMsg&type=accessDenied';
                break;

            case 'DISCONNECTED':
                printSystemMsg('guide','접속이 끊어졌습니다. 재접속 해주시기 바랍니다.');
                break;

            case 'MUTEMSG':
                printSystemMsg('guide','회원님은 벙어리 상태입니다.');
                break;

            case 'BAN':
                printSystemMsg('guide','운영자에 의해 강제 퇴장 되었습니다.');
                break;

            case 'BANIPON':
                printSystemMsg('guide','운영자에 의해 접속이 차단 되었습니다.');
                socket.disconnect();
                break;

            case 'BANIPOFF':
                printSystemMsg('guide','운영자에 의해 접속 차단이 해제 되었습니다.');
                break;

            case 'BANIPMSG':
                printSystemMsg('guide','접속이 차단되어 접속할 수 없습니다.');
                socket.disconnect();
                document.location.href = '/?view=chatStateMsg&type=banIp';
                break;

            case 'KICKON':
                location.href = './';
                break;

            case 'FREEZEMSG':
                printSystemMsg('guide','채팅창을 녹이기 전까지 채팅 입력이 제한됩니다.');
                break;

            case 'FREEZEON':
                is_freeze = true;
                chatManager('freezeOn');
                break;

            case 'FREEZEOFF':
                is_freeze = false;
                chatManager('freezeOff');
                break;

            case 'CLOSEROOM':
                printSystemMsg('notice','채팅방이 삭제되었습니다. 3초 후에 목록으로 이동합니다.');
                setTimeout(function(){
                    document.location.href = '/chat';
                },3000);
                break;

            case 'FORCECLOSEROOM':
                is_forceFreeze = true;
                $('#msgBox').html('');
                printSystemMsg('notice','운영자에 의해 채팅방이 삭제되었습니다. 3초 후에 목록으로 이동합니다.');
                setTimeout(function(){
                    document.location.href = './';
                },3000);
                break;

            case 'FORCECLEAR':
                $('#msgBox').html('');
                printSystemMsg('notice','운영자에 의해 채팅방이 청소 되었습니다.');
                if(bPacket.tuseridKey == this.useridKey)
                {
                    socket.disconnect();
                    document.location.href = '/?view=chatStateMsg&type=banIp';
                }
                break;

            case 'MODIFYROOM':
                printSystemMsg('notice','채팅방 정보가 변경되었습니다.');
                modifyRoomInfo(bPacket);
                break;
        }
    }
    else if(hPacket.type == 'ERROR')
    {
        switch(bPacket.type)
        {
            case 'INVALID_TOKEN':
                printSystemMsg('notice','[채팅방 입장하기] 버튼을 이용해서 접속하시기 바랍니다.');
                break;

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
                printSystemMsg('guide','채팅에 참여하려면 로그인이 필요합니다.');
                break;

            case 'BULLET_NEED':
                printSystemMsg('guide','당근이 부족합니다.');
                break;

            case 'BISCUIT_NEED':
                printSystemMsg('guide','건빵이 부족합니다.');
                break;
        }
    }
}

function updateState(type)
{
    var data = {
        cmd : 'updateState',
        type : type,
        useridKey : this.userIdKey
    };

    sendProcess('UPDATESTATE',data);
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
    else if(type == 'recom')
    {
        $('#msgBox').append('<li><p class="recom">'+msg+'</p></li>');
    }

    setScroll();
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
        $('#msgBox').append('<li><p class="msg-gift"><span>'+nickname+'</span> 님이 <span>'+tnickname+'</span> 님에게 <span>당근 '+cnt+'개</span>를 선물하셨습니다.</p></li>');
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

function printChatMsg(userType,level,sex,mark,useridKey,nickname,msg,item)
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
    var addMark = '';
    if(level == 30)
    {
        addClass = ' class="admin"';
    }
    else if(level == 29)
    {
        addClass = ' class="devadmin"';
    }

    if(userType == 1)
    {
        addClass = ' class="opener"';
        addMark = '<img src="/assets/images/powerball/mark_opener.gif" width="20" height="20"> ';
    }
    else if(userType == 2)
    {
        addClass = ' class="manager"';
        addMark = '<img src="/assets/images/powerball/mark_manager.gif" width="16" height="16"> ';
    }
    else if(userType == 3)
    {
        addClass = 'class="icon_managerFixMember"';
    }

    else if(userType == 4){
        addClass = ' class="fixMember"';
    }

    // emoticon
    msg = msg.replace(/\(#&([0-9]_[0-9]*)\)/gi,'<span class="emoticon e$1"></span>');

    $('#msgBox').append('<li'+addClass+'>'+addMark+'<img src="'+level_images[level]+'" width="30" height="30"> <strong><a href="#" class="uname nick" title="'+nickname+'" rel="'+useridKey+'">'+nickname+'</a></strong> '+msg+'</li>');

    addClass = null;

    setScroll();
}

function printWhisperChatMsg(userType,level,sex,mark,useridKey,nickname,msg,tnickname,item)
{
    var addClass = '';
    if(level == 30)
    {
        addClass = ' class="admin"';
    }
    else if(level == 29)
    {
        addClass = ' class="devadmin"';
    }

    $('#msgBox').append('<li'+addClass+'><img src="https://simg.powerballgame.co.kr/images/class/'+sex+level+'.gif" width="30" height="30"> <strong><a href="#" onclick="return false;" title="'+nickname+'" rel="'+useridKey+'" class="uname">'+nickname+'</a></strong> <span class="msg-whisper"><span class="whisperNick">귓['+tnickname+']</span></span> '+msg+'</li>');

    addClass = null;

    setScroll();
}

function fixMemberOnOff(type,useridKey)
{
    if(type == 'On')
    {
        if($('#u-'+useridKey).find('span').hasClass('icon_manager'))
        {
            $('#u-'+useridKey).find('span.icon_manager').removeClass('icon_manager').addClass('icon_managerFixMember');
        }
        else
        {
            $('#u-'+useridKey).find('.profile').addClass('mark');
            $('#u-'+useridKey).append('<span class="icon_fixMember">고정</span>');
        }
    }
    else if(type == 'Off')
    {
        if($('#u-'+useridKey).find('span').hasClass('icon_managerFixMember'))
        {
            $('#u-'+useridKey).find('span.icon_managerFixMember').removeClass('icon_managerFixMember').addClass('icon_manager');
        }
        else
        {
            $('#u-'+useridKey).find('.profile').removeClass('mark');
            $('#u-'+useridKey).find('.icon_fixMember').remove();
        }
    }
}

function managerOnOff(type,useridKey)
{
    if(type == 'On')
    {
        if($('#u-'+useridKey).find('span').hasClass('icon_fixMember'))
        {
            $('#u-'+useridKey).find('span.icon_fixMember').removeClass('icon_fixMember').addClass('icon_managerFixMember');
        }
        else
        {
            $('#u-'+useridKey).find('.profile').addClass('mark');
            $('#u-'+useridKey).append('<span class="icon_manager">매니저</span>');
        }

        var html = '<li id="u-'+useridKey+'">'+$('#u-'+useridKey).html()+'</li>';
        $('#u-'+useridKey).remove();
        $('#connectManagerList').append(html);
    }
    else if(type == 'Off')
    {
        if($('#u-'+useridKey).find('span').hasClass('icon_managerFixMember'))
        {
            $('#u-'+useridKey).find('span.icon_managerFixMember').removeClass('icon_managerFixMember').addClass('icon_fixMember');
        }
        else
        {
            $('#u-'+useridKey).find('.profile').removeClass('mark');
            $('#u-'+useridKey).find('.icon_manager').remove();
        }

        var html = '<li id="u-'+useridKey+'">'+$('#u-'+useridKey).html()+'</li>';
        $('#u-'+useridKey).remove();
        $('#connectUserList').append(html);
    }
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

function adminCmd(cmd,tuseridKey,tnickname)
{
    if(!is_admin && !is_manager)
    {
        printSystemMsg('guide','권한이 없습니다.');
        return false;
    }
    else
    {
        if((cmd == 'muteOn' || cmd == 'kickOn') && tnickname == JSON.parse(roomInfo).nickname)
        {
            printSystemMsg('guide','방장을 벙어리 또는 강퇴를 할 수 없습니다.');
            return false;
        }

        else if(cmd == 'freezeOn' || cmd == 'freezeOff')
        {
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/setFroze',
                data:{
                    cmd:cmd,
                    api_token:userIdToken,
                    roomIdx:roomIdx
                },
                success:function(data,textStatus){
                    if(data.status == 1)
                    {
                        var data = {
                            cmd : cmd,
                            roomIdx : roomIdx,
                            tuseridKey : tuseridKey,
                            tnickname : tnickname
                        };
                        sendProcess('ADMINCMD',data);
                    }
                    else
                    {
                        alertifyByCommon(data.msg);
                    }
                }
            });
        }
        else if(cmd == "closeRoom"){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/api/deleteChatRoom',
                data: {
                    cmd: cmd,
                    api_token: userIdToken,
                    roomIdx: roomIdx
                },
                success: function (data, textStatus) {
                    if (data.status == 1) {
                        var data = {
                            cmd: cmd,
                            roomIdx: roomIdx
                        };
                        sendProcess('ADMINCMD', data);
                    } else {
                        alertifyByCommon(data.msg)
                    }
                }
            });
        }
        else if(cmd == 'muteOn' || cmd == 'muteOff' || cmd == "kickOn" || cmd == "managerOn" || cmd == "managerOff"  || cmd == "fixMemberOn" || cmd == "fixMemberOff") {
            let url = "/api/setMute";
            if(cmd == "kickOn")
                url = "/api/kickUser"
            if(cmd == "managerOn" || cmd == "managerOff"){
                url = "/api/updateManage"
            }
            if(cmd == "fixMemberOn" || cmd == "fixMemberOff"){
                url = "/api/updateFixManage";
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: url,
                data: {
                    cmd: cmd,
                    api_token: userIdToken,
                    roomIdx: roomIdx,
                    tuseridKey : tuseridKey
                },
                success: function (data, textStatus) {
                    if (data.status == 1) {
                        var data = {
                            cmd: cmd,
                            roomIdx: roomIdx,
                            tuseridKey:tuseridKey
                        };
                        sendProcess('ADMINCMD', data);
                    } else {
                        alertifyByCommon(data.msg)
                    }
                }
            });
        }


        else
        {
            var data = {
                cmd : cmd,
                roomIdx : this.roomIdx,
                tuseridKey : tuseridKey,
                tnickname : tnickname
            };

            sendProcess('ADMINCMD',data);
        }
    }
}

function userCmd(cmd)
{
    var data = {
        cmd : cmd,
        roomIdx : this.roomIdx
    };

    sendProcess('USERCMD',data);
}

function pickCmd(pickDate,pickRound)
{
    if(!is_admin)
    {
        printSystemMsg('guide','권한이 없습니다.');
        return false;
    }
    else
    {
        var data = {
            cmd : 'userPick',
            roomIdx : this.roomIdx,
            pickDate : pickDate,
            pickRound : pickRound
        };

        sendProcess('ADMINCMD',data);
    }
}



// 비밀번호 갱신
function refreshPasswd()
{
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'./',
        data:{
            view:'action',
            action:'chatRoom',
            actionType:'refreshPasswd',
            roomIdx:roomIdx
        },
        success:function(data,textStatus){

            if(data.state == 'success')
            {
                $('#current_roomPasswd').text(data.code);
                $('#current_refreshPasswdCnt').text(data.refreshPasswdCnt);
            }
            else
            {
                alertifyByCommon(data.msg)
            }
        }
    });
}

// 채팅방 정보 변경
function modifyRoomInfo(data)
{
    roomInfo = JSON.parse(roomInfo);
    roomInfo.roomTitle = data.roomTitle;
    roomInfo.roomDesc = data.roomDesc;
    roomInfo.roomPublic = data.roomPublic;
    roomInfo = JSON.stringify(roomInfo);
    roomIdx = data.roomIdx;

    $('#roomTitle').html(data.roomTitle);
    $('#roomDesc').html(data.roomDesc);
}

// modal layer function
function modalLayerControl(type)
{
    if(type == 'kick')
    {
        var topPos = ($(window).height() - 300) / 2;
        var leftPos = ($(window).width() - 300) / 2;

        $('#modal_notice').css({'top':topPos+'px','left':leftPos+'px'});

        $('#modal_notice').find('.msg').html('방장으로부터 강제 퇴장 되었습니다.<br/>3초 후에 채팅방 대기실로 이동됩니다.');
        $('.modalLayer,#modal_notice').show();

        setTimeout(function(){
            location.href = '/chatRoom';
        },3000);
    }
}

function windowResize()
{
    var bodyHeight = $('body').height();
    var headerHeight = 72;
    var footerHeight = 25;
    var adHeight = $(".mainBanner").height() + 185;
    var inputHeight = 38 + 72;

        var msgBoxHeight = bodyHeight - adHeight;

    $('#msgBox').css('height',msgBoxHeight);
    $('.resultBox').css('height',msgBoxHeight+52);
}

function headlessChk(){
    var headlessYN = 'N';
    var headlessType = '';

    try{
        if(/HeadlessChrome/.test(window.navigator.userAgent)){
            headlessYN = 'Y';
            headlessType = 'userAgent';
        }

        if(navigator.plugins.length == 0){
            headlessYN = 'Y';
            headlessType = 'plugins';
        }

        if(navigator.languages == ''){
            headlessYN = 'Y';
            headlessType = 'languages';
        }

        if(navigator.webdriver){
            headlessYN = 'Y';
            headlessType = 'webdriver';
        }
    }
    catch(e){}

    if(headlessYN == 'Y')
    {
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/',
            data:{
                view:'action',
                action:'fp',
                actionType:'headless',
                headlessType:headlessType
            },
            success:function(data,textStatus){
            },
            error:function (xhr,textStatus,errorThrown){
                //alert('error'+(errorThrown?errorThrown:xhr.status));
            }
        });
    }
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
// get cookie

function sendMsg()
{
    if($('#msg').val().trim())
    {
        if(is_super == false && is_forceFreeze == true)
        {
            printSystemMsg('guide','채팅 입력이 제한됩니다.');
            return false;
        }

        if(is_super == false && is_admin == false && is_manager == false && is_freeze == true)
        {
            printSystemMsg('guide','채팅창을 녹이기 전까지 채팅 입력이 제한됩니다.');
            return false;
        }

        if(is_super == false && is_admin == false && is_manager == false && $('#u-'+JSON.parse(roomInfo).useridKey).length == 0)
        {
            printSystemMsg('guide','방장이 부재중이므로 채팅 입력이 제한됩니다.');
            return false;
        }

        // chat history set
        setChatHistory($('#msg').val().trim());

        if(is_super == false)
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
        if(is_super == false && $('#msg').val().substring(0,1) != '"' && $('#msg').val().substring(0,1) != '/')
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
        if(is_super == false && $('#msg').val().substring(0,1) != '"' && $('#msg').val().substring(0,1) != '/')
        {
            var normalCharPt = /[가-힣ㄱ-ㅎㅏ-ㅣ0-9'"\[\]{}!@#$%\^&*()<>\,\.\/?|\\~`\-_\=\+;:\s]/gi;
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

        if(is_super == false && is_admin == false && is_repeatChat == true)	// 도배 체크
        {
            var remindTime = msgStopTime - ((new Date().getTime() - lastMsgTime) / 1000);
            printSystemMsg('guide','[도배금지] ' + parseInt(remindTime) + '초간 채팅이 제한됩니다.');
            return false;
        }
        else if(is_super == false && is_admin == false && repeatChatFilter() == true)
        {
            return false;
        }

        if(is_super == false && $('#msg').val().length > 80)
        {
            printSystemMsg('guide','<span class="yellow">80자 이상</span> 은 입력할 수 없습니다.');
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
                case '얼리기':
                    adminCmd('freezeOn');
                    $('#msg').val('');
                    $('#msg').focus();
                    return;
                    break;

                case '녹이기':
                    adminCmd('freezeOff');
                    $('#msg').val('');
                    $('#msg').focus();
                    return;
                    break;

                case '방청소':
                    adminCmd('clear');
                    $('#msg').val('');
                    $('#msg').focus();
                    return;
                    break;

                case '설정':
                    $('#btn_chatRoomSetting').click();
                    $('#msg').val('');
                    $('#msg').focus();
                    return;
                    break;

                case '삭제':
                    $('#btn_chatRoomClose').click();
                    $('#msg').val('');
                    $('#msg').focus();
                    return;
                    break;

                case '강퇴':
                    cmd = 'kickOn';
                    break;

                case '강퇴해제':
                    cmd = 'kickOff';
                    break;

                case '벙어리':
                    cmd = 'muteOn';
                    break;

                case '벙어리해제':
                    cmd = 'muteOff';
                    break;
            }

            if(cmd == 'kickOn' || cmd == 'kickOff' || cmd == 'muteOn' || cmd == 'muteOff')
            {
                if($('#msg').val().indexOf(' ') == -1 || ($('#msg').val().indexOf(' ') != -1 && !$('#msg').val().substring($('#msg').val().indexOf(' ')+1)))
                {

                    alertifyByCommon("내용을 입력하세요.")
                    $('#msg').focus();
                    return false;
                }
            }

            var msg = $('#msg').val().substring($('#msg').val().indexOf(' ')+1);

            if(msg.substring(0,1) == '/')
            {
                msg = '';
            }

            if(cmd == 'kickOn' || cmd == 'kickOff' || cmd == 'muteOn' || cmd == 'muteOff')
            {
                adminCmd(cmd,'',msg);
            }
            else
            {
                var data = {
                    cmd : cmd,
                    roomIdx : this.roomIdx,
                    tnickname : tnick,
                    msg : msg
                };

                sendProcess('CMDMSG',data);
            }
        }
        else
        {
            // emoticon
            if(is_super == false && emoticonTicket == false)
            {
                var msg = $('#msg').val().replace(/\(#&([0-9]_[0-9]*)\)/gi,'');
            }
            else
            {
                var msg = $('#msg').val();
            }

            var data = {
                roomIdx : this.roomIdx,
                msg : msg
            };

            sendProcess('MSG',data);
        }
    }

    $('#msg').val('');
    $('#msg').focus();
}


function repeatChatFilter()
{
    var totalTime = 0;
    var curDate = new Date();

    msgTermArr[msgTermIdx % 8] = curDate.getTime() - lastMsgTime;
    lastMsgTime = curDate.getTime();
    msgTermIdx++;

    for(var i=0;i<msgTermArr.length;i++)
        totalTime += msgTermArr[i];

    if(msgTermArr.length == 8 && totalTime < 5 * 1000)
    {
        is_repeatChat = true;
        printSystemMsg('guide','[도배금지] ' + msgStopTime + '초간 채팅이 제한됩니다.');
        setTimeout(clearRepeatChat,msgStopTime * 1000);
        return true;
    }
    else
        return false;
}

function clearRepeatChat()
{
    msgTermIdx = 0;
    msgTermArr = new Array();
    is_repeatChat = false;
}

function gameResultRefresh(packet){
    var insert = {};
    var input  = new Array();
    var pb_oe = 1;
    var nb_oe = 1;
    var nb_uo = 1;
    var pb_uo = 1;
    var nb_size = 1;
    if(packet.numberOddEvenMsg == "짝")
        nb_oe = "0";
    if(packet.numberUnderOverMsg == "오버")
        nb_uo = "0";
    if(packet.powerballOddEvenMsg == "짝")
        pb_oe = "0";
    if(packet.powerballUnderOverMsg == "오버")
        pb_uo = "0";
    if(packet.numberPeriodMsg == "대")
        nb_size="3";
    if(packet.numberPeriodMsg == "중")
        nb_size="2";
    var pbWin = parseInt($(".powerballWinCnt").text());
    var pbLose = parseInt($(".powerballLoseCnt").text());
    var nbWin = parseInt($(".numberWinCnt").text());
    var nbLose = parseInt($(".numberLoseCnt").text());
    if(typeof cur_bet !="undefined" && cur_bet.trim() !=""){
        cur_bet = JSON.parse(cur_bet.replace(/&quot;/g,'"'));
        for(var index in cur_bet){
            if(index == "pb_oe")
                if(cur_bet["pb_oe"].pick == pb_oe.toString())
                {
                    cur_bet["pb_oe"].is_win= 1 ;
                    pbWin +=1;
                }
                else
                {
                    cur_bet["pb_oe"].is_win = 2;
                    pbLose +=1;
                }
            if(index == "pb_uo")
                if(cur_bet["pb_uo"].pick == pb_uo.toString())
                {
                    cur_bet["pb_uo"].is_win= 1 ;
                    pbWin +=1;
                }
                else
                {
                    cur_bet["pb_oe"].is_win = 2;
                    pbLose +=1;
                }

            if(index == "nb_oe")
                if(cur_bet["nb_oe"].pick == nb_oe.toString())
                {
                    cur_bet["nb_oe"].is_win= 1 ;
                    nbWin +=1;
                }
                else
                {
                    cur_bet["nb_oe"].is_win = 2;
                    nbLose +=1;
                }
            if(index == "nb_uo")
                if(cur_bet["nb_uo"].pick == nb_uo.toString())
                {
                    cur_bet["nb_uo"].is_win= 1 ;
                    nbWin +=1;
                }
                else
                {
                    cur_bet["nb_uo"].is_win = 2;
                    nbLose +=1;
                }
            if(index == "nb_size")
                if(cur_bet["nb_size"].pick == nb_size.toString())
                {
                    cur_bet["nb_size"].is_win= 1 ;
                    nbWin +=1;
                }
                else
                {
                    cur_bet["nb_size"].is_win = 2;
                    nbLose +=1;
                }
        }
        cur_bet = JSON.stringify(cur_bet)
        $(".totalWinCnt").text((pbWin+nbWin).toString())
        $(".totalLoseCnt").text((nbLose+pbLose).toString())
        $(".powerballWinCnt").text(pbWin.toString())
        $(".powerballLoseCnt").text(pbLose.toString())
        $(".numberWinCnt").text(nbWin.toString())
        $(".numberLoseCnt").text(nbLose.toString())
    }
    var month = (calcTime("+9").getMonth() + 1).toString();
    var date = calcTime("+9").getDate();
    insert = {day_round:packet.round,today:month+"월 "+date+"일",self:"1",pb_oe:pb_oe,pb_uo:pb_uo,nb_oe:nb_oe,nb_uo:nb_uo,nb_size:nb_size,betting_data:{content:cur_bet.replace(/&quot;/g,'"')}}
    input = {list:[insert]};
    compileJson("#chat-pick-list-cur","#pick-"+packet.round,input,1,false);
    cur_bet = "";
    next_round = parseInt(packet.round) + 1;
    input = {list: [{day_round:next_round,today:month+"월 "+date+"일",nnn:-1,betting_data:{content:cur_bet.replace(/&quot;/g,'"')}}] };
    compileJson("#chat-pick-list","#resultList",input,10,false);
    $('#resultList li').last().remove();
}


function chatManager(type,nick)
{
    if(type == 'clearChat')
    {
        if($('#msgBox').is(':hidden') == false)
        {
            $('#msgBox').html('');
            if(!is_admin && !is_manager)
                printSystemMsg('guide','채팅창을 지웠습니다.');
            else
                sendProcess('refreshMsg',{roomIdx:roomIdx})
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
        windowOpen('/?view=memo&type=write&receiveName='+nick,'memo',600,600,'auto');
    }
    else if(type == 'freezeOn')
    {
        printSystemMsg('system','방장이 채팅창을 얼렸습니다.');
    }
    else if(type == 'freezeOff')
    {
        printSystemMsg('system','방장이 채팅창을 녹였습니다.');
    }
    else if(type == 'friendList')
    {
        if(confirm('['+nick+']님을 친구 추가하시겠습니까?'))
        {
            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/',
                data:{
                    view:'action',
                    action:'member',
                    actionType:'friendList',
                    nickname:nick
                },
                success:function(data,textStatus){
                    if(data.state == 'success')
                    {
                        alertifyByCommon('['+data.friendNickname+']님을 친구 추가했습니다.')
                    }
                    else
                    {
                        alertifyByCommon(data.msg);
                    }
                },
                error:function (xhr,textStatus,errorThrown){
                    alertifyByCommon('error'+(errorThrown?errorThrown:xhr.status));
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
                url:'/',
                data:{
                    view:'action',
                    action:'member',
                    actionType:'blackList',
                    nickname:nick
                },
                success:function(data,textStatus){
                    if(data.state == 'success')
                    {
                        blackListArr.push(data.blackUseridKey);
                        alertifyByCommon('['+data.blackNickname+']님을 블랙리스트에 추가했습니다.');
                    }
                    else
                    {
                        alertifyByCommon(data.msg);
                    }
                }
            });
        }
    }
}

function modifyRoom()
{
    var roomTitle = $('#current_roomTitle').val();
    var roomDesc = $('#current_roomDesc').val();
    var roomPublic = $('#current_roomPublic').val();

    if(!roomTitle.trim().length)
    {
        alertifyByCommon('채팅방 제목을 입력하세요.');
        $("#current_roomTitle").focus();
        return false;
    }

    var filterWordArr = '스코어게임,scoregame,abcgame,abc게임,에이비씨게임,자지,보지,스게,개새,개세,개자식,뉘미럴,니귀미,니기미,개년,18놈,새끼,니미,뉘미,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,좀물,좁년,지랄,지롤,지럴,퍽큐,뻑큐,빠큐,.com,.co.kr,.kr,토크온,슈어맨,엔트리'.split(',');

    for(i=0;i<filterWordArr.length;i++)
    {
        if(roomTitle.toLowerCase().indexOf(filterWordArr[i]) != -1)
        {
            alertifyByCommon('방제목에 금지어 ['+ filterWordArr[i] +'] 가 포함되어 있습니다.');
            return false;
        }
    }

    for(i=0;i<filterWordArr.length;i++)
    {
        if(roomDesc.toLowerCase().indexOf(filterWordArr[i]) != -1)
        {
            alertifyByCommon('설명에 금지어 ['+ filterWordArr[i] +'] 가 포함되어 있습니다.');
            return false;
        }
    }
    if(roomPublic == "1")
        roomPublic = "public";
    else
        roomPublic = "premium";
    var data = {
        cmd : 'modifyRoom',
        roomIdx : roomIdx,
        roomTitle : roomTitle,
        roomDesc : roomDesc,
        roomPublic : roomPublic,
        api_token:userIdToken
    };

    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/modifyRoom',
        data:data,
        success:function(data,textStatus){
            if(data.status == 1){
                sendProcess('ADMINCMD',data);
            }
            else
                alertifyByCommon(data.msg)
        }
    });

    sendProcess('ADMINCMD',data);

    return true;
}


function giftManager(type,tuseridKey,cnt)
{
    var data = {
        cmd : 'gift',
        type : type,
        roomIdx : roomIdx,
        tuseridKey : tuseridKey,
        cnt : cnt
    };

    sendProcess('GIFT',data);
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
            eval(setUserLayer(target.attr('rel'),target.attr('title'),e,target.offset().left));

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
            eval(setUserLayer(target.parent().attr('rel'),target.parent().attr('title'),e,target.offset().left));

        }
        e.stopPropagation();
    }
}

// user layer set
function setUserLayer(useridKey,nickname,e,left)
{
    var str = '';

    if(this.userIdKey != useridKey)
    {
        str += '<ul>';

        if(roomIdx != 'lobby' && is_admin && useridKey != JSON.parse(roomInfo).useridKey)
        {
            str += '<li><a href="#" onclick="adminCmd(\'fixMemberOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">고정멤버임명</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'fixMemberOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">고정멤버해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'managerOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">매니저임명</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'managerOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">매니저해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'muteOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'muteOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리 해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'kickOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴</span></a></li>';
        }
        else if(roomIdx != 'lobby' && is_manager  && useridKey != JSON.parse(roomInfo).useridKey)
        {
            str += '<li><a href="#" onclick="adminCmd(\'muteOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'muteOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">벙어리 해제</span></a></li>';
            str += '<li><a href="#" onclick="adminCmd(\'kickOn\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴</span></a></li>';
            // str += '<li><a href="#" onclick="adminCmd(\'kickOff\',\''+useridKey+'\',\''+nickname+'\');return false;"><em class="ico"></em><span class="txt">강퇴 해제</span></a></li>';
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

                $('#userLayer').css({'left':left + 10,'top':layerTop});
                $('#userLayer').show();
            }
        }
    });
}
