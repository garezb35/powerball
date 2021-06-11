

<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <input type="hidden" id="api_token" value="<?php echo e($api_token); ?>">
        <ul class="itemList">
            <?php if(!empty($pur_item)): ?>
                <?php $__currentLoopData = $pur_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    if(empty($item->items->image))
                        continue;
                    ?>

                <li>
                    <img src="<?php echo e($item->items->image); ?>" width="115" height="115">
                    <div class="name"><?php echo e($item->items->name); ?></div>
                    <div class="amountSet">
                        <input type="text" name="<?php echo e($item->items->code); ?>" value="<?php echo e($item["count"]); ?>개" rel="<?php echo e($item["count"]); ?>" limit="<?php echo e($item["count"]); ?>" style="ime-mode:disabled;" onkeydown="return isNumber(event);" onblur="countChk(this);">
                        <span class="up" rel="item"></span>
                        <span class="down" rel="item"></span>
                    </div>
                    <div class="btns">
                        <a href="#" class="btn_use btn-danger btn-sm btn" itemcode="<?php echo e($item->items->code); ?>" title="<?php echo e($item->items->name); ?>" period="<?php echo e($item->items->period); ?>">사용</a>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/powerball-item.blade.php ENDPATH**/ ?>