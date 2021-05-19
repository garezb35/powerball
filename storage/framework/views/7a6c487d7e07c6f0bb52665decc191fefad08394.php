<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php

    $page =  Request::get("page") ?? 1;
    $first = $count - ($page-1) * 10;

?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <div class="exp-box">
            <span class="text">나의경험치</span><span class="exp"><?php echo e($user_exp); ?></span><span class="ea">EXP</span>
        </div>
        <div class="box-level">
            <ul>
                <?php if(!empty($level_list)): ?>
                    <?php $__currentLoopData = $level_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <li <?php if($value["code"] == $user_level): ?>on <?php endif; ?>>
                    <div>
                        <img src="<?php echo e($value["value3"]); ?>" width="23" height="23" alt="" class="<?php if($value["code"] != $user_level): ?>grayscale <?php endif; ?>">
                        <p><?php echo $value["description"]; ?></p>
                        <span class="text" style="display: <?php if($value["code"] == $user_level): ?>block <?php else: ?> none <?php endif; ?>">
                            <b><?php echo e($value["value1"]); ?></b> EXP
                            <span class="ar"></span>
                        </span>
                    </div>
                </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
        <div>
            <table class="table logBox table-bordered">
                <thead>
                    <tr class="title">
                        <th>번호</th>
                        <th>EXP</th>
                        <th>내용</th>
                        <th>일시</th>
                        <th>아이피</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($items)): ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $parsed_content = json_decode($value["content"]);
                    ?>
                <tr>
                    <td scope="row"><?php echo e($first); ?></td>
                    <td><?php echo e($parsed_content->exp); ?></td>
                    <td><?php echo e($parsed_content->msg); ?></td>
                    <td><?php echo e($value["created_at"]); ?></td>
                    <td><?php echo e($value["ip"]); ?></td>
                </tr>
                    <?php $first--; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($items->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/powerball-level.blade.php ENDPATH**/ ?>