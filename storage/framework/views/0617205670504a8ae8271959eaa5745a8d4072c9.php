<?php $__env->startSection("content"); ?>
<div class="memoBox">
    <?php echo $__env->make("member.memo-memu", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="content">
        <div class="top">
            <a href="#" onclick="memoDel();return false;">
                <img src="/assets/images/powerball/btn_del_off.png" width="48" height="24">
            </a>
            <span class="cnt"><span><?php echo e($result["not_read"]); ?></span> / <?php echo e(sizeof($result["list"])); ?></span>
        </div>
        <form name="memoForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="mtype" value="receive" />
            <table class="table-mail">
                <?php if($result["type"] != "send"): ?>
                    <colgroup>
                        <col width="6%">
                        <col width="24%">
                        <col>
                        <col width="20%">
                    </colgroup>
                <?php else: ?>
                    <colgroup>
                        <col width="6%">
                        <col width="24%">
                        <col>
                        <col width="15%">
                        <col width="15%">`
                    </colgroup>
                <?php endif; ?>
                <tbody>
                <tr>
                    <th><input type="checkbox" onclick="checkAll(this.checked);"></th>
                    <?php $__currentLoopData = $result["menu"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($menu); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
                <?php if(!empty(sizeof($result["list"]))): ?>
                    <?php $__currentLoopData = $result["list"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $read = "read";
                            if($mail["view_date"] == null)
                                $read  = "";
                            ?>
                    <tr>
                        <td><input type="checkbox" name="check[]" class="check" value="<?php echo e($mail["id"]); ?>"></td>
                        <td class="left"><span style="position:relative;">
                                <img src="<?php echo e($mail["send_usr"]["getLevel"]["value3"]); ?>" width="30" height="30">
                                 <?php if($mail["send_usr"]["isDeleted"] == 1 || $mail["send_usr"]["user_type"] == "00"): ?>
                                <span style="position:absolute;left:0;z-index:99;">
                                    <img src="/assets/images/powerball/prison.png" width="30" height="30">
                                </span>
                                <?php endif; ?>
                            </span>
                            <strong><?php echo e($mail["send_usr"]["nickname"]); ?></strong>
                        </td>
                        <td class="left"><a href="<?php echo e("memo"); ?>?type=memoView&mtype=receive&mid=<?php echo e($mail["id"]); ?>" class="<?php echo e($read); ?>">
                                <img src="/assets/images/powerball/giftBox.png" width="24" height="24">
                                <?php if($mail["mail_type"] == 1): ?>
                                    랜덤 쪽지입니다.
                                <?php else: ?>
                                    일반 쪽지입니다.
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="<?php echo e($read); ?>"><?php echo e(date("m-d H:i",strtotime($mail["created_at"]))); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php if($result["type"] == "send"): ?><?php echo e(5); ?><?php else: ?><?php echo e(4); ?><?php endif; ?>">자료가 비였습니다.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </form>
        <div class="page">
            <?php echo e($result["list"]->links()); ?>

        </div>
        <div class="guide">
            ※ 보관하지 않은 쪽지는 7일 후 자동삭제 됩니다.(보관쪽지는 30일 후 자동삭제 됩니다.)
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/memo.blade.php ENDPATH**/ ?>