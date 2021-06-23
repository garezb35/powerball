<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <title>채팅</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/chat.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/alertify.min.css">
    <script>
        var remainTime =<?php echo e($p_remain[0]); ?>;
        var speedRemain = 0;
        var is_scroll_lock = false;
        var userIdToken = "<?php echo e($api_token); ?>";
        var userIdKey = "<?php echo e($userIdKey); ?>";
        var roomIdx ="channel1";
        var is_admin = false;
        var is_freeze = 'off';
        var chatHistoryNum = 0;
        var filterWordArr = 'ㅋㅌ,카톡,틱톡,http,www,co.kr,net,com,kr,net,org,abcgame,scoregame,스코어게임,스게,abc게임,자지,보지,섹스,쎅스,씨발,시발,병신,븅신,개세,개새자지,출장,섹파,자위,8아,18놈,18새끼,18년,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,포경,ㅅㅂㄹㅁ,만남,전국망,대행,자살,스게,점수게임,모히또,토크온,페이스북,페북,매장,8394'.split(',');
        <?php if(!empty($profile)): ?>
        var levels = "<?php echo e($profile); ?>";
        var level_images = JSON.parse(levels.replace(/&quot;/g,'"'));
        <?php endif; ?>
        var total_num = 0;
        var is_repeatChat = false;
        var lastMsgTime = new Date().getTime();
        var sumMsgTerm = 0;
        var msgTermArr = new Array();
        var msgTermIdx = 0;
        var msgStopTime = 10;
        <?php if(Auth::check()): ?>
        var blackListArr = "<?php echo e(Auth::user()->block_list); ?>".split(',');
        <?php else: ?>
        var blackListArr = new Array();
        <?php endif; ?>

        

    </script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/alertify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.2/socket.io.js" ></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/chat.js"></script>
    <script src="/assets/js/handlebars.js"></script>
    <script src="/assets/js/common.js"></script>
    <script>
        var browser_ws = browserWsChk();
    </script>

</head>
<body>
    <style>
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
    </style>
    <div id="userLayer" style="display: none">
        <div class="lutop"><span id="unickname">관리왕1</span></div>
        <div class="game"></div>
    </div>
    <?php echo $__env->yieldContent("content"); ?>
</body>
</html>
<?php /**PATH D:\xampp1\htdocs\powerball\resources\views/includes/chat_header.blade.php ENDPATH**/ ?>