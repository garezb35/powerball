<?php
$start_amount = $user_amount = $start_round = $end_round = $current_round = $profit = $martin = $step = 0;
$mny = $pick_types =  array();
$dis = array();
$sim1 = $sim2 =  $sim3 = $class = $zu = $zu_class = array();
$pattern3="";
$zul3 = $money3 = 0;
$step3 = 10;
$current_step3 = 0;
if(!empty($auto_info)){
    $start_amount = $auto_info["start_amount"];
    $user_amount = $auto_info["user_amount"];
    $profit = $user_amount - $start_amount;
    $start_round = $auto_info["start_round"];
    $end_round = $auto_info["end_round"];
    $martin = $auto_info["martin"];
    $step = $auto_info["step"];
    $mny = !empty($auto_info["mny"]) ? explode(",",$auto_info["mny"]) : array();
}
$class[3] = "pow-element-blue pow-element";
$class[2] = "pow-element-red pow-element";
$class[1] = "pow-element";
$zu_class[0] = "btn-primary";
$zu_class[1] = "btn-danger";
$zu[0] = "줄";
$zu[1] = "꺽";

$dis2[2] = "오";
$dis2[3] = "언";
$dis2[1] = "대";

$dis1[2] = "짝";
$dis1[3] = "홀";
$dis1[1] = "대";

$pick_types[1] = "파홀";
$pick_types[2] = "파짝";
$pick_types[3] = "파언";
$pick_types[4] = "파옵";
$pick_types[5] = "일홀";
$pick_types[6] = "일짝";
$pick_types[7] = "일언";
$pick_types[8] = "일옵";

?>

<?php $__env->startSection("content"); ?>
    <script>
        var type = <?php echo e($type); ?>;

        <?php if(!empty($auto_info) && $auto_info["state"] == 1): ?>
        var started = <?php echo e($auto_info["betting_type"]); ?>;
        <?php else: ?>
        var started =  0;
        <?php endif; ?>
        var remain = <?php echo e($remain[0]); ?>;
    </script>

    <!-- Modal -->
    <div class="modal fade" id="settingWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">파워볼모의베팅</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="100px">
                        </colgroup>
                        <tbody>
                        <tr class="text-left">
                            <td class="align-middle">시작금액(원)</td>
                            <td class="start-amount"><input type="number" placeholder="1000" id="test-start-amount" class="form-control" style="width: 100px"></td>
                        </tr>
                        <tr class="text-left">
                            <td class="align-middle">시작회차</td>
                            <td><input type="text" placeholder="106000" id="test-start-round" class="form-control" style="width: 100px" value="<?php echo e($start_round); ?>"></td>
                        </tr>
                        <tr class="text-left">
                            <td class="align-middle">마감회차</td>
                            <td><input type="text" placeholder="106000" id="test-end-round" class="form-control" style="width: 100px" value="<?php echo e($end_round); ?>"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-danger" onclick="saveAutoSetting()">저장</button>
                </div>
            </div>
        </div>
    </div>
