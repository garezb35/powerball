@extends("includes.chat_header")
@section("content")
@include('chat.countdown')
<div class="mb-2"></div>
@auth
<table class="table box-menus">
    <colgroup>
        <col width="33.33%">
        <col width="33.33%">
        <col width="33.33%">
    </colgroup>
    <tr>
        <td class="text-center align-middle active pt-2 pb-1" onclick="goPa('myhome')">
           <div class="position-relative">
               <div class="mb-1">
                   <img src="{{Request::root()}}/assets/images/mine/act-home.png" height="21">
               </div>
               <a href="{{route("member")}}" target="mainFrame">마이홈</a>
           </div>
        </td>
        <td class="text-center align-middle pt-2 pb-1" onclick="goPa('mail')">
            <div class="position-relative">
                <div class="mb-1">
                    <img src="{{Request::root()}}/assets/images/mine/message.png" height="21">
                </div>
                <a href="#" onclick="windowOpen('/?view=memo','memo',600,600,'auto');return false;" >쪽지</a>
            </div>
        </td>
        <td class="text-center align-middle pt-2 pb-1" onclick="goPa('item')">
            <div class="position-relative">
                <div class="mb-1">
                    <img src="{{Request::root()}}/assets/images/mine/item.png" height="21">
                </div>
                <a href="{{route("member")}}?type=item" target="mainFrame">아이템</a>
                @if($item_count > 0)<div class="itemCntBox">{{$item_count}}</div>@endif
            </div>
        </td>
    </tr>
</table>
<div class="mb-2"></div>
@endauth
@include('chat.box-chatting')
@endsection
