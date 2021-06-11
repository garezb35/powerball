<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>파워볼 게임</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/pball.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <script>
        var remainTime = 0;
        var speedRemain = 0;
        var is_admin = false;
    </script>
    <?php echo $__env->yieldContent('script_header'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.2/socket.io.js" ></script>
    <script src="/assets/js/handlebars.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/jplayer/jquery.jplayer.min.js"></script>
    <script src="/assets/chart/Chart.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <?php if(empty(!$css)): ?>
        <link rel="stylesheet" href="/assets/css/<?php echo e($css); ?>">
    <?php endif; ?>
</head>
<body>
    <div class="modal sm-message bd-example-modal-sm"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">안내</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <div id="userLayer" style="display: none">
        <div class="lutop"><span id="unickname">관리왕1</span></div>
        <div class="game"></div>
    </div>
    <?php echo $__env->yieldContent('header'); ?>
    <?php echo $__env->yieldContent('content'); ?>
</body>
<?php echo $__env->make('includes.empty_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html>
<script>
    $(document).ready(function(){
        heightResize();
        $('.collapsing-element').on('hidden.bs.collapse', function () {
           $(this).parent().find(".closing").text("열기");
        })
        $('.collapsing-element').on('show.bs.collapse', function () {
            $(this).parent().find(".closing").text("닫기");
        })
    })
</script>
<?php /**PATH D:\xampp1\htdocs\powerball\resources\views/includes/empty_header.blade.php ENDPATH**/ ?>