<div class="auto-info">
    <div class="auto-left">
        <table class="table table-bordered">
            <thead class="border-jinblue jin-gradient">
                <th class="text-center">잔액정보</th>
                <th class="text-center">사회자정보</th>
                <th class="text-center">배팅시작/중지</th>
            </thead>
            <tbody>
                <tr>
                    <td class="align-middle">
                       <table class="table-init">
                           <tr class="text-left">
                               <td>시작금액</td>
                               <td class="start-amount"><?php echo e(number_format($start_amount)); ?>원</td>
                           </tr>
                           <tr class="text-left">
                               <td>보유금액</td>
                               <td class="saved-amount"><?php echo e(number_format($user_amount)); ?>원</td>
                           </tr>
                           <tr class="text-left">
                               <td>손익금액</td>
                               <td class="profit-amount"><?php echo e(number_format($profit)); ?>원</td>
                           </tr>
                       </table>
                    </td>
                    <td class="align-middle">
                        <table class="table-init">
                            <tr class="text-left">
                                <td>시작회차</td>
                                <td><span class="start-round"><?php echo e(substr($start_round,strlen($start_round)-3)); ?></span>-<span class="end-round"><?php echo e(substr($end_round,strlen($end_round)-3)); ?></span></td>
                            </tr>
                            <tr class="text-left">
                                <td>현배팅회차</td>
                                <td><?php echo e($current); ?></td>
                            </tr>
                            <tr class="text-left">
                                <td>배팅중</td>
                                <td class="timers"></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="table-init">
                            <tr>
                                <td>
                                    <button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" id="past_start" style="cursor:pointer;" data-code="<?php echo e($autos); ?>"><?php if($autos ==1): ?><?php echo e('지난회차중지'); ?><?php else: ?><?php echo e('지난회차시작'); ?><?php endif; ?></button>
                                </td>
                                <td>
                                    <button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" id="current_start" style="cursor:pointer;" data-code="<?php echo e($autos); ?>"><?php if($autos ==2): ?><?php echo e('현재회차중지'); ?><?php else: ?><?php echo e('현재회차시작'); ?><?php endif; ?></button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" data-toggle="modal" data-target="#settingWindow" style="cursor:pointer;">이전회차설정</button></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="auto-right">
        <table class="table table-bordered">
            <thead class="border-jinblue thead-jinblue">
                <th class="text-center green-back">최고단계정보</th>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 76px;">123</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="auto-content">
    <div class="content-left">
        <table class="table table-bordered mb-0">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <thead class="border-jinblue jin-gradient">
                <tr class="powerball-kind-all">
                    <th colspan="2" class="text-center font-weight-bold text-danger " onclick="hideType(1,this)">물레방아</th>
                    <th colspan="2" class="text-center " onclick="hideType(2,this)">패턴배팅</th>
                </tr>
                <tr class="powerball-kind">
                    <th class="text-center font-weight-bold text-danger patt-cate" onclick="openCity(this,1)">파워볼홀짝</th>
                    <th class="text-center patt-cate" onclick="openCity(this,2)">파워볼언옵</th>
                    <th class="text-center patt-cate" onclick="openCity(this,3)">일반홀짝</th>
                    <th class="text-center patt-cate" onclick="openCity(this,4)">일반언옵</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="text-center td-green-btn" onclick="savePatt()">저장하기</td>
                    <td colspan="2" class="text-center td-green-btn" onclick="savePattAll()">모두 적용</td>
                </tr>
            </tbody>
        </table>
        <?php for($index = 1; $index < 5 ; $index++): ?>
            <?php
            if($index == 1 || $index ==3)
                $dis = $dis1;
            else
                $dis=  $dis2;
            ?>
        <div id="part<?php echo e($index); ?>" class="<?php if($index !=1): ?><?php echo e('d-none'); ?><?php endif; ?> part">
            <table class="table table-bordered table-gray mulebanga">
                <tbody class="back-gray">
                <tr>
                    <td colspan="4" class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">물레방아</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="p-0">
                        <table class="table m-0">
                            <colgroup>
                                <col width="400px">
                            </colgroup>
                            <tr>
                                <?php if(empty($matches[$index][1][0])): ?>
                                    <td class="border-top-none border-left-none align-middle border-bottom-none">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <?php for($i = 0 ;$i < 10; $i++): ?>
                                                    <span class="pow-element" data-code="-1">대</span>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php for($i = 0 ;$i < 10; $i++): ?>
                                                    <span class="pow-element" data-code="-1">대</span>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-0 border-top-none border-right-none border-bottom-none">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <td class="text-center border-left-none border-top-none">최종단계</td>
                                                <td class="text-center border-top-none">단계</td>
                                                <td class="text-center border-top-none border-right-none">금액</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center border-bottom-none border-left-none">
                                                    <input type="number" value="<?php echo e(10); ?>" class="pattern-step form-control-custom pattern-step1" min="1" max="30"> 단
                                                </td>
                                                <td class="text-center border-bottom-none align-middle"></td>
                                                <td class="text-center border-bottom-none border-right-none align-middle"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                <?php endif; ?>
                                <?php if(!empty($matches[$index][1][0])): ?>
                                    <?php
                                    $patt = explode(",",$matches[$index][1][0]["auto_pattern"]);
                                    ?>
                                    <td class="border-top-none border-left-none align-middle border-bottom-none">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <?php for($i = 0 ;$i < 10; $i++): ?>
                                                    <?php if($i < sizeof($patt)): ?>
                                                        <?php
                                                            $patt[$i] = intval($patt[$i]);
                                                        ?>
                                                        <span class="<?php echo e($class[$patt[$i]+2]); ?>" data-code="<?php echo e($patt[$i]); ?>"><?php echo e($dis[$patt[$i]+2]); ?></span>
                                                    <?php else: ?>
                                                        <span class="pow-element" data-code="-1">대</span>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?php for($i = 0 ;$i < 10; $i++): ?>
                                                    <?php if($i < sizeof($patt)-10): ?>
                                                        <?php
                                                            $patt[$i+10] = intval($patt[$i+10]);
                                                        ?>
                                                    <span class="<?php echo e($class[$patt[$i+10]+2]); ?>" data-code="<?php echo e($patt[$i+10]); ?>"><?php echo e($dis[$patt[$i+10]+2]); ?></span>
                                                    <?php else: ?>
                                                        <span class="pow-element" data-code="-1">대</span>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-0 border-top-none border-right-none border-bottom-none">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <td class="text-center border-left-none border-top-none">최종단계</td>
                                                <td class="text-center border-top-none">단계</td>
                                                <td class="text-center border-top-none border-right-none">금액</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center border-bottom-none border-left-none">
                                                    <input type="number" value="<?php echo e($matches[$index][1][0]["auto_last_step"]); ?>" class="pattern-step form-control-custom pattern-step1" min="1" max="30"> 단
                                                </td>
                                                <td class="text-center border-bottom-none align-middle"><?php echo e($matches[$index][1][0]["auto_step"]+1); ?>단</td>
                                                <td class="text-center border-bottom-none border-right-none align-middle"><?php echo e($mny[$matches[$index][1][0]["auto_step"]]); ?>원</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <form id="pattern-form<?php echo e($index); ?>" class="autopattern" style="display: none">
                <table class="table table-bordered table-gray table-pad">
                    <thead class="border-jinblue jin-gradient">
                    <tr>
                        <th colspan="10" class="text-center">
                            <span class="text-white">패턴배팅 1</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="green-back">
                        <td class="text-center align-middle">패턴</td>
                        <td class="text-center align-middle">최종단계</td>
                        <td class="text-center align-middle">현재<br>단계</td>
                        <td class="text-center align-middle">배팅금액</td>
                        <td class="text-center align-middle">줄/꺽</td>
                        <td class="text-center align-middle">패턴</td>
                        <td class="text-center align-middle">최종단계</td>
                        <td class="text-center align-middle">현재<br>단계</td>
                        <td class="text-center align-middle">배팅금액</td>
                        <td class="text-center align-middle">줄/꺽</td>
                    </tr>
                    <input type="hidden" name="api_token" id="api_token" value="<?php echo e(Auth::user()->api_token); ?>" />
                    <input type="hidden" name="type" value="<?php echo e($index); ?>" />
                    <input type="hidden" name="var_type" value="2" />

                    <?php for($i =0 ; $i < 3 ; $i++): ?>
                        <tr>
                            <?php for($ii = 1; $ii <=2;$ii++): ?>
                                <?php if(empty($matches[$index][2][2*$i+$ii])): ?>
                                    <td class="align-middle text-center">
                                        <input type="text" placeholder="XXXXX" class="pattern-input1 form-control-custom" name="pattern[]" id="pattern<?php echo e(2*$i+$ii); ?>"
                                               value="">
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="number" value="<?php echo e('10'); ?>" class="pattern-step form-control-custom" min="1" max="30" name="step[]" id="step<?php echo e(2*$i+$ii); ?>"> 단
                                        <input type="hidden" id="oppo<?php echo e(2*$i); ?>" value="<?php echo e('0'); ?>" name="oppo[]">
                                    </td>
                                    <td class="align-middle text-center"></td>
                                    <td class="align-middle text-center"></td>
                                    <td class="align-middle text-center p-0">
                                        <a class="zulbtn" onclick="changeRow(this,<?php echo e(2*$i+$ii); ?>)"><?php echo e('줄'); ?></a>
                                    </td>
                                <?php endif; ?>
                                <?php if(!empty($matches[$index][2][2*$i+$ii])): ?>
                                    <td class="align-middle text-center">
                                        <input type="text" placeholder="XXXXX" class="pattern-input1 form-control-custom" name="pattern[]" id="pattern<?php echo e(2*$i+$ii); ?>"
                                               value="<?php echo e($matches[$index][2][2*$i+$ii]["auto_pattern"]); ?>">
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="number" value="<?php echo e($matches[$index][2][2*$i+$ii]["auto_last_step"]); ?>" class="pattern-step form-control-custom" min="1" max="30" name="step[]" id="step<?php echo e(2*$i+$ii); ?>">단
                                        <input type="hidden" id="oppo<?php echo e(2*$i+$ii); ?>" value="<?php echo e($matches[$index][2][2*$i+$ii]["auto_oppo"]); ?>" name="oppo[]">
                                    </td>
                                    <td class="align-middle text-center"><?php echo e($matches[$index][2][2*$i+$ii]["auto_step"]+1); ?>단</td>
                                    <td class="align-middle text-center"><?php echo e($mny[$matches[$index][2][2*$i+$ii]["auto_step"]]); ?>원</td>
                                    <td class="align-middle text-center p-0">
                                        <a class="zulbtn" onclick="changeRow(this,<?php echo e(2*$i+$ii); ?>)"><?php echo e($zu[$matches[$index][2][2*$i+$ii]["auto_oppo"]]); ?></a>
                                    </td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </form>
        </div>
        <?php endfor; ?>
    </div>
    <div class="content-right">
        <table class="table table-history table-bordered">
            <colgroup>
                <col width="50px">
            </colgroup>
            <thead class="thead-gray">
                <tr>
                    <th colspan="2" class="text-center pl-0 pr-0" style="width: 109px">배팅내역</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <?php if(!empty($history)): ?>
            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vhisotry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="pr-0 pl-0 left-td"><?php echo e(substr($vhisotry["day_round"],4)); ?>회<br>
                        <span class="font-weight-bold text-danger"><?php echo e($pick_types[$vhisotry["pick"]]); ?></span>
                    </td>
                    <td class="pr-0 pl-0 right-td"><?php echo e(number_format($vhisotry["bet_amount"])); ?><br>
                        <?php if($vhisotry["is_win"]==1): ?>
                        <span class="font-weight-bold text-danger">승</span>
                        <?php else: ?>
                            <span class="font-weight-bold text-primary">패</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            </tbody>
        </table>
        <table class="table table-martin table-bordered">
            <thead class="thead-gray">
                <tr>
                    <th class="text-center">배팅금액-마틴</th>
                </tr>
            </thead>
            <tbody class="text-center m-0">
                <tr>
                    <td class="align-middle">
                        <div style="margin-left: 33px;">
                            <a href="javascript:void(0)" id="btn-money-keep">저장</a>
                        </div>
                        <div style="margin: 8px 0 6px;">
                            <div style="text-align:center"><span id="martin-apply">마틴*:</span> <input class="field-input" type="text" id="martin-multi" value="<?php echo e($martin); ?>" style="font-size: 14px; width: 70px;"></div>
                        </div>
                    </td>
                </tr>
            <tr class="martin-tr">
                <td>
                    <div style="margin: 8px 0 6px;">
                        <div style="text-align:center"><span id="martin-apply">알림단계:</span> <input class="field-input" type="text" id="noti-input" value="<?php echo e($step); ?>" style="font-size: 14px; width: 70px;"></div>
                    </div>
                    <div class="martin-money-part">
                        <?php for($i =0 ;$i < 30 ;$i ++): ?>
                            <div class="martin-content d-flex mb-2">
                                <span><?php echo e($i+1); ?></span><input class="first-martin" type="text" name="martin[]" value="<?php if(!empty($mny[$i])): ?><?php echo e(number_format($mny[$i])); ?><?php else: ?><?php echo e('0'); ?><?php endif; ?>">
                            </div>
                        <?php endfor; ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/simulate.blade.php ENDPATH**/ ?>