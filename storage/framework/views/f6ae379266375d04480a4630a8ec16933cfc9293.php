
<?php $__env->startSection("content"); ?>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<div class="modifyBox">
    <div class="title">2차비밀번호</div>
    <div class="content">
        <div style="margin:10px;font-size:11px;line-height:18px;">
            <span class="highlight">2차비밀번호</span>란?<br>
            로그인시 2차비밀번호를 랜덤한  숫자 배열 키패드에서 <span class="highlight">키보드가 아닌 마으스로 클릭해서 입력하는 방식</span>으로 회원님의 <span class="highlight">계정 호보 서비스 이용시 보다 안정한 이용</span>이 가능합니다.
        </div>
        <form name="securityForm" method="post">
            <input type="hidden" id="api_token" name="api_token" value="<?php echo e($api_token); ?>">
            <input type="hidden" id="focusType" name="focusType" value="1">
            <input type="hidden" id="securityPasswd" name="securityPasswd">
            <input type="hidden" id="securityPasswd_re" name="securityPasswd_re">
            <div>
                <table class="table table-bordered">
                    <colgroup>
                        <col width="">
                        <col width="200px">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td class="tit text-center">2차비밀번호 설정</td>
                            <td class="text-center">
                                <input type="checkbox" name="securityPasswdUseYN" id="securityPasswdUseYN"  data-toggle="toggle"  data-height="20" data-on="사용" data-off="해제" data-onstyle="success" data-offstyle="danger"  value="1">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="security">
                <div class="content">
                    <h1 class="tit"><span>2차비밀번호를 입력</span> 해주세요.</h1>
                    <fieldset class="password">
                        <legend>2차비밀번호 입력</legend>
                        <div class="frame">
                            <p class="form_notice" style="margin-top:20px;">사용하실 <strong>2차비밀번호</strong>를 등록해 주세요.(숫자 8자리)</p>
                            <div class="form_guide">
                                <input type="password" maxlength="1" name="securityPasswd1" id="securityPasswd1" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd2" id="securityPasswd2" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd3" id="securityPasswd3" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd4" id="securityPasswd4" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd5" id="securityPasswd5" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd6" id="securityPasswd6" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd7" id="securityPasswd7" onfocus="setPasswordFocus(1);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd8" id="securityPasswd8" onfocus="setPasswordFocus(1);" readonly="">
                            </div>

                            <p class="form_notice" style="margin-top:15px;">입력한 <strong>2차비밀번호</strong> 확인</p>
                            <div class="form_guide">
                                <input type="password" maxlength="1" name="securityPasswd_re1" id="securityPasswd_re1" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re2" id="securityPasswd_re2" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re3" id="securityPasswd_re3" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re4" id="securityPasswd_re4" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re5" id="securityPasswd_re5" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re6" id="securityPasswd_re6" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re7" id="securityPasswd_re7" onfocus="setPasswordFocus(2);" readonly="">
                                <input type="password" maxlength="1" name="securityPasswd_re8" id="securityPasswd_re8" onfocus="setPasswordFocus(2);" readonly="">
                            </div>
                            <p class="form_notice">보안을 위해 키패드를 마우스로 클릭해 입력해 주세요.</p>

                            <div class="keypad">
                                <ul class="pad">
                                    <li class="num9">9</li><li class="num5">5</li><li class="num1">1</li><li class="num8">8</li><li class="num4">4</li><li class="num2">2</li><li class="reset">모두 지우기</li><li class="num7">7</li><li class="num6">6</li><li class="num3">3</li><li class="num0">0</li><li class="delete">삭제</li>
                                </ul>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
    <div class="btnBox">
        <a href="#" class="confirm" onclick="setSecurityPasswd();">확인</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/security.blade.php ENDPATH**/ ?>