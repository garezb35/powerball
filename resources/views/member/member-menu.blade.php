<div class="title">
    <ul>
        <li><a href="{{route("member")}}" target="mainFrame" @if(empty(Request::get("type"))) class="on" @endif>회원정보</a></li>
        <li><a href="{{route("member")}}?type=item" target="mainFrame" @if(Request::get("type") == "item") class="on" @endif>아이템</a></li>
        <li><a href="{{route("member")}}?type=itemLog" target="mainFrame" @if(Request::get("type") == "itemLog") class="on" @endif>아이템 사용내역</a></li>
        <li><a href="{{route("member")}}?type=itemTerm" target="mainFrame" @if(Request::get("type") == "itemTerm") class="on" @endif>아이템 사용기간</a></li>
        <li><a href="{{route("member")}}?type=nicknameLog" target="mainFrame" @if(Request::get("type") == "nicknameLog") class="on" @endif>닉네임 변경</a></li>
        <li><a href="{{route("member")}}?type=giftLog" target="mainFrame" @if(Request::get("type") == "giftLog") class="on" @endif>선물내역</a></li>
        <li><a href="{{route("member")}}?type=chargeLog" target="mainFrame" @if(Request::get("type") == "chargeLog") class="on" @endif>충전내역</a></li>
        <li><a href="{{route("member")}}?type=exchange" target="mainFrame" @if(Request::get("type") == "exchange") class="on" @endif>당근환전</a></li>
        <li><a href="{{route("member")}}?type=level" target="mainFrame" @if(Request::get("type") == "level") class="on" @endif>경험치</a></li>
        <li><a href="{{route("member")}}?type=loginLog" target="mainFrame" @if(Request::get("type") == "loginLog") class="on" @endif>접속기록</a></li>
        <li><a href="{{route("member")}}?type=withdraw" target="mainFrame" @if(Request::get("type") == "withdraw") class="on" @endif>회원탈퇴</a></li>
    </ul>
</div>
