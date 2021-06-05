<div id="ladderResultBox">
  <div class="pickView">
    <a href="#" onclick="toggleMiniView();return false;" class="miniView">게임닫기</a>
  </div>
  <div class="pickBtn">
    <a href="#" onclick="togglePickView();return false;" class="pick-btns">픽 열기</a>
  </div>
    <iframe src="/pick/powerball/live" width="830" height="490" scrolling="no" frameborder="0" class="pick-screeen"></iframe>
    <div class="pick-part d-none">
      <?php echo $__env->make("pick/pick1", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php /**PATH D:\work\xampp8.0\htdocs\powerball\resources\views/powerballminiView.blade.php ENDPATH**/ ?>