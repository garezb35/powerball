<?php $__env->startSection("content"); ?>
    <script>
        var filterWordArr = ['카카오톡','카톡','틱톡','kakao','텔레그램','telegram','스코어게임','스겜','scoregame','abc게임','abcgame','파워볼게임'];
    </script>
    <div class="memoBox">
        <?php echo $__env->make("member.memo-memu", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form name="writeForm" id="writeForm" method="post" action="/" onsubmit="return inputCheck();">
            <input type="hidden" name="api_token" value="<?php echo e($result["api_token"]); ?>">
            <div class="content">
                <div class="top">
                    <span class="textBox">
                        <input type="checkbox" name="randomMemo" id="randomMemo" value="Y" onclick="randomMemoCheck();">
                        <label for="randomMemo" style="cursor:pointer;">랜덤쪽지</label> <span class="bar">|</span> 쪽지 아이템
                        <span class="point"><?php echo e($result["send"]); ?></span>개 <span class="bar">|</span> 랜덤 쪽지 아이템
                        <span class="point"><?php echo e($result["random_send"]); ?></span>개</span>
                </div>
                <div class="titleInputBox">
                    <input type="text" name="receiveNick" id="receiveNick" value="<?php echo e($result["nickname"]); ?>" class="receiveNick">
                    <a href="#" onclick="ajaxNicknameCheck();return false;" class="nicknameBtn">닉네임확인</a>
                    <a href="<?php echo e("memo"); ?>?type=friendList" class="friendBtn">친구리스트</a>
                </div>
                <div class="contentInputBox"><textarea name="content" class="contentInput"></textarea></div>
                <div class="btnBox">
                    <a href="#" onclick="inputCheck();return false;" class="btnSend">쪽지보내기</a>
                </div>
                <div class="guide">
                    ※ 쪽지발송은 <strong>쪽지 아이템</strong>이 있어야 가능합니다. <a href="/market" target="mainFrame" class="b">[구매하러가기]</a><br>
                    ※ 개인정보 공유 및 사이트 홍보시 차단될 수 있습니다.
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('includes.empty_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/write.blade.php ENDPATH**/ ?>