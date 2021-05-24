var pattern = new Array();
var pattern_header = new Array();
pattern["three_four"] = pattern["left_right"] = pattern["odd_even"] = pattern["total"] = new Array();
var six =new Array();
var six_num = 6;
var six_alias = "left_right";
var pagination = 0;
var loading =false;



function ajaxPattern(type,from='',to='',limit)
{
    $('#patternBox-head a').each(function(){
        $(this).removeClass('on');
        if ($(this).attr('type') == type)
        {
            $(this).addClass('on');
            if(pattern[type].length == 0){
                $.ajax({
                    type: "POST",
                    url: "/api/psadari/get_more/analysePattern",
                    data:{type:type,limit:limit},
                    dataType:"json",
                    error:function(xhr){
                        console.log(xhr)
                    }
                }).done(function(data) {
                    if(data.status ==1){
                        pattern[type] = data.result;
                        pattern_header[type].pung = pattern[type].pung;
                        pattern_header[type].change = pattern[type].list.length;
                        pattern_header[type].type = type;
                        compileJson("#pattern-info","#head-info",pattern_header[type]);
                        compileJson("#pattern-date",".pattern-t",pattern[type]);
                    }
                });
            }
            else
            {
                compileJson("#pattern-info","#head-info",pattern_header[type]);
                compileJson("#pattern-date",".pattern-t",pattern[type]);
            }
        }
    });
}

$(document).ready(function(){
    $( "#roundCnt" ).selectmenu(
        {
            change: function( event, ui ) {
                location.href = "/p_analyse?terms=lates&limit="+ui.item.value;
            }
        }
    );

    setInterval(function () {
        ladderTimer(300, 'dayLogTimer');
    }, 1000);

    $.ajax({
        type: "POST",
        url: "/api/psadari/get_more/analyseDate",
        data:{limit : limit},
        dataType:"json",
        error:function(xhr){
            console.log(xhr)
        }
    }).done(function(data) {
        if(data.status ==1){
            pattern_header["left_right"] = data.result.left_right;
            pattern_header["odd_even"] = data.result.odd_even;
            pattern_header["three_four"] = data.result.three_four;
            pattern_header["total"] = data.result.total_lines;
        }
        moreClick();
        ajaxPattern('left_right','','',limit);
        compileJson("#chart-data",".chart-power",data.result)
        douPie([pattern_header["total"].count.LEFT4ODD,pattern_header["total"].count.RIGHT3ODD,pattern_header["total"].count.LEFT3EVEN,pattern_header["total"].count.RIGHT4EVEN],"chart-area","",[
            window.chartColors1.red,
            window.chartColors1.orange,
            window.chartColors1.yellow,
            window.chartColors1.pick]);
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
            data:{skip:pagination,limit:limit},
            beforeSend: function() {
                moreLoad(1)
            },
            success:function(data,textStatus){
                if(data.status == 1){
                    pagination = pagination + 30;
                    compileJson("#see-data",".see-t",data.result,2);
                }
            },
            error:function(xhr){
                console.log(xhr)
            }
        }).done(function(data){
            moreLoad(0)
            loading = false;
            if(data.status == 0)
                loading  = true;
        })
    }
}
