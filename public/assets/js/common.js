var pattern_alias = new Array();
pattern_alias["pb_oe"] = new Array();
pattern_alias["nb_size"] =  new Array();
pattern_alias["pb_uo"] = new Array();
pattern_alias["nb_oe"] = new Array();
pattern_alias["nb_uo"] = new Array();
pattern_alias["left_right"] = new Array();
pattern_alias["odd_even"] = new Array();
pattern_alias["three_four"] = new Array();
pattern_alias["total"] = new Array();

pattern_alias["pb_oe"]["p1"] = "홀";
pattern_alias["pb_oe"]["p0"] = "짝";
pattern_alias["pb_uo"]["p1"] = "언";
pattern_alias["pb_uo"]["p0"] = "오";
pattern_alias["nb_oe"]["p1"] = "홀";
pattern_alias["nb_oe"]["p0"] = "짝";
pattern_alias["nb_uo"]["p1"] = "언";
pattern_alias["nb_uo"]['p0'] = "오";
pattern_alias["nb_size"]['p1'] = "소";
pattern_alias["nb_size"]['p2'] = "중";
pattern_alias["nb_size"]['p3'] = "대";

pattern_alias["left_right"]["p1"] = "좌";
pattern_alias["left_right"]["p0"] = "우";
pattern_alias["odd_even"]["p1"] = "홀";
pattern_alias["odd_even"]["p0"] = "짝";
pattern_alias["three_four"]["p1"] = "3";
pattern_alias["three_four"]["p0"] = "4";

pattern_alias["total"]["p1"] = "좌4";
pattern_alias["total"]["p2"] = "우3";
pattern_alias["total"]["p3"] = "좌3";
pattern_alias["total"]["p4"] = "우4";

pattern_alias["nb_uo"][0] = "오";
pattern_alias["nb_uo"][1] = "언";
pattern_alias["pb_uo"][0] = "오";
pattern_alias["pb_uo"][1] = "언";

window.chartColors = {
    red: 'rgb(255, 62, 63)',
    orange: 'rgb(47, 118, 236)',
    yellow: 'rgb(38, 173, 96)'
};

window.chartColors1 = {
    red: '#3498db',
    orange: '#2980b9',
    yellow: '#e74c3c',
    pick :  '#c0392b'
};
/*  php array_coount_values 함수대신 사용  */
function arrayCountValues (arr) {
    var v, freqs = {};

    // for each v in the array increment the frequency count in the table
    for (var i = arr.length; i--; ) {
        v = arr[i];
        if (freqs[v]) freqs[v] += 1;
        else freqs[v] = 1;
    }

    // return the frequency table
    return freqs;
}

/*  파워볼 연속 데이터 최대값 얻는 모듈  */
function  getMinMax(str,index){
    var pb_resultlists = str.split(",");
    var max = 0;
    var temp = 0;
    for(var i=0;i<pb_resultlists.length;i++){
        if (pb_resultlists[i] == index) {
            temp++;
        } else {
            if (max < temp)
                max = temp;
            temp = 0;
        }
    }
    return max;
}

function compileJson(from,to,json,type=1,frame_reset = true){

    var template = $(from).html();
    var compiled_template = Handlebars.compile(template);
    var rendered = compiled_template(json);
    if(type == 2)
        $(to).append(rendered);
    if(type ==1)
        $(to).html(rendered);
    if(type == 10)
        $(to).prepend(rendered);
    if(frame_reset)
        heightResize();
}

function emptyReload(msg ="자료가 비였습니다."){
    alert(msg);
    location.reload();
}

function moreLoad(show){
    if(show ==1){
        $(".displayNone").removeClass("d-none");
        $(".moreBox a").addClass("d-none");
    }
    else
    {
        $(".displayNone").addClass("d-none");
        $(".moreBox a").removeClass("d-none");
    }
}



function goErrorPopup(msg){
    $('.sm-message .modal-body').html(msg);
    $('.sm-message').modal('show')
}

