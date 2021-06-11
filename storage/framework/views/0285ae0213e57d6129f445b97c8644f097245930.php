

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
                <th>이전닉네임</th>
                <th>변경닉네임</th>
                <th>변경날짜</th>
                <th>아이피</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($item)): ?>
                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $parsed_content = json_decode($value["content"]);
                    ?>
                <tr>
                    <td scope="row"><?php echo e($first); ?></td>
                    <td><?php echo e($parsed_content->old); ?></td>
                    <td><?php echo e($parsed_content->new); ?></td>
                    <td><?php echo e($parsed_content->date); ?></td>
                    <td><?php echo e($value["ip"]); ?></td>
                </tr>
                    <?php $first-- ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/powerball-nicknameLog.blade.php ENDPATH**/ ?>