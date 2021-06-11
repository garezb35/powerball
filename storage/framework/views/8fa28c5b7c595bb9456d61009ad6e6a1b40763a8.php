

<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php

    $page =  Request::get("page") ?? 1;
    $first = $count - ($page-1) * 10;

?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <table class="table logBox table-bordered">
            <thead>
                <tr class="title">
                    <th>번호</th>
                    <th>상태</th>
                    <th>결제수단</th>
                    <th>충전코인</th>
                    <th>결제금액</th>
                    <th>일시</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($item)): ?>
                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $alias= "입금신청";
                    if($value["accept"] == 1)
                        $alias = "입금완료";
                    if($value["accept"] == 2)
                        $alias = "입금거절";
                    ?>
                    <tr>
                        <td scope="row"><?php echo e($first); ?></td>
                        <td><span class="text-danger"><?php echo e($alias); ?></span></td>
                        <td>무통장입금</td>
                        <td><?php echo e(number_format($value["coin"])); ?></td>
                        <td><?php echo e(number_format($value["money"])); ?></td>
                        <td><?php echo e($value["created_at"]); ?></td>
                    </tr>
                    <?php $first--; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            </tbody>
        </table>
        <?php echo e($item->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/powerball-chargeLog.blade.php ENDPATH**/ ?>