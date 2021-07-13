var socket = null;
var is_connect = false;
var browser_ws = browserWsChk();
var socketOption = {};
socketOption['reconnect'] = true;
socketOption['force new connection'] = true;
socketOption['sync disconnect on unload'] = true;
var room_connector = {};


if('WebSocket' in window)
{
    socketOption['transports'] = ['websocket'];
}
socketOption['query'] = 'roomIdx=lobby';
$(document).on('click','a.uname',userLayerHandler);

$(document).click(function(){
    $('#userLayer:visible').hide();
});
$(document).ready(function() {

    connect();
    socket.on('receive',function(data){
        receiveProcess(data);
    });

    socket.on('reconnect',function(){
        //printSystemMsg('guide','채팅서버와의 접속이 종료되었습니다. 3초 후에 재접속합니다.');
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

    windowResize();
    $("#modal_createChatRoom").hide();
    $('#btn_joinMyChatRoom').click(function(){

        if(userIdToken == "")
        {
            alertifyByCommon('로그인 후 이용 가능합니다')
            return;
        }
        else if(!is_connect)
        {
            alertifyByCommon('채팅서버에 접속되지 않았습니다.')
            return;
        }

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'./api/checkActiveRoom',
            data:{api_token:userIdToken},
            success:function(data,textStatus){
                if(data.status == '1')
                {
                    location.href = '/discussion?token='+data.token;
                }
                else
                {
                    if(typeof data.required_id != "undefined" && data.required_id !="")
                        sendProcess("refreshChat",data.required_id)
                    alertifyByCommon(data.msg)
                }
            }
        });

    });

    $(".enterBtn").click(function(){
        if(userIdToken == "")
        {
            alertifyByCommon("로그인 후 이용 가능합니다.")
            return;
        }
        else if(!is_connect)
        {
            alertifyByCommon("채팅서버에 접속되지 않았습니다.")
            return;
        }
        $r = $(this).attr("rel");
        $("#unique").val($r);
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'./api/checkActiveRoom',
            data:{api_token:userIdToken,room:$r},
            success:function(data,textStatus){
                if(data.status == '1')
                {
                    location.href = '/discussion?token='+data.token;
                }
                else
                {
                    if(data.reason == "security"){
                        $("#security_dialog").modal("show");
                        return;
                    }
                    alertifyByCommon(data.msg)

                }
            }
        });
    })

    $(".create_room").click(function(){
        if($("#roomTitle").val().trim() == "")
        {
            alertifyByCommon("제목을 입력해주세요")
            $("#roomTitle").focus();
            return false;
        }

        for(i=0;i<filterWordArr.length;i++)
        {
            if($("#roomTitle").val().trim().toLowerCase().indexOf(filterWordArr[i]) != -1)
            {
                alertifyByCommon('방제목에 금지어 ['+ filterWordArr[i] +'] 가 포함되어 있습니다.');
                return false;
            }
            if($("#roomDesc").val().trim().toLowerCase().indexOf(filterWordArr[i]) != -1)
            {
                alertifyByCommon('설명에 금지어 ['+ filterWordArr[i] +'] 가 포함되어 있습니다.');
                return false;
            }

        }
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/api/createRoom',
            data: $("#form-room").serialize(),
            type: 'POST',
            dataType:"json",
            success: function ( data ) {
                if(data.status ==0){
                    alertifyByCommon(data.msg)
                    return;
                }
                alertifyByCommon(data.msg)
                sendProcess('CREATE',data.list);
                $('#creatingWindow').modal('hide');
                location.href = '/discussion?token='+data.list.roomIdx;
            },error:function(xhr){
                console.log(xhr)
            }
        });
        return false;
    })

    $('#create_roomPublic').change(function(){

        var chkVal = $('#create_roomPublic option:selected').val();

        if(chkVal == 'private' && level < "09")
        {
            alertifyByCommon("비공개 채팅방 개설은 소위 계급 부터 가능합니다.")
            $(this).val('public');
            return false;
        }

        if(chkVal == 'private')
        {
            $('#modal_createChatRoom').show();
        }
        else
        {
            $('#modal_createChatRoom').hide();
        }
    });

    $('#btn_joinPasswd').click(function(e){

        var inputPasswd = $('#roomPasswd').val();

        if(inputPasswd.length != 4)
        {
            alertifyByCommon("4글자의 비밀번호를 입력하세요.")
            $('#roomPasswd').focus();
            return false;
        }

        var roomIdx = $("#unique").val();

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/verifyPass',
            data:{
                roomIdx:roomIdx,
                roomPasswd:inputPasswd,
                api_token:userIdToken
            },
            success:function(data){
                if(data.status == 1)
                {
                    $('#security_dialog').modal("hide");
                    location.href = '/discussion?token='+data.token;
                }
                else
                {
                    alertifyByCommon(data.msg)
                }
            }
        }).done(function(){
            $("#unique").val("");
        });
    });

});