function  douPie(data,to,label = "",background = [
    window.chartColors.red,
    window.chartColors.orange,
    window.chartColors.yellow]){
    var ctx = document.getElementById(to).getContext('2d');
    var data = {
        datasets: [{
            data: data,
            weight:1,
            borderAlign:"left",
            borderWidth : 1,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            },
            backgroundColor: background,

        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: label,
    };
    var myDoughnutChart = new Chart(ctx, {
        type: 'pie',
        data: data
    });
}

function isNumber(event)
{
    var keyCode = event.keyCode;

    if(event.shiftKey)
    {
        return false;
    }

    if(keyCode >= 48 && keyCode <= 59)	// 0~9
    {
        return true;
    }
    else if(keyCode >= 96 && keyCode <= 105)	// keypad 0~9 (NumLock On)
    {
        return true;
    }
    else if(keyCode == 8 || keyCode == 46)	// backspace, delete
    {
        return true;
    }

    return false;
}

Handlebars.registerHelper('percentageofTwo', function(context,ndx) {
    var sum = context[0] +  context[1];
    if(sum == 0) sum = 1;
    return 100 * context[ndx] / sum;
});


Handlebars.registerHelper('index_of', function(context,ndx) {
    return context[ndx];
});

Handlebars.registerHelper("index_ofWithPick",function(context,type,ndx){
  if(type == "oe"){
    if(context[ndx].pick == 1)
      return "<div class='sp-odd'>홀</div>";
    else {
        return "<div class='sp-even'>짝</div>";
    }
  }
  else{
    if(context[ndx].pick == 1)
      return "<div class='sp-under'></div>";
    else {
        return "<div class='sp-over'></div>";
    }
  }
});

Handlebars.registerHelper('index_ofWithKey', function(context,ndx,key) {
    if(context.hasOwnProperty(ndx) ==true)
        return context[ndx][key];
    else
    {
        if(key =="class") return "WAIT";
        else return "?";
    }
});

Handlebars.registerHelper('index_ofWithKeyPer', function(context,ndx,key) {
    if(context.hasOwnProperty(ndx) ==true)
        return (context[ndx][key] * 100 / (context[ndx][0] + context[ndx][1])).toFixed(2);
    else
        return 0;
});


Handlebars.registerHelper('index_ofWithKeyPerSadari', function(context,ndx,key) {
    if(context.hasOwnProperty(ndx) ==true)
    {
        let sum = 1;
        if(key == "LEFT" || key == "RIGHT")
            sum = context[ndx]["LEFT"] + context[ndx]["RIGHT"];
        else if(key == "_3" || key == "_4")
            sum = context[ndx]["_3"] + context[ndx]["_4"];
        else if(key == "odd" || key== "even")
            sum = context[ndx]["odd"] + context[ndx]["even"];
        else
        {
            if(typeof context[ndx]["LEFT4ODD"] == "undefined")
                context[ndx]["LEFT4ODD"] = 0;
            if(typeof context[ndx]["LEFT3EVEN"] == "undefined")
                context[ndx]["LEFT3EVEN"] = 0;
            if(typeof context[ndx]["RIGHT4EVEN"] == "undefined")
                context[ndx]["RIGHT4EVEN"] = 0;
            if(typeof context[ndx]["RIGHT3ODD"] == "undefined")
                context[ndx]["RIGHT3ODD"] = 0;
            sum = context[ndx]["LEFT4ODD"] + context[ndx]["LEFT3EVEN"] + context[ndx]["RIGHT4EVEN"] + context[ndx]["RIGHT3ODD"];
        }
        if(typeof sum == "undefined" || sum == 0) sum = 1;
        return (context[ndx][key] * 100 / (sum)).toFixed(2);
    }
    else
        return 0;
});


Handlebars.registerHelper("inc", function(value, options)
{
    return parseInt(value) + 1;
});

Handlebars.registerHelper('minus', function(a,b) {
    return a - b;
});

Handlebars.registerHelper('times', function(n1,n2, block) {
    var n = n1 - n2;
    if(n <=0 )
        return "";
    var accum = '';
    for(var i = 0; i < n; ++i)
        accum += block.fn(i);
    return accum;
});

Handlebars.registerHelper('returnPer', function(context,index) {

    var sum = 0;
    var i = 0,until=2;
    if(context[3] != undefined){
        i = 1;
        until = 4;
    }
    for( var context_i = i; context_i< until ; context_i ++)
        sum += parseFloat(context[context_i]);
    if(sum == 0 || context[index] == 0)
        return 0;
    return (100 * (parseFloat(context[index])/sum)).toFixed(2);
});

Handlebars.registerHelper('returnPerSadari', function(context,index) {

    var sum = 0;
    var i = 0,until=2;

    if(index == "odd" || index == "even")
        sum += parseFloat(context["odd"]) + parseFloat(context["even"])
    else if(index == "LEFT" || index == "RIGHT")
        sum += parseFloat(context["LEFT"]) + parseFloat(context["RIGHT"])
    else if(index == "_3" || index == "_4")
        sum += parseFloat(context["_3"]) + parseFloat(context["_4"])
    else if(index == "RIGHT4EVEN" || index == "RIGHT3ODD" || index == "LEFT4ODD" || index == "LEFT3EVEN")
        sum += parseFloat(context["RIGHT4EVEN"]) + parseFloat(context["RIGHT3ODD"]) + parseFloat(context["LEFT4ODD"]) + parseFloat(context["LEFT3EVEN"])
    if(sum == 0 || context[index] == 0)
        return 0;
    return (100 * (parseFloat(context[index])/sum)).toFixed(2);
});

Handlebars.registerHelper('compareBig', function(arg1,arg2,options) {
    if(parseInt(arg1) > parseInt(arg2))
        return options.fn(this);
    else
        return options.inverse(this);
});

Handlebars.registerHelper('removeMinus', function(arg1) {
    return -1*arg1
});

Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
    if(arg1 == null || typeof arg1 =='undefined') arg1 = "";
    if(arg2 == null || typeof arg2 =='undefined') arg2 = "";
    if(!isNaN(arg1)){
        arg1 = arg1.toString();
    }
    if(!isNaN(arg2)){
        arg2 = arg2.toString();
    }
    var splited = arg2.split("/");
    var bools = 0;
    splited.forEach(function(entry){
        if(arg1 == entry) bools = 1;
    })
    if(bools == 1)
        return options.fn(this);
    else
        return options.inverse(this);

});

