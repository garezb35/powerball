var checked = new Array();
var loading = false;
var type = "odd_even";
var limit = 10;
var index = 0;
var patt = "";
var left_right = new Array(),odd_even = new Array(),three_four = new Array(),total_lines = new Array()
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
    initPattern(10,"odd_even",function(){
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
                url: "/api/psadari/checkedPattern",
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
            url: "/api/psadari/pattern-lists",
            data:{from:var_date,round:var_round,type:type,limit:limit,pattern:patt},
            dataType:"json",
            beforeSend: function() {
                loading=true;
                moreLoad(1)
            }
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
                    if(append == 1){
                        left_right = new Array();
                        odd_even = new Array();
                        three_four = new Array();
                        total_lines = new Array();
                    }
                    for(var item in data.result){
                        for(var i = 0; i < data.result[item].current.length;i++){
                            left_right.push(setAliasSadari(data.result[item].current[i].nb1,"left_right"))
                            odd_even.push(setAliasSadari(data.result[item].current[i].nb1,"odd_even"))
                            three_four.push(setAliasSadari(data.result[item].current[i].nb1,"three_four"))
                            total_lines.push(setAliasSadari(data.result[item].current[i].nb1,"total_lines"))
                        }
                        if(typeof data.result[item].next !="undefined"){
                            left_right.push(setAliasSadari(data.result[item].next.nb1,"left_right"))
                            odd_even.push(setAliasSadari(data.result[item].next.nb1,"odd_even"))
                            three_four.push(setAliasSadari(data.result[item].next.nb1,"three_four"))
                            total_lines.push(setAliasSadari(data.result[item].next.nb1,"total_lines"))
                        }
                    }
                    let patternAll = {};
                    patternAll["left_right"] = {};
                    patternAll["three_four"] = {};
                    patternAll["odd_even"] = {};
                    patternAll["total_lines"] = {};

                    patternAll["left_right"]["max"] = new Array();
                    patternAll["left_right"]["count"] = new Array();
                    patternAll["three_four"]["max"] = new Array();
                    patternAll["three_four"]["count"] = new Array();
                    patternAll["odd_even"]["max"] = new Array();
                    patternAll["odd_even"]["count"] = new Array();
                    patternAll["total_lines"]["max"] = new Array();
                    patternAll["total_lines"]["count"] = new Array();

                    patternAll["left_right"]["max"][0] = -1;patternAll["left_right"]["max"][1] = -1;
                    patternAll["three_four"]["max"][0] = -1; patternAll["three_four"]["max"][1] = -1;
                    patternAll["odd_even"]["max"][0] = -1; patternAll["odd_even"]["max"][1] = -1;
                    patternAll["total_lines"]["max"][0] = -1; patternAll["total_lines"]["max"][1] = -1;

                    patternAll["left_right"]["count"] = left_right.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["three_four"]["count"] = three_four.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["odd_even"]["count"] = odd_even.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});
                    patternAll["total_lines"]["count"] = total_lines.reduce(function(acc,e){acc[e] = (e in acc ? acc[e]+1 : 1); return acc}, {});

                    compileJson("#chart-data",".chart-power",patternAll);
                    douPie([patternAll["total_lines"]["count"]["LEFT4ODD"],patternAll["total_lines"]["count"]["RIGHT3ODD"],patternAll["total_lines"]["count"]["LEFT3EVEN"],patternAll["total_lines"]["count"]["RIGHT4EVEN"]],"chart-area","",[
                        window.chartColors1.red,
                        window.chartColors1.orange,
                        window.chartColors1.yellow,
                        window.chartColors1.pick]);
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
