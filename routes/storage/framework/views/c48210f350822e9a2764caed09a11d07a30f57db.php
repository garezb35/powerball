<?php
$po = $pu = array();
$po[0]="<div class=\"sp-odd\">홀</div>";
$po[1]="<div class=\"sp-even\">짝</div>";
$pu[0]="<div class='sp-under'></div>";
$pu[1]="<div class='sp-over''></div>";
$sum1 = $sum2 = $sum3 = $sum4 = 0;
$sum1 = ($pb_oe_arr[0] + $pb_oe_arr[1] ) == 0 ? 1 : $pb_oe_arr[0] + $pb_oe_arr[1];
$sum2 = ($pb_uo_arr[0] + $pb_uo_arr[1] ) == 0 ? 1 : $pb_uo_arr[0] + $pb_uo_arr[1];
$sum3 = ($nb_oe_arr[0] + $nb_oe_arr[1] ) == 0 ? 1 : $nb_oe_arr[0] + $nb_oe_arr[1];
$sum4 = ($nb_uo_arr[0] + $nb_uo_arr[1] ) == 0 ? 1 : $nb_uo_arr[0] + $nb_uo_arr[1];
?>

<?php $__env->startSection("content"); ?>

<div class="bar-header">
  <div class="bar_graph">
    <dl class="border-top-none">
        <dt>파워볼</dt>
        <dd>
            <div class="bar">
                <p class="left <?php if($pb_oe_arr[1] > $pb_oe_arr[0]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($pb_oe_arr[1]*100/$sum1); ?>%;">
                    <span class="per"><strong><?php echo e($pb_oe_arr[1]); ?></strong> (<?php echo e($pb_oe_arr[1]*100/$sum1); ?>%)</span>
                    <span class="tx">홀</span>
                </p>
                <p class="right <?php if($pb_oe_arr[0] > $pb_oe_arr[1]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($pb_oe_arr[0]*100/$sum1); ?>%;">
                    <span class="per"><strong><?php echo e($pb_oe_arr[0]); ?></strong> (<?php echo e($pb_oe_arr[0]*100/$sum1); ?>%)</span>
                    <span class="tx">짝</span>
                </p>
            </div>
            <div class="bar">
                <p class="left <?php if($pb_uo_arr[1] > $pb_uo_arr[0]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($pb_uo_arr[1]*100/$sum2); ?>%;">
                    <span class="per"><strong><?php echo e($pb_uo_arr[1]); ?></strong> (<?php echo e($pb_uo_arr[1]*100/$sum2); ?>%)</span>
                    <span class="tx">언더</span>
                </p>
                <p class="right  <?php if($pb_uo_arr[0] > $pb_uo_arr[1]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($pb_uo_arr[0]*100/$sum2); ?>%;">
                    <span class="per"><strong><?php echo e($pb_uo_arr[0]); ?></strong> (<?php echo e($pb_uo_arr[0]*100/$sum2); ?>%)</span>
                    <span class="tx">오버</span>
                </p>
            </div>
        </dd>
    </dl>
  </div>
  <div class="bar_graph">
    <dl class="border-top-none">
        <dt>일반볼</dt>
        <dd>
            <div class="bar">
                <p class="left <?php if($nb_oe_arr[1] > $nb_oe_arr[0]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($nb_oe_arr[1]*100/$sum3); ?>%;">
                    <span class="per"><strong><?php echo e($nb_oe_arr[1]); ?></strong> (<?php echo e($nb_oe_arr[1]*100/$sum3); ?>%)</span>
                    <span class="tx">홀</span>
                </p>
                <p class="right <?php if($nb_oe_arr[0] > $nb_oe_arr[1]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($nb_oe_arr[0]*100/$sum3); ?>%;">
                    <span class="per"><strong><?php echo e($nb_oe_arr[0]); ?></strong> (<?php echo e($nb_oe_arr[0]*100/$sum3); ?>%)</span>
                    <span class="tx">짝</span>
                </p>
            </div>
            <div class="bar">
                <p class="left <?php if($nb_uo_arr[1] > $nb_uo_arr[0]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($nb_uo_arr[1]*100/$sum4); ?>%;">
                    <span class="per"><strong><?php echo e($nb_uo_arr[1]); ?></strong> (<?php echo e($nb_uo_arr[1]*100/$sum4); ?>%)</span>
                    <span class="tx">언더</span>
                </p>
                <p class="right <?php if($nb_uo_arr[0] > $nb_uo_arr[1]): ?><?php echo e("on"); ?><?php endif; ?>" style="width:<?php echo e($nb_uo_arr[0]*100/$sum4); ?>%;">
                    <span class="per"><strong><?php echo e($nb_uo_arr[0]); ?></strong> (<?php echo e($nb_uo_arr[0]*100/$sum4); ?>%)</span>
                    <span class="tx">오버</span>
                </p>
            </div>
        </dd>
    </dl>
  </div>
