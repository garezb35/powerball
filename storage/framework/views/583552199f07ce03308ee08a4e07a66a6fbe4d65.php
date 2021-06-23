
<?php
    $self = "received_usr";
    $other = "send_usr";
    if($result["mtype"] == "send"){
        $self = "send_usr";
        $other = "received_usr";
    }

?>
<?php $__env->startSection("content"); ?>
<script>
var viewed_count = <?php echo e($viewed_count); ?>

</script>
    <div class="memoBox">
        <?php echo $__env->make("member.memo-memu", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content">
            <div class="top">
                <a href="#" onclick="memoDel();return false;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_del_off.png" width="48" height="24" ></a>
                <?php if($self == "received_usr" && $result["memo"]["state"] != 1): ?>
                    <a href="#" onclick="memoSave();return fasle;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_save_off.png" ></a>
                <?php endif; ?>
                <?php if($result["memo"]["report"] != 2 && $result["memo"]["report"] != 3): ?>
                <a href="#" onclick="memoReport();return false;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_report_off.png" width="48" height="24" ></a>
                <?php endif; ?>
                <span class="list-btn">
                <a href="<?php echo e(route("memo")); ?>?type=<?php echo e($result["mtype"]); ?>"><img src="https://simg.powerballgame.co.kr/images/memo/btn_list_off.png" width="48" height="24" alt="목록" ></a>
                <?php if(!empty($previous)): ?>
                <a href="/memo?type=memoView&mtype=<?php echo e($result["mtype"]); ?>&mid=<?php echo e($previous); ?>"><img src="https://simg.powerballgame.co.kr/images/memo/btn_prev_off.png" width="48" height="24" alt="이전" ></a>
                <?php endif; ?>
               <?php if(!empty($next )): ?>
                <a href="/memo?type=memoView&mtype=<?php echo e($result["mtype"]); ?>&mid=<?php echo e($next); ?>"><img src="https://simg.powerballgame.co.kr/images/memo/btn_next_off.png" width="48" height="24" alt="다음" ></a>
                <?php endif; ?>
                </span>
            </div>
            <div class="viewTitle">
                <div style="position:absolute">
                    <img src="<?php echo e($result["memo"][$other]["getLevel"]["value3"]); ?>" width="30" height="30">
                    <?php if($result["memo"][$self]["isDeleted"] == 1 || $result["memo"][$self]["user_type"] == "00"): ?>
                    <span style="position:absolute;left:0;z-index:99;">
                        <img src="/assets/images/powerball/prison.png" width="30" height="30">
                    </span>
                    <?php endif; ?>
                </div>
                <span style="margin-left:27px;">
                    <?php if(Request::get("mtype") == "receive"): ?>
                    <strong><?php echo e($result["memo"][$other]["nickname"]); ?></strong> 님에게 <?php echo e(date("y.m.d H:i",strtotime($result["memo"]["created_at"]))); ?> 에 받은 쪽지 입니다.
                    <?php else: ?>
                        <strong><?php echo e($result["memo"][$other]["nickname"]); ?></strong> 님에게 <?php echo e(date("y.m.d H:i",strtotime($result["memo"]["created_at"]))); ?> 에 보낸 쪽지 입니다.
                    <?php endif; ?>
                </span>
            </div>
            <div class="viewContent">
                <?php if($result["memo"][$self]["isDeleted"] == 1 || $result["memo"][$self]["user_type"] == "00"): ?>
                    <p class="tooltip-ban" style="margin-bottom:3px;">해당 회원은 접속 차단된 회원입니다.<a href="#" onclick="$(this).closest('p').hide();" class="btn-close"></a></p>
                <?php endif; ?>
                <div class="msg">
                    <?php echo nl2br(e($result["memo"]["content"])); ?>

                </div>
            </div>
            <div class="btnBox">
                <?php if($self == "received_usr"): ?>
                <a href="<?php echo e(route("memo")); ?>?type=write&nickname=<?php echo e($result["memo"][$other]["nickname"]); ?>" class="btnSend">답장보내기</a>
                <?php endif; ?>
                <a href="<?php echo e(route("memo")); ?>?type=<?php echo e($result["mtype"]); ?>" class="btnCancel">목록</a>
            </div>
        </div>
    </div>
    <form name="memoForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="check[]" value="<?php echo e($result["memo"]["id"]); ?>">
        <input type="hidden" name="mtype" value="<?php echo e($result["mtype"]); ?>" />
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/memoView.blade.php ENDPATH**/ ?>