Handlebars.registerHelper('bigSmall', function(arg1,arg2,arg3,options) {
    if(arg3 ==1){
        var max = Math.max(arg1[0],arg1[1]);
        var min = Math.min(arg1[0],arg1[1]);
    }
    else{
        var max = Math.max(arg1[3],arg1[2],arg1[1]);
        var min = Math.min(arg1[3],arg1[2],arg1[1]);
    }

    if(arg1[arg2] == max && max != min){
        return options.fn(this);
    }
    else{
        return options.inverse(this);
    }
});

Handlebars.registerHelper('bigSmallSadari', function(arg1,arg2,arg3,options) {
    if(arg3 == "left_right"){
        var max = Math.max(arg1["LEFT"],arg1["RIGHT"]);
        var min = Math.min(arg1["LEFT"],arg1["RIGHT"]);
    }
    if(arg3 == "three_four"){
        var max = Math.max(arg1["_3"],arg1["_4"]);
        var min = Math.min(arg1["-3"],arg1["_4"]);
    }
    if(arg3 == "odd_even"){
        var max = Math.max(arg1["odd"],arg1["even"]);
        var min = Math.min(arg1["odd"],arg1["even"]);
    }
    if(arg3 == "total_lines"){
        var max = Math.max(arg1["LEFT4ODD"],arg1["LEFT3EVEN"],arg1["RIGHT4EVEN"],arg1["RIGHT3ODD"]);
        var min = Math.min(arg1["LEFT4ODD"],arg1["LEFT3EVEN"],arg1["RIGHT4EVEN"],arg1["RIGHT3ODD"]);
    }

    if(arg1[arg2] == max && max != min){
        return options.fn(this);
    }
    else{
        return options.inverse(this);
    }
});

Handlebars.registerHelper('displayTime', function(arg) {
    var result = "";
    arg = arg.split(" ");
    if(arg.length ==2)
        arg = arg[1];
    arg = arg.split(":");
    if(arg.length ==3)
        result = arg[0]+ ":"+arg[1];
    return result;
});

Handlebars.registerHelper('npTerm', function(arg1, arg2) {
    var output = "";
    if(arg2 == 1)
    {
        if(arg1 >-1 && arg1 < 3 )
            output = "A (0~2)";
        if(arg1 == 3 || arg1 == 4)
            output = "B (3~4)";
        if(arg1 == 5 || arg1 == 6)
            output = "C (5~6)";
        if(arg1 > 6 && arg1 < 10)
            output = "D (7~9)";
    }
    if(arg2 ==2){
        if(arg1 >= 15 && arg1 <= 35)
            output = "A (15~35)";
        if(arg1 >= 36 && arg1 <= 49)
            output = "B (36~49)";
        if(arg1 >= 50 && arg1 <= 57)
            output = "C (50~57)";
        if(arg1 >= 58 && arg1 <= 65)
            output = "D (58~65)";
        if(arg1 >= 66 && arg1 <= 78)
            output = "E (66~78)";
        if(arg1 >= 79 && arg1 <= 130)
            output = "F (15~35)";
    }
    return output;
});

