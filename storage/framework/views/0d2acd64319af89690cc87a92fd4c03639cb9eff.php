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
    <div class="bottom_banner">
        <div class="bestpickster">
            <div class="inner"><a href="#" onclick="ajaxBestPickster();return false;" style="color:#fff;display:block;font-size:11px;">
                    <img src="/assets/images/pickster.png" width="60"></a>
            </div>
            <div id="bestPicksterList" style="display: none;">
                <div class="title"><?php echo e(date("Y")); ?>년<?php echo e(date("m")); ?>월<?php echo e(date("d")); ?>일 베스트 픽스터</div>
                <div class="content" style="background-color:#F8F8F8;">
                    <li class="rank1">
                        <span class="rank">1위</span>
                        <span class="profile">
                            <img src="https://sfile.powerballgame.co.kr/profileImg/b550087beec7e9518a699af1daaf6bac.gif?1618824338" class="profileImg">
                        </span>
                        <span class="level"><img src="https://simg.powerballgame.co.kr/images/class/M20.gif">
                        </span><strong>카카오뱅크님</strong><span class="rankTypeNum none">-</span>
                    </li>
                    <li class="rank2"><span class="rank">2위</span><span class="profile">
                            <img src="https://sfile.powerballgame.co.kr/profileImg/0306b44123062d60109cac22f164f1ab.gif?1596615578" class="profileImg"></span>
                        <span class="level"><img src="https://simg.powerballgame.co.kr/images/class/M19.gif"></span><strong>레전드강백호</strong>
                        <span class="rankTypeNum none">-</span>
                    </li>
                    <li class="rank3"><span class="rank">3위</span><span class="profile">
                            <img src="https://sfile.powerballgame.co.kr/profileImg/dec0893a0b5f29a912fc09a8af10b4c0.gif?1616678050" class="profileImg"></span>
                        <span class="level"><img src="https://simg.powerballgame.co.kr/images/class/M17.gif"></span><strong>갓슈팅</strong>
                        <span class="rankTypeNum none">-</span></li><li><span class="rank">4위</span><span class="profile">
                            <img src="https://sfile.powerballgame.co.kr/profileImg/3587bcc17e9b1392c8264ad76c5bd3b1.gif?1614170618" class="profileImg"></span>
                        <span class="level"><img src="https://simg.powerballgame.co.kr/images/class/M18.gif"></span><strong>MVP차차</strong>
                        <span class="rankTypeNum none">-</span></li><li><span class="rank">5위</span><span class="profile">
                            <img src="https://sfile.powerballgame.co.kr/profileImg/211b654ce4bd889b9eafc810a079cb6c.gif?1599933750" class="profileImg"></span>
                        <span class="level"><img src="https://simg.powerballgame.co.kr/images/class/M18.gif"></span><strong>촉돌이</strong>
                        <span class="rankTypeNum new">NEW</span>
                    </li>
                </div>
                <div class="guide"><span class="highlight">매일 0시 기준</span>으로 집계되며<br><span class="highlight">월요일에 1~3등까지 시상</span>합니다.</div>
            </div>
        </div>
        <div class="mt-2">
            <ul class="chatRoomList" id="chatRoomList">
                <?php if(!empty($rooms)): ?>
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $win = 0;
                        $lose = 0;
                        $parsed = json_decode($r["winning_history"]);
                        if(!empty($parsed)){
                            $win = $parsed->total->win;
                            $lose = $parsed->total->lose;
                        }
                        ?>
                        <li rel="<?php echo e($r["roomIdx"]); ?>">
                            <div id="data_0" class="tit thumb red" style="border:1px solid #f7f700;" >
                                <img src="<?php echo e($r["roomandpicture"]["image"]); ?>">
                                <?php if(!empty($r["cur_win"])): ?>
                                    <div class="winFixCnt"><?php echo e($r["cur_win"]); ?></div>
                                <?php endif; ?>
                            </div><div class="info">
                                <a href="#" onclick="return false;" rel="" class="tit"><?php echo e($win); ?>승 <?php echo e($lose); ?>패
                                    <span class="bar">|</span><?php echo e($r["roomandpicture"]["nickname"]); ?></a>
                                <span class="cnt"><?php echo e($r["members"]); ?>/<?php echo e($r["max_connect"]); ?></span>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php echo $__env->make('box-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="mb-2"></div>
<?php echo $__env->make('layouts.chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("Analyse.pickster", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/includes/inner-left.blade.php ENDPATH**/ ?>