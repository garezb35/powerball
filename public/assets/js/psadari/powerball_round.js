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
            url: "/api/get_more/analyseDate",
            data:{"from" : from,to : to,round:round},
            dataType:"json"
        }).done(function(data) {
            if(data.status ==1){
                pattern_header["pb_oe"] = data.result.poe;
                pattern_header["pb_uo"] = data.result.puo;
                pattern_header["nb_oe"] = data.result.noe;
                pattern_header["nb_uo"] = data.result.nuo;
                pattern_header["nb_size"] = data.result.nsize;
            }

            compileJson("#chart-data",".chart-power",data.result)
            douPie([pattern_header["nb_size"].count[3],pattern_header["nb_size"].count[2],pattern_header["nb_size"].count[1]],"chart-area","");
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
            url:'/api/get_more/powerball',
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