Handlebars.registerHelper('nbSize', function(arg) {
    var result = "";

    if(arg >= 15 && arg <= 64)
        result = "소 (15~64)";
    if(arg >= 65 && arg <= 80)
        result = "중 (65~80)";
    if(arg >= 81 && arg <= 130)
        result = "대 (81~130)";
    return result;
});

Handlebars.registerHelper('perOfDay', function(arg) {
    return ((arg / 288) * 100).toFixed(2);
});

Handlebars.registerHelper('for', function(from, to, incr, block) {
    var accum = '';
    if(typeof  from == "string")
        from = parseInt(from)
    if(typeof  to == "string")
        to = parseInt(to)
    for(var i = from; i < to; i += incr)
        accum += block.fn(i);
    return accum;
});

Handlebars.registerHelper('perOfDayFromArray', function(arg1,arg2) {
    return ((arg1[arg2] / 288) * 100).toFixed(2);
});

Handlebars.registerHelper('subRoundUntilThr', function(arg) {
    return arg.toString().substr(4);
});

Handlebars.registerHelper('oddClass', function(arg1,arg2) {
    if(arg2 =="pb_oe" || arg2 =="nb_oe"){
        if(arg1[arg2] =="1") return "sp-odd";
        else return "sp-even";
    }
    else if(arg2 =="pb_uo" || arg2 =="nb_uo"){
        if(arg1[arg2] =="1") return "sp-odd";
        else return "sp-even";
    }
    else if(arg2 == "nb_size"){
        if(arg1[arg2] == "1") return "sp-small";
        if(arg1[arg2] == "2") return "sp-middle";
        else return "sp-big";
    }
    else{
        if(!isNaN(arg1["nb1"]))
            arg1["nb1"] = parseInt(arg1["nb1"]);
        if(arg2 == "odd_even"){
            if([15,17,19,21,23,25,27,2,4,6,8,10,12,14].includes(arg1["nb1"]))
                return "sp-odd";
            else return "sp-even";
        }
        if(arg2 == "left_right"){
            if([1,3,5,7,9,11,13,15,17,19,21,23,25,27].includes(arg1["nb1"]))
                return "sp-odd";
            else return "sp-even";
        }
        if(arg2 == "three_four"){
            if([1,2,3,4,5,6,7,8,9,10,11,12,13,14].includes(arg1["nb1"]))
                return "sp-odd";
            else return "sp-even";
        }
        if(arg2 == "total")
        {
            if([1,3,5,7,9,11,13].includes(arg1["nb1"]))
                return "LEFT3EVEN";
            else if([15,17,19,21,23,25,27].includes(arg1["nb1"]))
                return "LEFT4ODD";
            else if([2,4,6,8,10,12,14].includes(arg1["nb1"]))
                return "RIGHT3ODD";
            else return "RIGHT4EVEN";
        }
    }
});

function setAliasSadari(arg1,arg2){
    if(arg2 == "odd_even"){
        if([15,17,19,21,23,25,27,2,4,6,8,10,12,14].includes(arg1))
            return "odd";
        else return "even";
    }
    if(arg2 == "left_right"){
        if([1,3,5,7,9,11,13,15,17,19,21,23,25,27].includes(arg1))
            return "LEFT";
        else return "RIGHT";
    }
    if(arg2 == "three_four"){
        if([1,2,3,4,5,6,7,8,9,10,11,12,13,14].includes(arg1))
            return "_3";
        else return "_4";
    }
    if(arg2 == "total_lines")
    {
        if([1,3,5,7,9,11,13].includes(arg1))
            return "LEFT3EVEN";
        else if([15,17,19,21,23,25,27].includes(arg1))
            return "LEFT4ODD";
        else if([2,4,6,8,10,12,14].includes(arg1))
            return "RIGHT3ODD";
        else return "RIGHT4EVEN";
    }
}

