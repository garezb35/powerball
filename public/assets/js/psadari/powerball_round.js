var dateDiff = 0;
var pattern_header = pattern =  new Array();
var pagination = 0;
var loading =false;
$(document).ready(function() {
    $.ajax({
        type: "get",
        url: "/api/synctime"
    }).done(function(data) {
        if (data > 0) {
            remainTime = getRemainTime(data);
            setInterval(function () {
                ladderTimer(300, 'dayLogTimer');
            }, 1000);
        }
        $.ajax({
            type: "POST",
            url: "/api/psadari/get_more/analyseDate",
            data:{"from" : from,to : to,round:round},
            dataType:"json"
        }).done(function(data) {
            if(data.status ==1){
                pattern_header["left_right"] = data.result.left_right;
                pattern_header["three_four"] = data.result.three_four;
                pattern_header["odd_even"] = data.result.odd_even;
                pattern_header["total"] = data.result.total_lines;
            }

            compileJson("#chart-data",".chart-power",data.result)
            douPie([pattern_header["total"].count.LEFT4ODD,pattern_header["total"].count.RIGHT3ODD,pattern_header["total"].count.LEFT3EVEN,pattern_header["total"].count.RIGHT4EVEN],"chart-area","",[
                window.chartColors1.red,
                window.chartColors1.orange,
                window.chartColors1.yellow,
                window.chartColors1.pick]);
            moreClick();
        })
    });
    $('#startDate').datepicker({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        dayNames: ['일','월','화','수','목','금','토'],
        dayNamesShort: ['일','월','화','수','목','금','토'],
        dayNamesMin: ['일','월','화','수','목','금','토'],
        showMonthAfterYear: true,
        yearSuffix: '년',
        defaultDate: dateDiff,
        maxDate: '+0d'
    });

    $('#endDate').datepicker({
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        dayNames: ['일','월','화','수','목','금','토'],
        dayNamesShort: ['일','월','화','수','목','금','토'],
        dayNamesMin: ['일','월','화','수','목','금','토'],
        showMonthAfterYear: true,
        yearSuffix: '년',
        defaultDate: dateDiff,
        maxDate: '+0d'
    });
});


function moreClick()
{
    if(loading == false)
    {
        loading = true;
        $('#pageDiv').show();
        var page = parseInt($('#pageDiv').attr('pageVal')) + 1;

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/psadari/get_more/powerball',
            data:{from:from,to:to,skip:pagination,round:round},
            beforeSend: function() {
                moreLoad(1)
            },
            success:function(data,textStatus){
                if(data.status == 1){
                    pagination = pagination + 30;
                    compileJson("#see-data",".see-t",data.result,2);
                }
            }
        }).done(function(data){
            moreLoad(0)
            loading = false;
            if(data.status == 0)
                loading  = true;
        })
    }
}
