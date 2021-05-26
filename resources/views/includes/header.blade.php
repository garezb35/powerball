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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        var remainTime = 0;
        var speedRemain = 0;
        var userIdToken = "{{$userIdToken}}";
    </script>
</head>
<body>
<div id="userLayer" style="display: none">
    <div class="lutop"><span id="unickname">관리왕1</span></div>
    <div class="game"></div>
</div>
    <div id="wrap">
        <div id="topArea">
            <div class="logo">
                <a href="/" class="none"><img src="{{Request::root()}}/assets/images/logo.svg" width="144" ></a>
                <div class="top-header-right">
                    <a href="/bbs/board.php?bo_table=custom&amp;wr_id=147" target="mainFrame">
                        <div class="d-inline-flex align-middle" style="transform:rotate(-40deg)"><img src="/assets/images/powerball/dangun.svg" width="60" height="60"></div>
                        <div class="d-inline-flex align-middle"><span class="header-right-1">코인을 충전하시겠어요?<br><span class="header-right-2">당근을 선물해 보세요!</span></span></div>
                    </a>
                </div>
            </div>
            <div class="gnb">
                <ul>
                    <li><a href="{{route('p_analyse')}}?terms=lates&pageType=display" target="mainFrame" class="on hiddenBorard" >파워볼분석 <div class="border-half"></div></a></li>
                    <li><a href="{{route('psadari_analyse')}}?terms=lates&pageType=display" target="mainFrame" class="hiddenBorard" >파사중계<div class="border-half"></div></a></li>
                    <li><a href="{{route('pick-powerball')}}" target="mainFrame" style="width:80px;text-align:center;" class="hiddenBorard">픽<div class="border-half"></div></a></li>
                    <li><a href="#" target="mainFrame" onclick='alert("적재중... 잠시 기다려 주세요");return false;' rel="hidden" class="hiddenBorard">파워모의배팅<div class="border-half"></div></a></li>
                    <li><a href="#" target="mainFrame" onclick='alert("적재중... 잠시 기다려 주세요");return false;' rel="hidden" class="hiddenBorard">연승제조기<div class="border-half"></div></a></li>
                    <li><a href="{{"board"}}?board_type=none&board_category=humor" target="mainFrame" class="hiddenBorard">커뮤니티<div class="border-half"></div></a></li>
                    <li><a href="{{route('market')}}" target="mainFrame" class="hiddenBorard">마켓<div class="border-half"></div></a></li>
                    <li><a href="#" onclick="openChatRoom();return false;" class="hiddenBorard">방채팅<div class="border-half"></div></a></li>
                    <li><a href="{{"board"}}?board_type=community&board_category=offten" target="mainFrame" class="hiddenBorard">고객센터<div class="border-half"></div></a></li>
                    <li><a href="/board?board_type=customer&board_category=notice" target="mainFrame" class="hiddenBorard">공지사항<div class="border-half"></div></a></li>
                    <li><a href="{{route("present")}}"  target="mainFrame" class="hiddenBorard">출석체크</a></li>
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
