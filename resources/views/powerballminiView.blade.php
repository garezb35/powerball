<div id="ladderResultBox">
  <div class="pickView">
    <a href="#" onclick="toggleMiniView();return false;" class="miniView">게임닫기</a>
  </div>
  <div class="pickBtn">
    <a href="#" onclick="togglePickView();return false;" class="pick-btns">픽 열기</a>
  </div>
    <iframe src="/pick/powerball/live" width="830" height="490" scrolling="no" frameborder="0" class="pick-screeen"></iframe>
    <div class="pick-part d-none">
      @include("pick/pick1")
    </div>
</div>
