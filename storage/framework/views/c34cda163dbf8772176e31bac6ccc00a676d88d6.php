<script>
    var api_token = "<?php echo e($result["api_token"]); ?>";
</script>
<div class="title">쪽지</div>
<ul>
    <li><a href="/memo?type=receive" <?php if($result["type"] == "receive" || Request::get("mtype") == "receive"): ?>class="<?php echo e("on"); ?>"<?php endif; ?>>받은 쪽지함</a></li>
    <li><a href="/memo?type=send" <?php if($result["type"] == "send" || Request::get("mtype") == "send"): ?>class="<?php echo e("on"); ?>"<?php endif; ?>>보낸 쪽지함</a></li>
    <li><a href="/memo?type=write" <?php if($result["type"] == "write"): ?>class="<?php echo e("on"); ?>"<?php endif; ?>>쪽지보내기</a></li>
    <li><a href="/memo?type=save" <?php if($result["type"] == "save"): ?>class="<?php echo e("on"); ?>"<?php endif; ?>>쪽지보관함</a></li>
    <li class="list"><a href="/memo?type=friendList&searchVal=all" <?php if($result["type"] == "friendList"): ?>class="<?php echo e("on"); ?>"<?php endif; ?>>친구리스트</a></li>
    <li class="list"><a href="/memo?type=fixMember&searchVal=all" <?php if($result["type"] == "fixMember"): ?>class="<?php echo e("on"); ?>"<?php endif; ?>>고정멤버</a></li>
</ul>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/member/memo-memu.blade.php ENDPATH**/ ?>