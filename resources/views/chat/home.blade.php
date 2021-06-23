@extends("includes.chat_header")
@section("content")
    <script>
        var userIdKey = "{{$userIdKey}}";
        @if($userIdKey !="")
        var loginYN = "Y";
        @else
        var loginYN = "N";
        @endif
        var userIdToken = "{{$api_token}}";
        @if(!empty($cur_nickname))
        var cur_nickname = "{{$cur_nickname}}";
        @else
        var cur_nickname = "";
        @endif

        @if(!empty($bullet))
        var bullet = {{$bullet}};
        @else
        var bulllet = 0;
        @endif
    </script>
    @include('chat.countdown')
    <div class="mb-2"></div>
    @include('pick.vs')
<div class="mb-2"></div>
@include('chat.box-chatting')
@endsection
