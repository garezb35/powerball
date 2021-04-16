var checked = new Array();
var loading = false;
var type = "pb_oe";
var limit = 10;
var index = 0;
var patt = "";
var pb_oe = new Array(),pb_uo = new Array(),nb_oe = new Array(),nb_uo = new Array(),nb_size = new Array()
let patternAll = {}
jQuery.fn.extend({
    live: function (event, callback) {
        if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
        return this;
    }
});

$(document).ready(function (){
    $("#patternCnt").change(function(){
        initPattern($(this).val(),type);
        limit = $(this).val();
    })
    initPattern(10,"pb_oe",function(){
        setTimeout(function(){
            searchPattern(1,date,round);
        },500);
    });
    $(".btn_plus").click(function(){
        if(limit > 19) return false;
        limit++;
        $(".tx").text(limit)
        initPattern(limit,type,function(){
            setTimeout(function(){
                searchPattern(1,date,round);
            },500);
        });
    })
    $(".btn_minus").click(function(){
        if(limit < 4) return false;
        limit--;
        $(".tx").text(limit)
        initPattern(limit,type,function(){
            setTimeout(function(){
                searchPattern(1,date,round);
            },500);
        });
    })
})

function initPattern(limit=10,type="pb_oe",callback){

    patt = "";
    index = 0;
    if(!loading){
        setTimeout(function() {
            $.ajax({
                type: "post",
                url: "/api/checkedPattern",
                data:{limit:limit,types:type},
                dataType:"json",
                beforeSend: function() {
                    loading=true;
                },
                success: callback

            }).done(function(data) {
                $(".moreBox a").removeClass("disabled");
                $("#patternList").html("");
                date = old_date;
                round = old_round;
                loading = false;
                if(data.status ==1){
                    checked[limit+type] = data.result;
                    compileJson(".checklist","#patternSet",checked[limit+type]);
                }
                if(data.status ==0)
                {
                    checked[limit+type] = null;
                    emptyReload();
                }
            })
        }, 300);

    }
}

function searchPattern(append = 1,var_date=old_date,var_round=old_round){
    if(index ==0 || append ==1){
        patt = "";
        $("#patternList").html("");
        $("#patternSet li").each(function(key,value){
            patt +=$(value).data("code");
        });
    }
    if(patt.trim() !="" && !loading){
        $.ajax({
            type: "post",
            url: "/api/pattern-lists",
            data:{from:var_date,round:var_round,type:type,limit:limit,pattern:patt},
            dataType:"json",
            beforeSend: function() {
                loading=true;
                moreLoad(1)
            },

        }).done(function(data) {
            moreLoad(0);
            loading = false;
            if(data.status ==1){
                compileJson(".pattern-item","#patternList",data.result,append);
                var length  = data.result.length;
                date = data.result[length-1].current[0].created_date.split(" ")[0];
                round = data.result[length-1].current[0].day_round;
                index++;
                if(data.result.length > 0 ){
                    if(append == 1)
                    {
                        pb_oe = new Array();
                        pb_uo = new Array();
                        nb_oe = new Array();
                        nb_uo = new Array();
                        nb_size = new Array();
                    }
                    for(var item in data.result){
                        for(var i = 0; i < data.result[item].current.length;i++){
                            pb_oe.push(data.result[item].current[i].pb_oe)
                            pb_uo.push(data.result[item].current[i].pb_uo)
                            nb_oe.push(data.result[item].current[i].nb_oe)
                            nb_uo.push(data.result[item].current[i].nb_uo)
                            nb_size.push(data.result[item].current[i].nb_size)
                        }
                        if(typeof data.result[item].next !="undefined"){
                            pb_oe.push(data.result[item].next.pb_oe)
                            pb_uo.push(data.result[item].next.pb_uo)
                            nb_oe.push(data.result[item].next.nb_oe)
                            nb_uo.push(data.result[item].next.nb_uo)
                            nb_size.push(data.result[item].next.nb_size)
                        }
                    }
                    let patternAll = {};
                    patternAll["poe"] = {};
                    patternAll["puo"] = {};
                    patternAll["noe"] = {};
                    patternAll["nuo"] = {};
                    patternAll["nsize"] = {};
                    patternAll["poe"]["max"] = new Array();
                    patternAll["poe"]["count"] = new Array();
                    patternAll["puo"]["max"] = new Array();
                    patternAll["puo"]["count"] = new Array();
                    patternAll["noe"]["max"] = new Array();
                    patternAll["noe"]["count"] = new Array();
                    patternAll["nuo"]["max"] = new Array();
                    patternAll["nuo"]["count"] = new Array();
                    patternAll["nsize"]["max"] = {};
                    patternAll["nsize"]["count"] = {};
                    patternAll["poe"]["max"][0] = -1;patternAll["poe"]["max"][1] = -1;
                    patternAll["puo"]["max"][0] = -1; patternAll["puo"]["max"][1] = -1;
                    patternAll["noe"]["max"][0] = -1; patternAll["noe"]["max"][1] = -1;
                    patternAll["nuo"]["max"][0] = -1; patternAll["nuo"]["max"][1] = -1;
                    patternAll["nsize"]["max"]["1"] = -1; patternAll["nsize"]["max"]["2"] = -1; patternAll["nsize"]["max"]["3"] = -1;
                    patternAll["poe"]["count"] = pb_oe.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["puo"]["count"] = pb_uo.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["noe"]["count"] = nb_oe.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["nuo"]["count"] = nb_uo.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["nsize"]["count"] = nb_size.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    compileJson("#chart-data",".chart-power",patternAll);
                    douPie([patternAll["nsize"]["count"]["3"],patternAll["nsize"]["count"]["2"],patternAll["nsize"]["count"]["1"]],"chart-area");
                }
            }
            if(data.status ==0)
            {
                $(".moreBox a").addClass("disabled");
            }
        })
    }
}

$('body').on('click','#pattern-sec a.nav-link',function(){
    if(loading) return false;
    $('#pattern-sec a.nav-link').removeClass('on1');
    $(this).addClass('on1');
    type = $(this).attr('rel');
    initPattern($("#patternCnt").val(),$(this).attr('rel'),function(){
        setTimeout(function(){
            searchPattern(1,date,round);
        },500);
    });
});

