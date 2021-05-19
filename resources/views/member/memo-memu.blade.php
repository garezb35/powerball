<script>
    var api_token = "{{$result["api_token"]}}";
</script>
<div class="title">쪽지</div>
<ul>
    <li><a href="/memo?type=receive" @if($result["type"] == "receive" || Request::get("mtype") == "receive")class="{{"on"}}"@endif>받은 쪽지함</a></li>
    <li><a href="/memo?type=send" @if($result["type"] == "send" || Request::get("mtype") == "send")class="{{"on"}}"@endif>보낸 쪽지함</a></li>
    <li><a href="/memo?type=write" @if($result["type"] == "write")class="{{"on"}}"@endif>쪽지보내기</a></li>
    <li><a href="/memo?type=save" @if($result["type"] == "save")class="{{"on"}}"@endif>쪽지보관함</a></li>
    <li class="list"><a href="/memo?type=friendList&searchVal=all" @if($result["type"] == "friendList")class="{{"on"}}"@endif>친구리스트</a></li>
    <li class="list"><a href="/memo?type=fixMember&searchVal=all" @if($result["type"] == "fixMember")class="{{"on"}}"@endif>고정멤버</a></li>
</ul>
