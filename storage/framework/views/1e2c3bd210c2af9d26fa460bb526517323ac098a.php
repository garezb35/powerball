<?php $__env->startSection("content"); ?>
    <?php
    $first = sizeof($presents);
    $page = Request::get("page") ?? 1 ;
    $first = $first - ($page-1) * 20;
    $date = empty(Request::get("type")) ? date("Y-m-d") : Request::get("type");
    $y = date("Y",strtotime($date));
    $m = date("m",strtotime($date));
    $d = date("d",strtotime($date));
    ?>
    <script>
        var y = <?php echo e($y); ?>;
        var m = <?php echo e($m); ?>;
        var d = <?php echo e($d); ?>;
        var month_days = "<?php echo e($month_days); ?>";
    </script>
    <link rel="stylesheet" href="/assets/calendar/simple-calendar.css">
    <script src="/assets/calendar/jquery.simple-calendar.js"></script>
    <div class="attendanceBox">
        <div class="titleBox">
            출석체크 <span>- 매일 매일 출석체크하고 랜덤아이템상자 받자!</span>
        </div>

        <div class="topBox">
            <div class="calendarBox">
            </div>
            <div class="ladderBox">
                <div class="choiceBox">
                    <div class="choiceNumber" style="left:40px;">1</div>
                    <div class="choiceNumber" style="left:210px;">2</div>
                    <div class="choiceNumber" style="left:380px;">3</div>
                </div>
                <div class="ladderContent">
                    <div id="ladderResult"></div>
                </div>

                <div class="contentArea">
                    <form name="attendanceForm" id="attendanceForm" method="post" action="/">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="selectNumber" id="selectNumber">
                        <input type="hidden" name="winNumber" value="<?php echo e($win_number); ?>">
                        <input type="hidden" name="api_token" value="<?php echo e($api_token); ?>">
                        <ul>
                            <li class="choice">1</li>
                            <li class="choice">2</li>
                            <li class="choice">3</li>
                        </ul>
                        <div class="text">출석 코멘트</div>
                        <div class="inputBox"><input type="text" name="comment" class="input" value="<?php echo e(randomItemMessage()[$size]); ?>" readonly=""></div>
                        <div class="submit" style="background-color: #8ee2e2">출석체크</div>
                    </form>
                </div>

                <div class="choiceBox">
                    <div class="choiceNumber <?php if($win_number == 1): ?> win <?php endif; ?>" style="left:40px;"><?php if($win_number == 1): ?><?php echo e("당첨"); ?><?php else: ?><?php echo e("꽝"); ?><?php endif; ?></div>
                    <div class="choiceNumber <?php if($win_number == 2): ?> win <?php endif; ?>" style="left:210px;"><?php if($win_number == 2): ?><?php echo e("당첨"); ?><?php else: ?><?php echo e("꽝"); ?><?php endif; ?></div>
                    <div class="choiceNumber <?php if($win_number == 3): ?> win <?php endif; ?>" style="left:380px;"><?php if($win_number == 3): ?><?php echo e("당첨"); ?><?php else: ?><?php echo e("꽝"); ?><?php endif; ?></div>
                </div>
            </div>
        </div>

        <div class="listBox tbl_head01 tbl_wrap">
            <table class="table table-bordered">
                <colgroup>
                    <col width="50">
                    <col width="50">
                    <col width="80">
                    <col width="150">
                    <col>
                    <col width="100">
                </colgroup>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>결과</th>
                        <th class="text-center">개근</th>
                        <th>닉네임</th>
                        <th>코멘트</th>
                        <th class="text-center">출석시간</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($presents)): ?>
                    <?php $__currentLoopData = $presents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $present): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="">
                        <td class="number"><?php echo e($first); ?></td>
                        <td class="result"><?php if($present["result"] == "win"): ?><?php echo e("당첨"); ?><?php else: ?><?php echo e("꽝"); ?><?php endif; ?></td>
                        <td class="number"><?php echo e($present["perfectatt"]); ?>일</td>
                        <td class="nick"><img src="<?php echo e($present["user"]["getLevel"]["value3"]); ?>" width="30" height="30"><?php echo e($present["user"]["nickname"]); ?></td>
                        <td class="txt" data-hasqtip="207" oldtitle="<?php echo e($present["comment"]); ?>" title="" aria-describedby="qtip-207"><?php echo e($present["comment"]); ?></td>
                        <td class="number"><?php echo e($present["created_at"]); ?></td>
                    </tr>
                        <?php $first--; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($presents->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("includes.empty_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/present.blade.php ENDPATH**/ ?>