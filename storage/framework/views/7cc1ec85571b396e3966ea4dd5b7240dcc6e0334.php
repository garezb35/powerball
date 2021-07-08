
<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('Analyse/analyse-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
<script>
    var from = "<?php echo e($from); ?>";
    var to = "<?php echo e($to); ?>";
    var from_round = "<?php echo e($from_round); ?>";
    var to_round = "<?php echo e($to_round); ?>";
    var pb_type = "<?php echo e($mode); ?>";
</script>
<?php echo $__env->make("Time.timebox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="round_area">
    <?php echo Form::open(['action' =>'App\Http\Controllers\PowerballController@view', 'method' => 'get',"id"=>"round_form"]); ?>

    <input type="hidden" name="terms" value="roundbox">
    <div class="info">
        <div id="round_search_type" class="view_se1">
            <div id="single_search" class="se1 pl-3">
                <select id="single_from_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="fromRound" style="margin-left: 0px">
                    <?php for($i=1;$i<=288;$i++): ?>
                        <option <?php if($from_round == $i): ?><?php echo e('selected'); ?> <?php endif; ?> value="<?php echo e($i); ?>"><?php echo e($i); ?>회차</option>
                    <?php endfor; ?>
                </select>
                <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                    <?php for($i=1;$i<=288;$i++): ?>
                        <option <?php if($to_round == $i): ?><?php echo e('selected'); ?> <?php endif; ?> value="<?php echo e($i); ?>"><?php echo e($i); ?>회차</option>
                    <?php endfor; ?>
                </select>
                <select name="mode" id="mode" class="selectbox">
                    <option value="pb_oe" <?php if($mode =="pb_oe"): ?><?php echo e('selected'); ?><?php endif; ?>>파워볼 홀/짝</option>
                    <option value="pb_uo" <?php if($mode =="pb_uo"): ?><?php echo e('selected'); ?><?php endif; ?>>파워볼 언/오</option>
                    <option value="nb_oe" <?php if($mode =="nb_oe"): ?><?php echo e('selected'); ?><?php endif; ?>>일반볼합 홀/짝</option>
                    <option value="nb_uo" <?php if($mode =="nb_uo"): ?><?php echo e('selected'); ?><?php endif; ?>>일반볼합 언/오</option>
                </select>
            </div>
        </div>
        <ul class="switch_tab round_tab">
            <li><a href="<?php echo e(route("p_analyse")); ?>?terms=round" rel="se1">단일회차</a></li>
            <li><a class="selected" href="<?php echo e(route("p_analyse")); ?>?terms=roundbox" rel="se2">복수회차</a></li>
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
                <a style="border-top-left-radius: 5px;border-bottom-left-radius:5px" href="/p_analyse?terms=roundbox&amp;dateType=2&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==2): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">2일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=4&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==4): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">4일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=7&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==7): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">7일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=15&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==15): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">15일</a>
                <a style="border-top-right-radius: 5px;border-bottom-right-radius:5px" href="/p_analyse?terms=roundbox&amp;dateType=30&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==30): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">한달</a>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>


</div>
<div class="list_opt">
    <ul id="filter-btns" class="filter_btn_area mb-0">
        <li><a type="button" value="" class="selected">전체</a></li>
        <li><a type="button" value="sp-odd">홀강조</a></li>
        <li><a type="button" value="sp-even" class="">짝강조</a></li>
    </ul>
</div>
<div style="width: 100%;overflow-x: scroll;padding-top:15px">
    <h5 class="text-center"><?php echo e($title); ?><div class="half-label" style="width: 608px"></div></h5>
    <table class="table powerballBox mt-2 table-bordered">
        <tbody class="roundbox-body"></tbody>
    </table>
</div>
<?php echo $__env->make("Analyse/roundbox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/powerball_roundbox.blade.php ENDPATH**/ ?>