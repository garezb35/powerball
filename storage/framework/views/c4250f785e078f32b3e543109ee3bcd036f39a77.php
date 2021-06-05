<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('Analyse/psadari/analyse-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <script>
        var from = "<?php echo e($from); ?>";
        var to = "<?php echo e($to); ?>";
        var from_round = "<?php echo e($from_round); ?>";
        var to_round = "<?php echo e($to_round); ?>";
        var pb_type = "<?php echo e($mode); ?>";
    </script>
    <div class="mt-2"></div>
    <?php echo $__env->make("Time.timebox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="mb-2"></div>
    <div class="round_area">
        <?php echo Form::open(['action' =>'App\Http\Controllers\PowerSadariController@view', 'method' => 'get',"id"=>"round_form"]); ?>

        <input type="hidden" name="terms" value="roundbox">
        <div class="info">
            <div id="round_search_type" class="view_se1">
                <div id="single_search" class="se1 pl-2">
                    <select id="single_from_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="fromRound">
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
                        <option value="odd_even" <?php if($mode =="odd_even"): ?><?php echo e('selected'); ?><?php endif; ?>>홀/짝</option>
                        <option value="three_four" <?php if($mode =="three_four"): ?><?php echo e('selected'); ?><?php endif; ?>>3/4</option>
                        <option value="left_right" <?php if($mode =="left_right"): ?><?php echo e('selected'); ?><?php endif; ?>>좌/우</option>
                        <option value="total" <?php if($mode =="total"): ?><?php echo e('selected'); ?><?php endif; ?>>출줅</option>
                    </select>
                </div>
            </div>
            <ul class="switch_tab round_tab">
                <li><a href="<?php echo e(route("psadari_analyse")); ?>?terms=round" rel="se1">단일회차</a></li>
                <li><a class="selected" href="<?php echo e(route("psadari_analyse")); ?>?terms=roundbox" rel="se2">복수회차</a></li>
                <li><a href="<?php echo e(route('psadari_analyse')); ?>?terms=lates&pageType=late">최근회차</a></li>
            </ul>
        </div>
        <div class="date_search_option pl-3">
            <div class="dateBox" style="width: 100%">
                <input type="text" name="from" value="<?php echo e($from); ?>" class="dateInput sp-dayspace_bg" id="startDate">
                <div class="bar1">~</div>
                <input type="text" name="to" value="<?php echo e($to); ?>" class="dateInput sp-dayspace_bg" id="endDate">
                <button type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3"><i class="fa fa-search"></i>&nbsp;&nbsp;검색</button>
                <div class="btn-group ml-2" role="group" aria-label="Basic example">
                    <a style="border-top-left-radius: 5px;border-bottom-left-radius:5px" href="/psadari_analyse?terms=roundbox&amp;dateType=7&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==7 || empty(Request::get("dateType"))): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">7일</a>
                    <a href="/psadari_analyse?terms=roundbox&amp;dateType=30&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==30): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">30일</a>
                    <a href="/psadari_analyse?terms=roundbox&amp;dateType=60&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==60): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">60일</a>
                    <a href="/psadari_analyse?terms=roundbox&amp;dateType=150&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==150): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">150일</a>
                    <a style="border-top-right-radius: 5px;border-bottom-right-radius:5px" href="/psadari_analyse?terms=roundbox&amp;dateType=365&toRound=<?php echo e($to_round); ?>&fromRound=<?php echo e($from_round); ?>&mode=<?php echo e($mode); ?>" class="btn <?php if(Request::get("dateType") ==365): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">365일</a>
                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>


    </div>
    <div class="list_opt">
        <ul id="filter-btns" class="filter_btn_area mb-0">
            <li><a type="button" value="" class="selected">전체</a></li>
            <?php if($mode == "odd_even"): ?>
                <li><a type="button" value="sp-odd">홀강조</a></li>
                <li><a type="button" value="sp-even" class="">짝강조</a></li>
            <?php endif; ?>
            <?php if($mode == "left_right"): ?>
                <li><a type="button" value="sp-odd">좌강조</a></li>
                <li><a type="button" value="sp-even" class="">우강조</a></li>
            <?php endif; ?>
            <?php if($mode == "three_four"): ?>
                <li><a type="button" value="sp-odd">3강조</a></li>
                <li><a type="button" value="sp-even" class="">4강조</a></li>
            <?php endif; ?>
            <?php if($mode == "total"): ?>
                <li><a type="button" value="sp-odd1">좌3짝강조</a></li>
                <li><a type="button" value="sp-odd2" class="">좌4홀강조</a></li>
                <li><a type="button" value="sp-odd3" class="">우3홀강조</a></li>
                <li><a type="button" value="sp-odd4" class="">우4짝강조</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div style="width: 100%;overflow-x: scroll;padding-top:15px">
        <h5 class="text-center"><?php echo e($title); ?><div class="half-label" style="width: 608px"></div></h5>
        <table class="table powerballBox mt-2 table-bordered">
            <tbody class="roundbox-body"></tbody>
        </table>
    </div>
    </div>
    <?php echo $__env->make("Analyse/psadari/roundbox", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/psadari/powerball_roundbox.blade.php ENDPATH**/ ?>