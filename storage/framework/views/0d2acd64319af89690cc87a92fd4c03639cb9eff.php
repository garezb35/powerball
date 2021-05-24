<div class="inner-left">
    <div class="top_banner" style="left:-70px;">
        <div class="lb1"><a href="/board?board_type=customer&board_category=notice&bid=48&page=1" target="mainFrame">
                <img src="/assets/images/powerball/manual.png" width="20"><p class=" mt-1 mb-0">메뉴얼</p></a>
        </div>
        <div class="lb1">
            <a href="<?php echo e(route("ranking")); ?>" target="mainFrame">
                <img src="/assets/images/powerball/rank.png" width="20"><p class=" mt-1 mb-0">랭킹</p>
            </a>
        </div>
        <div class="lb1">
            <a href="<?php echo e(route("present")); ?>" target="mainFrame">
                <img src="/assets/images/powerball/checker.png" width="20"><p class=" mt-1 mb-0">출석체크</p>
            </a>
        </div>
        <div class="lb1">
            <a href="#" onclick="openChatRoom();return false;" target="mainFrame">
                <img src="/assets/images/powerball/chatting.png" width="20"><p class=" mt-1 mb-0">채팅대기실</p>
            </a>
        </div>
    </div>
<?php echo $__env->make('box-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="mb-2"></div>
<?php echo $__env->make('layouts.chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/includes/inner-left.blade.php ENDPATH**/ ?>