
function toggleBetting()
{
    if($('#betBox').css('display') == 'block')
    {
        $('#betBox').hide();
        $('.bettingBtn a').text('픽 열기');
    }
    else
    {
        $('#betBox').show();
        $('.bettingBtn a').text('픽 닫기');
    }
}

function toggleMiniView()
{
    if($('#ladderResultBox').css('display') == 'block')
    {
        $('#ladderResultBox').hide();
        $('.miniViewBtn a').text('미니뷰 열기');

        try{
            miniViewControl('close');
        }
        catch(e){}
    }
    else
    {

        $('#ladderResultBox').show();
        $('.miniViewBtn a').text('미니뷰 닫기');

        try{
            miniViewControl('open');
        }
        catch(e){}
    }
}
function miniViewControl(type)
{
    if(type == 'open')
    {
        $('#powerballMiniViewDiv #miniViewFrame').css('height','502px');
    }
    else if(type == 'close')
    {
        $('#powerballMiniViewDiv #miniViewFrame').css('height','117px');
    }
}

function resetPowerballBetting()
{
    var fn = document.bettingForm;
    fn.reset();

    $('#powerballOddEven').val('');
    $('#numberOddEven').val('');
    $('#powerballUnderOver').val('');
    $('#numberUnderOver').val('');
    $('#numberPeriod').val('');

    $('#betBox .pick-btn').each(function(){
        $(this).removeClass('on');
    });
}

function resetSpeedkenoBetting()
{
    var fn = document.bettingForm;
    fn.reset();

    $('#numberSumOddEven').val('');
    $('#numberMinOddEven').val('');
    $('#numberMaxOddEven').val('');
    $('#underOver').val('');

    $('#speedkenoBetBox .pick-btn').each(function(){
        $(this).removeClass('on');
    });
}
function speedkenoBetting()
{
    var fn = document.forms.bettingForm;

    if(!fn.numberSumOddEven.value && !fn.underOver.value)
    {
        //alert('두개 중 한개 이상을 선택하세요.');
        goErrorPopup('두개 중 한개 이상을 선택하세요.');
        return false;
    }
    if(speedkeno_remain < 60){
        goErrorPopup('마감 1분전에만 참여 가능합니다.');
        return false;
    }

    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/processBet',
        data:$('#bettingForm').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data,textStatus){
            if(data.status == 1)
            {
                goErrorPopup(data.message);
                document.location.reload();
            }
            else
            {
                goErrorPopup(data.message);
                // if(data.msg == 'CAPTCHA')
                // {
                //     $('#betBox').hide();
                //     $('#captchaBox').show();
                //     $('#captchaImg').html('<img src="/captcha.php?type=pointBet&time='+new Date().getTime()+'">');
                // }
                // else
                // {
                //     alert(data.msg);
                //     modalMsg(data.msg);
                // }
            }
        }
    }).fail(function(xhr, status, error) {
        if(xhr.status == "401"){
            goErrorPopup("로그인후 참여 가능한 서비스입니다.");
        }
    });

}

function powerballBetting(in_room = -1)
{
    var fn = document.forms.bettingForm;

    if(!fn.powerballOddEven.value && !fn.numberOddEven.value && !fn.powerballUnderOver.value && !fn.numberUnderOver.value && !fn.numberPeriod.value)
    {
        goErrorPopup('다섯개 중 한개 이상을 선택하세요.');
        return false;
    }
    if(powerball_remain < 60){
        goErrorPopup('마감 1분전에만 참여 가능합니다.');
        return false;
    }
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/processBet',
        data:$('#bettingForm').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data,textStatus){
            if(data.status == 1)
            {
                goErrorPopup(data.message);
                if(data.room == 1)
                    document.location.reload()
                else
                {
                    if(typeof socket !="undefined" && socket !=null)
                        sendProcess("ADMINCMD",data.picks)
                    resetPowerballBetting()
                    $('.sm-message').modal('hide')
                    $('#betBox').slideToggle('fast')
                    $("#btn_pointBet").parent().css("background","#00b4b4")
                    $("#btn_pointBet").text("픽 열기")
                    setScroll();
                }
            }
            else
            {
                goErrorPopup(data.message);
                // if(data.msg == 'CAPTCHA')
                // {
                //     $('#betBox').hide();
                //     $('#captchaBox').show();
                //     $('#captchaImg').html('<img src="/captcha.php?type=pointBet&time='+new Date().getTime()+'">');
                // }
                // else
                // {
                //     alert(data.msg);
                //     modalMsg(data.msg);
                // }
            }
        }
    }).fail(function(xhr, status, error) {
        if(xhr.status == "401"){
            goErrorPopup("로그인후 참여 가능한 서비스입니다.");
        }
    });

}
$(document).ready(function (){
    $('#betBox .pick-btn').click(function(){

        var type = $(this).attr('type');
        var val = $(this).attr('val');
        var totalPoint = 0;

        $('#betBox .pick-btn').each(function(){
            if($(this).attr('type') == type)
            {
                $(this).removeClass('on');
            }
        });

        $(this).addClass('on');
        $('#betBox .pick-btn').each(function(){

            if($(this).attr('type') == 'powerballOddEven' || $(this).attr('type') == 'numberOddEven' || $(this).attr('type') == 'powerballUnderOver' || $(this).attr('type') == 'numberUnderOver' || $(this).attr('type') == 'numberPeriod')
            {
                if($(this).hasClass('on'))
                {
                    $('#'+$(this).attr('type')).val($(this).attr('val'));
                }
            }
            else if($(this).attr('type') == 'powerballOddEvenP' || $(this).attr('type') == 'numberOddEvenP' || $(this).attr('type') == 'powerballUnderOverP' || $(this).attr('type') == 'numberUnderOverP' || $(this).attr('type') == 'numberPeriodP')
            {
                if($(this).hasClass('on'))
                {
                    // totalPoint += parseInt($(this).attr('val'));
                    $('#point_'+$(this).attr('type')).val(parseInt($(this).attr('val')));
                }
            }
        });
    });

    $('#speedkenoBetBox .pick-btn').click(function(){

        var type = $(this).attr('type');
        var val = $(this).attr('val');

        $('#speedkenoBetBox .pick-btn').each(function(){
            if($(this).attr('type') == type)
            {
                $(this).removeClass('on');
            }
        });

        $(this).addClass('on');

        $('#speedkenoBetBox .pick-btn').each(function(){

            if($(this).attr('type') == 'numberSumOddEven' || $(this).attr('type') == 'underOver')
            {
                if($(this).hasClass('on'))
                {
                    $('#'+$(this).attr('type')).val($(this).attr('val'));
                }
            }
        });
    });
    if(pick_type !=undefined && pick_type==1){
        $.ajax({
            type: "get",
            url: "/api/synctime"
        }).done(function(data) {
            if(data > 0){
                powerball_remain = getRemainTime(data);
                setInterval(function(){
                    powerTimer(300);
                },1000);
            }
        })
    }

    if(pick_type !=undefined && pick_type==2)
    {
        $.ajax({
            type: "get",
            url: "/api/synctime"
        }).done(function(data) {
            if(data > 0){
                speedkeno_remain = getRemainTime(data,0);
                setInterval(function(){
                    speedTimer(300);
                },1000);
            }
        })
    }
});
