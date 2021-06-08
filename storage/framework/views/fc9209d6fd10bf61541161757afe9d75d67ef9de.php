<?php
$start_amount = $user_amount = $start_round = $end_round = $current_round = $profit = $martin = $step = 0;
$mny = $pick_types =  array();
$dis = array();
$sim1 = $sim2 =  $sim3 = $class = $zu = $zu_class = array();
$pattern3="";
$zul3 = $money3 = 0;
$step3 = 10;
$current_step3 = 0;
$s = 0;
if(!empty($auto_info)){
    $start_amount = $auto_info["start_amount"];
    $user_amount = $auto_info["user_amount"];
    $profit = $user_amount - $start_amount;
    $start_round = $auto_info["start_round"];
    $end_round = $auto_info["end_round"];
    $martin = $auto_info["martin"];
    $step = $auto_info["step"];
    $mny = !empty($auto_info["mny"]) ? explode(",",$auto_info["mny"]) : array();
    $win_limit = $auto_info["win_limit"];
    $lost_limit = $auto_info["lost_limit"];
}
else{
    $start_amount = 0;
    $user_amount = 0;
    $profit = 0;
    $start_round = 0;
    $end_round = 0;
    $martin = 0;
    $step = 0;
    $mny = "";
    $win_limit = 0;
    $lost_limit = 0;
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
$alias_game_settings  =["poe","puo","noe","nuo"];
$winlose = array();
if(!empty($auto_info["winlose"])){
  foreach($auto_info["winlose"] as $v){
    $winlose[$v["game_type"].$v["win_type"]] = $v;
  }
}
$bet_amouont = $auto_info["bet_amount"] ?? 0;
if(!empty($auto_info)){
  if(empty($auto_info["current_round"])){
    $s = $auto_info["start_round"];
  }
  else{
    $s = $auto_info["current_round"];
  }
}

?>

<?php $__env->startSection("content"); ?>
    <script>
      var start_round = 0;
        var type = <?php echo e($type); ?>;
        var patts1 = {} ,patts2 = {};
        <?php if(!empty($auto_info) && $auto_info["state"] == 1): ?>
        var started = <?php echo e($auto_info["betting_type"]); ?>;
        var start_round =<?php echo e($auto_info["start_round"]); ?>;
        <?php else: ?>
        var started =  0;
        <?php endif; ?>
        var remain = <?php echo e($remain[0]); ?>;

        var round = 0;

        <?php if($autos ==1): ?>
        round =  <?php echo e($s); ?>;
        <?php endif; ?>
        <?php if($autos ==2): ?>
        round = <?php echo e($current); ?>;
        <?php endif; ?>
        <?php if(!empty($matches[1])): ?>
          <?php $__currentLoopData = $matches[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($value["state"] == 1): ?>
              patts1[<?php echo e($key); ?>] = {  pattern:"<?php echo e($value["auto_pattern"]); ?>",
                                    past_step:"<?php echo e($value["past_step"]); ?>",
                                    past_cruiser:"<?php echo e($value["past_step"]); ?>",
                                    past_pattern:"<?php echo e($value["past_pattern"]); ?>",
                                    step : "<?php echo e($value["auto_step"]); ?>",
                                    cruiser : "<?php echo e($value["auto_train"]); ?>",
                                    money : "<?php echo e($value["money"]); ?>",
                                    amount_step : "<?php echo e($value["amount_step"]); ?>"
                                  }
            <?php endif; ?>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if(!empty($matches[2])): ?>
          <?php $__currentLoopData = $matches[2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($value["state"] == 1): ?>
              patts2[<?php echo e($key); ?>] = {  pattern:"<?php echo e($value["auto_pattern"]); ?>",
                                    past_step:"<?php echo e($value["past_step"]); ?>",
                                    past_cruiser:"<?php echo e($value["past_step"]); ?>",
                                    past_pattern:"<?php echo e($value["past_pattern"]); ?>",
                                    step : "<?php echo e($value["auto_step"]); ?>",
                                    cruiser : "<?php echo e($value["auto_train"]); ?>",
                                    money : "<?php echo e($value["money"]); ?>"
                                  }
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <div class="modal-body pb-0">
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
    <!-- Modal -->
    <div class="modal fade" id="gameSettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">설정</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <ul class="nav nav-tabs" id="gameTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true">일반설정</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#poe" role="tab" aria-controls="poe" aria-selected="false">파홀v파짝</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#puo" role="tab" aria-controls="puo" aria-selected="false">파언v파오</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#noe" role="tab" aria-controls="noe" aria-selected="false">일홀v일짝</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#nuo" role="tab" aria-controls="nuo" aria-selected="false">일언v일오</a>
                    </li>
                  </ul>
                  <form id="gameForm">
                    <input type="hidden" name="api_token" id="api_token" value="<?php echo e(Auth::user()->api_token); ?>" />
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="home-tab">
                        <div class="p-2" style="padding-bottom:0px">
                          <p class="font-weight-bold ft-fitsize">손익상한 금액설정</p>
                          <p class="pb-1 m-0">이익이나 손해가 설정된 상한 금액을 도달 시 배팅을 중단</p>
                          <table class="table table-borderless">
                            <colgroup>
                              <col width="50%"/>
                              <col width="50%"/>
                            </colgroup>
                            <tbody>
                              <tr>
                                <td class="pl-0">
                                  <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">이익상한</span>
                                    </div>
                                    <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="win_limit" value="<?php echo e($win_limit); ?>">
                                  </div>
                              </td>
                                <td  class="pl-0">
                                  <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">손해상한</span>
                                    </div>
                                    <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="lost_limit" value="<?php echo e($lost_limit); ?>">
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php $__currentLoopData = $alias_game_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $index_game = $key + 1 ;
                        ?>
                        <div class="tab-pane fade" id="<?php echo e($v); ?>" role="tabpanel" aria-labelledby="profile-tab">
                          <div class="p-2 pb-0">
                            <p class="font-weight-bold ft-fitsize">연승/연패 휴식설정</p>
                            <div>
                              <p  class="pb-1  m-0">연속 승리시 휴식할 횟수를 지정</p>
                              <table class="table table-borderless mb-0">
                                <colgroup>
                                  <col width="50%"/>
                                  <col width="50%"/>
                                </colgroup>
                                <tbody>
                                  <?php if(!empty($winlose[$index_game."1"])): ?>
                                  <tr>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-3">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="wtimes[]" value="<?php echo e($winlose[($key+1)."1"]["times"]); ?>">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 연승</span>
                                        </div>
                                      </div>
                                  </td>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-3">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="wrtimes[]" value="<?php echo e($winlose[($key+1)."1"]["rest"]); ?>">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 휴식</span>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                <?php else: ?>
                                  <tr>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-3">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="wtimes[]">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 연승</span>
                                        </div>
                                      </div>
                                  </td>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-3">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="wrtimes[]">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 휴식</span>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                                </tbody>
                              </table>
                            </div>
                            <div>
                              <p  class="pb-1 m-0">연속 패배시 휴식할 횟수를 지정</p>
                              <table class="table table-borderless mb-0">
                                <colgroup>
                                  <col width="50%"/>
                                  <col width="50%"/>
                                </colgroup>
                                <tbody>
                                  <?php if(!empty($winlose[$index_game."2"])): ?>
                                  <tr>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-1">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="ltimes[]" value="<?php echo e($winlose[($key+1)."2"]["times"]); ?>">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 연패</span>
                                        </div>
                                      </div>
                                  </td>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-1">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="lrtimes[]" value="<?php echo e($winlose[($key+1)."2"]["rest"]); ?>">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 휴식</span>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                <?php else: ?>
                                  <tr>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-1">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="ltimes[]">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 연패</span>
                                        </div>
                                      </div>
                                  </td>
                                    <td class="pl-0">
                                      <div class="input-group input-group-sm mb-1">
                                        <input type="number" min="0" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="lrtimes[]">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">회 휴식</span>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-danger" onclick="saveGameSettings()">저장</button>
                </div>
            </div>
        </div>
    </div>
<div class="auto-info">
    <div class="auto-left">
        <div class="auto-header p-3">
          <span  class="text-center font-weight-bold text-danger category-auto" onclick="hideType(1,this)" id="category-auto1">물레방아</span>
          <span class="text-center text-white category-auto" onclick="hideType(2,this)" id="category-auto2">패턴배팅</span>
          <div class="position-absolute auto-info-right">
            <span class="nickname"><?php echo e($nickname); ?></span>님,로그인 중
            <span class="amount"><?php echo e(number_format($user_amount)); ?></span>
          </div>
        </div>
        <table class="table table-bordered mb-1">
          <colgroup>
            <col width="150px"/>
          </colgroup>
            <tbody>
                <tr>
                  <td class="align-middle p-0">
                      <table class="table-init">
                         <tr>
                           <td class="text-center text-danger font-weight-bold">
                             <?php echo e($current); ?>

                           </td>
                         </tr>
                          <tr class="text-left">
                              <td>배팅중</td>
                              <td class="timers"></td>
                          </tr>
                      </table>
                  </td>
                    <td class="align-middle p-0">
                       <table class="table-init">
                           <tr class="text-left">
                               <td>시작금액</td>
                               <td class="start-amount"><?php echo e(number_format($start_amount)); ?>원</td>
                               <td>손익금액</td>
                               <td class="profit-amount"><?php echo e(number_format($profit)); ?>원</td>
                           </tr>
                           <tr class="text-left">

                           </tr>
                           <tr class="text-left">
                               <td>보유금액</td>
                               <td class="saved-amount"><?php echo e(number_format($user_amount)); ?>원</td>

                               <td>배팅금액</td>
                               <td class="profit-amount"><?php echo e(number_format($bet_amouont)); ?>원</td>
                           </tr>
                       </table>
                    </td>
                    <td class="align-middle p-1">
                        <button class="btn-secondary btn-sm ft-btsize" id="past_start" style="cursor:pointer;width:40%" data-code="<?php echo e($autos); ?>"><?php if($autos ==1): ?><?php echo e('지난회차중지'); ?><?php else: ?><?php echo e('지난회차시작'); ?><?php endif; ?></button>
                        <button class="btn-secondary btn-sm ft-btsize" id="current_start" style="cursor:pointer;width:40%" data-code="<?php echo e($autos); ?>"><?php if($autos ==2): ?><?php echo e('현재회차중지'); ?><?php else: ?><?php echo e('현재회차시작'); ?><?php endif; ?></button>
                        <div class="mt-1">
                          <button class="btn-secondary  btn-sm  ft-btsize" data-toggle="modal" data-target="#gameSettings" style="cursor:pointer;width:40%">게임설정</button>
                          <button class="btn-secondary  btn-sm  ft-btsize" data-toggle="modal" data-target="#settingWindow" style="cursor:pointer;width:40%">이전회차설정</button>
                        </div>
                    </td>
                    <td class="p-1">
                      <button class="btn-danger btn btn-block  btn-sm  ft-btsize btnSave" onclick="save();">저장하기</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<form id="autoForm">
  <div class="auto-content" style="height:544px;overflow:hidden">
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
          <div class="part" >
              <table class="table table-gray mulebanga">
                  <tbody class="back-gray">
                  <tr>
                      <td  class="p-0">
                          <table class="table m-0">
                              <colgroup>
                                  <col width="25%">
                              </colgroup>
                                  <?php if(empty($matches[1][$index])): ?>
                                    <tr>
                                      <td class="border-top-none border-left-none align-middle border-bottom-none text-left pl-1 border-right-none position-relative">
                                            <span class="font-weight-bold text-secondary">배팅패턴</span>
                                            <div class="position-absolute" style="top:2px;right:0px">
                                              <button class="btn btn-secondary btn-sm btn-rest" type="button">휴식</button>
                                              <button class="btn btn-secondary btn-sm btn-rest" type="button">초기</button>
                                            </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="border-top-none border-left-none align-middle border-bottom-none scroll-td border-right-none ver-scroll">
                                        <div class="editor-text p1" contenteditable="true" spellcheck="false" data-class="p1[]" data-pattern = "onlyNum"></div>
                                        <textarea class="d-none" name="p1[]"></textarea>
                                        <input type="hidden" name="game_type1[]" value="<?php echo e($index); ?>" />
                                      </td>
                                    </tr>
                                    <tr>
                                        <td class="border-left-none align-middle">패턴옵션 :
                                          <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="round1_<?php echo e($index); ?>" id="inlineRadio1" value="1"
                                           <?php if((!empty($matches[1][$index]) && $matches[1][$index]["auto_cate"] == 1) || empty($matches[1][$index]["auto_cate"])): ?><?php echo e("checked"); ?><?php endif; ?>
                                            >
                                            <label class="form-check-label" for="inlineRadio1" >회차</label>
                                          </div>
                                          <div class="form-check-inline">
                                            <input class="form-check-input" type="radio"  name="round1_<?php echo e($index); ?>" id="inlineRadio2" value="2"
                                            <?php if(!empty($matches[1][$index]) && $matches[1][$index]["auto_cate"] == 2): ?><?php echo e("checked"); ?><?php endif; ?>
                                            >
                                            <label class="form-check-label" for="inlineRadio2">마틴</label>
                                          </div>
                                          <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="round1_<?php echo e($index); ?>" id="inlineRadio3" value="3"
                                            <?php if(!empty($matches[1][$index]) && $matches[1][$index]["auto_cate"] == 3): ?><?php echo e("checked"); ?><?php endif; ?>
                                            >
                                            <label class="form-check-label" for="inlineRadio3" >순환</label>
                                          </div>
                                        </td>
                                    </tr>
                                    <tr>
                                      <tr>
                                        <td class="border-bottom-none">
                                          <p class="p-1 mb-0">배팅금액</p>
                                        </td>
                                      </tr>
                                      <td class="p-0 border-none ver-scroll">
                                        <div class="editor-text amount1" contenteditable="true" spellcheck="false" style="width:100%;height:110px;resize: none;" data-class="amount1[]" data-pattern="amount"></div>
                                        <textarea class="d-none"  name="amount1[]"></textarea>
                                      </td>
                                      </tr>
                                  <?php endif; ?>
                                  <?php if(!empty($matches[1][$index])): ?>
                                    <tr>
                                      <td class="border-top-none border-left-none align-middle border-bottom-none text-left pl-1 border-right-none position-relative">
                                            <span class="font-weight-bold text-secondary">배팅패턴</span>
                                            <div class="position-absolute" style="top:2px;right:0px">
                                              <button class="btn btn-secondary btn-sm btn-rest" type="button" onclick="doRest(<?php echo e($matches[1][$index]["id"]); ?>,this)">
                                                <?php if($matches[1][$index]["state"] == 1): ?><?php echo e("휴식"); ?><?php else: ?><?php echo e("시작"); ?><?php endif; ?>
                                              </button>
                                              <button class="btn btn-secondary btn-sm btn-rest" type="button" onclick="doInit(<?php echo e($matches[1][$index]["id"]); ?>,this)">초기</button>
                                            </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="border-top-none border-left-none align-middle border-bottom-none scroll-td border-right-none ver-scroll">
                                         <div class="editor-text p1" data-class="p1[]" contenteditable="true" spellcheck="false" data-pattern = "onlyNum"><?php echo $matches[1][$index]["auto_pattern"]; ?></div>
                                         <textarea class="d-none"  name="p1[]"><?php echo $matches[1][$index]["auto_pattern"]; ?></textarea>
                                         <input type="hidden" name="game_type1[]" value="<?php echo e($index); ?>" />
                                      </td>
                                    </tr>
                                    <tr>
                                        <td class="border-left-none align-middle">패턴옵션 :
                                          <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="round1_<?php echo e($index); ?>" id="inlineRadio1" value="1"
                                           <?php if((!empty($matches[1][$index]) && $matches[1][$index]["auto_cate"] == 1) || empty($matches[1][$index]["auto_cate"]  )): ?><?php echo e("checked"); ?><?php endif; ?>
                                            >
                                            <label class="form-check-label" for="inlineRadio1" >회차</label>
                                          </div>
                                          <div class="form-check-inline">
                                            <input class="form-check-input" type="radio"  name="round1_<?php echo e($index); ?>" id="inlineRadio2" value="2"
                                            <?php if(!empty($matches[1][$index]) && $matches[1][$index]["auto_cate"] == 2): ?><?php echo e("checked"); ?><?php endif; ?>
                                            >
                                            <label class="form-check-label" for="inlineRadio2">마틴</label>
                                          </div>
                                          <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="round1_<?php echo e($index); ?>" id="inlineRadio3" value="3"
                                            <?php if(!empty($matches[1][$index]) && $matches[1][$index]["auto_cate"] == 3): ?><?php echo e("checked"); ?><?php endif; ?>
                                            >
                                            <label class="form-check-label" for="inlineRadio3" >순환</label>
                                          </div>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td class="border-bottom-none">
                                        <p class="p-1 mb-0">배팅금액</p>
                                      </td>
                                    </tr>
                                      <tr>
                                      <td class="p-0 border-none ver-scroll">
                                        <div class="editor-text amount1" contenteditable="true" spellcheck="false" style="width:100%;height:110px;resize: none;" data-class="amount1[]" data-pattern = "amount"><?php echo $matches[1][$index]["money"]; ?></div>
                                        <textarea class="d-none"  name="amount1[]"><?php echo $matches[1][$index]["money"]; ?></textarea>
                                      </td>
                                    </tr>
                                  <?php endif; ?>
                          </table>
                      </td>
                  </tr>
                  </tbody>
              </table>
              <table class="table table-bordered table-gray table-pad autopattern">
                <colgroup>
                <col width = "25%"/>
                <col width = "25%"/>
                <col width = "25%"/>
                <col width = "25%"/>
                </colgroup>
                  <tbody class="bg-white">

                  <input type="hidden" name="api_token" id="api_token" value="<?php echo e(Auth::user()->api_token); ?>" />
                  <input type="hidden" name="type" value="<?php echo e($index); ?>" />
                  <input type="hidden" name="var_type" value="2" />

                  <?php for($i =0 ; $i < 1 ; $i++): ?>

                    <?php if(!empty($matches[2][4*$index + $i-3])): ?>
                    <tr>
                      <td class="position-relative text-left pl-1 border-bottom-none" style="height:14px">
                        <span class="text-secondary font-weight-bold">배팅패턴</span>
                        <div class="position-absolute" style="top:2px;right:0px">
                          <button class="btn btn-secondary btn-sm border-round-none btn-rest" type="button" onclick="doRest(<?php echo e($matches[2][4*$index + $i-3]["id"]); ?>,this)">
                          <?php if($matches[2][4*$index + $i-3]["state"] == 1): ?><?php echo e("휴식"); ?><?php else: ?><?php echo e("시작"); ?><?php endif; ?>
                          </button>
                          <button class="btn btn-secondary btn-sm border-round-none btn-rest" type="button" onclick="doInit(<?php echo e($matches[2][4*$index + $i-3]["id"]); ?>,this)">초기</button>
                        </div>
                      </td>
                    </tr>
                    <tr class="pattern1">
                      <td class="border-top-none">
                        <div class="editor-text p2" id="p2_<?php echo e($index); ?>_<?php echo e($i); ?>" contenteditable="true" spellcheck="false" data-class="p2_<?php echo e($index); ?>_<?php echo e($i); ?>"><?php echo $matches[2][4*$index + $i-3]["auto_pattern"]; ?></div>
                        <textarea class="d-none" name="p2_<?php echo e($index); ?>_<?php echo e($i); ?>"><?php echo $matches[2][4*$index + $i-3]["auto_pattern"]; ?></textarea>
                      </td>
                    </tr>
                  <?php else: ?>
                    <tr>
                      <td class="position-relative text-left pl-1 border-bottom-none" style="height:14px">
                        <span class="text-secondary font-weight-bold">배팅패턴</span>
                        <div class="position-absolute" style="top:2px;right:0px">
                          <button class="btn btn-secondary btn-sm border-round-none btn-rest" type="button">휴식</button>
                          <button class="btn btn-secondary btn-sm border-round-none btn-rest" type="button">초기</button>
                        </div>
                      </td>
                    </tr>
                    <tr class="pattern1">
                      <td class="border-top-none">
                        <div class="editor-text p2" id="p2_<?php echo e($index); ?>_<?php echo e($i); ?>" contenteditable="true" spellcheck="false" data-class="p2_<?php echo e($index); ?>_<?php echo e($i); ?>"></div>
                        <textarea class="d-none" name="p2_<?php echo e($index); ?>_<?php echo e($i); ?>"></textarea>
                      </td>
                    </tr>
                  <?php endif; ?>
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
        <?php if(!empty($history)): ?>
          <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $parse  = get_object_vars(json_decode($h["reason"]));
            if(empty($parse["win_type"]))
              $win_class = "";
            else {
              $win_class =  $parse["win_type"] ?? "";
            }
            ?>
          <li class="<?php echo e($parse["type"]); ?> win<?php echo e($win_class); ?>">
              <?php if($parse["type"] == "current_result"): ?>
                <?php
                  $pb_oe ="pb_oe".$parse["pb_oe"];
                  $pb_uo ="pb_uo".$parse["pb_uo"];
                  $nb_oe ="nb_oe".$parse["nb_oe"];
                  $nb_uo ="nb_uo".$parse["nb_uo"];
                ?>
                #<?php echo e($parse['date']); ?> > <?php echo e($parse["rownum"]); ?>차 결과 : <?php echo e(getPowerHeader()[$pb_oe]); ?> / <?php echo e(getPowerHeader()[$pb_uo]); ?> / <?php echo e(getPowerHeader()[$nb_oe]); ?> / <?php echo e(getPowerHeader()[$nb_uo]); ?>

              <?php endif; ?>
              <?php if($parse["type"] == "betting"): ?>
              #<?php echo e($h['created_at']); ?> > <?php echo e(getPowerballBetSim($parse["auto_type"],$parse["auto_kind"],$parse["pick"],$parse["win_type"])); ?> <?php echo e($parse["amount"]); ?>

              <?php endif; ?>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/pick/simulate.blade.php ENDPATH**/ ?>