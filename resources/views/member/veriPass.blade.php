@extends("includes.empty_header")
@section("content")
    <div style="position:relative;margin:10px auto;" class="pcVersion">
        <div>
            <a href="/" class="none"><img src="https://simg.powerballgame.co.kr/images/logo.gif" width="190" height="70"></a>
        </div>

        <div class="security">
            <div class="header">
                <h1>2차비밀번호</h1>
                <a href="/?view=action&amp;action=logout" class="close"><img src="https://simg.powerballgame.co.kr/images/btn_securityClose.png" width="17" height="17"></a>
            </div>
            <div class="content">
                <h1 class="tit">안전한 서비스 이용을 위해<br><span>2차비밀번호를 입력</span>해 주세요.</h1>

                <form name="securityForm" method="post" action="/verifySeconds">
                    @csrf
                    <input type="hidden" id="focusType" name="focusType" value="1">
                    <input type="hidden" id="securityPasswd" name="securityPasswd">

                    <fieldset class="password">
                        <div class="frame">
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
                            <p class="form_notice">보안을 위해 키패드를 마우스로 클릭해 입력해 주세요.</p>

                            <div class="keypad">
                                <ul class="pad">
                                    <li class="num4">4</li><li class="num9">9</li><li class="num5">5</li><li class="num2">2</li><li class="num3">3</li><li class="num1">1</li><li class="reset">모두 지우기</li><li class="num6">6</li><li class="num7">7</li><li class="num8">8</li><li class="num0">0</li><li class="delete">삭제</li>
                                </ul>
                            </div>

                            <ul class="more_info_text">
                                <!--<li><span class="blt">*</span>비밀번호 입력시 마다 키패드 숫자의 위치가 변경됩니다.</li>-->
                                <!--<li><span class="blt">*</span>2차비밀번호를 잊으셨나요? <a href="/?view=securityPassword&type=auth"><span class="link">[보안 비밀번호 재설정]</span></a></li>-->
                            </ul>
                        </div>

                    </fieldset>
                </form>

            </div>
            <div class="btnBox">
                <button class="btn" onclick="securityConfirm();">확인</button>
            </div>
        </div>

        <div style="text-align:center;margin-top:20px;">
            <p class="copyright">Copyright © <strong>powerballgame.co.kr</strong> All rights reserved.</p>
        </div>
    </div>
@endsection
