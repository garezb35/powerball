$(document).ready(function(){
    $('.coinList li').click(function(){
        $('.coinList li').each(function(){
            $(this).find('img').removeClass('grayscale-off');
            $(this).removeClass('on');
        });

        $(this).find('img').addClass('grayscale-off');
        $(this).addClass('on');

        $('.coinInput').removeClass('on').find('img').removeClass('grayscale-off');

        var totalPrice = parseInt($(this).find('.price').attr('rel')) + parseInt($(this).find('.price').attr('rel')) * 0.1;
        var price_charge = parseInt($(this).find('.price').attr('rel'));
        var price_vat = parseInt($(this).find('.price').attr('rel')) * 0.1;

        $('#price').text(number_format(totalPrice.toString()));
        $('#price_charge').text(number_format(price_charge.toString()));
        $('#price_vat').text(number_format(price_vat.toString()));

        $('#chargeCoin').val($(this).find('.price').attr('rel'));
        $('#chargePrice').val(totalPrice);

        $('#chargeCoinInput').val('');
    });

    $('#chargeCoinInput').keyup(function(){

        $('.coinList li').find('.grayscale-off').removeClass('grayscale-off').parent().removeClass('on');
        $('.coinInput').addClass('on').find('img').addClass('grayscale-off');

        var totalPrice = parseInt($(this).val()) + parseInt($(this).val()) * 0.1;
        var price_charge = parseInt($(this).val());
        var price_vat = parseInt($(this).val()) * 0.1;

        if(isNaN(totalPrice))
        {
            totalPrice = '';
            $('#price').text(0);
            $('#price_charge').text(0);
            $('#price_vat').text(0);
        }
        else
        {
            $('#price').text(number_format(totalPrice.toString()));
            $('#price_charge').text(number_format(price_charge.toString()));
            $('#price_vat').text(number_format(price_vat.toString()));
        }

        $('#chargeCoin').val($(this).val());
        $('#chargePrice').val(totalPrice);
    });

    $('#chargeCoinInput').blur(function(){

        if($(this).val() % 10000 != 0)
        {
            alert('코인의 충전금액은 만원 단위로 입력 가능합니다.');
            $(this).val('');
            $(this).focus();
            $('#price').text(0);
            $('#price_charge').text(0);
            $('#price_vat').text(0);
            $('#chargeCoin').val(0);
            $('#chargePrice').val(0);
        }
    });

    $('.plusCoin').click(function(){

        $('.coinList li').find('.grayscale-off').removeClass('grayscale-off').parent().removeClass('on');
        $('.coinInput').addClass('on').find('img').addClass('grayscale-off');

        var currentPrice = isNaN(parseInt($('#chargeCoinInput').val()))?0:parseInt($('#chargeCoinInput').val());
        var plusPrice = parseInt($(this).attr('rel'));
        var inputPrice = 0;

        if($(this).attr('rel') != 0)
        {
            inputPrice = currentPrice + plusPrice;
        }

        $('#chargeCoinInput').val(inputPrice);

        var totalPrice = inputPrice + inputPrice * 0.1;
        var price_charge = inputPrice;
        var price_vat = inputPrice * 0.1;

        $('#price').text(number_format(totalPrice.toString()));
        $('#price_charge').text(number_format(price_charge.toString()));
        $('#price_vat').text(number_format(price_vat.toString()));

        $('#chargeCoin').val(inputPrice);
        $('#chargePrice').val(totalPrice);

        return false;
    });

    // smsYN
    $('#smsYN').click(function(){
        if($('#smsYN').is(':checked') == true)
        {
            $('#mobileNum').attr('disabled',false);
        }
        else
        {
            $('#mobileNum').attr('disabled',true);
        }
    });

    $('#accountNoticeDiv .layerPop .close,#accountNoticeDiv .btn_confirm,#accountNoticeDiv .btn_cancel').on({
        click:function(e){

            if($(this).hasClass('dayNotOpen'))
            {
                setCookie('pop_accountNotice','Y',1);
            }

            $('#accountNoticeDiv').hide();
        }
    });
});


function charge()
{
    var fn = document.forms.chargeForm;

    if(!fn.chargePrice.value)
    {
        alert('충전금액을 선택하세요.');
        return false;
    }
    else if(fn.chargeCoin.value % 10000 != 0)
    {
        alert('충전금액은 만원 단위로 가능합니다.');
        $('#chargeCoinInput').focus();
        return false;
    }
    else if(!fn.accountName.value)
    {
        alert('입금자 이름을 입력하세요.');
        fn.accountName.focus();
        return false;
    }
    else if(fn.smsYN.checked == true && !fn.mobileNum.value)
    {
        alert('입금정보 받을 휴대폰번호를 입력하세요.');
        fn.mobileNum.focus();
        return false;
    }
    else if(confirm('본 사이트는 배팅사이트가 아닙니다.\n\n입금신청 하시겠습니까?'))
    {
        fn.submit();
    }
}
