var diff, timer, request_time = 0;
var cookie = false;


function animation_default_setting() {
    sprite_smog.fps(5).play();
    sprite_light.fps(8).play();
    sprite_balls.fps(15).play();
}

function getColorStr(number) {
    let colorStr = '';
    if (number > 0 && number <= 7) {
        colorStr = 'yellow';
    } else if (number > 7 && number <= 14) {
        colorStr = 'blue';
    } else if (number > 14 && number <= 21) {
        colorStr = 'red';
    } else if (number > 21 && number <= 28) {
        colorStr = 'green';
    } else {
        colorStr = 'black';
    }
    return colorStr;
}

function getBallSteps(number) {
    let steps = [0, 0];
    if (number > 0 && number <= 7) {
        steps = [1, 12];
    } else if (number > 7 && number <= 14) {
        steps = [37, 48];
    } else if (number > 14 && number <= 21) {
        steps = [13, 24];
    } else if (number > 21 && number <= 28) {
        steps = [25, 36];
    } else {
        steps = [49, 60];
    }
    return steps;
}

function handleVisibilityChange() {
    if (document[getHiddenValue()]) {
        if (live_game_type == 'powerball') {
            live_game_board.is_play = true;
            $('#result_board div').hide();
            $('#div_background_wall').show();
            $('#div_machine_circle').show();
            $('#div_machine_light_side').show();
            $('#div_machine_glass').show();
            $('#div_machine_bottom').show();
            $('#score_board').show();
        }
    } else {
        location.reload();
    }
}

function getHiddenValue() {
    if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
        return "hidden";
    } else if (typeof document.msHidden !== "undefined") {
        return "msHidden";
    } else if (typeof document.webkitHidden !== "undefined") {
        return "webkitHidden";
    }
}

function getVisibilityValue() {
    if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
        return "visibilitychange";
    } else if (typeof document.msHidden !== "undefined") {
        return "msvisibilitychange";
    } else if (typeof document.webkitHidden !== "undefined") {
        return "webkitvisibilitychange";
    }
}

$(function () {


    // $('#btn_sound').click(function () {
    //     $(this).toggleClass("on", live_game_board.switch_sound().is_sound());
    // }).toggleClass("on", live_game_board.is_sound());

    // switch the sound off for mobile devices by default
    // $('.game_sound_toggle').click(function () {
    //     let state = live_game_board.switch_sound().is_sound()
    //     $(this).toggleClass("sound_on", state).toggleClass("sound_off", !state)
    // }).toggleClass("sound_on", live_game_board.is_sound()).toggleClass("sound_off", !live_game_board.is_sound())
    // let platforms = ['iphone', 'ipad', 'android', 'linux']
    // if(platforms.includes(window.navigator.platform.split(" ")[0].toLowerCase())) {
    //     let state = live_game_board.switch_sound_off().is_sound()
    //     $('.game_sound_toggle').toggleClass("sound_on", state).toggleClass("sound_off", !state)
    // }

    $('#btn_tip').click(function () {
        var $ly_game_tip = $('#ly_game_tip');
        if ($ly_game_tip.is(':hidden')) {
            $(this).addClass('on');
            $ly_game_tip.show();
        } else {
            $(this).removeClass('on');
            $ly_game_tip.hide();
        }
    });

    $('#btn_share').click(function () {
        var $ly_share = $('#ly_share');
        if ($ly_share.is(':hidden')) {
            $(this).addClass('on');
            $ly_share.show();
        } else {
            $(this).removeClass('on');
            $ly_share.hide();
        }
    });

    $('#btn_skip').click(function () {
        $('#btn_skip').hide();
        $('#div_machine_result_board').fadeIn(1000);
    });

});

function handleDarkMode() {
    // var mode = $(this).attr('dark');
    // if (cookie) mode = cookie === 'on' ? 'off' : 'on';
    if (cookie) {
        $('.img_title').hide();
        $('.img_title_dark').show();
        $('.lottery_wrap').addClass('dark');
        $(this).attr('dark', 'on');

    } else {
        $('.img_title_dark').hide();
        $('.img_title').show();
        $('.lottery_wrap').removeClass('dark');
        $(this).attr('dark', 'off');
    }
    cookie = !cookie;
}
