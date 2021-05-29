<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('Analyse/analyse-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <script>
        var from = "<?php echo e($from); ?>";
        var to = "<?php echo e($to); ?>";
        var round = <?php echo e($current_round); ?>;
    </script>
    <?php echo $__env->make("Time.timebox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="round_area">
        <?php echo Form::open(['action' =>'App\Http\Controllers\PowerballController@view', 'method' => 'get',"id"=>"round_form"]); ?>

        <input type="hidden" name="terms" value="round">
        <div class="info">
            <div id="round_search_type" class="view_se1">
                <div id="single_search" class="se1 ml-2">
                    <a class="sp-date_prev prev rollover" href="<?php echo e(route("p_analyse")); ?>?terms=round&toRound=<?php echo e($prev); ?>&from=<?php echo e($from); ?>&to=<?php echo e($to); ?>" rel="down" style="line-height: 61px;">
                        <i class="fa fa-angle-left" style="/* font-size:24px */"></i>
                    </a>
                    <span id="single_round" class="date"><?php echo e($current_round); ?></span>
                    <a class="sp-date_next next rollover" href="<?php echo e(route("p_analyse")); ?>?terms=round&toRound=<?php echo e($next); ?>&from=<?php echo e($from); ?>&to=<?php echo e($to); ?>" rel="up" style="line-height: 61px;">
                        <i class="fa fa-angle-right" style="/* font-size:24px */"></i>
                    </a>
                    <a class="btn_box" href="<?php echo e(route("p_analyse")); ?>?terms=round&current=1" rel="current">현재회차</a>
                    <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                        <?php for($i=1;$i<=288;$i++): ?>
                            <option <?php if($current_round == $i): ?><?php echo e('selected'); ?> <?php endif; ?> value="<?php echo e($i); ?>"><?php echo e($i); ?>회차</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <ul class="switch_tab round_tab">
                <li><a class="selected" href="<?php echo e(route("p_analyse")); ?>?terms=round" rel="se1">단일회차</a></li>
                <li><a class="" href="<?php echo e(route("p_analyse")); ?>?terms=roundbox" rel="se2">복수회차</a></li>
                <li><a href="<?php echo e(route('p_analyse')); ?>?terms=lates&pageType=late">최근회차</a></li>
            </ul>
        </div>
        <div class="date_search_option">
            <div class="dateBox" style="width: 100%">
                <input type="text" name="from" value="<?php echo e($from); ?>" class="dateInput sp-dayspace_bg" id="startDate">
                <div class="bar1">~</div>
                <input type="text" name="to" value="<?php echo e($to); ?>" class="dateInput sp-dayspace_bg" id="endDate">
                <button type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3"><i class="fa fa-search"></i>&nbsp;&nbsp;검색</button>
                <div class="btn-group ml-2" role="group" aria-label="Basic example">
                    <a style="border-top-left-radius: 5px;border-bottom-left-radius:5px" href="/p_analyse?terms=round&amp;dateType=7&toRound=<?php echo e($current_round); ?>" class="btn <?php if(Request::get("dateType") ==7): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">7일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=30&toRound=<?php echo e($current_round); ?>" class="btn <?php if(Request::get("dateType") ==30): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">30일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=60&toRound=<?php echo e($current_round); ?>" class="btn <?php if(Request::get("dateType") ==60): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">60일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=150&toRound=<?php echo e($current_round); ?>" class="btn <?php if(Request::get("dateType") ==150): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">150일</a>
                    <a style="border-top-right-radius: 5px;border-bottom-right-radius:5px" href="/p_analyse?terms=round&amp;dateType=365&toRound=<?php echo e($current_round); ?>" class="btn <?php if(Request::get("dateType") ==365): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">365일</a>
                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
    <?php echo $__env->make("Analyse.all_analyseTable", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/seeAnalyseTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/powerball_round.blade.php ENDPATH**/ ?>