

<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <table class="table logBox table-bordered">
            <thead>
                <tr class="title">
                    <th>번호</th>
                    <th>접속일시</th>
                    <th>접속IP</th>
                    <th>접속기기</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $loginlog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($log["id"]); ?></td>
                        <td><?php echo e($log["created_at"]); ?></td>
                        <td><?php echo e($log["ip"]); ?></td>
                        <td><?php if($log["machine"] == 1): ?><?php echo e('PC'); ?><?php else: ?><?php echo e("mobile"); ?><?php endif; ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($loginlog->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/powerball-accesslog.blade.php ENDPATH**/ ?>