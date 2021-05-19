<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php

    $page =  Request::get("page") ?? 1;
    $first = $count - ($page-1) * 10;

?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <table class="table logBox">
            <thead>
            <tr class="title">
                <th>번호</th>
                <th>아이템명</th>
                <th>만료일</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                if(empty($value["item"]["name"])) continue;
                ?>
                <tr>
                    <td scope="row"><?php echo e($first); ?></td>
                    <td><?php echo e($value["item"]["name"]); ?></td>
                    <td><?php echo e($value["terms2"]); ?></td>
                </tr>
                <?php $first--; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($item->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/powerball-itemTerm.blade.php ENDPATH**/ ?>