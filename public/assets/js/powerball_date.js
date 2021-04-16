var dateDiff = '0';
var pattern = new Array();
var pattern_header = new Array();
pattern["pb_oe"] = pattern["pb_uo"] = pattern["nb_oe"] = pattern["nb_uo"] = pattern["nb_size"] = new Array();
var six =new Array();
var six_num = 6;
var six_alias = "pb_oe";
var pagination = 0;
var loading =false;

$(document).ready(function(){
    $('#datepicker').datepicker({
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
    }).change(function(){
        document.location.href = '/p_analyse?terms=date&from='+this.value+'&to='+this.value;
    });

    $(document).ready(function(){
        $.ajax({
            type: "get",
            url: "/api/synctime"
        }).done(function(data) {
            if(data > 0){
                remainTime = getRemainTime(data);
                setInterval(function(){
                    ladderTimer(300,'dayLogTimer');
                },1000);
            }

            $.ajax({
                type: "POST",
                url: "/api/get_more/analyseDate",
                data:{"from" : date,to : date},
                dataType:"json"
            }).done(function(data) {
                if(data.status ==1){
                    pattern_header["pb_oe"] = data.result.poe;
                    pattern_header["pb_uo"] = data.result.puo;
                    pattern_header["nb_oe"] = data.result.noe;
                    pattern_header["nb_uo"] = data.result.nuo;
                    pattern_header["nb_size"] = data.result.nsize;
                    ajaxPattern('pb_oe',date,'','')
                }
                moreClick();
                ajaxPattern('pb_oe',date,date,"");
                compileJson("#chart-data",".chart-power",data.result)
                douPie([pattern_header["nb_size"].count[3],pattern_header["nb_size"].count[2],pattern_header["nb_size"].count[1]],"chart-area",["대","중","소"]);
                ajaxSixPattern(6,"pb_oe",date);
            })
        })
    })

    $('#boardmenu-sec .nav-item a').click(function(){

        $('#boardmenu-sec .nav-item a').removeClass('on1');
        $(this).addClass('on1');
        $('#sixBox .patternType .btns').find('[sixType='+six_alias+']').addClass('on2');
        six_num = $(this).attr('rel');
        ajaxSixPattern(six_num,six_alias,date);

    });

    $('#sixBox .patternType .btns a').click(function(){

        $('#sixBox .patternType .btns a').removeClass('on2');
        $(this).addClass('on2');

        $('#sixBox .patternCnt .btns a').removeClass('on1');
        $('#sixBox .patternCnt .btns').find('[rel='+six_num+']').addClass('on1');

        six_alias = $(this).attr('rel');
        ajaxSixPattern(six_num,six_alias,date);
    });
})

function ajaxPattern(type,date,dateTo="",round="")
{
    $('#patternBox-head a').each(function(){
        $(this).removeClass('on');
        if ($(this).attr('type') == type)
        {
            $(this).addClass('on');
            if(pattern[type].length == 0){
                $.ajax({
                    type: "POST",
                    url: "/api/get_more/analysePattern",
                    data:{"from" : date,to : date,type:type},
                    dataType:"json"
                }).done(function(data) {
                    if(data.status ==1){
                        pattern[type] = data.result;
                        pattern_header[type].pung = pattern[type].pung;
                        pattern_header[type].change = pattern[type].list.length;
                        pattern_header[type].type = type;
                        compileJson("#pattern-info","#head-info",pattern_header[type]);
                        compileJson("#pattern-date",".pattern-t",pattern[type]);
                    }
                })
            }
            else
            {
                compileJson("#pattern-info","#head-info",pattern_header[type]);
                compileJson("#pattern-date",".pattern-t",pattern[type]);
            }
        }
    });
}

function ajaxSixPattern(cnt,type,date)
{
    if(six[type+cnt] !=null && six[type+cnt] !=undefined && six[type+cnt].length > 0){
        compileJson("#six-data",".six-t",six[type+cnt]);
    }
    else{
        $.ajax({
            type: "POST",
            url: "/api/get_more/analyseSix",
            data:{"from" : date,to : date,step:cnt,type:type},
            dataType:"json"
        }).done(function(data) {
            if(data.status ==1){
                six[type+cnt] = data.result;
                compileJson("#six-data",".six-t",six[type+cnt]);
            }
            if(data.status ==0)
            {
                emptyReload();
                six[type+cnt] = null;
            }
        })
    }
}

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
            data:{from:date,to:date,skip:pagination},
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