</div>
<ul class="nav mb-2" id="powerball-category" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="powerball-tab" data-toggle="pill" href="#powerball-content" role="tab" >파워볼</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="nb-tab" data-toggle="pill" href="#nb-content" role="tab" aria-controls="nb-content" aria-selected="false">일반볼</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="powerball-content" role="tabpanel" aria-labelledby="pills-home-tab">
        <table class="table table-bordered table-gray table-pad">
            <tbody>
            <tr class="green-back">
                <td colspan="4" class="text-center" width="50%">파워볼</td>
                <td colspan="4" class="text-center" width="50%">파워볼언옵</td>
            </tr>
            <tr>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">AI번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">현재연승</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">다음회차픽</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">AI번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">현재연승</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">다음회차픽</span>
                </td>
            </tr>
            <?php if(!empty($pb_oe)): ?>
                <?php for($i = 0 ;$i <sizeof($pb_oe);$i++): ?>
                    <tr>
                        <td class="text-center"><?php echo e($i+1); ?></td>
                        <td class="text-center"><?php echo e($pb_oe[$i]["ai_id"]); ?></td>
                        <td class="text-center"><?php echo e($pb_oe[$i]["winning_num"]); ?></td>
                        <td class="text-center"><?php echo $po[$pb_oe[$i]["pick"]]; ?></td>
                        <td class="text-center"><?php echo e($i+1); ?></td>
                        <td class="text-center"><?php echo e($pb_uo[$i]["ai_id"]); ?></td>
                        <td class="text-center"><?php echo e($pb_uo[$i]["winning_num"]); ?></td>
                        <td class="text-center"><?php echo $pu[$pb_uo[$i]["pick"]]; ?></td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">배팅대기중...</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nb-content" role="tabpanel" aria-labelledby="pills-profile-tab">
        <table class="table table-bordered table-gray table-pad">
            <tbody>
                <tr class="green-back">
                    <td colspan="4" class="text-center" width="50%">일반볼</td>
                    <td colspan="4" class="text-center" width="50%">일반볼언옵</td>
                </tr>
                <tr>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">AI번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">현재연승</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">다음회차픽</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">AI번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">현재연승</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">다음회차픽</span>
                    </td>
                </tr>
                <?php if(!empty($nb_oe)): ?>
                    <?php for($i = 0 ;$i <sizeof($nb_oe);$i++): ?>
                        <tr>
                            <td class="text-center"><?php echo e($i+1); ?></td>
                            <td class="text-center"><?php echo e($nb_oe[$i]["ai_id"]); ?></td>
                            <td class="text-center"><?php echo e($nb_oe[$i]["winning_num"]); ?></td>
                            <td class="text-center"><?php echo $po[$nb_oe[$i]["pick"]]; ?></td>
                            <td class="text-center"><?php echo e($i+1); ?></td>
                            <td class="text-center"><?php echo e($nb_uo[$i]["ai_id"]); ?></td>
                            <td class="text-center"><?php echo e($nb_uo[$i]["winning_num"]); ?></td>
                            <td class="text-center"><?php echo $pu[$nb_uo[$i]["pick"]]; ?></td>
                        </tr>
                    <?php endfor; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">배팅대기중...</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<style>
#powerball-category .nav-link{
    display: block;
    text-decoration: none;
    border: 1px solid #cfd2d4;
    border-right: none;
}
#powerball-category .nav-item{
    list-style: none;
    float: left;
    width: 100px;
    text-align: center;
}
#powerball-category .nav-link.active{
  background-color: #00b4b4;
  color: #fff;
}
#powerball-category .nav-item:nth-child(1) a {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}
#powerball-category .nav-item:last-child a {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-right: solid #cfd2d4 1px;
}

.bar-header:after{
  clear: both;
  display: block;
  content: "";
}

.bar_graph{
  width: 50%;
  float: left;
}

.bar_graph .bar {
    margin-bottom: 30px;
    width: 100%;
    height: 21px;
    border-radius: 11px;
    background-color: #d7dbdb;
}

.bar_graph p {
    position: relative;
    height: 21px;
    border-radius: 11px;
    color: #555;
}

.bar_graph .left {
    float: left;
    max-width: 50px;
}

.bar_graph .left.on {
    color: #fff;
    max-width: 250px;
    background: url(/assets/images/powerball/bar-blue.svg) no-repeat;
    background-size: cover;
}

.bar_graph .left .per {
    left: 9px;
}
.bar_graph .right .per {
    right: 9px;
}


.bar_graph .per {
    position: absolute;
    top: 0;
    line-height: 21px;
    white-space: nowrap;
    font-family: 'nanumseb';
    font-size: 11px;
    z-index: 1;
    font-weight: bold;
}


.bar_graph .right {
    float: right;
    max-width: 50px;
}

.bar_graph{
    width: 50%
}


.bar_graph .left.on .tx {
    background: url(/assets/images/powerball/odd.svg);
    background-size: 29px;
    color: #fff;
}

.bar_graph .right.on .tx {
    background: url(/assets/images/powerball/even.svg);
    background-size: 29px;
    color: #fff;
}

.bar_graph .left .tx {
    left: -41px;
}

.bar_graph .right .tx {
    right: -41px;
}

.bar_graph .tx {
    position: absolute;
    top: -5px;
    width: 29px;
    height: 29px;
    line-height: 29px;
    text-align: center;
    border: 1px solid #d8d8d8;
    border-radius: 16px;
    background-color: #fff;
    color: #333;
}

.bar_graph dd {
    padding: 0 71px;
    width: 272px;
}

.bar_graph dl {
    border-top: 1px solid #d6d6d6;
}

.bar_graph dt {
    padding: 19px 0 28px;
    text-align: center;
    font-weight: normal;
    font-size: 15px;
}
.bar_graph .right.on {
    color: #fff;
    max-width: 250px;
    background: url(/assets/images/powerball/bar-red.svg) no-repeat;
    background-size: cover;
}
</style>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/winning.blade.php ENDPATH**/ ?>