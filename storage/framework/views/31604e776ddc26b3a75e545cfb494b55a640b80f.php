<?php
    $x = array();
    $x[0]=1;
    $x[1]=1;
?>

<?php $__env->startSection("content"); ?>
<div class="marketBox">
    <input type="hidden" id="api_token" value="<?php echo e(AUth::user()->api_token); ?>">
    <div class="title">
        <ul>
            <li><a href="<?php echo e(route("market")); ?>" target="mainFrame" <?php if(empty(Request::get("type"))): ?> class="on" <?php endif; ?>>전체</a></li>
            <li><a href="<?php echo e(route("market")); ?>?type=item" target="mainFrame" <?php if(Request::get("type") =="item"): ?> class="on" <?php endif; ?>>아이템</a></li>
            <li><a href="<?php echo e(route("market")); ?>?type=use" target="mainFrame" <?php if(Request::get("type") =="use"): ?> class="on" <?php endif; ?>>이용권</a></li>

            <li class="right"><a href="/member?type=charge" target="mainFrame">코인충전</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="tit none"><strong>코인</strong> 으로 구매 가능한 아이템입니다.</div>
        <ul class="itemList">
        <?php if(!empty($item[1])): ?>
            <?php $__currentLoopData = $item[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.item','data' => ['list' => $value,'key' => $key,'coin' => '코인','head' => '']]); ?>
<?php $component->withName('item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value),'key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($key),'coin' => '코인','head' => '']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        </ul>
		<div class="tit"><strong>도토리</strong> 로 구매 가능한 아이템입니다.</div>
		<ul class="itemList">
            <?php if(!empty($item[2])): ?>
                <?php $__currentLoopData = $item[2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.item','data' => ['list' => $value,'key' => $key,'coin' => '개','head' => '건빵']]); ?>
<?php $component->withName('item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value),'key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($key),'coin' => '개','head' => '건빵']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
		</ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/market.blade.php ENDPATH**/ ?>