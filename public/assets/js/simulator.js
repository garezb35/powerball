var dae=powodd=powunder=defodd=defunder=powpattern2=powpattern1 = new Array();
var check_save = check_save_all = true;

var api_token = "";
var steps = new Array();
var typess = new Array();
typess[1]=  "pb_oe";
typess[2] = "pb_uo";
typess[3] = "nb_oe";
typess[4] = "nb_uo";
var result = new Array();
result["pb_oe"] = {alias:"[1]파홀(1.95)vs[2]파짝(1.95)"};
result["pb_uo"] = {alias:"[1]파언(1.95)vs[2]파오(1.95)"};
result["nb_oe"] = {alias:"[1]일홀(1.95)vs[2]일짝(1.95)"};
result["nb_uo"] = {alias:"[1]일언(1.95)vs[2]일오(1.95)"};
var loading = false;
var simulator_in = ["pb_oe","pb_uo","nb_oe","nb_uo"];
var simulator_in_index= 0;
var presult = new Array()
presult[0] = "";
presult[1] = "";
presult[2] = "";
presult[3] = "";
var rr  = new Array();
var clicked = false;
var page = 0;
var page_loaded  = false;
var page_finished = false;
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
    heightResize()
}

function getResultFromDatabase(){
  simulator_in_index = 0;
  var typeo = simulator_in[simulator_in_index];

  if(round > 0){
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/get_more/power_data-simulator',
        data:{round:round,type:typeo,start_round:start_round},
        success:function(data,textStatus){
           for(var i = 0 ;i < simulator_in.length;i++){
             if(simulator_in[i] == "pb_oe")
            {
              if(data.pb_oe.status == 1){
                var tem = "";
                var alias = result["pb_oe"]["alias"]
                result["pb_oe"] = data.pb_oe.result;
                result["pb_oe"]["alias"] = alias;
                rr[0] = data.pb_oe.result.list;
              }
            }
             if(simulator_in[i] == "pb_uo")
            {
              if(data.pb_uo.status == 1){
                var tem = "";
                var alias = result["pb_uo"]["alias"]
                result["pb_uo"] = data.pb_uo.result;
                result["pb_uo"]["alias"] = alias;
                rr[1] = data.pb_uo.result.list;
              }
            }
             if(simulator_in[i] == "nb_oe")
            {
              if(data.nb_oe.status == 1){
                var tem = "";
                var alias = result["nb_oe"]["alias"]
                result["nb_oe"] = data.nb_oe.result;
                result["nb_oe"]["alias"] = alias;
                rr[2] = data.nb_oe.result.list;
              }
            }
             if(simulator_in[i] == "nb_uo")
            {
              if(data.nb_uo.status == 1){
                var tem = "";
                var alias = result["nb_uo"]["alias"]
                result["nb_uo"] = data.nb_uo.result;
                result["nb_uo"]["alias"] = alias;
                rr[3] = data.nb_uo.result.list;
              }
            }


             // setTimeout(function(){
             //   compileJson("#pattern-date",".pattern-tr",result["pb_uo"],2);
             // },400)
             // compileJson("#pattern-date",".pattern-tr",result["pb_uo"],2);
             // compileJson("#pattern-date",".pattern-tr",result["nb_oe"],2);
             // compileJson("#pattern-date",".pattern-tr",result["nb_uo"],2);
           }
           compileJson("#pattern-date",".pattern-tr",result["pb_oe"],2);
           compileJson("#pattern-date",".pattern-tr",result["pb_uo"],2);
           compileJson("#pattern-date",".pattern-tr",result["nb_oe"],2);
           compileJson("#pattern-date",".pattern-tr",result["nb_uo"],2);
           $('.pattern-t').animate({scrollLeft:10000},100);
           processResult();
        }
    }).done(function(){
      loading  = false;
    })
  }
  else{
    compileJson("#pattern-date",".pattern-tr",result["pb_oe"],2);
    compileJson("#pattern-date",".pattern-tr",result["pb_uo"],2);
    compileJson("#pattern-date",".pattern-tr",result["nb_oe"],2);
    compileJson("#pattern-date",".pattern-tr",result["nb_uo"],2);
  }
}

function hideType(type,obj){
    $(".auto-content").css("height","unset")
    $(".auto-content").css("overflow","unset")
    $(".category-auto").removeClass("text-danger")
    $(".category-auto").addClass("text-white")
    $(obj).removeClass("text-white")
    $(obj).addClass("text-danger")
    if(type == 1){
        $(".mulebanga").show();
        $(".autopattern").hide();
    }
    else{
        $(".mulebanga").hide();
        $(".autopattern").show();
    }
    heightResize();
    setCookie("simulate_tap",type,3);
}

