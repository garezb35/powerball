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
        $(".see-t").find("tr").removeClass("current")
        $(".see-t tr:nth-child(2)").after(getPowerball(data.body))
        heightResize();
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
            socket = io.connect(node+'/result',socketOption);
        }
    }
    catch(e){

    }
}

function getPowerball(data){
  var power_under = data.powerballUnderOverMsg == "언더" ? "under":"over";
  var number_under = data.numberUnderOverMsg == "언더" ? "under":"over";
  var numPer = "";
  if(data.numberSum >= 15 && data.numberSum<=64)
    numPer = "소 (15~64)";
  if(data.numberSum >= 65 && data.numberSum<=80)
      numPer = "중 (65~80)	";
  if(data.numberSum >= 81 && data.numberSum<=130)
      numPer = "대 (81~130)";
  var pb_term="",nb_term ="";
  if(data.pb_term == "A")
    pb_term = "A (0~2)";
  if(data.pb_term == "B")
    pb_term = "B (3~4)";
  if(data.pb_term == "C")
    pb_term = "C (5~6)";
  if(data.pb_term == "D")
    pb_term = "D (7~9)";

    if(data.nb_term == "A")
      nb_term = "A (15~35)";
    if(data.nb_term == "B")
      nb_term = "B (36~49)";
    if(data.nb_term == "C")
      nb_term = "C (50~57)";
    if(data.nb_term == "D")
      nb_term = "D (58~65)";
    if(data.nb_term == "E")
      nb_term = "E (66~78)";
    if(data.nb_term == "F")
      nb_term = "F (15~35)";
  return '<tr class="current">\
        <td height="40" align="center">\
            <span class="numberText">'+data.round+'회</span><br>\
            ( <span class="numberText">'+data.day_round+'회</span> )\
        </td>\
        <td align="center" class="numberText">'+data.time+'</td>\
        <td align="center" class="numberText"><div class="sp-ball_bg">'+data.powerball+'</div></td>\
        <td align="center" class="numberText">'+pb_term+'</td>\
        <td align="center"> <div class="sp-'+data.powerballOddEven+'">'+data.powerballOddEvenMsg+'</div></td>\
        <td align="center"><div class="sp-'+power_under+'"></div></td>\
        <td align="center" class="numberText">'+data.balls+'</td>\
        <td align="center" class="numberText">'+data.numberSum+'</td>\
        <td align="center" class="numberText">'+nb_term+'</td>\
        <td align="center" class="numberText">'+numPer+'</td>\
        <td align="center"><div class="sp-'+data.numberOddEven+'">'+data.numberOddEvenMsg+'</div> </td>\
        <td align="center"><div class="sp-'+number_under+' "></div></td>\
    </tr>';
}
