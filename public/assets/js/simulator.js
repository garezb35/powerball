var dae=powodd=powunder=defodd=defunder=powpattern2=powpattern1 = new Array();
var check_save = check_save_all = true;

var api_token = "";
var steps = new Array();
$(".pow-element").click(function() {
    initOdd();
    if ($(this).hasClass("pow-element-blue")) {
        $(this).removeClass("pow-element-blue");
        $(this).addClass("pow-element-red");
        $(this).text(dae[0]);
        $(this).data("code",0);
    }
    else if ($(this).hasClass("pow-element-red")) {
        $(this).removeClass("pow-element-red");
        $(this).text("대");
        $(this).data("code",-1);
    }
    else {
        $(this).addClass("pow-element-blue");
        $(this).text(dae[1]);
        $(this).data("code",1);
    }
});

function openCity(evt,patt_index) {
    $(".part").addClass("d-none");
    $(".patt-cate").removeClass("text-danger");
    $(".patt-cate").removeClass("font-weight-bold");
    $(evt).addClass("text-danger");
    $(evt).addClass("font-weight-bold");
    $("#part"+patt_index).removeClass("d-none");
    type = patt_index;
}

function hideType(type,obj){
    $(".powerball-kind-all th").removeClass("text-danger")
    $(obj).addClass("text-danger")
    if(type == 1){
        $(".mulebanga").show();
        $(".autopattern").hide();
    }
    else{
        $(".mulebanga").hide();
        $(".autopattern").show();
    }
}

function saveAutoSetting(){
    if(started > 0)
    {
        alert("게임중지후 이용해주세요");
        return;
    }
    var start = $("#test-start-round").val();
    var end = $("#test-end-round").val();
    var amount = $("#test-start-amount").val();
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/setAutoConfig',
        data:{start_round:start,end_round:end,start_amount:amount,api_token:api_token},

        success:function(data,textStatus){
          if(data.status == "1")
          {
              alert("성공적으로 저장되였습니다.");
              if(amount > 0){
                  $(".start-amount").text(number_format(amount)+"원");
                  $(".saved-amount").text(number_format(amount)+"원");
                  $(".profit-amount").text("0원");
              }
              $(".start-round").text(start.substr(start.length-3,3));
              $(".end-round").text(end.substr(end.length-3,3));
          }
          else
              alert("처리중 오류가 발생하였습니다.");
        }
    }).done(function(){
        $('#settingWindow').modal('toggle')
    });
}

$(document).ready(function(){
    if(started > 0)
        checkTimer();
    api_token = $("#part2").find("#api_token").val();
    $("#btn-money-keep").click(function(){
        $(".first-martin").each(function(index,value){
            if($(value).val().trim() == "" || $(value).val().trim() <=0 ){
                return false;
            }
            steps.push($(value).val().replaceAll(/,/ig,''));
        });
        if(steps.length ==0)
        {
            alert("금액이 비였습니다.")
            return;
        }
        var notivalue = $("#noti-input").val();
        var martin = $("#martin-multi").val();

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/setAutoConfig',
            data:{api_token:api_token,step:notivalue,martin:martin,mny:steps.join()},
            success:function(data,textStatus){
                if(data.status == "1")
                {
                    alert("성공적으로 저장되였습니다.");
                }
                else
                    alert("처리중 오류가 발생하였습니다.");
            }
        });
    });
    $("#martin-apply").click(function(){
        var martin = $("#martin-multi").val();
        var init = 0;
        $(".first-martin").each(function(index,value){
            if(index ==0 && ($(value).val().trim() == "" || $(value).val().trim() <=0) ){
                alert("금액이 설정되여 있지 않습니다.")
                return false;
            }
            if(index ==0)
                init = $(value).val();
            else{
                init = parseInt(init * martin);
                $(value).val(number_format(init.toString()));
            }
        });
    });

    $("#past_start").click(function(){
        var code = $(this).data("code");
        var type = 1;
        processAutoStart(code,type);
    });
    $("#current_start").click(function(){
        var code = $(this).data("code");
        var type = 2;
        processAutoStart(code,type);
    });
})


function processAutoStart(code,type){
    // if(started > 0){
    //     alert("이미 오토배팅중입니다.중지후 이용해주십시오");
    //     return;
    // }
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/setAutoStart',
        data:{api_token:api_token,code:code,type:type},
        success:function(data,textStatus){
            location.reload();
        }
    })
}

function savePattern(tt,var_type,callback){

    if(started >0){
        alert("배팅중지후 설정해주세요");
        return false;
    }
    if(var_type == 1){
        var input_pattern = new Array();
        var pattern_step = $("#part"+tt).find(".pattern-step1").val();
        $("#part"+tt).find(".pow-element").each(function(index,value){
            if($(value).data("code") == "-1")
                return false;
            input_pattern.push($(value).data("code"));
        });

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/setAutoMatch',
            data:{api_token:api_token,var_type:var_type,type:tt,pattern:input_pattern.join(),pattern_step:pattern_step},
            success:callback
        });
    }

    if(var_type ==3){
        var input_pattern  = $("#part"+tt).find(".pattern-input3").val();
        var oppo = $("#part"+tt).find("#oppo30").val();
        var pattern_step = $("#part"+tt).find(".pattern-step3").val();

        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/api/setAutoMatch',
            data:{api_token:api_token,var_type:var_type,type:tt,pattern:input_pattern,pattern_step:pattern_step,auto_oppo:oppo},
            success:callback
        })
    }
    if(var_type ==2){
        var myform = document.getElementById("pattern-form"+tt);
        var fd = new FormData(myform);
        $.ajax({
            url:'/api/setAutoMatch',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType:"json",
            success: callback
        });
    }
}

function changeRow(evt,rows){
    if($(evt).text().trim() =="줄"){
        $("#oppo"+rows).val(1);
        $(evt).text("꺽");
        // $(evt).removeClass("btn-primary");
        // $(evt).addClass("btn-danger");
        return;
    }
    if($(evt).text().trim() =="꺽"){
        $("#oppo"+rows).val(0);
        $(evt).text("줄");
        // $(evt).removeClass("btn-danger");
        // $(evt).addClass("btn-primary");
    }
}

function startAction(bet_type){
    if(bet_type ==1){
        setInterval(function(){
            $.ajax({
                type:"get",
                url:'/api/processSimulatorBet',
                success: function (data) {
                }
            });
        },100000);
    }
}

function savePatt(tt=type,alert=true,callback){
    if(check_save){
        check_save  = false;
        savePattern(tt,1,function(){
            savePattern(tt,2,function(){
                savePattern(tt,3,function(){
                    check_save  = true;
                    if(alert == true) window.alert("저장되였습니다.");
                    callback();
                })
            })
        })
    }
}

function savePattAll(){
    if(check_save_all){
        check_save_all  = false;
        savePatt(1,false,function(){
            savePatt(2,false,function(){
                savePatt(3,false,function(){
                    savePatt(4,false,function(){
                        check_save_all  = true;
                        alert("저장되였습니다.");
                    })
                })
            })
        })
    }
}

function initOdd(){
    if(type ==1 || type ==3){
        dae[0] = "짝";
        dae[1] = "홀";
    }
    else{
        dae[0] = "오";
        dae[1] = "언";
    }
}

function checkTimer(){
    var full = -1;
    if(started == 1){
        full = 10;
    }
    else
        full = 300;

    setInterval(function(){
        if(remain ==0){
            remain = full;
            setTimeout(function(){location.reload()},2000);
        }
        remain--;
        $('.timers').text(remain+"초");
    },1000);
}