Handlebars.registerHelper('oddClassAlias', function(arg1,arg2) {
    if(arg2 == "left_right" || arg2 == "odd_even" || arg2 == "three_four" || arg2 == "total"){
        alias = "";
        if(arg2 == "odd_even"){
            if([15,17,19,21,23,25,27,2,4,6,8,10,12,14].includes(arg1["nb1"]))
                alias = "1";
            else alias = "0";
        }
        if(arg2 == "left_right"){
            if([1,3,5,7,9,11,13,15,17,19,21,23,25,27].includes(arg1["nb1"]))
                alias = "1";
            else alias = "0";
        }
        if(arg2 == "three_four"){
            if([1,2,3,4,5,6,7,8,9,10,11,12,13,14].includes(arg1["nb1"]))
                alias = "1";
            else alias = "0";
        }
        if(arg2 == "total")
        {
            if([1,3,5,7,9,11,13].includes(arg1["nb1"]))
                alias = "1";
            else if([15,17,19,21,23,25,27].includes(arg1["nb1"]))
                alias = "2";
            else if([2,4,6,8,10,12,14].includes(arg1["nb1"]))
                alias = "3";
            else alias = "4";
        }
        return pattern_alias[arg2]["p"+alias];
    }
    else
        return pattern_alias[arg2]["p"+arg1[arg2]];
});

Handlebars.registerHelper('loadLevelImage', function(arg) {
    return level_images[arg]
});

Handlebars.registerHelper("displayKTime",function(arg,arg1 = 1){
   if(arg1 == 1)
       return diff_minutes(calcTime("+9"),arg);
   else
       return diff_minutes(calcTime("+9"),new Date(arg));
});
Handlebars.registerHelper("checkCurWin",function(arg){
    if(arg !=null && typeof arg !="undefined" && arg.trim() != ""){
        let parsed_history = JSON.parse(arg)
        if(parsed_history.current_win > 0){
            return "<div class=\"winFixCnt\" style=\"z-index:100;\">"+parsed_history.current_win+"</div>";
        }
    }
    return "";
});

Handlebars.registerHelper("wl",function(arg,arg1){
   if(arg == null || arg.trim() == "")
       return 0;
   let parsed_wl = JSON.parse(arg);
   if(arg1 == "w")
       return parsed_wl.total.win;
   else
       return parsed_wl.total.lose;
});

Handlebars.registerHelper('displayImg', function(arg,arg1) {
    if(typeof arg != "undefined" && arg !=null){
        if(arg1 == 1)
            return arg["image"];
        else
            return arg["get_level"]["value3"];
    }
    return "/assets/images/mine/profile.png";
});

Handlebars.registerHelper('processBettingData', function(arg1,arg2) {

    const betting_data = JSON.parse(arg1);
    let lose = 0;
    let win = 0;
    let html = "";
    let label = "";
    for(var key in betting_data){
        let classs = "";
        if(key == "pb_oe"){
            if(betting_data[key].pick == 1) classs = "chat-pbodd";
            else classs = "chat-pbeven";
        }
        if(key == "pb_uo"){
            if(betting_data[key].pick == 1) classs = "chat-pbunder";
            else classs = "chat-pbover";
        }
        if(key == "nb_oe"){
            if(betting_data[key].pick == 1) classs = "chat-nbodd";
            else classs = "chat-nbeven";
        }
        if(key == "nb_uo"){
            if(betting_data[key].pick == 1) classs = "chat-nbunder";
            else classs = "chat-nbover";
        }
        if(key == "nb_size"){
            if(betting_data[key].pick == 3) {
                label = "대";
                classs = "chat-nbbig";
            }
            if(betting_data[key].pick == 2) {
                label = "중";
                classs = "chat-nbmiddle";
            }
            if(betting_data[key].pick == 1) {
                label = "소";
                classs = "chat-nbsmall";
            }
        }
        if(betting_data[key].is_win == 2)
        {
            classs = classs+" " + "not";
            lose +=1;
        }
        else
            win +=1;
        html += "<div class='"+classs+"'><div>"+label+"</div></div>";
    }
    var first = "<div class=\"pick nnonn\">"+html+"</div>";
    if( typeof arg2[0] != 'undefined' && typeof arg2[0]["nnn"] != 'undefined' && arg2[0]["nnn"] == -1)
    {
    }
    else
        first = first + "<div class=\"pickResultText\"><span class=\"win\">"+win+"</span>승<span class=\"bar\">/</span><span class=\"lose\">"+lose+"</span>패</div>";
    return first
});

