
<?php $__env->startSection("content"); ?>
    <script>
        var useridKey = '<?php echo e(Request::get("useridKey")); ?>';
        var userBulletCnt = '<?php echo e($user->bullet); ?>';
    </script>
    <div class="giftBox">
        <div class="title">당근 선물하기</div>
        <div class="content">
            <div class="userBullet">
                보유 당근 <span><?php echo e($user->bullet); ?></span>
                <a href="#" onclick="opener.top.mainFrame.location.href = '/market';return false;" class="buyBtn">당근 구매하기</a>
            </div>

            <div class="bulletDesc">
                <div class="tit">당근이란?</div>
                <ul>
                    <li>- 회원간 선물할 수 있는 유료 아이템입니다.</li>
                    <li class="small">(선물받은 당근은 환전하여 실제수익으로 돌려받게 됩니다.)</li>
                </ul>
            </div>

            <div class="bulletSelect">
                <table>
                    <tbody><tr>
                        <th>선물할 회원 닉네임</th>
                        <td class="highlight b"><?php echo e($other_nick); ?>님</td>
                    </tr>
                    <tr>
                        <th>선물할 당근</th>
                        <td><label><input type="radio" name="cnt" value="5"> 5개</label> <label><input type="radio" name="cnt" value="10" checked=""> 10개</label> <label><input type="radio" name="cnt" value="50"> 50개</label> <label><input type="radio" name="cnt" value="100"> 100개</label></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><label><input type="radio" name="cnt" value="0"> 직접입력</label> <input type="text" name="inputCnt" id="inputCnt" maxlength="5" style="width:50px;" disabled="true" onkeypress="onlyNumber();"> 개</td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
        <div class="btn">
            <a href="#" onclick="giftBullet();return false;" class="gift">선물하기</a>
            <a href="#" onclick="self.close();" class="cancel">취소</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\powerball\resources\views/member/giftBox.blade.php ENDPATH**/ ?>