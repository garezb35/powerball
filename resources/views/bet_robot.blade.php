<link rel="stylesheet" href="/assets/css/betrobot.css">
<div class="bet_captchaBox" id="captchaBox">
    <div class="title">
        로봇
        <div>방지</div>
    </div>
    <form name="captchaForm" id="captchaForm" method="post" action="/">
        <input type="hidden" name="view" value="action" />
        <input type="hidden" name="action" value="betting" />
        <input type="hidden" name="actionType" value="captcha" />
        <input type="hidden" name="captchaNum" id="captchaNum" />

        <div class="captchaImg" id="captchaImg"></div>
        <div class="inputBox">
            <p class="form_notice" style="margin-top: 15px;"><strong>좌측 숫자</strong> 입력</p>
            <div class="auth_guide">
                <input type="text" maxlength="1" name="captchaNum1" id="captchaNum1" readonly="" />
                <input type="text" maxlength="1" name="captchaNum2" id="captchaNum2" readonly="" />
            </div>
            <p class="form_notice">키패드를 마우스로 클릭해 입력해 주세요.</p>
        </div>
        <div class="keypadBox">
            <div class="keypad">
                <ul class="pad">
                    <li class="num3">3</li>
                    <li class="num9">9</li>
                    <li class="num4">4</li>
                    <li class="num2">2</li>
                    <li class="num8">8</li>
                    <li class="num5">5</li>
                    <li class="reset">모두 지우기</li>
                    <li class="num0">0</li>
                    <li class="num1">1</li>
                    <li class="num7">7</li>
                    <li class="num6">6</li>
                    <li class="delete">삭제</li>
                </ul>
            </div>
        </div>

        <div class="btnBox">
            <div class="btns" onclick="runCaptcha();">확인</div>
        </div>
    </form>
</div>
<script src="/assets/js/betrobot.js"></script>

