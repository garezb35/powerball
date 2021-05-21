var diff, timer, request_time = 0;
var cookie = false;
var i=0;
(function(){
    var dURL = '/api/live/result';
    var content = $('.gmContent');
    var TYPE = content.data('type');
    var GAME = content.data('game');
    var SCRAP = content.data('scrap');
    var BLACK = content.data('black');
    var FRIEND = content.data('friend');
    var timestamp = content.data('timestamp');
    var nowClock = new Date(timestamp * 1000);
    var nextUserTime, nowTime, gameTime, gameRound, gameLimit, gameAjax = 0;
    var sound_mute =  'false';
    var sound_play = null;
    var sound_effect = null;
    var nextUserTime = 0;

    $.ajax({
        type: "get",
        url: "/api/synctime"
    }).done(function(data) {
        if (data > 0) {
            nextTime = getRemainTime(data);
            $("#timer_gauge").css("width",(100*nextTime/300)+"%")
            core.init()
        }
    });
    var core = (function () {
        return {
            init: function () {
                core.timerSet();
            },
            timerSet: function () {
                gameRound = parseInt($('.gmContent').data('round'));
                gameTime = 300;
                gameLimit = 288;
                core.timer();
            },
            timer: function () {
                var ii = Math.floor((nextTime) / 60);
                var ss = Math.floor(((nextTime) % 60));
                ii = ii < 10 ? '0' + ii : ii;
                ss = ss < 10 ? '0' + ss : ss;
                var HTML = ii + ":" + ss + " 후 " + gameRound + "회차 추첨 시작";
                nextTime--;
                if (nextTime == 0) {
                    // nextUserTime = userTime + gameTime;
                    nextTime = 300;
                    gameRound = gameRound + 1;
                    gameRound = gameRound > gameLimit ? 1 : gameRound;
                    core.startGame();
                }
                $('#timer_gauge').css('width', (nextTime / gameTime) * 100 + '%');
                $('#countdown_clock').html(HTML);
                $("#ready-round").text(gameRound)
                setTimeout(function () {
                    core.timer();
                }, 1000);
            },
            startGame: function () {
                var TYPE = $('.gmContent').data("type")
                if (TYPE == 'POWERBALL') {
                    powerball.init();
                    $(".stopped_balls").attr("src","/assets/images/pick/live.gif")
                }
                if (TYPE == 'POWERBALL')
                    powerladder.init();
                // if (TYPE == 'POWERLADDER') powerladder.init();
                // if (TYPE == 'BTCLADDER') btcladder.init();
                // if (TYPE == 'LADDER') ladder.init();
            },
            soundPlay: function () {
                if (sound_mute == 'false') {
                    //sound_play.play();
                }
            },
            soundEffect: function () {
                if (sound_mute == 'false') {
                    sound_effect.play();
                }
            },
            setDate: function (str) {
                var yyyy = str.substr(0, 4);
                var mm = str.substr(4, 2);
                var dd = str.substr(6, 2);
                return yyyy + '.' + mm + '.' + dd;
            }
        }
    })();

    var powerball = (function () {
        return {
            init: function () {
                powerball.getData();
            },
            socket: function () {

            },
            getData: function () {
                $.ajax({
                    timeout: 3000,
                    type: "POST",
                    url: dURL,
                    dataType: "json"
                }).done(function (response) {
                    if (!diff_minutes(calcTime("+9"),new Date(response.created_date),false)) {
                        if (gameAjax == 5) {
                            alert('게임데이터에 문제가 발생하였습니다.');
                            window.location.reload(true);
                        } else {
                            setTimeout(function () {
                                gameAjax = gameAjax + 1;
                                powerball.getData();
                            }, 1000);
                        }
                    } else {
                        powerball.start(response);
                    }
                }).fail(function () {
                    alert('게임데이터에 문제가 발생하였습니다.');
                    window.location.reload(true);
                });
            },
            start: function (response) {
                gameAjax = 0;
                $("#current_result").find(".round").find("span").text(response.round+"회차 결과")
                $("#current_result").css("display","block")
                updateResult(response)
            }
        }
    })();

    var powerladder = (function () {
        return {
            init: function () {
                powerladder.getData();
            },
            getData: function () {
                $.ajax({
                    timeout: 3000,
                    type: "POST",
                    url: dURL,
                    dataType: "json"
                }).done(function (response) {
                    if (!diff_minutes(calcTime("+9"),new Date(response.created_date),false)) {
                        if (gameAjax == 5) {
                            alert('게임데이터에 문제가 발생하였습니다.');
                            window.location.reload(true);
                        } else {
                            setTimeout(function () {
                                gameAjax = gameAjax + 1;
                                powerball.getData();
                            }, 1000);
                        }
                    } else {
                        powerball.start(response);
                    }
                }).fail(function () {
                    alert('게임데이터에 문제가 발생하였습니다.');
                    window.location.reload(true);
                });
            },
            start: function (response) {
                var playResult = content.find('.playResult');
                var lineBox = content.find('.lineBox');
                var ladderLine = '<em class="line"></em>';
                var lis = '<li></li><li></li><li></li><li></li>';
                var ulClass = 's4';
                var startIcon = content.find('.start_l');
                var endIcon = content.find('.end_l');
                if (response.fd4 == 1 || response.fd4 == 3) {
                    lis = '<li></li><li></li><li></li>';
                    ulClass = 's3';
                }
                if (response.fd4 == 3 || response.fd4 == 4) {
                    startIcon = content.find('.start_r');
                }
                if (response.fd4 == 1 || response.fd4 == 4) {
                    endIcon = content.find('.end_r');
                }
                core.soundPlay();
                pickinfo.hide();
                content.find('.pPick').find('ul').html('');
                content.find('.playBox ul').removeClass().addClass(ulClass).html(lis);
                content.find('.bepickLogo').hide();

                var sType = response.setting;
                new Promise(function (resolve, reject) {
                    startIcon.addClass('on');
                    setTimeout(function () {
                        resolve();
                    }, 500);
                }).then(function () {
                    lineBox.append(ladderLine).find('em:eq(0)').css(sType[0].pos).animate(sType[0].size, sType[0].spd).promise().then(function () {
                        return lineBox.append(ladderLine).find('em:eq(1)').css(sType[1].pos).animate(sType[1].size, sType[1].spd).promise();
                    }).then(function () {
                        return lineBox.append(ladderLine).find('em:eq(2)').css(sType[2].pos).animate(sType[2].size, sType[2].spd).promise();
                    }).then(function () {
                        return lineBox.append(ladderLine).find('em:eq(3)').css(sType[3].pos).animate(sType[3].size, sType[3].spd).promise();
                    }).then(function () {
                        return lineBox.append(ladderLine).find('em:eq(4)').css(sType[4].pos).animate(sType[4].size, sType[4].spd).promise();
                    }).then(function () {
                        return lineBox.append(ladderLine).find('em:eq(5)').css(sType[5].pos).animate(sType[5].size, sType[5].spd).promise();
                    }).then(function () {
                        return lineBox.append(ladderLine).find('em:eq(6)').css(sType[6].pos).animate(sType[6].size, sType[6].spd).promise();
                    }).then(function () {
                        if (typeof sType[7] == 'object') {
                            return lineBox.append(ladderLine).find('em:eq(7)').css(sType[7].pos).animate(sType[7].size, sType[7].spd).promise();
                        } else {
                            return console.log('null');
                        }
                    }).then(function () {
                        if (typeof sType[8] == 'object') {
                            return lineBox.append(ladderLine).find('em:eq(8)').css(sType[8].pos).animate(sType[8].size, sType[8].spd).promise();
                        } else {
                            return console.log('null');
                        }
                    }).then(function () {
                        endIcon.addClass('on');
                        setTimeout(function () {
                            content.find('.progressBar, .timeBox').hide();
                            playResult.css('display', 'flex');
                            var HTML = response.round + '회차 결과는 [좌3짝] 입니다.';
                            playResult.html(HTML);
                            powerladder.resultBox(response);
                        }, 1000);
                    });
                })
            },
            resultBox: function (response) {
                var HTML = '<h2>' + response.round + '회차 게임결과</h2>';
                HTML += '<p>';
                HTML += '<span class="ricon r1_' + response.fd1 + '"></span>' + "\n";
                HTML += '<span class="ricon r2_' + response.fd2 + '"></span>' + "\n";
                HTML += '<span class="ricon r3_' + response.fd3 + '"></span>' + "\n";
                HTML += '</p>' + "\n";
                content.find('.gameResultBox').html(HTML).show();
                setTimeout(function () {
                    content.find('.bepickLogo, .progressBar, .timeBox').show();
                    content.find('.gameResultBox, .playResult').hide().html('');
                    content.find('.lineBox, .playBox ul').html('');
                    content.find('.pl_icon').removeClass('on');
                    powerladder.update(response);
                }, 5000);
            },
            update: function (response) {
                var tResult = content.find('.tResult');
                var tmp_t = tResult.find('li:eq(0)').clone();
                tmp_t.find('h3').text(response.round + ' - ' + response.rownum);
                tmp_t.find('.ricon').removeClass().addClass('ricon');
                tmp_t.find('.resultBox').find('span:eq(0)').addClass('r1_' + response.fd1);
                tmp_t.find('.resultBox').find('span:eq(1)').addClass('r2_' + response.fd2);
                tmp_t.find('.resultBox').find('span:eq(2)').addClass('r3_' + response.fd3);
                tmp_t.find('.resultBox').find('span:eq(3)').addClass('rpb').text(response.bp);
                tResult.find('ul').prepend(tmp_t);
                var nResult = content.find('.nResult');
                var tmp_n = nResult.find('li:eq(0)').clone();
                tmp_n.find('h3').text(response.round + ' - ' + response.rownum);
                tmp_n.find('.ricon').removeClass().addClass('ricon');
                tmp_n.find('.resultBox').find('span:eq(0)').addClass('b' + response.b1).text(response.b1);
                tmp_n.find('.resultBox').find('span:eq(1)').addClass('b' + response.b2).text(response.b2);
                tmp_n.find('.resultBox').find('span:eq(2)').addClass('b' + response.b3).text(response.b3);
                tmp_n.find('.resultBox').find('span:eq(3)').addClass('b' + response.b4).text(response.b4);
                tmp_n.find('.resultBox').find('span:eq(4)').addClass('b' + response.b5).text(response.b5);
                tmp_n.find('.resultBox').find('span:eq(5)').addClass('bp').text(response.bp);
                nResult.find('ul').prepend(tmp_n);
            },
            getRanking: function () {
                $.ajax({
                    timeout: 3000,
                    type: "GET",
                    cache: false,
                    async: true,
                    url: rURL + GAME,
                    dataType: "json"
                }).done(function (response) {
                    if (response.length > 0) {
                        content.find('.rankingBox .lodingBox').hide();
                        content.find('.rankingBox .rankingScroll').show();
                        var HTML = '<ul class="trank">';
                        for (var key in response) {
                            var row = response[key];
                            var ranking = parseInt(key) + 1;
                            HTML += '<li>';
                            HTML += '<span class="col rankNum">';
                            if (ranking < 4) {
                                HTML += '<span class="gmImg rankicon r' + ranking + '"></span>';
                            } else {
                                HTML += ranking;
                            }
                            HTML += '</span>';
                            HTML += '<span class="col nickBox"><img src="/img/level/' + row.sex + '_' + row.level + '.png" class="level middle"><span class="nick">' + row.nick + '</span></span>';
                            HTML += '<span class="col pickRow">';
                            if (row.mainrow > 0) {
                                HTML += '<span class="red">▲ ' + row.mainrow + '연승</span>';
                            } else if (row.mainrow < 0) {
                                HTML += '<span class="blue">▼ ' + row.mainrow + '연패</span>';
                            } else {
                                HTML += '-';
                            }
                            HTML += '</span>';
                            HTML += '<span class="col pickRate"><span class="red">' + row.mainwin + '승</span> / <span class="blue">' + row.mainlost + '패</span> (' + Math.round(row.mainper * 100) + '%)</span>';
                            HTML += '<span class="col todayMsg">' + (row.intro ? row.intro : '') + '</span>'; //rm_room
                            HTML += '<span class="col roomChat">';
                            if (row.rm_room) {
                                HTML += '<span class="ricon chat on" data-room="' + row.rm_room + '" title="채팅방입장"></span>';
                            } else {
                                HTML += '<span class="ricon chat off"></span>';
                            }

                            HTML += '</span>';
                            HTML += '</li>';
                        }
                        HTML += '</ul>';
                        content.find('.rankingBox .rankingScroll').html(HTML);
                    } else {
                        alert('래킹 데이터가 없습니다.');
                    }
                }).fail(function () {
                    alert('서버 통신간 오류가 발생하였습니다. 잠시후 다시 시도해주세요.');
                });
            },
            getMyPick: function () {
                $.ajax({
                    timeout: 3000,
                    type: "GET",
                    cache: false,
                    async: true,
                    url: pURL + GAME,
                    dataType: "json"
                }).done(function (response) {
                    if (response.list.length > 0) {
                        content.find('.mypickBox .lodingBox').hide();
                        content.find('.mypickBox .mypickStats').css('display', 'flex');
                        content.find('.mypickBox .mypickScroll').show();
                        var HTML = '<ul class="mrank">';
                        for (var key in response.list) {
                            var pow = '';
                            var row = response.list[key];
                            HTML += '<li>';
                            HTML += '<span class="col round">' + core.setDate(row.date) + ' - ' + row.round + '</span>';
                            var icontype = '';
                            if (row.maintype == 'fd1') {
                                icontype = 'r1_';
                            }
                            if (row.maintype == 'fd2') {
                                icontype = 'r2_';
                            }
                            if (row.maintype == 'fd3') {
                                icontype = 'r3_';
                            }
                            icontype += row.mainpick;
                            if (row.main == 2) {
                                HTML += '<span class="col mypick"><span class="ricon ' + icontype + ' ' + pow + 'gray"></span></span>';
                            } else {
                                HTML += '';
                                HTML += '<span class="col mypick"><span class="ricon ' + icontype + ' ' + pow + '"></span></span>';
                            }
                            if (row.main == 0) {
                                HTML += '<span class="col result gray">현재회차대기중</span>';
                            } else {
                                if (row.main == 1) {
                                    HTML += '<span class="col result"><span class="red">적중</span></span>';
                                } else {
                                    HTML += '<span class="col result"><span class="gray">미적</span></span>';
                                }
                                if (row.mainrow > 0) {
                                    HTML += '<span class="col result"><span class="red">▲ ' + row.mainrow + '연승</span></span>';
                                } else if (row.mainrow < 0) {
                                    HTML += '<span class="col result"><span class="gray">▼ ' + Math.abs(row.mainrow) + '연패</span></span>';
                                } else {
                                    HTML += '<span class="col result"><span class="gray">-</span></span>';
                                }
                            }
                            HTML += '</li>';
                        }
                        HTML += '</ul>';
                        content.find('.mypickBox .mypickScroll').html(HTML);
                        var _St = response.stats;
                        var _per = Math.round((_St.mainwin / _St.cnt) * 100);
                        var STATS = '<span class="col nickBox"><img src="/img/level/' + _St.sex + '_' + _St.level + '.png" class="level middle"> <span class="nick">' + _St.nick + '</span>님의 파워볼 픽 전적</span>';
                        STATS += '<span class="col rate"><span class="red">' + _St.mainwin + '승</span> / <span class="blue">' + _St.mainlost + '패</span> (' + _per + '%)</span>';
                        if (_St.mainrow > 0) {
                            STATS += '<span class="col row"><span class="red">▲ ' + _St.mainrow + '연승</span></span>';
                        } else if (_St.mainrow < 0) {
                            STATS += '<span class="col row"><span class="blue">▼ ' + Math.round(_St.mainrow) + '연승</span></span>';
                        } else {
                            STATS += '<span class="col row"><span class="gray">-</span></span>';
                        }

                        content.find('.mypickBox .mypickStats').html(STATS);
                    } else {
                        alert('픽 데이터가 없습니다.');
                    }
                }).fail(function () {
                    alert('서버 통신간 오류가 발생하였습니다. 잠시후 다시 시도해주세요.');
                });
            },
            updateGamePick: function (data) {
                content.find('.pPick').show();
                content.find('.pPickLoading').hide();
                var rPoint = parseInt(data.mainrow * 1000000) + parseInt(data.mainwin * 1000) + parseInt(data.level);
                var type = data.maintype.replace('fd', '');
                var HTML = '<li data-npoint="' + rPoint + '" data-type="파워사다리" data-mainrow="' + data.mainrow + '" data-mainwin="' + data.mainwin + '" data-mainlost="' + data.mainlose + '">';
                if (data.mainrow > 0) {
                    HTML += '<span class="winrow plus">' + data.mainrow + '</span>';
                } else {
                    HTML += '<span class="winrow">' + Math.abs(data.mainrow) + '</span>';
                }
                HTML += '<span class="nickBox"><img src="/img/level/' + data.sex + '_' + data.level + '.png" class="level middle"> <span class="nick">' + data.nick + '</span></span>';

                if (isLogin === false && data.game_pm == 1) {
                    HTML += '<span class="ricon rpick lock" title="회원공개"></span>';
                } else if ($.inArray(data.token, BLACK[0]) > 0) {
                    HTML += '<span class="ricon rpick lock" title="블랙차단"></span>';
                } else if (data.game_pm == 2 && $.inArray(data.token, FRIEND[0]) > 0) {
                    HTML += '<span class="ricon rpick lock" title="친구공개"></span>';
                } else if (data.game_pm == 0) {
                    HTML += '<span class="ricon rpick r' + type + '_' + data.mainpick + '"></span>';
                } else {
                    HTML += '<span class="ricon rpick lock"></span>';
                }
                if (data.room) {
                    HTML += '<span class="ricon chat on" data-room="' + data.room + '" title="채팅방입장"></span>';
                } else {
                    HTML += '<span class="ricon chat"></span>';
                }

                HTML += '</li>';
                content.find('.pPick').find('ul').append(HTML);
                var list_content = content.find('.pPick').find('ul');
                var sortData = list_content.children('li').get();
                sortData.sort(function (a, b) {
                    var val1 = parseInt($(a).data('npoint'));
                    var val2 = parseInt($(b).data('npoint'));
                    return val2 - val1;
                });
                $.each(sortData, function (index, row) {
                    list_content.append(row);
                });
            }
        }
    })();

})(this);




