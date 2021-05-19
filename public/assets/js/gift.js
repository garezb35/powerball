
var isClick = false;

function giftBullet()
{
    if($('.btn .gift').hasClass('stop') == true)
    {
        return false;
    }

    var bulletCnt = 10;

    $('.bulletSelect input[type=radio]').each(function(idx){
        if($(this).prop('checked'))
        {
            if(idx == 4)
            {
                bulletCnt = $('#inputCnt').val();
            }
            else
            {
                bulletCnt = $(this).val();
            }
        }
    });

    var numRegexp = /[^0-9]/;

    if(!bulletCnt || bulletCnt <= 0)
    {
        alert('선물할 총알을 입력하세요.');
        $('#inputCnt').focus();
    }
    else if(numRegexp.test(bulletCnt))
    {
        alert('선물할 총알을 숫자로 입력하세요.');
        $('#inputCnt').focus();
    }
    else if(bulletCnt > parseInt(userBulletCnt))
    {
        if(confirm('보유한 총알이 부족합니다. 총알을 구매하시겠습니까?'))
        {
            opener.top.mainFrame.location.href = '/market';
        }
        else
        {
            return false;
        }
    }
    else
    {
        $('.btn .gift').addClass('stop').text('선물중');

        opener.giftManager('bullet',useridKey,bulletCnt);

        setTimeout(function(){
            self.close()
        },1000);
    }
}

$(document).ready(function(){

    try{
        top.initAd();
    }
    catch(e){}

    setTimeout(function(){
        heightResize();
    },500);

    $('.bulletSelect input[type=radio]').click(function(){
        if($(this).val() == 0)
        {
            $('#inputCnt').attr('disabled',false);
            $('#inputCnt').focus();
        }
        else
        {
            $('#inputCnt').attr('disabled',true);
        }
    });

});

$(window).resize(function(){
    heightResize();
});

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

function giftItem()
{
    if(!$('#targetNick').val())
    {
        alert('받는 회원 닉네임을 입력하세요.');
        $('#targetNick').focus();
        return false;
    }
    else if(userNick == $('#targetNick').val())
    {
        alert('자신에게는 선물할 수 없습니다.');
        return false;
    }
    else
    {
        if(isClick)
        {
            return false;
        }

        isClick = true;

        $.ajax({
            type:'POST',
            url:'/api/sendItem',
            data:{
                itemCode:itemCode,
                itemCnt:$('#itemCnt').attr('rel'),
                targetNick:$('#targetNick').val(),
                api_token : api_token
            },
            dataType:'json',
            success:function (data,textStatus){
                if(data.status == 1)
                {
                    alert(data.msg);
                    self.close();
                }
                else
                {
                    switch(data.code)
                    {
                        case 'NOTLOGIN':
                            alert(data.msg);
                            break;

                        case 'PERMISSION':
                            alert(data.msg);
                            break;

                        case 'NEEDBISCUIT':
                            alert('도토리가 부족합니다.\n\n도토리 획득 후 이용하시기 바랍니다.');
                            break;

                        case 'CHARGE':
                            if(confirm('코인이 부족합니다.\n\n코인 충전 페이지로 이동하시겠습니까?'))
                            {
                                chargePop();
                            }
                            break;

                        default:
                            alert(data.msg);
                            break;
                    }
                }

                isClick = false;

                return false;
            }
        });
    }
}

function chargePop()
{
    windowOpen('/member?type=charge','charge',500,770,'no');
}
