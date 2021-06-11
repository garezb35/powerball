
<?php $__env->startSection("content"); ?>
    <div class="memoBox">
        <div class="title">인증 아이피 관리</div>
        <div class="content">
            <div style="margin:10px;font-size:11px;line-height:18px;">
                행단위로 아이피 구분 해주세요.
                한개 아이디당 10개의 아이피를 등록할수 있습니다.
            </div>
            <form name="memoForm" method="post" action="/saveIP">
                <?php echo csrf_field(); ?>
                <textarea rows="10" style="width: 538px;min-height: 300px;padding: 20px;font-size: 23px;line-height: 30px" id="ip" name="ip"><?php echo e($ip); ?></textarea>
                <div class="btnBox mt-3">
                    <input type="submit" value="확인" class="confirm">
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<style>

    .confirm {
        display: inline-block;
        width: 180px;
        height: 40px;
        margin: 0 auto;
        text-shadow: 1px 1px 1px #2f447f;
        text-align: center;
        text-decoration: none;
        font-weight: bold;
        line-height: 40px;
        color: #fff !important;
        font-size: 16px;
        background-color: #CC3300;
        border: 1px solid #9c1818;
        border-radius: 3px;
    }
</style>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/authIp.blade.php ENDPATH**/ ?>