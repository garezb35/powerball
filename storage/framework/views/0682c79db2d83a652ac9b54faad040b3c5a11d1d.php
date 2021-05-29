<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('Analyse/analyse-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <script>
        var limit = <?php echo e($limit); ?>;
    </script>
    <?php if(Request::get("pageType") =="display"): ?>
    <div id="powerballMiniViewDivpowerballMiniViewDiv" class="mb-1">
        <?php echo $__env->make('powerballminiView', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php endif; ?>
    <?php if(Request::get("pageType") =="late"): ?>
        <?php echo $__env->make("Time.timebox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="round_area" style="height: 63px;
        margin-bottom: 10px;">
            <div class="view_se1">
                <div id="single_search" class="se1">
                    <a class="sp-date_prev prev rollover" href="<?php echo e(route("p_analyse")); ?>?terms=lates&pageType=late&limit=<?php echo e($prev); ?>" rel="down" style="height: 61px;line-height: 61px;">
                        <i class="fa fa-angle-left" style="/* font-size:24px */"></i>
                    </a>
                    <span id="single_round" class="date"><?php echo e($limit); ?></span>
                    <a class="sp-date_next next rollover" href="<?php echo e(route("p_analyse")); ?>?terms=lates&pageType=late&limit=<?php echo e($next); ?>" rel="up" style="height: 61px;line-height: 61px;">
                        <i class="fa fa-angle-right" style="/* font-size:24px */"></i>
                    </a>
                    <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                        <?php for($i = 50; $i <= 2000; $i+=50): ?>
                            <option value="<?php echo e($i); ?>" <?php if($i ==$limit): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <ul class="switch_tab round_tab">
                <li><a  href="<?php echo e(route("p_analyse")); ?>?terms=round" rel="se1">단일회차</a></li>
                <li><a class="" href="<?php echo e(route("p_analyse")); ?>?terms=roundbox" rel="se2">복수회차</a></li>
                <li><a class="selected" href="<?php echo e(route('p_analyse')); ?>?terms=lates&pageType=late">최근회차</a></li>
            </ul>
        </div>
    <?php endif; ?>
    <?php echo $__env->make('Analyse/patternAnalyseTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/patternTerms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/seeAnalyseTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/head-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/powerball_lates.blade.php ENDPATH**/ ?>