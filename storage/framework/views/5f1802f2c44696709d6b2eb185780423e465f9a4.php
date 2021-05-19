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
                    <th>아이템명</th>
                    <th>수량</th>
                    <th>총금액</th>
                    <th>일시</th>
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
                        <td><span class="text-<?php if($parsed_content->class == "use"): ?><?php echo e("danger"); ?><?php else: ?><?php echo e("primary"); ?><?php endif; ?>"><?php echo e($parsed_content->use); ?></span></td>
                        <td><?php echo e($parsed_content->name); ?></td>
                        <td><?php echo e($parsed_content->count); ?></td>
                        <td><?php echo e($parsed_content->price); ?></td>
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

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/powerball-itemLog.blade.php ENDPATH**/ ?>