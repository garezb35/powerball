<html>
    <head>
        <link rel="stylesheet" href="/assets/css/live/common.css">
        <link rel="stylesheet" href="/assets/css/live/power.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/pick/power_execute.js"></script>
    </head>
    <body>
        <div style="font-size: 24px;
    position: absolute;
    z-index: 100;
    width: 100%;
    height: 100%;
    /* top: 50%; */
    text-align: center;
    padding-top: 25%;
    color: #fff;
    /* background-color: #123; */
    /* opacity: 0.3; */
    /* filter: blur(8px); */
    /* -webkit-filter: blur(8px);">서버 설정 확인해주세요<br> 플러그인 설치(php_smt())</div>
        <div class="lottery_wrap powerball dark">
            <div class="header_wrap">
                <div class="header flex_row">
                    <div class="game_type" style="position:relative;">
                        <img class="img_title" src="/assets/images/pick/logo.png" style="display:none; width:149px;position:absolute;top:0px;left:0px;">
                        <img class="img_title_dark" src="/assets/images/pick/logo.png" style="width:149px;position:absolute;top:0px;left:0px;">
                    </div>
                    <div class="today_star">
                        <p>
                            동행복권의 파워볼을 기준으로<br>
                            5분 단위로 추첨하며 288회차까지 진행
                        </p>
                    </div>
                    <div class="func_btns">
                        <ul class="flex_row">
                            <li id="btn_share" class="btn btn_share" title="퍼가기"><i class="fa fa-share-alt"></i></li>
                            <li id="btn_tip" class="btn btn_tip" title="게임안내"><i class="fa fa-question"></i></li>
                            <li id="btn_sound" class="btn btn_sound on" title="소리 켜기/끄기"><i class="fa fa-volume-up"></i></li>
                        </ul>

                    </div>
                </div>
                <div id="caution-area" class="inprogress_wrap">
                    <div id="timer_gauge" class="fill_bar" style="left: -65.6px;"></div>
                    <div class="progress_text">
                        <span id="countdown_clock">4분 36초 후</span>
                        <span style="margin-left: 3px;">추첨 시작</span>
                    </div>
                </div>
                <div id="ly_game_tip" class="ly_game_tip" style="display:none;">
                    <h1 class="tit">엔트리 파워볼 게임 설명</h1>
                    <p>- 동행복권의 파워볼을 기준으로 진행됩니다.</p>
                    <p>- 5분에 한번씩 매 2분55초, 7분55초에 게임이 실행 됩니다.</p>
                </div>
                <div id="ly_share" class="ly_share" style="display:none;">
                    <h1 class="tit">엔트리 파워볼 중계화면 퍼가기</h1>
                    <div class="source">
                        <textarea>&lt;iframe src="http://{{Request::getHost()}}/pick/powerball/live" width="830" height="641" scrolling="no" frameborder="0"&gt;&lt;/iframe&gt;</textarea>
                    </div>
                    <p>위의 HTML의 코드를 복사하여 원하시는 페이지에 아이프레임으로 추가하시면 파워볼 게임 영역만 중계화면으로 이용 가능합니다.</p>
                </div>
            </div>
            <div class="contents">
                <div class="side left">
                    <div class="powerball_board">
                        <div id="result_board" class="result_board">
                            <img src="/assets/images/pick/balls.png" class="stopped_balls"/>
                            <div id="div_machine_glass" class="full_size"></div>
                        </div>
                    </div>
                </div>
                <div class="side right">
                    <div class="tit_wrap flex_row">
                        <h2 class="section_tit">회차별 결과</h2>
                    </div>
                    <ul class="result_history">

                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                        <li style="display: list-item;">
                            <div class="round">
                                <p>173회차</p>
                                <span>(1091810)</span>
                            </div>
                            <div class="balls_wrap">
                                <div class="flex_row">
                                    <div class="result_ball n24">24</div>
                                    <div class="result_ball n19">19</div>
                                    <div class="result_ball n17">17</div>
                                    <div class="result_ball n6">6</div>
                                    <div class="result_ball n16">16</div>
                                    <div class="result_ball p1">1</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>

