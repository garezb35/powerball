<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php

    $page =  Request::get("page") ?? 1;
    $first = $count - ($page-1) * 10;

?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <div style="margin-bottom:5px;">
            <a href="/member?type=giftLog&giftType=give" class="b">■ 선물한 내역</a> &nbsp;
            <a href="/member?type=giftLog&giftType=take" class="">■ 선물 받은 내역</a>
        </div>
        <table class="table logBox">
            <thead>
            <tr class="title">
                <th>번호</th>
                <th>선물종류</th>
                <th><?php echo e($alias); ?></th>
                <th>수량</th>
                <th>일시</th>
            </tr>
            </thead>
            <tbody>
                <?php if(!empty($item)): ?>
                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php
                        if(empty($value[$self]["nickname"])) continue;
                        $parsed_content = json_decode($value["content"]);
                    ?>
                    <tr>
                        <td scope="row"><?php echo e($first); ?></td>
                        <td><?php echo e($parsed_content->type); ?></td>
                        <td><?php echo e($value[$self]["nickname"]); ?></td>
                        <td><?php echo e($parsed_content->count); ?></td>
                        <td><?php echo e($value["created_at"]); ?></td>
                    </tr>
                    <?php $first--; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/powerball-giftLog.blade.php ENDPATH**/ ?>