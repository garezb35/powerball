<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <title>파워볼 게임</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script>
        var remainTime = 0;
        var speedRemain = 0;
    </script>
</head>
<body>
    <div id="wrap">
        <div id="topArea">
            <div class="logo"><a href="/" class="none"><img src="{{Request::root()}}/assets/images/logo.png" width="163" height="60"></a></div>
            <div style="position:absolute;top:0;right:72px;">
                <a href="/bbs/board.php?bo_table=custom&amp;wr_id=147" target="mainFrame"><img src="https://simg.powerballgame.co.kr/images/banner/banner_bullet.png?1" width="300" height="60"></a>
            </div>
            <div class="gnb">
                <ul>
                    <li><a href="{{route('p_analyse')}}?terms=lates&pageType=display" target="mainFrame" class="on hiddenBorard" >파워볼분석</a></li>
                    <li><a href="{{route('pick-powerball')}}" target="mainFrame" style="width:80px;text-align:center;" class="hiddenBorard">픽</a></li>
                    <li><a href="{{route('pick-simulator')}}" target="mainFrame" rel="hidden" class="hiddenBorard">파워모의배팅</a></li>
                    <li><a href="{{route('pick-win')}}" target="mainFrame" rel="hidden" class="hiddenBorard">연승제조기</a></li>
                    <li><a href="{{route('market')}}" target="mainFrame" class="hiddenBorard">샵</a></li>
                    <li><a href="#" onclick="openChatRoom();return false;" class="hiddenBorard">방채팅</a></li>
                    <li><a href="{{route('board')}}" target="mainFrame" class="hiddenBorard">커뮤니티</a></li>
                    <li><a href="/bbs/board.php?bo_table=qna" target="mainFrame" class="hiddenBorard">문의 및 요청</a></li>
                    <li><a href="/bbs/board.php?bo_table=custom" target="mainFrame" class="hiddenBorard">고객센터</a></li>
                   <li><a href="/?view=attendance" target="mainFrame" class="hiddenBorard">출석체크</a></li>


                </ul>
            </div>
        </div>
        <div id="container">
            <div id="box-ct">
                @include('includes.inner-left')
                <div class="inner-right">
                    @include("layouts.boardBox")
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
@include('includes.footer')
</html>
