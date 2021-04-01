<script> var pick_type  = @if(empty($type))-1 @else {{$type}} @endif; </script>
<script src="/assets/js/miniview.js"></script>
<link rel="stylesheet" href="/assets/css/miniview.css">
@php
    $iroom = 1;
    $roomIdx = "";
    if(!empty($room)){
        $roomIdx = $room["roomIdx"];
    }
    if(!empty($in_room))
        $iroom = $in_room;
@endphp
<div class="betBox" id="betBox" style="display:{{$pick_visible}}">
    <div class="title">픽</div>
    <form name="bettingForm" id="bettingForm" method="post" action="{{route('processBet')}}">
        <input type="hidden" name="view" value="action" />
        <input type="hidden" name="action" value="betting" />
        <input type="hidden" name="actionType" value="bet" />
        <input type="hidden" name="powerballOddEven" id="powerballOddEven" />
        <input type="hidden" name="numberOddEven" id="numberOddEven" />
        <input type="hidden" name="powerballUnderOver" id="powerballUnderOver" />
        <input type="hidden" name="numberUnderOver" id="numberUnderOver" />
        <input type="hidden" name="numberPeriod" id="numberPeriod" />
        <input type="hidden" name="api_token" value="{{$token}}" />
        <input type="hidden" name="roomIdx" value = "{{$roomIdx}}" />
        <input type="hidden" name="in_room" value="{{$iroom}}" />
        <ul class="betting">
            <li>
                <span class="titleBox">파워볼</span>
                <div style="margin-top: 5px;">
                    <span class="titleBox">숫자합</span>
                </div>
            </li>
            <li>
                <span type="powerballOddEven" val="1" class="pick-btn">홀</span>
                <span type="powerballOddEven" val="0" class="pick-btn">짝</span>
                <div style="margin-top: 5px;">
                    <span type="numberOddEven" val="1" class="pick-btn">홀</span>
                    <span type="numberOddEven" val="0" class="pick-btn">짝</span>
                </div>
            </li>
            <li>
                <span type="powerballUnderOver" val="1" class="pick-btn">언더</span>
                <span type="powerballUnderOver" val="0" class="pick-btn">오버</span>
                <div style="margin-top: 5px;">
                    <span type="numberUnderOver" val="1" class="pick-btn">언더</span>
                    <span type="numberUnderOver" val="0" class="pick-btn">오버</span>
                </div>
            </li>
            <li>
                <div style="margin-top: 5px;">
                    <span  type="numberPeriod" val="3" class="pick-btn">대</span>
                    <span  type="numberPeriod" val="2" class="pick-btn">중</span>
                    <span  type="numberPeriod" val="1" class="pick-btn">소</span>
                </div>
            </li>
            <li class="btnBox" style="position: relative;">
                <div class="left">
                    <span class="pick" onclick="powerballBetting();">픽</span>
                </div>
                <div class="right">
                    <div class="reset" onclick="resetPowerballBetting();">리셋</div>
                    <div class="point">
                        <a href="/?view=bettingLog" target="mainFrame" class="log">픽 내역</a>
                    </div>
                </div>
            </li>
        </ul>
    </form>
</div>
@include("bet_robot")
