$(document).ready(function(){
    $('.box-level').find('li').mouseenter(function(){
        $(this).find('.text').show().closest('li').siblings().find('.text').hide();
    });
    $('.box-level').mouseleave(function(){
        $(this).find('li.on').find('.text').show().closest('li').siblings().find(".text").hide();
    });
});
function calPrice()
{
    var fn = document.forms.exchangeForm;
    var price = (Math.round((fn.bullet.value * '70')/10)*10) - (Math.floor((fn.bullet.value * '70' * 0.033)/10) * 10);
    $('#price').text(number_format(price.toString()));
    $('#priceDesc').text('[ 당근 환산액 '+number_format((Math.round((fn.bullet.value*'70')/10)*10).toString())+'원('+number_format(fn.bullet.value)+' * 70) - 원천징수세액 '+number_format((Math.floor(fn.bullet.value*'70'*0.033/10)*10).toString())+'원('+number_format((fn.bullet.value*'70').toString())+' * 0.033) ]');
}

function oknamePop()
{
    var width = 430;
    var height = 590;
    var scroll = 'yes';

    var wid = (screen.availWidth - width) / 2;
    var hei = (screen.availHeight - height) / 2;
    var opt = 'width='+width+',height='+height+',top='+hei+',left='+wid+',resizable=no,status=no,scrollbars='+scroll;
    window.open('/okname/phone_exchange.php','authPop',opt);
}
