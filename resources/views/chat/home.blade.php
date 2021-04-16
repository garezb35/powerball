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
    </script>
@include('chat.countdown')
<div class="mb-2"></div>
@include('chat.box-chatting')
@endsection


