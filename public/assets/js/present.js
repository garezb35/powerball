
//<![CDATA[

var $calendar;
$(document).ready(function(){
    $('body').on('click','.choice',function(){
        $('.choice').css('border-color','#BEE0FA');
        $('.choice').css('color','#000');
        $(this).css('border-color','#127CCB');
        $(this).css('color','red');
        $('#selectNumber').val($(this).text());
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
                        $('#ladderResult').html('<img src="/assets/images/random/ladder'+data.selectNumber+'-'+data.number+'.gif">');
                        setTimeout(function(){
                            if(data.ladderResult == 'win')
                            {
                                alert('축하합니다. 당첨되어 [랜덤아이템상자]가 지급되었습니다. 아이템 메뉴에서 확인하세요!');
                            }
                            location.reload();

                        },3000);
                    }
                    else
                    {
                        alert(data.msg);
                    }
                },error:function(xhr){
                    console.log(xhr)
                }
            });
        }
    });

    let events  = new Array();

    month_days = month_days.split(",");
    if(month_days.length > 0){
        for(let i = 0 ; i < month_days.length ; i++){
            events.push({
                startDate : new Date(month_days[i]),
                endDate : new Date(month_days[i]),
                summary: '사이트 출근 날'
            });
        }
    }

    let container = $(".calendarBox").simpleCalendar({
        cur_date:new Date(y, m-1, d),
        fixedStartDay: 0, // begin weeks by sunday
        disableEmptyDetails: true,
        events: events,
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
