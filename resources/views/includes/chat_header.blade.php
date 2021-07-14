<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <title>채팅</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/chat.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/alertify.min.css">
    <script>
        var remainTime ={{$p_remain[0]}};
        var speedRemain = 0;
        var is_scroll_lock = false;
        var userIdToken = "{{$api_token}}";
        var userIdKey = "{{$userIdKey}}";
        var roomIdx ="channel1";
        var is_admin = false;
        var is_freeze = 'off';
        var chatHistoryNum = 0;
        var filterWordArr = "{{$prohited}}".split(',');
        @if(!empty($profile))
        var levels = "{{$profile}}";
        var level_images = JSON.parse(levels.replace(/&quot;/g,'"'));
        @endif
        var total_num = 0;
        var is_repeatChat = false;
        var lastMsgTime = new Date().getTime();
        var sumMsgTerm = 0;
        var msgTermArr = new Array();
        var msgTermIdx = 0;
        var msgStopTime = 10;
        @if(Auth::check())
        var blackListArr = "{{Auth::user()->block_list}}".split(',');
        @else
        var blackListArr = new Array();
        @endif
        var node = "{{$node}}";
    </script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/alertify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.2/socket.io.js" ></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/chat.js"></script>
    <script src="/assets/js/handlebars.js"></script>
    <script src="/assets/js/common.js"></script>
    <script>
        var browser_ws = browserWsChk();
    </script>

</head>
<body>
    <style>
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
    </style>
    <div id="userLayer" style="display: none">
        <div class="lutop"><span id="unickname">관리왕1</span></div>
        <div class="game"></div>
    </div>
    @yield("content")
</body>
</html>
