<?php $__env->startSection("content"); ?>
    <?php
        $win_prefer= "pb_oe";
        $win_bet = "bet_number";
        $first= sizeof($users);
        switch(Request::get("type")){
            case "powerballOddEven":
                break;
            case "powerballUnderOver":
                $win_prefer= "pb_uo";
                $win_bet = "bet_number1";
                break;
            case "numberOddEven":
                $win_prefer= "nb_oe";
                $win_bet = "bet_number2";
                break;
            case "numberUnderOver":
                $win_prefer= "nb_uo";
                $win_bet = "bet_number3";
                break;
            case "numberSize":
                $win_prefer= "nb_size";
                $win_bet = "bet_number4";
                break;
            default:
                break;
        }
    ?>
    <div class="rankingBox">
        <div class="titleBox">
            랭킹 <span>- 픽 5,000회 이상 참여한 회원만 순위에 반영 됩니다. (최근 일주일 내에 픽한 경우)</span>
        </div>
        <div class="menuBox">
            <div class="title">
                <div class="left">파워볼</div>
                <div class="right">숫자합</div>
            </div>
            <div class="leftMenu">
                <div class="left"><a href="<?php echo e(route("ranking")); ?>?type=powerballOddEven" <?php if(empty(Request::get("type")) || Request::get("type") == "powerballOddEven"): ?> class="on" <?php endif; ?>>홀/짝</a></div>
                <div class="right"><a href="<?php echo e(route("ranking")); ?>?type=powerballUnderOver" <?php if(Request::get("type") == "powerballUnderOver"): ?> class="on" <?php endif; ?>>언더/오버</a></div>
            </div>
            <div class="rightMenu">
                <div class="subMenu"><a href="<?php echo e(route("ranking")); ?>?type=numberOddEven" <?php if(Request::get("type") == "numberOddEven"): ?> class="on" <?php endif; ?>>홀/짝</a></div>
                <div class="subMenu"><a href="<?php echo e(route("ranking")); ?>?type=numberUnderOver" <?php if(Request::get("type") == "numberUnderOver"): ?> class="on" <?php endif; ?>>언더/오버</a></div>
                <div class="subMenu none"><a href="<?php echo e(route("ranking")); ?>?type=numberSize" <?php if(Request::get("type") == "numberSize"): ?> class="on" <?php endif; ?>>대중소</a></div>
            </div>
        </div>
        <div class="listBox tbl_head01 tbl_wrap">
            <table class="table table-bordered">
                <colgroup>
                    <col width="80">
                    <col>
                    <col width="130">
                    <col width="130">
                    <col width="130">
                    <col width="130">
                </colgroup>
                <thead>
                    <tr >
                        <th class="text-center">순위</th>
                        <th class="text-center">닉네임</th>
                        <th class="text-center">참여회차수</th>
                        <th class="text-center">승률</th>
                        <th class="text-center">승</th>
                        <th class="text-center">패</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($users)): ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $win_history = $user["winning_history"];
                        if(!empty($win_history))
                           {
                           $win_history = json_decode($user["winning_history"]);
                            $total_bet = ($win_history->$win_prefer->win + $win_history->$win_prefer->lose) == 0 ? 1 : win_history->$win_prefer->win + $win_history->$win_prefer->lose;
                           }
                        ?>

                <tr class="trEven">
                    <td class="number text-center align-middle"><?php echo e($first); ?></td>
                    <td class="nick text-center align-middle"><img src="<?php echo e($user["get_level"]["value3"]); ?>" width="30" height="30"> <?php echo e($user["nickname"]); ?></td>
                    <td class="number text-center align-middle"><?php echo e(number_format($user[$win_bet])); ?></td>
                    <td class="number text-center align-middle"> <?php echo e(number_format($win_history->$win_prefer->win*100 /$total_bet,2)); ?>%</td>
                    <td class="number text-center align-middle"><?php echo e(number_format($win_history->$win_prefer->win)); ?></td>
                    <td class="number text-center align-middle"><?php echo e(number_format($win_history->$win_prefer->lose)); ?></td>
                </tr>
                        <?php
                        $first--;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </tbody></table>
            <div class="pagingBox"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("includes.empty_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/ranking.blade.php ENDPATH**/ ?>