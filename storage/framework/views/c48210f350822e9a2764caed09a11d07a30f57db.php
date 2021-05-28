<?php
$po = $pu = array();
$po[0]="<div class=\"sp-odd\">홀</div>";
$po[1]="<div class=\"sp-even\">짝</div>";
$pu[0]="<div class='sp-under'></div>";
$pu[1]="<div class='sp-over''></div>";
?>

<?php $__env->startSection("content"); ?>
<ul class="nav nav-pills mb-2" id="powerball-category" role="tablist">
    <li class="nav-item mr-2">
        <a class="nav-link btn-green-gradient btn border-round-none pr-4 pl-4 active" id="powerball-tab" data-toggle="pill" href="#powerball-content" role="tab" aria-controls="powerball-content" aria-selected="true">파워볼</a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn-green-gradient btn border-round-none pr-4 pl-4" id="nb-tab" data-toggle="pill" href="#nb-content" role="tab" aria-controls="nb-content" aria-selected="false">일반볼</a>
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
                <?php for($i = 0 ;$i <50;$i++): ?>
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
                    <?php for($i = 0 ;$i <50;$i++): ?>
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

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/winning.blade.php ENDPATH**/ ?>