$(function () {

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


function showNumber(num,ii)
{
    setTimeout(function(){

        ballColor = ballColorSel(num,ii);
        $('#lotteryBall').show();
        $('#lotteryBall').html('<span class="result_ball '+ballColor+'">'+num+'</span>');
        TweenMax.to(document.getElementById('lotteryBall'),1,{bezier:{curviness:1.25,type:'cubic',values:[{x:207,y:10},{x:119,y:28},{x:72,y:77},{x:61,y:153},{x:92,y:221},{x:184,y:266},{x:366,y:279}],autoRotate:false},ease:Power1.easeInOut,
            onStart:function(){
                $('#lotteryResult').append('<span id="ballNumber_'+num+'" class="ball_'+ballColor+'"><span class="ballNumber">'+num+'</span></span>');
                $('#ballNumber_'+num).addClass("animations")

            },
            onComplete:function(){
                $('#lotteryBall').find("span").removeClass("animations")
                $("#lotteryBall").find("span.result_ball").addClass("zoomin")
                setTimeout(function(){
                    $("#current_result").find(".flex_row").append("<div class='result_ball "+ballColor+"'>"+num+"</div>");
                    $('#lotteryBall').html('').hide();
                },1000)
            }
        });
    },3000*i);

    i++;

    if(i == 6)
    {
        i = 0;
    }
}

function ballColorSel(num,i)
{
    if(i == 5)
        return "pb";
    switch(num)
    {
        case '01':
        case '1':
        case '05':
        case '5':
        case '09':
        case '9':
        case '13':
        case '17':
        case '21':
        case '25':
            var ballColor = 'red';
            break;
        case '02':
        case '2':
        case '06':
        case '6':
        case '10':
        case '14':
        case '18':
        case '22':
        case '26':
            var ballColor = 'yellow';
            break;
        case '03':
        case '3':
        case '07':
        case '7':
        case '11':
        case '15':
        case '19':
        case '23':
        case '27':
            var ballColor = 'green';
            break;
        case '0':
        case '04':
        case '4':
        case '08':
        case '8':
        case '12':
        case '16':
        case '20':
        case '24':
        case '28':
            var ballColor = 'blue';
            break;
    }
    return ballColor;
}

function updateResult(data)
{

    $('#timeRound').text(parseInt(data.round)+1);
    $('#lastRound').text(data.round);

    var numberList = '';
    var ballArr = new Array();
    ballArr[0] = data.nb1
    ballArr[1] = data.nb2
    ballArr[2] = data.nb3
    ballArr[3] = data.nb4
    ballArr[4] = data.nb5

    numberList += ', <span style="color:#66ffff;" class="b">'+parseInt(data.powerball)+'</span>, <span style="color:#fff;" class="b">'+data.numberSum+'</span>';
    ballArr[5] = parseInt(data.pb).toString();

    setTimeout(function(){

        for(var i=0;i<7;i++)
        {
            if(i == 6)
            {

                setTimeout(function(){
                    $('#lotteryBox .play').hide();
                    $('#ladderReady').show();
                    window.location.reload(true);

                },18000);
            }
            else
            {
                showNumber(ballArr[i],i);
            }
        }
    },500);
}
