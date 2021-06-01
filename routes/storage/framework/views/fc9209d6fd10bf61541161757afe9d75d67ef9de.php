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

        var round = 0;

        <?php if($autos ==1): ?>
        round =  <?php echo e($start_round); ?>;
        <?php endif; ?>
        <?php if($autos ==2): ?>
        round = <?php echo e($current); ?>;
        <?php endif; ?>
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
                <th class="text-center">게임설정</th>
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
                           <tr class="text-left">
                               <td>배팅금액</td>
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
                    <td class="align-middle">
                        <div class="mb-2">
                          <button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" id="past_start" style="cursor:pointer;" data-code="<?php echo e($autos); ?>"><?php if($autos ==1): ?><?php echo e('지난회차중지'); ?><?php else: ?><?php echo e('지난회차시작'); ?><?php endif; ?></button>
                        </div>
                        <button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" id="current_start" style="cursor:pointer;" data-code="<?php echo e($autos); ?>"><?php if($autos ==2): ?><?php echo e('현재회차중지'); ?><?php else: ?><?php echo e('현재회차시작'); ?><?php endif; ?></button>

                    </td>
                    <td class="align-middle">
                          <div class="mb-2">
                              <button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" style="cursor:pointer;">게임설정</button>
                          </div>
                              <button class="btn-green btn-block btn-sm pl-0 pr-0 ft-btsize" data-toggle="modal" data-target="#settingWindow" style="cursor:pointer;">이전회차설정</button>
                              <div class="mb-2">
                          </div>
                          <button class="btn-danger btn btn-block btn-sm pl-0 pr-0 ft-btsize" onclick="save();">저장하기</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<form id="autoForm">
  <div class="auto-content">
      <div class="content-left">
          <table class="table table-bordered mb-0">
              <colgroup>
                  <col width="25%">
                  <col width="25%">
                  <col width="25%">
                  <col width="25%">
              </colgroup>
              <thead class="border-jinblue">
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
                    <td colspan="4" class="border-none p-1">
                        <?php echo $__env->make("Analyse/patt-analyse", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </td>
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
                                  <col width="550px">
                              </colgroup>
                              <tr>
                                <td class="border-top-none border-left-none align-middle border-bottom-none text-right pr-2">
                                      <button class="btn tn-secondary-outline btn-sm">휴식</button>
                                      <button class="btn btn-secondary-outline btn-sm">초기</button>
                                      <button class="btn btn-secondary-outline btn-sm">시작</button>
                                </td>
                                <td class="border-top-none border-left-none align-middle" style="padding-left:10px">패턴옵션 :
                                  <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="round1_<?php echo e($index); ?>" id="inlineRadio1" value="1" checked>
                                    <label class="form-check-label" for="inlineRadio1" >회차</label>
                                  </div>
                                  <div class="form-check-inline">
                                    <input class="form-check-input" type="radio"  name="round1_<?php echo e($index); ?>" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">마틴</label>
                                  </div>
                                  <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="round1_<?php echo e($index); ?>" id="inlineRadio3" value="3">
                                    <label class="form-check-label" for="inlineRadio3" >순환</label>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                  <?php if(empty($matches[1][$index][0])): ?>
                                      <td class="border-top-none border-left-none align-middle border-bottom-none scroll-td">
                                        <div class="editor-text" contenteditable="true" spellcheck="false" data-class="p1[]" data-pattern = "onlyNum">

                                        </div>
                                        <textarea class="d-none" value="" name="p1[]"></textarea>
                                      </td>
                                      <td class="p-0 border-top-none border-right-none border-bottom-none">
                                        <p class="p-1 mb-0">배팅금액</p>
                                        <div class="editor-text" contenteditable="true" spellcheck="false" style="width:100%;height:110px;resize: none;" data-class="amount1[]" data-pattern="amount"></div>
                                        <textarea class="d-none"  name="amount1[]"></textarea>
                                      </td>
                                  <?php endif; ?>
                                  <?php if(!empty($matches[1][$index][0])): ?>
                                      <?php
                                      $patt = explode(",",$matches[$index][1][0]["auto_pattern"]);
                                      ?>
                                      <td class="border-top-none border-left-none align-middle border-bottom-none scroll-td">
                                         <div class="editor-text" data-class="p1[]" contenteditable="true" spellcheck="false" data-pattern = "onlyNum">
                                        <?php echo str_replace("\n","<br/>",$matches[1][1][0]["auto_pattern"]); ?>

                                         </div>
                                      </td>
                                      <td class="p-0 border-top-none border-right-none border-bottom-none">
                                        <p class="p-1 mb-0">배팅금액</p>
                                        <div class="editor-text" contenteditable="true" spellcheck="false" style="width:100%;height:110px;resize: none;" data-class="amount1[]" data-pattern = "amount"></div>
                                        <textarea class="d-none"  name="amount1[]"></textarea>
                                      </td>
                                  <?php endif; ?>
                              </tr>
                          </table>
                      </td>
                  </tr>
                  </tbody>
              </table>
              <table class="table table-bordered table-gray table-pad autopattern" style="display:none">
                <colgroup>
                <col width = "25%"/>
                <col width = "25%"/>
                <col width = "25%"/>
                <col width = "25%"/>
                </colgroup>
                  <thead class="text-center gray_gradient">
                      <tr>
                          <th colspan="10" class="text-center">
                              <span class="text-black font-weight-bold">패턴배팅</span>
                          </th>
                      </tr>
                  </thead>
                  <tbody>

                  <input type="hidden" name="api_token" id="api_token" value="<?php echo e(Auth::user()->api_token); ?>" />
                  <input type="hidden" name="type" value="<?php echo e($index); ?>" />
                  <input type="hidden" name="var_type" value="2" />

                  <?php for($i =0 ; $i < 4 ; $i++): ?>
                    <tr>
                      <td class="position-relative text-center" style="height:14px">
                        <span class="text-secondary font-weight-bold">배팅패턴</span>
                        <div class="position-absolute" style="top:4px;right:3px">
                          <button class="btn btn-secondary btn-sm border-round-none">휴식</button>
                          <button class="btn btn-secondary btn-sm border-round-none">초기</button>
                          <button class="btn btn-secondary btn-sm border-round-none">시작</button>
                        </div>
                      </td>
                    </tr>
                    <tr class="pattern1">
                      <td>
                        <div class="editor-text" contenteditable="true" spellcheck="false" data-class="p2_<?php echo e($index); ?>_<?php echo e($i); ?>[]"></div>
                        <textarea class="d-none" name="p2_<?php echo e($index); ?>_<?php echo e($i); ?>"></textarea>
                      </td>
                    </tr>
                    
                  <?php endfor; ?>
                  </tbody>
              </table>
          </div>
          <?php endfor; ?>
      </div>
      
  </div>
</form>

<div class="log-part">
    <ul>
        <li>log</li>
    </ul>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/simulate.blade.php ENDPATH**/ ?>