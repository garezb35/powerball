<html>
<head>
    <link rel="stylesheet" href="/assets/css/live/common.css">
    <link rel="stylesheet" href="/assets/css/live/sadari.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/css/font.css">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/handlebars.js"></script>
    <script src="/assets/js/pick/power_execute.js"></script>
    <script src="/assets/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>
    <script src="/assets/js/common.js"></script>
</head>
<body style="margin: 0;">
<div class="gmContent" data-type="POWERLADDER" data-round="<?php echo e($last + 1); ?>"  data-game="nlotto_power"></div>
<div class="lottery_wrap powerball dark">
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
                <textarea>&lt;iframe src="<?php echo e(Request::getHost()); ?>/pick/powerball/live" width="830" height="641" scrolling="no" frameborder="0"&gt;&lt;/iframe&gt;</textarea>
            </div>
            <p>위의 HTML의 코드를 복사하여 원하시는 페이지에 아이프레임으로 추가하시면 파워볼 게임 영역만 중계화면으로 이용 가능합니다.</p>
        </div>
    </div>
    <div class="contents">
        <div class="side left">
          
            <div class="powerball_board">
                <div class="playBox">
                    <div id="result_board" class="result_board relativeBox">
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
                                <span id="ready-round">83</span>
                                <span>회차</span>
                                <span id="countdown_clock"></span>
                            </div>
                            <p class="ready-txt">추첨준비중</p>
                        </div>
                        <ul class="s3"></ul>
                        <div class="lineBox"></div>
                    </div>
                </div>
                <a href="/" target="_top" style="color:wheat;margin-top:17px;display:block;margin-left: 87px;">몬스터파워볼주소 : <?php echo e(Request::root()); ?></a>
            </div>
        </div>
        <div class="side right">
            <div class="tit_wrap flex_row">
                <h2 class="section_tit">회차별 결과</h2>
                <div class="func_btns">
                    <ul class="flex_row">
                        <li id="btn_share" class="btn btn_share" title="퍼가기"><i class="fa fa-share-alt"></i></li>
                        <li id="btn_tip" class="btn btn_tip" title="게임안내"><i class="fa fa-question"></i></li>
                        <li id="btn_sound" class="btn btn_sound on" title="소리 켜기/끄기"><i class="fa fa-volume-up"></i></li>
                    </ul>
                </div>
            </div>
            <ul class="result_history">
                <?php if(!empty($psadari_result)): ?>
                    <?php $__currentLoopData = $psadari_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex_row">
                            <p class="round"><?php echo e($p_result["round"]); ?>회차</p>
                            <div class="balls_wrap">
                                <?php $result = sadariCheck($p_result["nb1"]) ?>
                                <?php if($result == "left_3"): ?>
                                    <div class="result_ball left">좌</div>
                                    <div class="result_ball line3">3</div>
                                    <div class="result_ball even">짝</div>
                                <?php endif; ?>
                                <?php if($result == "left_4"): ?>
                                    <div class="result_ball left">좌</div>
                                    <div class="result_ball line4">4</div>
                                    <div class="result_ball odd">홀</div>
                                <?php endif; ?>
                                <?php if($result == "right_3"): ?>
                                    <div class="result_ball right">우</div>
                                    <div class="result_ball line3">3</div>
                                    <div class="result_ball odd">홀</div>
                                <?php endif; ?>
                                <?php if($result == "right_4"): ?>
                                    <div class="result_ball right">우</div>
                                    <div class="result_ball line4">4</div>
                                    <div class="result_ball even">짝</div>
                                <?php endif; ?>

                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/psadari_live.blade.php ENDPATH**/ ?>