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

    $('#btn_joinMyChatRoom').click(function(){

        if(userIdToken == "")
        {
            alert('로그인 후 이용 가능합니다.');
            return;
        }
        else if(!is_connect)
        {
            alert('채팅서버에 접속되지 않았습니다.');
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
                    alert(data.msg);
                }
            }
        });

    });

    $(".enterBtn").click(function(){
        if(userIdToken == "")
        {
            alert('로그인 후 이용 가능합니다.');
            return;
        }
        else if(!is_connect)
        {
            alert('채팅서버에 접속되지 않았습니다.');
            return;
        }
        $r = $(this).attr("rel");
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
                    alert(data.msg);
                }
            }
        });
    })

    $(".create_room").click(function(){
        if($("#roomTitle").val().trim() == "")
        {
            alert("제목을 입력해주세요");
            $("#roomTitle").focus();
        }
        else{
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/api/createRoom',
                data: $("#form-room").serialize(),
                type: 'POST',
                dataType:"json",
                success: function ( data ) {
                    if(data.status ==0){
                        alert(data.msg);
                        return;
                    }
                    alert(data.msg);
                    sendProcess('CREATE',data.list);
                    $('#creatingWindow').modal('hide')
                },error:function(xhr){
                    console.log(xhr)
                }
            });
        }
        return false;
    })


});


function connect()
{
    try{
        if(socket == null)
        {
            socket = io.connect('http://cake6978.com:3000/room',socketOption);
        }
        sendProcess('login');
    }
    catch(e){
        alert(e);
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
                        document.location.href = '/chat?state=doubled_display';
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
