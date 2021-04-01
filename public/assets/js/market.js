$(document).ready(function(){
    var isClick = false;
    $('.amountSet > span').click(function(){
        var type = $(this).attr('class');
        var limitCnt = $(this).parent().find('input').attr('limit');
        var cnt = Number($(this).parent().find('input').attr('rel'));
        var rel = $(this).attr('rel');
        if(cnt >= limitCnt && type == 'up')
        {
            if(rel == "item")
                var message = "해당 상품의 보유 수량은 ["+limitCnt+"개] 입니다.";
            else
                var message = '해당 상품의 1회 최대구매 수량은 ['+limitCnt+'개] 입니다.';
            alert(message);
        }
        else if(cnt == 1 && type == 'down')
        {
            return false;
        }
        else
        {
            if(type == 'up')
            {
                $(this).parent().find('input').attr('rel',cnt+1);
                $(this).parent().find('input').val((cnt+1)+'개');
            }
            else if(type == 'down')
            {
                $(this).parent().find('input').attr('rel',cnt-1);
                $(this).parent().find('input').val((cnt-1)+'개');
            }
        }
    });

    $('.btn_use').click(function(){

        var itemCode = $(this).attr('itemCode');
        var itemName = $(this).attr('title');
        var itemCnt = Number($(this).parent().prev('.amountSet').find('input').attr('rel'));
        var period = $(this).attr('period');

        if(itemCode == 'NOTE_ITEM_100')
        {
            alert('쪽지 아이템은 쪽지 발송시 사용 가능합니다.\n쪽지 메뉴를 이용하세요.');
            return false;
        }
        else if(itemCode == 'RANDOM_NOTE')
        {
            alert('랜덤 쪽지는 랜덤 쪽지 발송시 사용 가능합니다.\n쪽지 메뉴를 이용하세요.');
            return false;
        }
        else if(itemCode == 'CHATROOM' || itemCode == "CHATROOM_20")
        {
            alert('채팅방 개설권은 채팅방 개설시 사용 가능합니다.');
            return false;
        }
        else if(itemCode == 'PREMIUM_CHATROOM' || itemCode == "PREMIUM_CHATROOM_20")
        {
            alert('프리미엄 채팅방 개설권은 프리미엄 채팅방 개설시 사용 가능합니다.');
            return false;
        }
        else if(period == 0){
            switch (itemCode){
                case "WORD_TODAY":
                    if(confirm("이 아이템은  오늘의 한마디 이용권 변경시 사용 가능합니다.\n 해당 페지로 가시겠습니까?")){
                        location.href="/member?action=word_today";
                        return false;
                    }
                    break;
                case "NICKNAME_RIGHT":
                    if(confirm("이 아이템은  닉네임 변경시 사용 가능합니다.\n 해당 페지로 가시겠습니까?")){
                        location.href="/member?action=nickname";
                        return false;
                    }
                    break;
                case "PROFILE_IMAGE_RIGHT":
                    if(confirm("이 아이템은  프로필 이미지 변경시 사용 가능합니다.\n 해당 페지로 가시겠습니까?")){
                        location.href="/member?action=profile";
                        return false;
                    }
                    break;
                default:
                    break;
            }
        }
        if(itemCnt > 1)
        {
            alert(itemName + '은(는) 1개씩만 사용 가능합니다.');
            return false;
        }

        if(confirm('['+itemName+'] 아이템 ['+itemCnt+'개]를 사용하시겠습니까?\n\n한번 사용한 아이템은 복구가 불가능합니다.'))
        {
            $.ajax({
                type:'POST',
                url:'/api/useItem',
                data:{
                    api_token:$("#api_token").val(),
                    code: itemCode,
                    count:itemCnt
                },
                dataType:'json',
                success:function (data){
                    if(data.status ==1){
                        alert("아이템 사용이 정상적으로 처리되었습니다.");
                        return;
                    }
                    if(data.status ==0){
                        switch (data.code){
                            case 20:
                                alert(itemName + '은(는) 1개씩만 사용 가능합니다.');
                                break;
                            case 19:
                                alert("구매하신 아이템이 존재하지 않습니다.");
                                break;
                            case 18:
                                alert("이미 사용중인 아이템이 존재합니다.");
                                break;
                            case 17:
                                alert("해당 아이템은 사용하려는 페지에서 직접 이용해주시기 바랍니다.")
                                break;
                            case 16:
                                alert("보유한 아이템 수량이 부족합니다.");
                                break;
                            default:
                                break;
                        }
                    }
                }
            })
        }
        else
        {
            return false;
        }
    });

    $('.btn_buy').click(function(){

        var itemCode = $(this).attr('itemCode');
        var itemName = $(this).attr('title').trim();
        var itemCnt = Number($(this).parent().prev('.amountSet').find('input').attr('rel'));

        if(confirm('['+itemName+'] 아이템을 구매하시겠습니까?'))
        {
            if(!isClick){
                $.ajax({
                    type: "POST",
                    url: "/api/buyItem",
                    data:{api_token:$("#api_token").val(),count:itemCnt,code:itemCode},
                    dataType:"json",
                    beforeSend:function(){isClick = true;}
                }).done(function(data) {
                    isClick = false;
                    if(data.status ==1){
                        alert("성공적으로 구매하였습니다.");
                    }
                    if(data.status ==0 && data.code== 0){
                        if(confirm('코인이 부족합니다.\n코인 충전 페이지로 이동하시겠습니까?'))
                        {
                            location.href = '';
                        }
                        return false;
                    }
                    else if(data.code > 0){
                        alert(data.message);
                    }

                }).fail(function(xhr){
                    console.log(xhr);
                });
            }
        }
        else
        {
            return false;
        }
    });

})

function countChk(obj)
{
    var countVal = $(obj).val();

    // 숫자만 가능
    countVal = countVal.replace(/[^0-9]*/gi,'');

    var limitCnt = $(obj).attr('limit');

    if(countVal < 1)
    {
        $(obj).attr('rel',1);
    }
    else if(Number(limitCnt) < Number(countVal))
    {
        alert('해당 상품의 1회 최대구매 수량은 ['+limitCnt+'개] 입니다.');
        $(obj).attr('rel',limitCnt);
    }
    else
    {
        $(obj).attr('rel',countVal);
    }

    $(obj).val($(obj).attr('rel')+'개');
}

