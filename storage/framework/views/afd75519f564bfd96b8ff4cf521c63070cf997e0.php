<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <title>파워볼 게임</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        var remainTime = 0;
        var speedRemain = 0;
        var userIdToken = "<?php echo e($userIdToken); ?>";
    </script>
</head>
<body>
<div id="userLayer" style="display: none">
    <div class="lutop"><span id="unickname">관리왕1</span></div>
    <div class="game"></div>
</div>
    <div id="wrap">
        <div id="topArea">
            <div class="logo">
                <a href="/" class="none"><img src="<?php echo e(Request::root()); ?>/assets/images/logo.svg" width="144" ></a>
                <div class="top-header-right">
                    <a href="/member?type=charge" target="mainFrame">
                        <div class="d-inline-flex align-middle" style="transform:rotate(-40deg)"><img src="/assets/images/powerball/dangun.svg" width="60" height="60"></div>
                        <div class="d-inline-flex align-middle"><span class="header-right-1">코인을 충전하시겠어요?<br><span class="header-right-2">당근을 선물해 보세요!</span></span></div>
                    </a>
                </div>
            </div>
            <div class="gnb">
                <ul>
                    <li><a href="<?php echo e(route('p_analyse')); ?>?terms=lates&pageType=display" target="mainFrame" class="on hiddenBorard" >파워볼분석 <div class="border-half"></div></a></li>
                    <li><a href="<?php echo e(route('psadari_analyse')); ?>?terms=lates&pageType=display" target="mainFrame" class="hiddenBorard" >파사중계<div class="border-half"></div></a></li>
                    <li><a href="<?php echo e(route('pick-powerball')); ?>" target="mainFrame" style="width:80px;text-align:center;" class="hiddenBorard">픽<div class="border-half"></div></a></li>
                    <li><a href="<?php echo e(route("pick-simulator")); ?>" target="mainFrame" rel="hidden" class="hiddenBorard">파워모의배팅<div class="border-half"></div></a></li>
                    <li><a href="/pick/winning-machine"  target="mainFrame"   class="hiddenBorard">연승제조기<div class="border-half"></div></a></li>
                    <li><a href="<?php echo e(route('market')); ?>" target="mainFrame" class="hiddenBorard">마켓<div class="border-half"></div></a></li>
                    <li><a href="#" onclick="openChatRoom();return false;" class="hiddenBorard">방채팅<div class="border-half"></div></a></li>
                    <li><a href="<?php echo e("board"); ?>?board_type=none&board_category=humor" target="mainFrame" class="hiddenBorard">커뮤니티<div class="border-half"></div></a></li>
                    <li><a href="<?php echo e("board"); ?>?board_type=community&board_category=offten" target="mainFrame" class="hiddenBorard">고객센터<div class="border-half"></div></a></li>
                    <li><a href="/board?board_type=customer&board_category=notice" target="mainFrame" class="hiddenBorard">공지사항<div class="border-half"></div></a></li>
                    <li><a href="<?php echo e(route("present")); ?>"  target="mainFrame" class="hiddenBorard">출석체크</a></li>
                </ul>
            </div>
        </div>
        <div id="container">
            <div id="box-ct">
                <?php echo $__env->make('includes.inner-left', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="inner-right">
                    <?php echo $__env->make("layouts.boardBox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </div>
</body>

<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/includes/header.blade.php ENDPATH**/ ?>