function saveAutoSetting(){
    if(started > 0)
    {
        alertifyByCommon("게임중지후 이용해주세요");
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
              alertifyByCommon("성공적으로 저장되였습니다.");
              if(amount > 0){
                  $(".start-amount").text(number_format(amount)+"원");
                  $(".saved-amount").text(number_format(amount)+"원");
                  $(".profit-amount").text("0원");
              }
              $(".start-round").text(start.substr(start.length-3,3));
              $(".end-round").text(end.substr(end.length-3,3));
          }
          else
              alertifyByCommon("처리중 오류가 발생하였습니다.");
        }
    }).done(function(){
        $('#settingWindow').modal('toggle')
    });
}

$(document).ready(function(){

  var simulate_tap = getCookie("simulate_tap");
  if( typeof simulate_tap == "undefined" || simulate_tap == null || simulate_tap.trim() == "" || simulate_tap == 1){
    $("#category-auto1").addClass("text-danger")
    $("#category-auto1").removeClass("text-white")
    $("#category-auto2").addClass("text-white")
    $("#category-auto2").removeClass("text-danger")
    $(".mulebanga").show();
    $(".autopattern").hide();
  }
  else{
    $("#category-auto1").addClass("text-white")
    $("#category-auto1").removeClass("text-danger")
    $("#category-auto2").addClass("text-danger")
    $("#category-auto2").removeClass("text-white")
    $(".mulebanga").hide();
    $(".autopattern").show();
    $(".auto-content").css("height","355px");
  }
  $('.editor-text').on('DOMSubtreeModified', function(){
      $(this).parent().find("textarea").val($(this).html());
  });
    if(started > 0)
    {
      checkTimer();
    }

    api_token = $("#api_token").val();
    $("#btn-money-keep").click(function(){
        $(".first-martin").each(function(index,value){
            if($(value).val().trim() == "" || $(value).val().trim() <=0 ){
                return false;
            }
            steps.push($(value).val().replaceAll(/,/ig,''));
        });
        if(steps.length ==0)
        {
            alertifyByCommon("금액이 비였습니다.")
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
                    alertifyByCommon("성공적으로 저장되였습니다.");
                }
                else
                    alertifyByCommon("처리중 오류가 발생하였습니다.");
            }
        });
    });
    $("#martin-apply").click(function(){
        var martin = $("#martin-multi").val();
        var init = 0;
        $(".first-martin").each(function(index,value){
            if(index ==0 && ($(value).val().trim() == "" || $(value).val().trim() <=0) ){
                alertifyByCommon("금액이 설정되여 있지 않습니다.")
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
    getResultFromDatabase();
    getPageLog()

    $(".log-part").scroll(function(){
      if($(".log-part").scrollTop() == 0){
        getPageLog();
      }
    })
})


function processAutoStart(code,type){

    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/setAutoStart',
        data:{api_token:api_token,code:code,type:type},
        success:function(data,textStatus){
            location.reload();
        }
    }).fail(function(xhr){
      console.log(xhr)
    })
}

function savePattern(tt,var_type,callback){

    if(started >0){
        alertifyByCommon("배팅중지후 설정해주세요");
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



function savePatt(tt=type,alert=true,callback){
    if(check_save){
        check_save  = false;
        savePattern(tt,1,function(){
            savePattern(tt,2,function(){
                savePattern(tt,3,function(){
                    check_save  = true;
                    if(alert == true) alertifyByCommon("저장되였습니다.");
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
                        alertifyByCommon("저장되였습니다.");
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
        full = 20;
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

function save(){
  var myform = document.getElementById("autoForm");
  var fd = new FormData(myform);
  $.ajax({
      url:'/api/setAutoMatch',
      data: fd,
      cache: false,
      processData: false,
      contentType: false,
      type: 'POST',
      dataType:"json",
      success: function(data){
        console.log(data)
        if(data.status == "1")
        {
            alertifyByCommon("성공적으로 저장되였습니다.");
        }
        else
            alertifyByCommon(data.msg);
      }
  })
}

function saveGameSettings(){
  var myform = document.getElementById("gameForm");
  var fd = new FormData(myform);
  $.ajax({
      url:'/api/setGameSettings',
      data: fd,
      cache: false,
      processData: false,
      contentType: false,
      type: 'POST',
      dataType:"json",
      success: function(data){
        console.log(data)
        if(data.status == "1")
        {
            alertifyByCommon("성공적으로 저장되였습니다.");
        }
        else
            alertifyByCommon(data.msg);
      }
  }).fail(function(xhr){
    console.log(xhr)
  })
}




function setCaret(el,line=0,start,end,color = "blue") {
    var range = document.createRange()
    var sel = window.getSelection()
    if(el.childNodes.length > 0){
      if(typeof el.childNodes[line].firstChild == "undefined" ||  el.childNodes[line].firstChild == null)
        var temp = el.childNodes[line];
      else {
        var temp = el.childNodes[line].firstChild;
      }
      range.setStart(temp, start)
      range.setEnd(temp, end)
      var sel = window.getSelection();
      sel.removeAllRanges();
      sel.addRange(range);
      document.execCommand ('backColor', false, color);
      document.execCommand ('foreColor', false, "#FFF");
      var scrollTop = line > 0 ? line-1 : line
      $(el).parent().scrollTop(scrollTop * 19)
      sel.removeAllRanges();
    }
}

function setCaretToHtml(el,html,index){
  $(el).html(html)
  var el_offset = $(el).offset();
  var displayed_offset = $(".displayed-pick"+index).offset();
  var moved_left = displayed_offset.left - el_offset.left;
  var moved_top = displayed_offset.top - el_offset.top;
  if(moved_left <=20)
    moved_left = 0;
  if(moved_top <=100)
    moved_top = 0;
  if(moved_top >100)
    moved_top -=20 ;
  moved_left -=25;
  $(el).parent().animate({scrollLeft:moved_left,scrollTop:moved_top},100);
}

function getdataFromLine(el,line){
  temp = "";
  var outTer = el.outerText.split("\n");
  return outTer[line];
}

function processResult(){
  rr.forEach(function(val,key) {
      var tye = key;
      var temp = "";
      val.forEach(function(val1,key1){
        if(val1.type == "odd" || val1.type == "under"){
          for(var i = 0 ;i < val1.list.length ; i++){
            temp =  temp + "1"
          }
        }
        else{
          for(var i= 0 ;i < val1.list.length; i++){
            temp =  temp + "0"
          }
        }
      })
      if(temp != ""){
        presult[key] = temp.replaceAll("2","0")
      }
  });
  var p1 = document.getElementsByClassName("p1");
  $('.p1').each(function(i, obj) {
      var html_dom = $(obj)[0];
      if(typeof patts1[i+1] !="undefined" && patts1[i+1].money !="" && patts1[i+1].pattern !=""){
        var mny = getdataFromLine($(".amount1")[0],patts1[i+1].amount_step);
        if(mny == null || isNaN(mny)){

        }
        else{
          var step = parseInt(patts1[i+1].step);
          setCaret(html_dom,0,step,step+1)
          setCaret($(".amount1")[i],parseInt(patts1[i+1].amount_step),0,mny.length)
        }
      }
  }).promise().done( function(){
      $('.p2').each(function(i, obj) {
          var html_dom = $(obj)[0];
          if(typeof patts2[i+1] !="undefined" &&  patts2[i+1].pattern.trim() !=""){
            var pattern =  new Array()
            var compare_pattern = new Array()
            var pick = new Array()
            var pattern_split  = $(html_dom)[0].innerHTML.trim().split("</div>");
            pattern_split.forEach(function(val,key){
              if(key == 0){
                var div_split = val.split("<div>")
                if(div_split.length == 2)
                  {
                    if(div_split[0].trim() !=""){
                      pattern.push(div_split[0])
                    }
                    if(div_split[1].trim() !=""){
                      pattern.push(div_split[1])
                    }
                  }
                else
                  pattern.push(div_split[0])
              }
              else{
                var divv_split = val.split("<div>")
                if(typeof divv_split[1] != "undefined")
                  pattern.push(divv_split[1])
              }
            })

            if(pattern.length > 0 && pattern[0] != ""){
              var step = parseInt(patts2[i+1].step);
              var cruiser = parseInt(patts2[i+1].cruiser);
              var past_step = patts2[i+1].past_step;
              var past_cruiser = patts2[i+1].past_cruiser;
              if(typeof pattern[step].split("/")[cruiser] != "undefined")
              {
                var cruiser_arr = pattern[step].split("/")
                var current_part = cruiser_arr[cruiser]
                var header_split = current_part.split("단-")
                if(header_split.length == 2)
                  header_split = header_split[1];
                else
                  header_split = header_split[0];

                dash_split = header_split.split(":")
                dash_split.splice(0,1)
                if(past_cruiser.trim() != "" && past_cruiser.trim() != ""){
                  past_step = parseInt(past_step);
                  past_cruiser = parseInt(past_cruiser);
                  if(typeof pattern[past_step].split("/")[past_cruiser] != "undefined" && past_step != step){
                    var past_split_cruiser = pattern[past_step].split("/");
                    past_split_cruiser[past_cruiser] = "*<sbp*"+past_split_cruiser[past_cruiser]+"*s>*";
                    pattern[past_step] = past_split_cruiser.join("/");
                  }
                  if(past_step == step && cruiser != past_cruiser && typeof cruiser_arr[past_cruiser] != "undefined"){
                    cruiser_arr[past_cruiser] = "*<sbp*"+cruiser_arr[past_cruiser]+"*s>*";
                  }
                }
                cruiser_arr[cruiser] = "*<sbb*"+cruiser_arr[cruiser]+"*s>*";
                pattern[step] = cruiser_arr.join("/")
                dash_split.forEach(function(dash_val,dash_key){
                  var com_pattern = dash_val.split("-")
                  compare_pattern.push(dash_val)
                })

                if(compare_pattern.length > 0  && presult[i % 4].length > 0){
                  compare_pattern.sort(function(a, b){
                    return b.length - a.length;
                  });
                  compare_pattern.forEach(function(compare_val,compare_key){
                    var splitbyDash = compare_val.split("-")
                    if(splitbyDash[0].replaceAll("2","0") == presult[i % 4].substring(presult[i % 4].length - splitbyDash[0].length)){
                        var offer_index =  0;
                        offer_index = cruiser_arr[cruiser].indexOf(compare_val)
                        cruiser_arr[cruiser] = cruiser_arr[cruiser].slice(0, offer_index) + "*<fcr*" + cruiser_arr[cruiser].slice(offer_index);
                        offer_index = cruiser_arr[cruiser].indexOf(compare_val)
                        cruiser_arr[cruiser] = cruiser_arr[cruiser].slice(0, offer_index+compare_val.length) + "*f>*" + cruiser_arr[cruiser].slice(offer_index+compare_val.length);
                        var packed_cruiser = cruiser_arr.join("/");
                        pattern[step] = packed_cruiser;
                    }
                  })
                }
              }
              var total = "";
              var left = 0;
              for(var pattern_index =0; pattern_index < pattern.length; pattern_index++){
                total +="<div>"+pattern[pattern_index]+"</div>";
              }

              total = total.replaceAll("*<sbb*","<span class='displayed-pick"+i+"' style='background:blue;color:white'>").
                            replaceAll("*<fcr*","<span style='background:red;font-weight:bold'>").
                            replaceAll("*<sbp*","<span style='background:pink;color:white'>").
                            replaceAll("*f>*","</span>").
                            replaceAll("*s>*","</span>");
              setCaretToHtml(html_dom,total,i);
            }
          }
      }).promise().done( function(){
      });
  });

}

function doRest(id,obj){
  if(!clicked)
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/setIndividualGame',
        data:{id:id,api_token:api_token,type:"rest"},
        beforeSend:function(){
          clicked = true;
        },
        success:function(data,textStatus){
          if(data.status ==1){
              if(data.type == 0) $(obj).text("시작")
              else $(obj).text("휴식")
          }
          else {
            alertifyByCommon(data.msg)
          }
        }
    }).done(function(){
      clicked = false;
    })
}
function doInit(id){
  if(!clicked)
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/setIndividualGame',
        data:{id:id,api_token:api_token,type:"init"},
        beforeSend:function(){
          clicked = true;
        },
        success:function(data,textStatus){
          if(data.status ==1){
              alertifyByCommon("초기화되였습니다.")
          }
          else {
            alertifyByCommon(data.msg)
          }
        }
    }).done(function(){
      clicked = false;
    })
}

function getPageLog(){
  if(!page_loaded || !page_finished)
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'/api/getLogData',
        data:{page:page,api_token:api_token},
        beforeSend:function(){
          page_loaded = true;
        },
        success:function(data,textStatus){
          if(data.status ==1){
              compileJson("#log-data",".infinite-scroll",data.result,10)
              if(page == 0)
                $('.log-part').animate({scrollTop:10000},0);
              else {
                $('.log-part').animate({scrollTop:$('.log-part').height()},0);
              }
              page++;
          }
          else{
            page_finished  = true;
          }
        }
    }).done(function(){
      page_loaded = false;
    })
}
