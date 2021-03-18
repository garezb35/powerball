<script> var pick_type  = @if(empty($type))-1 @else {{$type}}@endif; </script>
<script src="/assets/js/miniview.js"></script>
<link rel="stylesheet" href="/assets/css/miniviewSpeed.css">
<div class="speedkenoBetBox" id="speedkenoBetBox" style="margin-top: 5px; display: block;">
    <div class="title">픽</div>
    <form name="bettingForm" id="bettingForm" method="post" action="/">
        <input type="hidden" name="view" value="action" />
        <input type="hidden" name="action" value="speedkenoBetting" />
        <input type="hidden" name="actionType" value="bet" />
        <input type="hidden" name="numberSumOddEven" id="numberSumOddEven" />
        <input type="hidden" name="numberMinOddEven" id="numberMinOddEven" />
        <input type="hidden" name="numberMaxOddEven" id="numberMaxOddEven" />
        <input type="hidden" name="underOver" id="underOver" />
        <input type="hidden" name="api_token" value="{{$token}}" />
        <ul class="betting">
            <li>
                <span class="titleBox">숫자합 마지막자리</span>
                <div style="margin-top: 5px;">
                    <span class="pick-btn odd" type="numberSumOddEven" val="1">홀</span>
                    <span class="pick-btn even" type="numberSumOddEven" val="0">짝</span>
                </div>
            </li>
            <li>
                <span class="titleBox">숫자합 마지막자리</span>
                <div style="margin-top: 5px;">
                    <span class="pick-btn odd" type="underOver" val="1">언더</span>
                    <span class="pick-btn even" type="underOver" val="0">오버</span>
                </div>
            </li>
            <li class="btnBox" style="position: relative;">
                <div class="left">
                    <span class="pick" onclick="speedkenoBetting();">픽</span>
                </div>
                <div class="right">
                    <span class="reset" onclick="resetSpeedkenoBetting();">리셋</span>
                    <div class="point">
                        <a href="/?view=speedkenoBettingLog" target="mainFrame" class="log">픽 내역</a>
                    </div>
                </div>
            </li>
        </ul>
    </form>
</div>
@include("bet_robot")
