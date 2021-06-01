<?php $__env->startSection("header"); ?>
    <?php echo $__env->make('member/member-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <div class="content">
        <div class="memberInfoBox">
            <form name="memberForm" method="post" action="/exitMember" >
                <?php echo csrf_field(); ?>
                <table border="0" cellspacing="0" cellpadding="0" class="table">
                    <colgroup>
                        <col width="120px">
                        <col width="190px">
                        <col>
                    </colgroup>

                    <tbody><tr>
                        <td class="tit">아이디 <span class="red"></span></td>
                        <td class="pdL10" colspan="2"><?php echo e($nickname); ?></td>
                    </tr>
                    <tr>
                        <td class="tit">비밀번호 <span class="red"></span></td>
                        <td><input type="password" name="passwd" class="input" required></td>
                        <td class="guideMsg" id="widthdrawPasswdChkDiv" checkyn="N"></td>
                    </tr>
                    </tbody></table>

                <div style="margin-top:10px;text-align:center;font-size:11px;">
                    탈퇴한 아이디는 복구가 불가능하니 신중하게 선택하시기 바랍니다.<br>
                    회원정보 및 코인, 총알 등 서비스 기록이 모두 삭제되며, 삭제된 데이터는 복구되지 않습니다.<br>
                    탈퇴시 같은 번호로 재가입이 불가능합니다.
                </div>
                <div style="margin:15px 0;">
                    <input type="button" class="btn" onclick="inputCheck()" value="회원탈퇴">
                </div>
                <div id="resultBox" class="red b" style="text-align:center;"></div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<style>
    .memberInfoBox .input {
        margin-left: 10px;
        padding: 0 8px;
        width: 150px;
        height: 22px;
        line-height: 22px;
        border: 1px solid #c2c6cb;
        font-family: Gulim;
        font-size: 12px;
        font-weight: bold;
        z-index: 10;
    }
</style>
<script>
    function inputCheck()
    {
        var fn = document.forms.memberForm;
        var valid = true;

        $('.memberInfoBox .guideMsg').each(function(){
            var checkYN = $(this).attr('checkYN');
            var chkType = $(this).attr('id').replace('ChkDiv','');
            var val = $(this).prev().children().val();

            if(!val)
            {
                $(this).prev().children().focus();
                valid = false;
                return false;
            }
        });

        if(valid)
        {
            if(!confirm('회원탈퇴시 회원정보 및 코인이 모두 소멸되고 재가입이 불가능합니다.\n정말 탈퇴하시겠습니까?'))
            {
                return false;
            }

            $.ajax({
                type:'POST',
                dataType:'json',
                url:'/api/exitMember',
                data:{
                    api_token:"<?php echo e($api_token); ?>",
                    passwd:fn.passwd.value
                },
                success:function(data,textStatus){
                    $('#resultBox').show();
                    $('#resultBox').html(data.msg);
                    if(data.status == 1)
                    {
                        top.location.href = '/logout';
                    }
                }
            }).fail(function(xhr){
                console.log(xhr)
            });
        }
    }
</script>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/powerball-withdraw.blade.php ENDPATH**/ ?>