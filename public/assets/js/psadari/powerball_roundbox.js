var dateDiff = 0;

$(document).ready(function() {
    $("#filter-btns a").click(function(){
        $("#filter-btns a").removeClass("selected");
        $(this).addClass("selected");
        var value = $(this).attr("value");
        if(value !=""){
            $(".roundbox-body").find(".content").find(".sp-odd").removeClass("strong");
            $(".roundbox-body").find(".content").find(".sp-even").removeClass("strong");
            $(".roundbox-body").find(".content").find("."+value).addClass("strong");
        }
        else{
            $(".roundbox-body").find(".content").find(".sp-odd").removeClass("strong");
            $(".roundbox-body").find(".content").find(".sp-even").removeClass("strong");
        }
    })
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
            url: "/api/getRoundBox",
            data:{from_date: from,to_date : to,from_round:from_round,to_round:to_round,pb_type:pb_type},
            dataType:"json"
        }).done(function(data) {
            if(data.status ==1){
                compileJson("#roundbox-data",".roundbox-body",data.result)
            }
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
