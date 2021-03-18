var pattern_alias = new Array();
pattern_alias["pb_oe"] = new Array();
pattern_alias["nb_size"] =  new Array();
pattern_alias["pb_uo"] = new Array();
pattern_alias["nb_oe"] = new Array();
pattern_alias["nb_uo"] = new Array();

pattern_alias["pb_oe"]["p1"] = "홀";
pattern_alias["pb_oe"]["p0"] = "짝";
pattern_alias["pb_uo"]["p1"] = "";
pattern_alias["pb_uo"]["p0"] = "";
pattern_alias["nb_oe"]["p1"] = "홀";
pattern_alias["nb_oe"]["p0"] = "짝";
pattern_alias["nb_uo"]["p1"] = "";
pattern_alias["nb_uo"]['p0'] = "";
pattern_alias["nb_size"]['p1'] = "소";
pattern_alias["nb_size"]['p2'] = "중";
pattern_alias["nb_size"]['p3'] = "대";
window.chartColors = {
    red: 'rgb(255, 62, 63)',
    orange: 'rgb(47, 118, 236)',
    yellow: 'rgb(38, 173, 96)'
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

function compileJson(from,to,json,type=1,frame_reset = 1){

    var template = $(from).html();
    var compiled_template = Handlebars.compile(template);
    var rendered = compiled_template(json);
    if(type == 2)
        $(to).append(rendered);
    else
        $(to).html(rendered);
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

function  douPie(data,to,label = ""){
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
            backgroundColor: [
                window.chartColors.red,
                window.chartColors.orange,
                window.chartColors.yellow,
            ],

        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: label,
    };
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
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


Handlebars.registerHelper('index_of', function(context,ndx) {
    return context[ndx];
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

Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
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
    if(arg2 =="pb_uo" || arg2 =="nb_uo"){
        if(arg1[arg2] =="1") return "sp-under";
        else return "sp-over";
    }
    if(arg2 == "nb_size"){
        if(arg1[arg2] == "1") return "sp-small";
        if(arg1[arg2] == "2") return "sp-middle";
        else return "sp-big";
    }
});

Handlebars.registerHelper('oddClassAlias', function(arg1,arg2) {
    return pattern_alias[arg2]["p"+arg1[arg2]];
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


