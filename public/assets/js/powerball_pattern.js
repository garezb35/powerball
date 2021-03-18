var checked = new Array();
var loading = false;
var type = "pb_oe";
var limit = 10;
var index = 0;
var patt = "";
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

    // $('#patternSet').on('click','li',function(){
    //     if($(this).find('.img').hasClass('sp-even'))
    //     {
    //         $(this).find('.img').removeClass('sp-even').addClass('sp-odd');
    //         $(this).data("code",1);
    //     }
    //     else if($(this).find('.img').hasClass('sp-odd'))
    //     {
    //         $(this).find('.img').removeClass('sp-odd').addClass('sp-even');
    //         $(this).data("code",0);
    //     }
    //     else if($(this).find('.img').hasClass('sp-under'))
    //     {
    //         $(this).find('.img').removeClass('sp-under').addClass('sp-over');
    //         $(this).data("code",1);
    //     }
    //     else if($(this).find('.img').hasClass('sp-over'))
    //     {
    //         $(this).find('.img').removeClass('sp-over').addClass('sp-under');
    //         $(this).data("code",0);
    //     }
    //     else if($(this).find('.img').hasClass('sp-big'))
    //     {
    //         $(this).find('.img').removeClass('sp-big').addClass('sp-middle');
    //         $(this).data("code",2);
    //
    //     }
    //     else if($(this).find('.img').hasClass('sp-middle'))
    //     {
    //         $(this).find('.img').removeClass('sp-middle').addClass('sp-small');
    //         $(this).data("code",1);
    //     }
    //     else if($(this).find('.img').hasClass('sp-small'))
    //     {
    //         $(this).find('.img').removeClass('sp-small').addClass('sp-big');
    //         $(this).data("code",3);
    //     }
    // })
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

    // if(append ==1)

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
            }
            if(data.status ==0)
            {
                $(".moreBox a").addClass("disabled");
                // goErrorPopup();
            }
        })
    }
}

$('body').on('click','.tabMenu a',function(){
    $('.tabMenu a').removeClass('btn-jin-green');
    $('.tabMenu a').addClass('btn-green');
    $(this).addClass('btn-jin-green');
    $(this).removeClass('btn-green');
    type = $(this).attr('rel');
    initPattern($("#patternCnt").val(),$(this).attr('rel'),function(){
        setTimeout(function(){
            searchPattern(1,date,round);
        },500);
    });
});

