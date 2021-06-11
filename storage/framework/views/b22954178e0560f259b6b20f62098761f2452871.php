
<?php $__env->startSection("header"); ?>
<?php echo $__env->make("pick/pick1", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
<table  id="powerballLogBox" class="powerballBox table table-bordered table-striped" style="margin-top: 5px;">
    <colgroup>
        <col width="110" />
        <col />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
    </colgroup>
    <tbody>
        <tr>
            <th height="30" colspan="12" class="title pt-2 pb-2 border-top-bora ggray">파워볼게임 픽 내역 (최근 3개월만 보관됩니다.)</th>
        </tr>
        <tr class="subTitle ggray">
            <th class="ggray" rowspan="3" style="height: 60px;">회차</th>
            <th class="ggray" rowspan="3">참여시간</th>
            <th class="ggray" colspan="2" rowspan="2">홀/짝</th>
            <th class="ggray" colspan="2" rowspan="2">언더/오버</th>
            <th class="ggray" rowspan="2">대중소</th>
            <th class="ggray" colspan="5">적중여부</th>
        </tr>
        <tr class="subTitle ggray">
            <th class="ggray" colspan="2">홀/짝</th>
            <th class="ggray" colspan="2">언더/오버</th>
            <th class="ggray">대중소</th>
        </tr>
        <tr class="thirdTitle ggray">
            <th class="ggray" style="height: 40px;">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">숫자합</th>
        </tr>
        <?php if(!empty($current_picks)): ?>

        <?php endif; ?>
        <?php $__currentLoopData = $picks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pick_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $pick_content = json_decode($pick_item->content);
            ?>
        <tr class="trOdd">
            <td height="40" align="center" class="numberText"><?php echo e(date("m.d",strtotime($pick_item->created_date))); ?>-<?php echo e($pick_item->round); ?>회</td>
            <td align="center" class="numberText"><?php echo e(date("m-d H:i",strtotime($pick_item->pick_date))); ?></td>
            <td align="center">
                <?php if(!empty($pick_content->pb_oe)): ?>
                    <?php if($pick_content->pb_oe->pick == "1" ): ?>
                        <div class="sp-odd">홀</div>
                    <?php else: ?>
                        <div class="sp-even">짝</div>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>

            </td>
            <td align="center">
                <?php if(!empty($pick_content->nb_oe)): ?>
                    <?php if($pick_content->nb_oe->pick == "1" ): ?>
                        <div class="sp-odd">홀</div>
                    <?php else: ?>
                        <div class="sp-even">짝</div>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->pb_uo)): ?>
                    <?php if($pick_content->pb_uo->pick == "1" ): ?>
                        <div class="sp-under"></div>
                    <?php else: ?>
                        <div class="sp-over"></div>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->nb_uo)): ?>
                    <?php if($pick_content->nb_uo->pick == "1" ): ?>
                        <div class="sp-under"></div>
                    <?php else: ?>
                        <div class="sp-over"></div>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->nb_size)): ?>
                    <?php if($pick_content->nb_size->pick == "1" ): ?>
                        <div class="sp-small">소</div>
                    <?php elseif($pick_content->nb_size->pick == "2" ): ?>
                        <div class="sp-middle">중</div>
                    <?php else: ?>
                        <div class="sp-big">대</div>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->pb_oe)): ?>
                <span class="lightgray">
                    <?php if($pick_content->pb_oe->is_win == "1" ): ?>
                        <span class="text-danger font-weight-bold">적중</span>
                    <?php elseif($pick_content->pb_oe->is_win == "-1" ): ?>
                        -
                    <?php else: ?>
                        <span class="lightgray">미적중</span>
                    <?php endif; ?>
                </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->nb_oe)): ?>

                    <?php if($pick_content->nb_oe->is_win == "1" ): ?>
                        <span class="text-danger font-weight-bold">적중</span>
                    <?php elseif($pick_content->nb_oe->is_win == "-1" ): ?>
                        -
                    <?php else: ?>
                        <span class="lightgray">미적중</span>
                    <?php endif; ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->pb_uo)): ?>
                    <?php if($pick_content->pb_uo->is_win == "1" ): ?>
                        <span class="text-danger font-weight-bold">적중</span>
                    <?php elseif($pick_content->pb_uo->is_win == "-1" ): ?>
                        -
                    <?php else: ?>
                        <span class="lightgray">미적중</span>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->nb_uo)): ?>

                    <?php if($pick_content->nb_uo->is_win == "1" ): ?>
                        <span class="text-danger font-weight-bold">적중</span>
                    <?php elseif($pick_content->nb_uo->is_win == "-1" ): ?>
                        -
                    <?php else: ?>
                        <span class="lightgray">미적중</span>
                    <?php endif; ?>
                    </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td align="center">
                <?php if(!empty($pick_content->nb_size)): ?>
                    <?php if($pick_content->nb_size->is_win == "1" ): ?>
                        <span class="text-danger font-weight-bold">적중</span>
                    <?php elseif($pick_content->nb_size->is_win == "-1" ): ?>
                        -
                    <?php else: ?>
                        <span class="lightgray">미적중</span>
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php echo e($picks->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/powerball_pick.blade.php ENDPATH**/ ?>