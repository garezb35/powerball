<div class="title">
    <ul>
        <li><a href="<?php echo e(route("member")); ?>" target="mainFrame" <?php if(empty(Request::get("type"))): ?> class="on" <?php endif; ?>>회원정보</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=item" target="mainFrame" <?php if(Request::get("type") == "item"): ?> class="on" <?php endif; ?>>아이템</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=itemLog" target="mainFrame" <?php if(Request::get("type") == "itemLog"): ?> class="on" <?php endif; ?>>아이템 사용내역</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=itemTerm" target="mainFrame" <?php if(Request::get("type") == "itemTerm"): ?> class="on" <?php endif; ?>>아이템 사용기간</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=nicknameLog" target="mainFrame" <?php if(Request::get("type") == "nicknameLog"): ?> class="on" <?php endif; ?>>닉네임 변경</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=giftLog" target="mainFrame" <?php if(Request::get("type") == "giftLog"): ?> class="on" <?php endif; ?>>선물내역</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=chargeLog" target="mainFrame" <?php if(Request::get("type") == "chargeLog"): ?> class="on" <?php endif; ?>>충전내역</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=exchange" target="mainFrame" <?php if(Request::get("type") == "exchange"): ?> class="on" <?php endif; ?>>총알환전</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=level" target="mainFrame" <?php if(Request::get("type") == "level"): ?> class="on" <?php endif; ?>>경험치</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=loginLog" target="mainFrame" <?php if(Request::get("type") == "loginLog"): ?> class="on" <?php endif; ?>>접속기록</a></li>
        <li><a href="<?php echo e(route("member")); ?>?type=withdraw" target="mainFrame" <?php if(Request::get("type") == "withdraw"): ?> class="on" <?php endif; ?>>회원탈퇴</a></li>
    </ul>
</div>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/member-menu.blade.php ENDPATH**/ ?>