Handlebars.registerHelper('checkSeqWin', function(arg) {
    let show = false;
    let badge_html  = "";
    if(arg.roomandpicture.item_use.length > 0 && diffDays(arg.roomandpicture.win_date) <=7){
        if(arg.roomandpicture.badge >= 5){
            badge_html +="<div class=\"badge1\" title=\"일주일 내에 5연승 기록이 있습니다\">\n" +
                "                <div class=\"sp-badge5_s\"></div>\n" +
                "            </div>";
        }
        if(arg.roomandpicture.badge >= 10){
            badge_html +="<div class=\"badge2\" title=\"일주일 내에 10연승 기록이 있습니다\">\n" +
                "                <div class=\"sp-badge10_s\"></div>\n" +
                "            </div>";
        }
        if(arg.roomandpicture.badge >= 15){
            badge_html +="<div class=\"badge3\" title=\"일주일 내에 15연승 기록이 있습니다\">\n" +
                "                <div class=\"sp-badge15_s\"></div>\n" +
                "            </div>";
        }
        if(arg.roomandpicture.badge >= 20){
            badge_html +="<div class=\"badge4\" title=\"일주일 내에 20연승 기록이 있습니다\">\n" +
                "                <div class=\"sp-badge20_s\"></div>\n" +
                "            </div>";
        }

    }

    return badge_html;
});


function number_format(user_input){
    var filtered_number = user_input.replace(/[^0-9]/gi, '');
    var length = filtered_number.length;
    var breakpoint = 1;
    var formated_number = '';

    for(i = 1; i <= length; i++){
        if(breakpoint > 3){
            breakpoint = 1;
            formated_number = ',' + formated_number;
        }
        var next_letter = i + 1;
        formated_number = filtered_number.substring(length - i, length - (i - 1)) + formated_number;

        breakpoint++;
    }

    return formated_number;
}

function calcTime(offset) {
    // create Date object for current location
    var d = new Date();

    // convert to msec
    // subtract local time zone offset
    // get UTC time in msec
    var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

    // create new Date object for different city
    // using supplied offset
    var nd = new Date(utc + (3600000*offset));

    // return time as a string
    return nd;
}

function powerballDiff(){
    var current = calcTime("+9");
    var second = current.getSeconds();
    var minute = current.getMinutes()
    var g_nMinute = 4 - (minute) % 5;
    var g_nSecond = 40 - second;
    --g_nSecond;
    if (g_nSecond < 0)
    {
        --g_nMinute;
        if (g_nMinute < 0)
            g_nMinute = 4;
        g_nSecond = 60 + g_nSecond;
    }
    return g_nMinute*60 + g_nSecond;
}

function diff_minutes(dt2, dt1,type=true)
{
    var diff =(dt2 - dt1) / 1000;
    var return_obj="";
    var minute = Math.abs(Math.round(diff / 60));
    var sec = Math.abs(Math.round(diff % 60));
    if(minute < 1)
    {
        if(sec ==0)
            return_obj = "방금";
        else
            return_obj = sec+"초";
    }
    if(type){
        if(minute >= 1 && minute < 60)
            return_obj = minute+"분";
        if(minute >=60)
            return_obj = Math.abs(Math.round(minute/60))+"시간";
        return return_obj;
    }
    else{
        if(minute < 5)
            return true;
        else return false;
    }
}

function get_time_diff( datetime )
{
    var datetime = typeof datetime !== 'undefined' ? datetime : "2014-01-01 01:02:03.123456";

    var datetime = new Date( datetime ).getTime();
    var now = calcTime("+9").getTime();

    if( isNaN(datetime) )
    {
        return "";
    }

    console.log( datetime + " " + now);

    if (datetime < now) {
        var milisec_diff = now - datetime;
    }else{
        var milisec_diff = datetime - now;
    }

    var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));

    var date_diff = new Date( milisec_diff );

    return days + " Days "+ date_diff.getHours() + " Hours " + date_diff.getMinutes() + " Minutes " + date_diff.getSeconds() + " Seconds";
}

function giftPop(itemCode,chargeType,itemCnt)
{
    windowOpen('/giftPop?itemCode='+itemCode+'&chargeType='+chargeType+'&itemCnt='+itemCnt,'giftPop',420,530,'no');
}
function windowOpen(src,target,width,height,scroll)
{
    var wid = (screen.availWidth - width) / 2;
    var hei = (screen.availHeight - height) / 2;
    var opt = 'width='+width+',height='+height+',top='+hei+',left='+wid+',resizable=no,status=no,scrollbars='+scroll;
    window.open(src,target,opt);
}


function diffDays(date){
    if(date != null && typeof date !="undefined"){
        var date1 = new Date(date);
        var date2 = new Date();
        var diffTime = Math.abs(date2 - date1);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }
    else{
        var diffDays = 100;
    }
    return diffDays;
}
