
//<![CDATA[

var $calendar;
$(document).ready(function(){
    $('body').on('click','.choice',function(){
        $('.choice').css('background-color','#fff');
        $('.choice').css('border-color','#BEE0FA');
        $('.choice').css('color','#000');
        $(this).css('background-color','#00b4b4');
        $(this).css('border-color','#127CCB');
        $(this).css('color','#FFF');
        $('#selectNumber').val($(this).text());
    });

    $('body').on('mouseover','.submit',function(){
        $(this).css('background-color','#00b4b4');
        $(this).css('border-color','#00b4b4');
        $(this).css('color','#fff');
    });

    $('body').on('mouseleave','.submit',function(){
        $(this).css('background-color','#8ee2e2');
        $(this).css('border-color','#8ee2e2');
        $(this).css('color','#000');
    });

    $('body').on('click','.submit',function(){
        var fn = document.forms.attendanceForm;
        if(!fn.selectNumber.value)
        {
            alert('사다리 숫자를 선택해주세요.');
            return false;
        }
        else if(!fn.comment.value)
        {
            alert('출석 코멘트를 입력해주세요.');
            fn.comment.focus();
            return false;
        }
        else
        {
            var params = $('#attendanceForm').serialize();
            $.ajax({
                url:'/api/setPresent',
                type:'POST',
                data:params,
                dataType:'json',
                success:function(data)
                {
                    if(data.status == 1)
                    {
                        $('.contentArea').hide();
                        $('#ladderResult').html('<img src="https://simg.powerballgame.co.kr/images/ladder'+data.selectNumber+'-'+data.number+'.gif">');
                        setTimeout(function(){
                            if(data.ladderResult == 'win')
                            {
                                alert('축하합니다. 당첨되어 [랜덤아이템상자]가 지급되었습니다. 아이템 메뉴에서 확인하세요!');
                            }
                            else
                            {
                                alert('꽝입니다. 다음에 이용해주세요~');
                            }

                            location.reload();

                        },3000);
                    }
                    else
                    {
                        alert(data.msg);
                    }
                }
            });
        }
    });

    let container = $(".calendarBox").simpleCalendar({
        cur_date:new Date(y, m-1, d),
        fixedStartDay: 0, // begin weeks by sunday
        disableEmptyDetails: true,
        events: [
            // {
            //     startDate: new Date(new Date().setHours(new Date().getHours() + 24)).toDateString(),
            //     endDate: new Date(new Date().setHours(new Date().getHours() + 25)).toISOString(),
            //     summary: 'Visit of the Eiffel Tower'
            // }
            // {
            //     startDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 12, 0)).toISOString(),
            //     endDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 11)).getTime(),
            //     summary: 'Restaurant'
            // },
            // {
            //     startDate: new Date(new Date().setHours(new Date().getHours() - 48)).toISOString(),
            //     endDate: new Date(new Date().setHours(new Date().getHours() - 24)).getTime(),
            //     summary: 'Visit of the Louvre'
            // }
        ],
        onMonthChange:function (month, year) {
            month++;
            location.href = "/present?type="+year+"-"+month
        },


    });
    $calendar = container.data('plugin_simpleCalendar')
});



$(window).resize(function(){
    heightResize();
});

//]]>

