$(document).ready(function (){
    $(".gnb").find("a").click(function (){
        $(".gnb").find("a").removeClass("on");
        $(this).addClass("on");
    })
});

function openChatRoom()
{
    chatRoomPop = window.open('/chatRoom','chatRoom','width=500px,height=500px,status=no,scrollbars=no,toolbar=no');
}
