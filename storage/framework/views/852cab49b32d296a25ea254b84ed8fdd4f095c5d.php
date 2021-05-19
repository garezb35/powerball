
<?php $__env->startSection("content"); ?>
<div class="modifyBox">
    <div class="title">패밀리닉네임 변경하기</div>
    <div class="content">
        <div style="margin:10px;font-size:11px;line-height:18px;">
            패밀리닉네임은 <span class="highlight">한글,영문,특수문자 4자 이하</span>로 가능합니다.<br>
            <span class="highlight">욕설이나 미풍양속에 어긋나는 패밀리닉네임</span>은 사용할 수 없으며 변경하더라도 제한될 수 있습니다.
        </div>
    </div>

    <form name="memberForm" id="memberForm" method="post" action="/">
    <input type="hidden" id="token" value="<?php echo e($user["api_token"]); ?>">
    <input type="hidden" id="actionType" value="family">

    <div>
        <table class="table table-bordered">
            <colgroup>
                <col width="140px">
                <col width="145px" style="background-color:#fff;">
                <col style="background-color:#fff;">
            </colgroup>
            <tbody><tr>
                <td class="tit align-middle">패밀리닉네임</td>
                <td class="align-middle"><input type="text" id="family" value="<?php echo e($user["familynickname"]); ?>"  maxlength="8" autocomplete="off" ></td>
                <td class="guideMsg align-middle" id="familyNickChkDiv" checkyn="N"></td>
            </tr>
            <tr>
                <td class="tit">패밀리닉네임 초기화</td>
                <td colspan="2"><a href="#" onclick="familyNickInit();return false;" class="btn_set">패밀리닉네임 초기화</a> - 초기화한 아이템은 복구되지 않습니다.</td>
            </tr>
        </tbody></table>
    </div>

    <div class="btnBox">
        <a href="#" onclick="inputCheck();return false;" class="confirm">확인</a>
        <a href="#" onclick="inputReset();return false;" class="cancel">취소</a>
    </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/family-change.blade.php ENDPATH**/ ?>