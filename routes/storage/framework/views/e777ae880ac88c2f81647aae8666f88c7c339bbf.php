<?php $__env->startSection("content"); ?>
    <script>
        var userNick = '<?php echo e($nickname); ?>';
        var itemCode = '<?php echo e($itemCode); ?>';
        var api_token = '<?php echo e($api_token); ?>';
    </script>
    <div class="giftPopBox">
        <div class="title">아이템 선물하기</div>
        <div class="content">
            <div class="tit">선물할 아이템</div>
            <ul class="itemList">
                <li>

                    <img src="<?php echo e($item["image"]); ?>" width="115" height="115">
                    <div class="name"><?php echo e($item["name"]); ?></div>
                    <div class="desc"><?php echo e($item["description"]); ?></div>
                    <div class="price"><?php echo e(number_format($item["price"])); ?> <?php if($item["price_type"] ==1 ): ?><?php echo e("코인"); ?><?php else: ?><?php echo e("도토리"); ?><?php endif; ?></div>
                </li>
            </ul>

            <div class="inputBox">
                <table>
                    <tbody><tr>
                        <th>받는 회원 닉네임</th>
                        <td class="highlight"><input type="text" name="targetNick" id="targetNick"></td>
                    </tr>
                    <tr>
                        <th>아이템 수량</th>
                        <td>
                            <div class="amountSet">
                                <input type="text" name="itemCnt" id="itemCnt" maxlength="2" value="1개" rel="1" limit="50" style="ime-mode:disabled;" onkeydown="return isNumber(event);" onblur="countChk(this);">
                                <span class="up"></span>
                                <span class="down"></span>
                            </div>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
        <div class="btn">
            <a href="#" onclick="giftItem();return false;" class="gift">선물하기</a>
            <a href="#" onclick="self.close();" class="cancel">취소</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/giftPop.blade.php ENDPATH**/ ?>