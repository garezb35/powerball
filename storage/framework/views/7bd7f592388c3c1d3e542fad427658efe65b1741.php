<li class="<?php if(intval($key) % 4 == 0): ?> ml-0 <?php endif; ?> <?php if(intval($key) % 4 == 3): ?> mr-0 <?php endif; ?>" style="<?php if(intval($key) % 4 == 3): ?> width:180px <?php endif; ?>">
    <?php if($list["hot_icon"]==1): ?><div class="edge hot"><img src="assets/images/powerball/hot.png" width="45" ></div><?php endif; ?>
    <?php if($list["hot_icon"]==2): ?><div class="edge new"><img src="assets/images/powerball/new.png" width="45"></div><?php endif; ?>
    <img src="<?php echo e($list["image"]); ?>" width="115" height="100">
    <div class="name"><?php echo e($list["name"]); ?></div>
    <?php if(!empty($list["bonus"])): ?>
        <div class="bonus">
            <span class="tit">보너스</span>
            <span class="exp"><?php echo e($list["bonus"]); ?>EXP</span></div>
    <?php endif; ?>
    <div class="desc"><?php echo e($list["description"]); ?></div>

    <div class="priceBox">
        <div class="price"><?php echo e($head); ?> <?php echo e(number_format($list["price"])); ?> <?php echo e($coin); ?></div>
        <div class="amountSet">
            <input type="text" name="<?php echo e($list["code"]); ?>" maxlength="2" value="1개" rel="1" limit="<?php echo e($list["limit"]); ?>" style="ime-mode:disabled;" onkeydown="return isNumber(event);" onblur="countChk(this);">
            <span class="up"></span>
            <span class="down"></span>
        </div>
        <div class="btn-g">
            <a href="#" class="btn_buy btn btn-sm" itemcode="<?php echo e($list["code"]); ?>" title="<?php echo e($list["name"]); ?>">구매</a>
            <?php if(!empty($list["gift_used"])): ?>
            <a href="#" class="btn_gift btn btn-outline-secondary btn-sm" itemcode="<?php echo e($list["code"]); ?>" title="<?php echo e($list["name"]); ?>" >선물</a>
            <?php endif; ?>
        </div>
    </div>
</li>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/components/item.blade.php ENDPATH**/ ?>