
<?php $__env->startSection("content"); ?>
    <div class="findBox">
        <div class="content">
            <ul>
                <li class="id"><a href="#" onclick="changeTab('id');return false;" class="on">아이디 찾기</a></li>
                <li class="pw"><a href="#" onclick="changeTab('pw');return false;">비밀번호 찾기</a></li>
            </ul>
            <div id="findIdBox">
                <form name="memberForm" method="post" action="/">
                    <input type="hidden" name="view" value="action">
                    <input type="hidden" name="action" value="member">
                    <input type="hidden" name="actionType" value="findId">
                    <table border="0" cellspacing="0" cellpadding="0" class="table">
                        <colgroup>
                            <col width="120px">
                            <col width="300px">
                            <col>
                        </colgroup>

                        <tbody>
                            <tr>
                                <td class="title">이름</td>
                                <td><input type="text" name="name" class="input" style="width:250px;" ></td>
                                <td class="guideMsg" id="nameChkDiv" checkyn="N"></td>
                            </tr>
                            <tr>
                                <td class="title">휴대폰번호</td>
                                <td><input type="text" name="mobile" class="input" style="width:250px;"  maxlength="11"></td>
                                <td class="guideMsg" id="findMobileChkDiv" checkyn="N"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin:30px 0 0 0;"><a href="#" onclick="inputCheck();return false;" class="btn">아이디 찾기</a></div>
                </form>
            </div>
            <div id="findPwBox" style="display:none;">
                <form name="pwForm" method="post" action="/">
                    <input type="hidden" name="view" value="action">
                    <input type="hidden" name="action" value="member">
                    <input type="hidden" name="actionType" value="findPw">
                    <table border="0" cellspacing="0" cellpadding="0" class="table">
                        <colgroup>
                            <col width="120px">
                            <col width="300px">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <td class="title">아이디</td>
                                <td><input type="text" name="userid" class="input" style="width:250px;"></td>
                                <td class="guideMsg" id="findUseridChkDiv" checkyn="N"></td>
                            </tr>
                            <tr>
                                <td class="title">휴대폰번호</td>
                                <td><input type="text" name="mobile" class="input" style="width:250px;" maxlength="11"></td>
                                <td class="guideMsg" id="findMobile2ChkDiv" checkyn="N"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin:30px 0 0 0;"><a href="#" onclick="inputCheckPw();return false;" class="btn">비밀번호 찾기</a></div>
                </form>
            </div>
        </div>
        <div id="resultBox" class="resultBox"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("includes.empty_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/findIdPw.blade.php ENDPATH**/ ?>