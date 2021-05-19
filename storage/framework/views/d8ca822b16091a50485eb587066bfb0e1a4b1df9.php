<?php $__env->startSection("content"); ?>
    <style>
        body {position:absolute;width:100%;height:100%;background:url(https://simg.powerballgame.co.kr/images/bg_loading.png);overflow:hidden;}
        .contentBox {position:absolute;top:50%;left:50%;margin-top:-80px;margin-left:-175px;width:350px;height:160px;text-align:center;}
        .contentBox .txt {margin-top:20px;font-size:11px;font-family:dotum;color:#0D568C;}
    </style>
    <div class="contentBox">
        <div><img src="<?php echo e(Request::root()); ?>/assets/images/logo.png"></div>
        <div class="txt">중복 로그인으로 인해 이전 접속을 종료합니다.</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/chat/duplicate.blade.php ENDPATH**/ ?>