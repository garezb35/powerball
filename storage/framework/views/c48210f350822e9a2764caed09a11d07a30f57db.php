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
  <script>
    var winning = <?php echo e($winning); ?>;
  </script>
  <ul class="nav mb-2" id="powerball-category" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="powerball-tab" data-toggle="pill" href="#powerball-content" role="tab" >파워볼</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="nb-tab" data-toggle="pill" href="#nb-content" role="tab" aria-controls="nb-content" aria-selected="false">일반볼</a>
      </li>
  </ul>
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

<div class="mb-1">
  <div class="time-part">
    <?php echo $__env->make('chat.countdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </div>
  <div class="bet-part d-none" style="text-align:center"><span>다음 회차 다음회차 픽 갱신중~<span id="bettingPart" class="font-weight-bold"></span></span></div>
</div>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active tbl_head01 tbl_wrap" id="powerball-content" role="tabpanel" aria-labelledby="pills-home-tab">
        <table class="table table-bordered" style="width: calc(100% - 0.1em);">
          <thead>
            <tr>
                <th class="text-center align-middle" rowspan="2">
                    <span class="font-weight-bold" style="display:block;width:80px">번호</span>
                </th>
                <th colspan="3" class="text-center" width="50%">파워볼</th>
                <th colspan="3" class="text-center" width="50%">파워볼언옵</th>
            </tr>
            <tr class ="bl_gray">
                <td class="text-center ">
                    <span class="font-weight-bold">AI번호</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">현재연승</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">다음회차픽</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">AI번호</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">현재연승</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">다음회차픽</span>
                </td>
            </tr>
          </thead>
            <tbody>
            <?php if(!empty($pb_oe)): ?>
                <?php for($i = 0 ;$i <sizeof($pb_oe);$i++): ?>
                    <tr>
                        <td class="text-center" style="width:150px"><?php echo e($i+1); ?></td>
                        <td class="text-center"><?php echo e($pb_oe[$i]["ai_id"]); ?></td>
                        <td class="text-center"><?php echo e($pb_oe[$i]["winning_num"]); ?>연승중</td>
                        <td class="text-center"><?php echo $po[$pb_oe[$i]["pick"]]; ?></td>
                        <td class="text-center"><?php echo e($pb_uo[$i]["ai_id"]); ?></td>
                        <td class="text-center"><?php echo e($pb_uo[$i]["winning_num"]); ?>연승중</td>
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
    <div class="tab-pane fade tbl_head01 tbl_wrap" id="nb-content" role="tabpanel" aria-labelledby="pills-profile-tab">
        <table class="table table-bordered">
          <thead>
            <tr>
                <th class="text-center align-middle" rowspan="2">
                    <span class="font-weight-bold" style="display:block;width:80px">번호</span>
                </th>
                <th colspan="3" class="text-center" width="50%">일반볼</th>
                <th colspan="3" class="text-center" width="50%">일반볼언옵</th>
            </tr>
            <tr class="bl_gray">
                <td class="text-center ">
                    <span class="font-weight-bold">AI번호</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">현재연승</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">다음회차픽</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">AI번호</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">현재연승</span>
                </td>
                <td class="text-center ">
                    <span class="font-weight-bold">다음회차픽</span>
                </td>
            </tr>
          </thead>
            <tbody>
                <?php if(!empty($nb_oe)): ?>
                    <?php for($i = 0 ;$i <sizeof($nb_oe);$i++): ?>
                        <tr>
                            <td class="text-center"><?php echo e($i+1); ?></td>
                            <td class="text-center"><?php echo e($nb_oe[$i]["ai_id"]); ?></td>
                            <td class="text-center"><?php echo e($nb_oe[$i]["winning_num"]); ?>연승중</td>
                            <td class="text-center"><?php echo $po[$nb_oe[$i]["pick"]]; ?></td>
                            <td class="text-center"><?php echo e($nb_uo[$i]["ai_id"]); ?></td>
                            <td class="text-center"><?php echo e($nb_uo[$i]["winning_num"]); ?>연승중</td>
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
    padding:10px;
    font-size: 17px
}
#powerball-category{
  width: 100%
}
#powerball-category .nav-item{
    list-style: none;
    float: left;
    width: 50%;
    text-align: center;
}
#powerball-category .nav-link.active{
  background-color: #00b4b4;
  color: #fff;
}

#powerball-category .nav-item:last-child a {
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
    margin-bottom: 20px;
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
  padding: 0 42px;
  width: calc(100% - 94px);
}

.bar_graph dl {
    border-top: 1px solid #d6d6d6;
}

.bar_graph dt {
  padding: 11px 10px 17px;
  font-weight: 600;
  font-size: 17px;
}
.bar_graph .right.on {
    color: #fff;
    max-width: 250px;
    background: url(/assets/images/powerball/bar-red.svg) no-repeat;
    background-size: cover;
}
.tbl_head01 thead th {
    background: #f0f5f5;
    border-bottom: none;
    border-top: 2px solid #00b4b4 !important;
}

.bl_gray td{
  background:#f0f5f5
}

td{
    vertical-align: middle !important;
    height: 38px;
    padding: 0px !important;
}
</style>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/winning.blade.php ENDPATH**/ ?>