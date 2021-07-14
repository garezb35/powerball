<html>
<head>
  <meta charset="UTF-8">
  <title>채팅방내용보기</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?=base_url_source()?>assets/css/chat-room.css">
  <link rel="stylesheet" href="<?=base_url_source()?>/assets/css/alertify.min.css">
  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.2/socket.io.js" ></script>
  <script src="<?=base_url_source()?>assets/js/alertify.min.js"></script>
</head>
<body>
  <div id="userLayer" style="display: none">
      <div class="lutop"><span id="unickname"></span></div>
      <div class="game"></div>
  </div>
  <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>채팅방내용</h1>
     </section>
     <section class="content">
        <div class="row">
           <div class="col-xs-12">
              <ul class="msgBox" id="msgBox" style="height: 522px;">

              </ul>
           </div>
        </div>
     </section>
  </div>
</body>
</hmtl>
<script>
var level_images = new Array()
var is_scroll_lock = false;
<?php if(!empty($profile)): ?>
var levels = '<?=$profile?>';
level_images = JSON.parse(levels.replace(/&quot;/g,'"'));
<?php endif; ?>
function receiveProcess(data)
{
    var hPacket = data.header;
    var bPacket = data.body;
    if(hPacket.type == "INIT"){
        $('#msgBox').empty();
        for(var i in bPacket.msgList)
        {
            var dataInfo = bPacket.msgList[i];
            printChatMsg(dataInfo.userType,dataInfo.level,dataInfo.sex,dataInfo.mark,dataInfo.id,dataInfo.nickname,dataInfo.msg,dataInfo.item,dataInfo.roomIdx);
        }

    }

    if(hPacket.type == 'MSG')
    {
        printChatMsg(bPacket.userType,bPacket.level,bPacket.sex,bPacket.mark,bPacket.id,bPacket.nickname,bPacket.msg,bPacket.item,bPacket.roomIdx);
    }
}
function printChatMsg(userType,level,sex,mark,useridKey,nickname,msg,item,roomIdx="")
{

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
        addClass ="admin";
    }
    else if(level == 29)
    {
        addClass = "devadmin";
    }

    if(userType == 1)
    {
        addClass = "opener";
        addMark = '<img src="<?=base_url_source()?>assets/images/powerball/mark_opener.gif" width="20" height="20"> ';
    }
    else if(userType == 2)
    {
        addClass = "manager";
        addMark = '<img src="<?=base_url_source()?>assets/images/powerball/mark_manager.gif" width="16" height="16"> ';
    }
    else if(userType == 3)
    {
        addClass = "icon_managerFixMember";
    }

    else if(userType == 4){
        addClass = "fixMember";
    }

    addClass = addClass + " " + roomIdx;

    var rel = 'data-room="'+roomIdx+'"';

    var chattype = "";
    if(roomIdx == "channel1")
      chattype = "(공개채팅)"
    // emoticon
    msg = msg.replace(/\(#&([0-9]_[0-9]*)\)/gi,'<span class="emoticon e$1"></span>');

    $('#msgBox').append('<li '+rel+' class="'+addClass+'" >'+addMark+'<img src="<?=base_url_source()?>'+level_images[level]+'" width="30" height="30"> '+chattype+' <strong><a '+rel+' href="#" class="uname nick" title="'+nickname+'" rel="'+useridKey+'">'+nickname+'</a></strong> '+msg+'</li>');

    addClass = null;

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
var socketOption = {};
socketOption['reconnect'] = true;
socketOption['force new connection'] = true;
socketOption['sync disconnect on unload'] = true;
var is_manager = false;
if('WebSocket' in window)
{
    socketOption['transports'] = ['websocket'];
}
var socket =  null;
var socket = io("<?=get_site_info()[0]->node_address?>/prefix",socketOption);

$(document).ready(function(){
  socket.on('receive',function(data){
      receiveProcess(data);
  });
  socket.emit('init',"<?=$roomIdx?>");
  $(document).on('click','a.uname',userLayerHandler);
  $(document).click(function(){
      $('#userLayer:visible').hide();
  });
})



function setUserLayer(useridKey,nickname,e,left,roomIdx)
{
    var str = '';
    str += '<ul>';

    if(roomIdx.length == 50)
    {
        str += '<li><a href="#" onclick="adminCmd(\'muteOn\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">벙어리</span></a></li>';
        str += '<li><a href="#" onclick="adminCmd(\'muteOff\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">벙어리 해제</span></a></li>';
        str += '<li><a href="#" onclick="adminCmd(\'kickOn\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">강퇴</span></a></li>';
        str += '<li><a href="#" onclick="adminCmd(\'closeRoom\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">채팅방 삭제하기</span></a></li>';
        str += '<li><a href="#" onclick="adminCmd(\'foreverstop\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">영구정지</span></a></li>';
    }

    if(roomIdx == "channel1"){
      str += '<li><a href="#" onclick="chatManager(\'muteOn\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">벙어리(5분)</span></a></li>';
      str += '<li><a href="#" onclick="chatManager(\'muteOnTime1\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">벙어리(1시간)</span></a></li>';
      str += '<li><a href="#" onclick="chatManager(\'muteOnTime\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">벙어리(영구)</span></a></li>';
      str += '<li><a href="#" onclick="chatManager(\'muteOff\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">벙어리해제</span></a></li>';
      str += '<li><a href="#" onclick="chatManager(\'banipOn\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">아이피차단</span></a></li>';
      str += '<li><a href="#" onclick="chatManager(\'banipOff\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">아이피차단해제</span></a></li>';
      str += '<li><a href="#" onclick="adminCmd(\'foreverstop\',\''+useridKey+'\',\''+nickname+'\',\''+roomIdx+'\');return false;"><em class="ico"></em><span class="txt">영구정지</span></a></li>';
    }

    str += '</ul>';
    $('#unickname').html(nickname);

    $('#userLayer .ubody').remove();
    if(str)
    {
        $('#userLayer').append('<div class="ubody">'+str+'</div>');
    }

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
function userLayerHandler(e)
{
    var target = $(e.target);
    eval(setUserLayer(target.attr('rel'),target.attr('title'),e,target.offset().left,target.data("room")));
    e.stopPropagation();
}

function adminCmd(cmd,tuseridKey,tnickname,roomIdx){
    url = "<?=base_url()?>/setConfig"
    var chats = $("."+roomIdx)
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {
            cmd: cmd,
            roomIdx: roomIdx,
            tuseridKey : tuseridKey
        },
        success: function (data, textStatus) {
            if (data.status == 1) {
                var socket_data = {
                    cmd: cmd,
                    roomIdx: roomIdx,
                    tuseridKey:tuseridKey
                };
                sendProcess('ADMINCMD', socket_data);
                if(cmd == "closeRoom"){
                    chats.remove()
                }
            } else {
                alertify.error(data.msg)
            }
        }
    });
}

function chatManager(cmd,tuseridKey,tnickname,roomIdx){
  url = "<?=base_url()?>/setConfig"
  $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url,
      data: {
          cmd: cmd,
          roomIdx: roomIdx,
          tuseridKey : tuseridKey
      },
      success: function (data, textStatus) {
          if (data.status == 1) {
              var socket_data = {
                  cmd: cmd,
                  roomIdx: roomIdx,
                  tuseridKey:tuseridKey,
                  bytime:data.bytime
              };
              sendProcess('ADMINCMD', socket_data);
          } else {
              alertify.error(data.msg)
          }
      }
  });
}


function sendProcess(type,data)
{
  var packet = {
      'header' : {
          'version' : '1.0',
          'type' : type
      },

      'body' : data
  };

  socket.emit('adminsend',packet);
}

</script>

<style>
li{
  list-style: none
}
</style>
