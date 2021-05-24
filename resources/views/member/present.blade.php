@extends("includes.empty_header")
@section("content")
    @php
    $first = sizeof($presents);
    $page = Request::get("page") ?? 1 ;
    $first = $first - ($page-1) * 20;
    $date = empty(Request::get("type")) ? date("Y-m-d") : Request::get("type");
    $y = date("Y",strtotime($date));
    $m = date("m",strtotime($date));
    $d = date("d",strtotime($date));
    @endphp
    <script>
        var y = {{$y}};
        var m = {{$m}};
        var d = {{$d}};
        var month_days = "{{$month_days}}";
    </script>
    <link rel="stylesheet" href="/assets/calendar/simple-calendar.css">
    <script src="/assets/calendar/jquery.simple-calendar.js"></script>
    <div class="attendanceBox">
        <div class="titleBox">
            출석체크 <span>- 매일 매일 출석체크하고 랜덤아이템상자 받자!</span>
        </div>

        <div class="topBox">
            <div class="calendarBox">
            </div>
            <div class="ladderBox">
                <div class="choiceBox">
                    <div class="choiceNumber" style="left:40px;">1</div>
                    <div class="choiceNumber" style="left:210px;">2</div>
                    <div class="choiceNumber" style="left:380px;">3</div>
                </div>
                <div class="ladderContent">
                    <div id="ladderResult"></div>
                </div>

                <div class="contentArea">
                    <form name="attendanceForm" id="attendanceForm" method="post" action="/">
                        @csrf
                        <input type="hidden" name="selectNumber" id="selectNumber">
                        <input type="hidden" name="winNumber" value="{{$win_number}}">
                        <input type="hidden" name="api_token" value="{{$api_token}}">
                        <ul>
                            <li class="choice">1</li>
                            <li class="choice">2</li>
                            <li class="choice">3</li>
                        </ul>
                        <div class="text">출석 코멘트</div>
                        <div class="inputBox"><input type="text" name="comment" class="input" value="{{randomItemMessage()[$size]}}" readonly=""></div>
                        <div class="submit" style="background-color: #8ee2e2">출석체크</div>
                    </form>
                </div>

                <div class="choiceBox">
                    <div class="choiceNumber @if($win_number == 1) win @endif" style="left:40px;">@if($win_number == 1){{"당첨"}}@else{{"꽝"}}@endif</div>
                    <div class="choiceNumber @if($win_number == 2) win @endif" style="left:210px;">@if($win_number == 2){{"당첨"}}@else{{"꽝"}}@endif</div>
                    <div class="choiceNumber @if($win_number == 3) win @endif" style="left:380px;">@if($win_number == 3){{"당첨"}}@else{{"꽝"}}@endif</div>
                </div>
            </div>
        </div>

        <div class="listBox tbl_head01 tbl_wrap">
            <table class="table table-bordered">
                <colgroup>
                    <col width="50">
                    <col width="50">
                    <col width="80">
                    <col width="150">
                    <col>
                    <col width="100">
                </colgroup>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>결과</th>
                        <th class="text-center">개근</th>
                        <th>닉네임</th>
                        <th>코멘트</th>
                        <th class="text-center">출석시간</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($presents))
                    @foreach($presents as $present)
                    <tr class="">
                        <td class="number">{{$first}}</td>
                        <td class="result">@if($present["result"] == "win"){{"당첨"}}@else{{"꽝"}}@endif</td>
                        <td class="number">{{$present["perfectatt"]}}일</td>
                        <td class="nick"><img src="{{$present["user"]["getLevel"]["value3"]}}" width="23" height="23">{{$present["user"]["nickname"]}}</td>
                        <td class="txt" data-hasqtip="207" oldtitle="{{$present["comment"]}}" title="" aria-describedby="qtip-207">{{$present["comment"]}}</td>
                        <td class="number">{{$present["created_at"]}}</td>
                    </tr>
                        @php $first--; @endphp
                    @endforeach
                @endif
                </tbody>
            </table>
            {{$presents->links()}}
        </div>
    </div>
@endsection
