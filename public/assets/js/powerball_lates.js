var pattern = new Array();
var pattern_header = new Array();
pattern["pb_oe"] = pattern["pb_uo"] = pattern["nb_oe"] = pattern["nb_uo"] = pattern["nb_size"] = new Array();
var six =new Array();
var six_num = 6;
var six_alias = "pb_oe";
var pagination = 0;
var loading =false;

var socketOption = {};
socketOption['reconnect'] = true;
socketOption['force new connection'] = true;
socketOption['sync disconnect on unload'] = true;
if('WebSocket' in window)
{
    socketOption['transports'] = ['websocket'];
}


var socket =  null;

$(document).ready(function(){

    connect();
    socket.on('result',function(data){
        console.log(data)
    });
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
        url: "/api/get_more/analyseDate",
        data:{limit : limit},
        dataType:"json"
    }).done(function(data) {
        if(data.status ==1){
            pattern_header["pb_oe"] = data.result.poe;
            pattern_header["pb_uo"] = data.result.puo;
            pattern_header["nb_oe"] = data.result.noe;
            pattern_header["nb_uo"] = data.result.nuo;
            pattern_header["nb_size"] = data.result.nsize;

            // compileJson("#all-date","#all_datesanalyse",data.result);
        }
        moreClick();
        ajaxPattern('pb_oe','','',limit);
        compileJson("#chart-data",".chart-power",data.result)
        douPie([pattern_header["nb_size"].count[3],pattern_header["nb_size"].count[2],pattern_header["nb_size"].count[1]],"chart-area");
    });


    $('#sixBox .patternCnt .btns a').click(function(){
        $('#sixBox .patternCnt .btns a').removeClass('on1');
        $(this).addClass('on1');
        $('#sixBox .patternType .btns a').removeClass('on2');
        $('#sixBox .patternType .btns').find('[sixType='+six_alias+']').addClass('on2');
        six_num = $(this).attr('rel');
        ajaxSixPattern(six_num,six_alias);

    });

    $('#sixBox .patternType .btns a').click(function(){

        $('#sixBox .patternType .btns a').removeClass('on2');
        $(this).addClass('on2');
        $('#sixBox .patternCnt .btns a').removeClass('on1');
        $('#sixBox .patternCnt .btns').find('[rel='+six_num+']').addClass('on1');
        six_alias = $(this).attr('rel');
        ajaxSixPattern(six_num,six_alias);
    });

});

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
                    url: "/api/get_more/analysePattern",
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
            $('#patternBox').find('.content').animate({scrollLeft:10000},1000);
        }
    });
}

function ajaxSixPattern(cnt,type)
{
    if(six[type+cnt] !=null && six[type+cnt] !=undefined && six[type+cnt].length > 0){
        compileJson("#six-data",".six-t",six[type+cnt]);
    }
    else{
        $.ajax({
            type: "POST",
            url: "/api/get_more/analyseSix",
            data:{step:cnt,type:type,limit:limit},
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
    $("#sixBox .content").animate({scrollLeft:10000},1000);
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
            data:{skip:pagination,limit:limit},
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


function connect()
{
    try{

        if(socket == null)
        {
            socket = io.connect('http://127.0.0.1:3000/result',socketOption);
            socket.emit('presult',"success");
        }
    }
    catch(e){

    }
}
