<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('Analyse/psadari/analyse-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        var limit = <?php echo e($limit); ?>;
    </script>
    <?php if(Request::get("pageType") =="display"): ?>
    <div id="powerballMiniViewDiv" class="mb-1">
        <?php echo $__env->make('powerballSadariMiniview', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php endif; ?>
    <?php if(Request::get("pageType") =="late"): ?>
    <div class="mt-2"></div>
    <?php echo $__env->make("Time.timebox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="round_area" style="height: 63px;
    margin-top: 8px;
    margin-bottom: 10px;">
        <div class="view_se1">
            <div id="single_search" class="se1">
                <a style="height: 61px;line-height: 61px;" class="sp-date_prev prev rollover" href="<?php echo e(route("p_analyse")); ?>?terms=lates&pageType=late&limit=<?php echo e($prev); ?>" rel="down"><i class="fa fa-angle-left" style="/* font-size:24px */"></i></a>
                <span id="single_round" class="date"><?php echo e($limit); ?></span>
                <a style="height: 61px;line-height: 61px;" class="sp-date_next next rollover" href="<?php echo e(route("p_analyse")); ?>?terms=lates&pageType=late&limit=<?php echo e($next); ?>" rel="up"><i class="fa fa-angle-right" style="/* font-size:24px */"></i></a>
                <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                    <?php for($i = 50; $i <= 2000; $i+=50): ?>
                        <option value="<?php echo e($i); ?>" <?php if($i ==$limit): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <ul class="switch_tab round_tab">
            <li><a  href="<?php echo e(route("psadari_analyse")); ?>?terms=round" rel="se1">단일회차</a></li>
            <li><a class="" href="<?php echo e(route("psadari_analyse")); ?>?terms=roundbox" rel="se2">복수회차</a></li>
            <li><a class="selected" href="<?php echo e(route('psadari_analyse')); ?>?terms=lates&pageType=late">최근회차</a></li>
        </ul>
    </div>
    <?php endif; ?>
    <?php echo $__env->make('Analyse/psadari/patternAnalyseTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/psadari/patternTerms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/psadari/seeAnalyseTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/psadari/head-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/psadari/chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/psadari/powerball_lates.blade.php ENDPATH**/ ?>