function connect()
{
    try{
        if(socket == null)
        {
            socket = io.connect('http://203.109.14.130:3000/room',socketOption);
        }
        sendProcess('login');
    }
    catch(e){
        alertifyByCommon(e.message)
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

    if(hPacket.type == 'LOGIN')
    {
        switch(bPacket.cmd)
        {
            case 'ERROR':
                switch(bPacket.type)
                {
                    case 'DUPLICATE':
                        //printSystemMsg('guide','중복 로그인으로 인해 이전 접속을 종료합니다.');
                        socket.disconnect();
                        document.location.href = '/chat?state=doubled_display&logout='+bPacket.logout;
                        break;

                    case 'IPDUPLICATE':
                        //printSystemMsg('guide','동일 아이피에서 접속이 확인되어 이전 접속을 종료합니다.');
                        socket.disconnect();
                        document.location.href = '/?view=chatStateMsg&type=ipDuplicate';
                        break;
                }
                break;
            case 'LOGIN':
                if(bPacket.useridKey == this.useridKey)
                {
                    is_connect = true;
                }
                lobby_joinUser(bPacket,true);
                break;
        }
    }

    else if(hPacket.type == "INITMSG"){

        compileJson("#connected_list","#lobbyUser",bPacket.users,1,false);
        total_num = bPacket.users.length;
        $("#lobby_userCnt").html(number_format(total_num.toString()));
        is_connect = true;
        room_connector = bPacket.connector;
        for(var r in room_connector){
            $("#room-"+r).find(".curCnt").html(room_connector[r])
        }
    }

    else if(hPacket.type == "ListUser"){
        if(typeof bPacket.users != "undefined"){
            var ss = new Array()
            ss[0] = bPacket.users;
            compileJson("#connected_list","#lobbyUser",ss,2,false);
            total_num = total_num+1;
            $("#lobby_userCnt").html(number_format(total_num.toString()));
        }
    }

    else if(hPacket.type == "LeaveUserId")
    {
        total_num = total_num-1;
        if(total_num < 0)
            total_num = 1;
        $("#u-"+bPacket.userIdKey).remove();
        $("#lobby_userCnt").html(number_format(total_num.toString()));
    }

    else if(hPacket.type == 'NOTICE')
    {
        switch(bPacket.type)
        {
            case 'AUTHKEY_NOTMATCHED':
                //printSystemMsg('system','패킷 암호화 오류입니다. 다시 로그인 하시기 바랍니다.');
                alert('패킷 암호화 오류입니다. 다시 로그인 하시기 바랍니다.');
                break;

            case 'BANIPMSG':
                //printSystemMsg('guide','접속이 차단되어 접속할 수 없습니다.');
                socket.disconnect();
                document.location.href = '/?view=chatStateMsg&type=banIp';
                break;
        }
    }
    else if(hPacket.type == 'EXIT')
    {
        switch(bPacket.cmd)
        {
            case 'EXIT':
                if(bPacket.useridKey == this.useridKey)
                {
                    is_connect = false;
                }
                lobby_exitUser(bPacket);
                break;
        }
    }
    else if(hPacket.type == 'CREATE')
    {
        if(bPacket.useridKey == this.useridKey)
        {
            location.href = './?view=chatRoom&roomIdx='+bPacket.roomIdx;
        }
        else
        {
            if(category != 'favorite')
            {
                createChatRoomInfo(bPacket);
            }
        }
    }
    else if(hPacket.type == 'LOBBY')
    {
        switch(bPacket.cmd)
        {
            case 'REFRESHCHATROOMUSERCNT':
                refreshChatRoomUserCnt(bPacket.roomInfo);
                break;

            case 'REFRESHCHATROOMINFO':
                refreshChatRoomInfo(bPacket);
                break;

            case 'CHATROOMUSERCNT':
                chatRoomUserCnt(bPacket.data);
                break;

            /*
            case 'MODIFYCHATROOMUSERCNT':
                modifyChatRoomUserCnt(bPacket.roomInfo);
            break;
            */

            case 'CLOSEROOM':
                closeChatRoomInfo(bPacket);
                break;

            case 'FORCECLOSEROOM':
                closeChatRoomInfo(bPacket);
                break;

            case 'MODIFYROOM':
                modifyChatRoomInfo(bPacket.roomInfo);
                break;
        }
    }
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

function windowResize()
{
    var bodyHeight = $('body').height();
    var footerHeight = 25;
    var adHeight = 90;
    var marginHeight = 21;

    var roomListHeight = bodyHeight  - marginHeight - 73;

    $('#roomList').css('height',roomListHeight);
}
