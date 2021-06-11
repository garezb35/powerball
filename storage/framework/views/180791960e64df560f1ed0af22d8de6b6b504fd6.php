
<?php $__env->startSection("content"); ?>
    <script>
        var userIdKey = "<?php echo e($userIdKey); ?>";
        <?php if($userIdKey !=""): ?>
        var loginYN = "Y";
        <?php else: ?>
        var loginYN = "N";
        <?php endif; ?>
        var userIdToken = "<?php echo e($api_token); ?>";
    </script>
    <?php echo $__env->make('chat.countdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="mb-2"></div>
    <?php echo $__env->make('pick.vs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="mb-2"></div>
<?php echo $__env->make('chat.box-chatting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make("includes.chat_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/chat/home.blade.php ENDPATH**/ ?>