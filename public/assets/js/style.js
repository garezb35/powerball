$(document).ready(function (){
    $(".gnb").find("a").click(function (){
        $(".gnb").find("a").removeClass("on");
        $(this).addClass("on");
    })

    $("#boardmenu li").click(function(){
        let $iframe = $('#mainFrame');
        let url = "";
        if($(this).find("a").hasClass("active")){
            url = "";
            if($(this).find("a").attr("id") == "humor-tab"){
                url = "/board?board_type=none&board_category=humor"
            }
            if($(this).find("a").attr("id") == "photo-tab"){
                url = "/board?board_type=none&board_category=photo"
            }
            if($(this).find("a").attr("id") == "pick-tab"){
                url = "/board?board_type=none&board_category=pick"
            }
            if($(this).find("a").attr("id") == "free-tab"){
                url = "/board?board_type=none&board_category=free"
            }

            if(url != ""){
                $iframe.attr("src",url);
            }
        }
    })
});

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
function memoSend(tuserid,memoid)
{
    document.getElementById('chatFrame').contentWindow.memoSend(tuserid);
}

function memoNoti()
{
    let mail_count = parseInt($("#mail-count").text());
    mail_count +=1;
    $("#mail-count").text(mail_count);
    $("#mail-count").show();
}
