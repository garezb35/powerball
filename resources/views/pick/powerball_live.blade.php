<html>
    <head>
        <link rel="stylesheet" href="/assets/css/live/common.css">
        <link rel="stylesheet" href="/assets/css/live/power.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/assets/css/font.css">
        <link rel="stylesheet" href="/assets/css/alertify.min.css">
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/handlebars.js"></script>
        <script src="/assets/jplayer/jquery.jplayer.min.js"></script>
        <script src="/assets/js/alertify.min.js"></script>
        <script src="/assets/js/sprite/sprite.js"></script>
        <script src="/assets/js/common.js"></script>
        <script src="/assets/js/all.js"></script>
        <script src="/assets/js/pick/power_execute.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>

    </head>

    <body style="margin: 0;">
      <div id="init_sound">
      </div>
      <div id="driving_sound">

      </div>
      <div id="zoomin_sound" >

      </div>
      <div id="comein_sound" >

      </div>
      <div id="last_result_sound" >

      </div>
    <div class="gmContent" data-type="POWERBALL" data-round="{{$last + 1}}" data-unique={{$last_unique_round+1}}  data-game="nlotto_power"></div>
        <div class="lottery_wrap powerball dark">
            <div id="game_caution_closed_state" style="">
                <p class="sub_title">- 휴장 안내 -</p>
                <p class="sub_title" style="margin-top: -20px">00시~ 06시 추첨 휴장 시간입니다.</p>
            </div>
            <div class="header_wrap">
                <div id="ly_game_tip" class="ly_game_tip" style="display:none;">
                    <h1 class="tit">몬스터 파워볼 게임 설명</h1>
                    <p>- 동행복권의 파워볼을 기준으로 진행됩니다.</p>
                    <p>- 5분에 한번씩 매 2분55초, 7분55초에 게임이 실행 됩니다.</p>
                </div>
                <div id="ly_share" class="ly_share" style="display:none;">
                    <h1 class="tit">몬스터 파워볼 중계화면 퍼가기</h1>
                    <div class="source">
                        <textarea>&lt;iframe src="http://{{Request::getHost()}}/pick/powerball/live" width="830" height="641" scrolling="no" frameborder="0"&gt;&lt;/iframe&gt;</textarea>
                    </div>
                    <p>위의 HTML의 코드를 복사하여 원하시는 페이지에 아이프레임으로 추가하시면 파워볼 게임 영역만 중계화면으로 이용 가능합니다.</p>
                </div>
            </div>
            <div class="contents">
                <div class="side left">
                  {{-- <div id="caution-area" class="inprogress_wrap">
                      <div id="timer_gauge" class="fill_bar" ></div>
                      <div class="progress_text">
                          <span id="countdown_clock"></span>
                      </div>
                  </div> --}}
                    <div class="powerball_board">
                        <div id="result_board" class="result_board">
                            <img src="/assets/images/pick/bulb.png" class="bulb-img"/>
                            <div id="div_machine_glass" class="full_size"></div>
                            <div id="sprite-balls" class="full_size"></div>
                            <div id="lotteryBall"></div>
                            <div id="powerball-letter"></div>
                            <div id="any-balls" class="d-none"></div>
                            <div id="ready-screen">
                                <div>
                                    <span class="txt-round">제 <span id="ready-unique"></span> 회차</span>
                                    <span class="txt-round"><span id="ready-round"></span></span>
                                    <span id="countdown_clock"></span>
                                </div>
                                <p class="ready-txt">추첨준비중</p>
                            </div>
                            <div id="current_result">
                                <div class="round">
                                    <span>--회차 결과</span>
                                </div>
                                <div class="balls_wrap">
                                    <div class="flex_row">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="/" target="_top" style="color:wheat;margin-top:17px;display:block">몬스터파워볼주소 : {{Request::root()}}</a>
                    </div>
                </div>
                <div class="side right">
                    <div class="tit_wrap flex_row">
                        <h2 class="section_tit">회차별 결과</h2>
                        <div class="func_btns">
                            <ul class="flex_row">
                                <li id="btn_share" class="btn btn_share" title="퍼가기"><i class="fa fa-share-alt"></i></li>
                                <li id="btn_tip" class="btn btn_tip" title="게임안내"><i class="fa fa-question"></i></li>
                                <li id="btn_sound" class="btn btn_sound on" title="소리 켜기/끄기"><i class="fa"></i></li>
                            </ul>
                        </div>
                    </div>
                    <ul class="result_history">
                        @if(!empty($powerball_result))
                            @foreach($powerball_result as $p_result)
                            <li style="display: list-item;">
                                <div class="round">
                                    <p>{{$p_result["round"]}}회차</p>
                                    <span>({{$p_result["day_round"]}})</span>
                                </div>
                                <div class="balls_wrap">
                                    <div class="flex_row">
                                        <div class="result_ball {{ballColorSel($p_result["nb1"],0)}}">{{$p_result["nb1"]}}</div>
                                        <div class="result_ball {{ballColorSel($p_result["nb2"],1)}}">{{$p_result["nb2"]}}</div>
                                        <div class="result_ball {{ballColorSel($p_result["nb3"],2)}}">{{$p_result["nb3"]}}</div>
                                        <div class="result_ball {{ballColorSel($p_result["nb4"],3)}}">{{$p_result["nb4"]}}</div>
                                        <div class="result_ball {{ballColorSel($p_result["nb5"],4)}}">{{$p_result["nb5"]}}</div>
                                        <div class="result_ball pb">{{$p_result["pb"]}}</div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
