<html>
<head>
    <link rel="stylesheet" href="/assets/css/live/common.css">
    <link rel="stylesheet" href="/assets/css/live/sadari.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/css/font.css">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/handlebars.js"></script>
    <script src="/assets/jplayer/jquery.jplayer.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/pick/power_execute.js"></script>
    <script src="/assets/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>

</head>

<body style="margin: 0;">
  <div id="init_sound">

  </div>
  <div id="sadari_3_sound" >

  </div>
  <div id="sadari_4_sound" >

  </div>
  <div id="oddeven_sound" >

  </div>
  <div id="sadari_started_sound" >

  </div>
  <div id="leftright_sound" >

  </div>
<div class="gmContent" data-type="POWERLADDER" data-round="{{$last + 1}}" data-unique={{$last_unique_round+1}}  data-game="nlotto_power"></div>
<div class="lottery_wrap powerball dark" style="height:361px">
  <div id="game_caution_closed_state" class="d-none" >
		<img src="/assets/images/stopping.png" />
	</div>
    <div class="header_wrap">
        <div id="ly_game_tip" class="ly_game_tip" style="display: none">
            <h1 class="tit">몬스터 파워사다리 게임 설명</h1>
            <p>- 동행복권의 파워볼의 첫번째 숫자를 기준으로 진행됩니다.</p>
            <p>- 5분에 한번씩 매 2분55초, 7분55초에 게임이 실행 됩니다.</p>
            <p>- 출발점은 일반볼 첫번째 숫자가 홀일 경우 좌출발, 짝일 경우 우출발입니다.</p>
            <p>- 줄갯수는 일반볼 첫번째 숫자가 1~14일 경우 3줄, 15~28일 경우 4줄입니다.</p>
        </div>
        <div id="ly_share" class="ly_share" style="display:none;">
            <h1 class="tit">몬스터 파워사다리 중계화면 퍼가기</h1>
            <div class="source">
                <textarea>&lt;iframe src="http://{{Request::getHost()}}/pick/psadari/live" width="830" height="641" scrolling="no" frameborder="0"&gt;&lt;/iframe&gt;</textarea>
            </div>
            <p>위의 HTML의 코드를 복사하여 원하시는 페이지에 아이프레임으로 추가하시면 파워볼 게임 영역만 중계화면으로 이용 가능합니다.</p>
        </div>
    </div>
    <div class="contents">
        <div class="side left">
          {{-- <div id="caution-area" class="inprogress_wrap">
              <div id="timer_gauge" class="fill_bar" ></div>
              <div class="progress_text">

              </div>
          </div> --}}
            <div class="powerball_board">
                <div class="playBox">
                    <div id="result_board" class="result_board relativeBox" style="margin-top:32px">
                        <div id="div_sadari_machine_glass" class="full_size">
                            <img class="bar1" src="/assets/images/pick/empty-sadari.png" />
                            <img class="bar2" src="/assets/images/pick/empty-sadari.png" />
                        </div>
                        <div class="abs_img left-s">좌</div>
                        <div class="abs_img right-s">우</div>
                        <div class="abs_img even-s">짝</div>
                        <div class="abs_img odd-s">홀</div>
                        <div id="ready-screen">
                            <div>
                              <span class="txt-round">제 <span id="ready-unique"></span> 회차</span>
                              <span class="txt-round"><span id="ready-round"></span></span>
                                <span id="countdown_clock"></span>
                            </div>
                            <p class="ready-txt">추첨준비중</p>
                        </div>
                        <ul class="s3"></ul>
                        <div class="lineBox"></div>
                    </div>
                </div>
                <a href="/" target="_top" style="color:wheat;margin-top:17px;display:block;margin-left: 87px;">몬스터파워볼주소 : {{Request::root()}}</a>
            </div>
        </div>
        <div class="side right">
            <div class="tit_wrap flex_row">
                <h2 class="section_tit">회차별 결과</h2>
                <div class="func_btns">
                    <ul class="flex_row" style="padding-inline-start:14px">
                        <li id="btn_share" class="btn btn_share" title="퍼가기"><i class="fa fa-share-alt"></i></li>
                        <li id="btn_tip" class="btn btn_tip" title="게임안내"><i class="fa fa-question"></i></li>
                        <li id="btn_sound" class="btn btn_sound on" title="소리 켜기/끄기"><i class="fa fa-volume-up"></i></li>
                    </ul>
                </div>
            </div>
            <ul class="result_history">
                @if(!empty($psadari_result))
                    @foreach($psadari_result as $p_result)
                        <li class="flex_row">
                            <p class="round">{{$p_result["round"]}}회차</p>
                            <div class="balls_wrap">
                                @php $result = sadariCheck($p_result["nb1"]) @endphp
                                @if($result == "left_3")
                                    <div class="result_ball left">좌</div>
                                    <div class="result_ball line3">3</div>
                                    <div class="result_ball even">짝</div>
                                @endif
                                @if($result == "left_4")
                                    <div class="result_ball left">좌</div>
                                    <div class="result_ball line4">4</div>
                                    <div class="result_ball odd">홀</div>
                                @endif
                                @if($result == "right_3")
                                    <div class="result_ball right">우</div>
                                    <div class="result_ball line3">3</div>
                                    <div class="result_ball odd">홀</div>
                                @endif
                                @if($result == "right_4")
                                    <div class="result_ball right">우</div>
                                    <div class="result_ball line4">4</div>
                                    <div class="result_ball even">짝</div>
                                @endif

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
