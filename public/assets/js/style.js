$(document).ready(function (){
    $(".gnb").find("a").click(function (){
        $(".gnb").find("a").removeClass("on");
        $(this).addClass("on");
    })
});

function openChatRoom()
{
    chatRoomPop = window.open('/chatRoom','chatRoom','width=1233px,height=565px,status=no,scrollbars=no,toolbar=no');
}
