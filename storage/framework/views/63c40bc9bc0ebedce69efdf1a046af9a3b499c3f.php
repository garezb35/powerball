<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('Analyse/analyse-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>


    <script>
        var from = "<?php echo e($from); ?>";
        var to = "<?php echo e($to); ?>";
    </script>
    <div class="periodBox" style="border-bottom: none">
        <div class="dateBox" style="width: 80%">
            <span class="from-date float-left" style="margin-left: 5px"><?php echo e(date("Y.m.d",strtotime($from))); ?></span>
            <div class="bar">~</div>
            <span class="to-date"><?php echo e(date("Y.m.d",strtotime($to))); ?></span>
            <span class="period-date" style="padding-right: 15px">(<?php echo e($diff); ?>일간)</span>
            <span>
                <ul class="switch_tab" style="display: inline-flex">
                    <li><a  href="/p_analyse?terms=date" style="margin-top: 5px;">하루씩 보기</a></li>
                    <li><a class="selected" href="/p_analyse?terms=period&dateType=30" style="margin-top: 5px;">기한으로 보기</a></li>
                </ul>
            </span>
        </div>
        <div class="btnBox" style="width: 20%">

            <a  class="btn_refresh" id="btn_refresh" href="javascript:location.reload();" title="새로고침" >
                <span class="ic fa fa-refresh"></span><span id="refresh-element">새로고침</span>
            </a>
        </div>
    </div>
    <div class="periodBox" style="padding-bottom: 20px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
        <div class="dateBox" style="width: 100%">
            <?php echo Form::open(['action' =>'App\Http\Controllers\PowerballController@view', 'method' => 'get','class'=>'d-inline-flex']); ?>

            <input type="hidden" name="terms" value="period">
            <input type="text" name="from" value="<?php echo e($from); ?>" class="dateInput sp-dayspace_bg " id="startDate"/>
            <div class="bar1">~</div>
            <input type="text" name="to" value="<?php echo e($to); ?>" class="dateInput sp-dayspace_bg " id="endDate"/>
            <button type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3" ><i class="fa fa-search"></i>&nbsp;&nbsp;검색</button>
            <?php echo Form::close(); ?>

            <div class="btn-group ml-2" role="group">
                <a href="/p_analyse?terms=period&dateType=7" style="border-top-left-radius: 5px;border-bottom-left-radius: 5px" class="border-right-0 btn <?php if(Request::get("dateType") ==7): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">7일</a>
                <a href="/p_analyse?terms=period&dateType=30" class="border-right-0 btn <?php if(Request::get("dateType") ==30 || (empty(Request::get("dateType")) && empty(Request::get("from")))): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">30일</a>
                <a href="/p_analyse?terms=period&dateType=60" class="border-right-0 btn <?php if(Request::get("dateType") ==60): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">60일</a>
                <a href="/p_analyse?terms=period&dateType=150" class="border-right-0 btn <?php if(Request::get("dateType") ==150): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">150일</a>
                <a href="/p_analyse?terms=period&dateType=365" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px" class="btn <?php if(Request::get("dateType") ==365): ?><?php echo e('btn-jin-green'); ?><?php else: ?><?php echo e('btn-green'); ?><?php endif; ?> btn-sm pl-3 pr-3">365일</a>
            </div>
        </div>
    </div>

    <div style="margin-top: 10px"></div>
    <div class="mt-4"></div>
    <?php echo $__env->make('Analyse/all_analyseTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('Analyse/maxminAnalyse', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("Analyse/maxminDay", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/powerball_period.blade.php ENDPATH**/ ?>