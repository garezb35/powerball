<div class="box-login">
    <?php if(auth()->guard()->check()): ?>
        <?php
            if($next_level ==0){
                $nextClass = (Auth::user()->exp-$normal_level) <= 0 ? 1 : Auth::user()->exp-$normal_level;
            }
            else
                $nextClass = ($next_level - $normal_level) <=0 ? 1 : $next_level - $normal_level;
        ?>
    <div style="height:204px;">
        <table class="mt-0" style="width: 100%">
            <colgroup>
                <col width="176px">
            </colgroup>
            <tr>
                <td class="text-left align-top p-1">
                    <div class="mb-2 ml-2"><img src="<?php echo e($user_level[0]["value3"]); ?>">
                        <span class="font-weight-bold  ll-he23 ja-color ft-thsize"><span class="grades"><?php echo e(Auth::user()->nickname); ?></span> (계급 : <a href="<?php echo e(route("member")); ?>?type=level" target="mainFrame" class="text-gam font-weight-bold"><?php echo $user_level[0]["codename"]; ?></a>)</span>
                        <div style="margin-left: 33px;">
                            <span class="text-gam font-weight-bold" style="font-size: 13px">경험치</span>
                            <div class="mb-2 position-relative mt-1 exp-back">
                                <div style="width:<?php echo e(((Auth::user()->exp-$normal_level) / $nextClass)*100); ?>%;" class="numberFont">
                                    <div style="position:absolute;left: 35px;" class="text-white font-weight-bold"><span><?php echo e(Auth::user()->exp-$normal_level); ?></span> / <?php echo e($nextClass); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="p-2">
                   <div style="border: 1px solid #d5d9db;border-radius: 5px">
                       <table class="table mb-0  user-info">
                           <colgroup>
                               <col width="60px">
                               <col width="*">
                           </colgroup>
                           <tr>
                               <td class="pt-1 pb-1 pl-1 pr-1 align-middle"><span class="list-item"><img src="/assets/images/powerball/coin.png" height="15"/><span class="list-item coin-label"> 코인 </span></td>
                               <td class="pt-1 pb-1 pl-0   align-middle text-right" style="padding-right: 4px"><span class="text-blo font-weight-bold"><?php echo e(number_format(Auth::user()->coin)); ?></span></td>
                           </tr>
                           <tr >
                               <td class="pt-0 pb-1 pl-1 pr-1 align-middle"><img src="/assets/images/powerball/dangun.png" height="15"/><span class="list-item dangun-label"> 당근 </span></td>
                               <td class="pt-0 pb-1 pl-0  align-middle text-right" style="padding-right: 4px"><span class="text-blo font-weight-bold" id="bullet_cnt"><?php echo e(number_format(Auth::user()->bullet)); ?></span>개</td>
                           </tr>
                           <tr>
                               <td class="pt-0 pb-1 pl-1 pr-1 align-middle"><span class="list-item dotori-label"><img src="/assets/images/powerball/dotori.png" height="15"/> 도토리 </span></td>
                               <td class="pt-0 pb-1 pl-0  align-middle text-right" style="padding-right: 4px"><span class="text-blo font-weight-bold"><?php echo e(number_format(Auth::user()->bread)); ?></span>개</td>
                           </tr>
                       </table>
                   </div>
                </td>
            </tr>
        </table>
        <table class="table box-menus mar-t-5 mb-0">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <tr>
                <td class="text-center align-middle active pt-2 pb-1 border-right-ja">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-home"></i>
                        </div>
                        <a href="<?php echo e(route("member")); ?>" target="mainFrame">마이홈</a>
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1 border-right-ja">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <a href="#" onclick="windowOpen('/memo','memo',600,600,'auto');return false;" >쪽지</a>
                        <div class="itemCntBox" id="mail-count" style="display:<?php if($mail_count == 0): ?><?php echo e("none"); ?><?php else: ?><?php echo e("block"); ?><?php endif; ?>"><?php echo e($mail_count); ?></div>
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1 border-right-ja">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                        </div>
                        <a href="<?php echo e(route("member")); ?>?type=item" target="mainFrame">아이템</a>
                        <?php if($item_count > 0): ?><div class="itemCntBox"><?php echo e($item_count); ?></div><?php endif; ?>
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1" >
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                        </div>
                        <a href="/logout">로그아웃</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="back-blue simu-head">
                    <span class="text-gold font-weight-bold align-middle ll-he23">파워모의배팅</span> <span class="font-weight-bold text-white align-middle ll-he23">남은 기간</span>  <span class="text-gold font-weight-bold align-middle ll-he23">30일</span>
                    <button class="btn btn-sm btn-jin-blue gopur_btn">구매하러 가기</button>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="p-0 align-middle border-0">
                    <div class="notice">
                        <span class="not-left">공지</span>
                        <div style="position: absolute; top: 0px;" id="scrollNotice">
                            <ul>
                                <?php if(!empty($notice)): ?>
                                <?php $__currentLoopData = $notice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="/board?board_type=customer&board_category=notice&bid=<?php echo e($nitem["id"]); ?>&page=1" target="mainFrame"><?php echo e($nitem["title"]); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="mb-2"></div>
    </div>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    <div class="pt-2 pb-0">
        <?php echo Form::open(['action' =>'App\Http\Controllers\Auth\LoginController@process_login', 'method' => 'post', 'enctype' => 'multipart/form-data']); ?>

        <table class="ml-3">
            <colgroup>
                <col width="210px">
                <col width="110px">
            </colgroup>
            <tr>
                <td class="p-1">
                    <?php echo Form::text('loginId', '', ['class' => 'input-green mb-1 w-100','autocomplete'=>"off"]); ?>

                    <?php echo Form::password('password', ['class'=>'input-green w-100']); ?>

                </td>
                <td class="text-left p-1 pr-3">
                    <?php echo Form::submit('로그인', ['class' => 'btn btn-jin-greenoutline w-100 h-55']); ?>

                </td>
            </tr>
            <tr>
                <td class="pt-2 pb-2 pl-1" colspan="2">
                    <label class="container-radio">
                        <input type="checkbox" checked="checked">
                        <span class="checkmark"></span>
                    </label>
                    <a style="color: #000 !important;margin-left: -11px;" class="mr-2" href="<?php echo e(route('register')); ?>">로그인상태유지</a>
                    <a class="text-blue mr-2" href="<?php echo e(route('register')); ?>">회원가입</a>
                    <a class="text-blue" href="<?php echo e(route('password.request')); ?>" target="mainFrame">아이디,비밀번호 찾기</a>
                </td>
            </tr>
        </table>
        <?php echo Form::close(); ?>

    </div>
    <?php endif; ?>
</div>


<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/box-login.blade.php ENDPATH**/ ?>