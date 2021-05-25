@extends("includes.empty_header")
@section("content")
    @php
        $win_prefer= "pb_oe";
        $win_bet = "bet_number";
        $first= sizeof($users);
        switch(Request::get("type")){
            case "powerballOddEven":
                break;
            case "powerballUnderOver":
                $win_prefer= "pb_uo";
                $win_bet = "bet_number1";
                break;
            case "numberOddEven":
                $win_prefer= "nb_oe";
                $win_bet = "bet_number2";
                break;
            case "numberUnderOver":
                $win_prefer= "nb_uo";
                $win_bet = "bet_number3";
                break;
            case "numberSize":
                $win_prefer= "nb_size";
                $win_bet = "bet_number4";
                break;
            default:
                break;
        }
    @endphp
    <div class="rankingBox">
        <div class="titleBox">
            랭킹 <span>- 픽 5,000회 이상 참여한 회원만 순위에 반영 됩니다. (최근 일주일 내에 픽한 경우)</span>
        </div>
        <div class="menuBox">
            <div class="title">
                <div class="left">파워볼</div>
                <div class="right">숫자합</div>
            </div>
            <div class="leftMenu">
                <div class="left"><a href="{{route("ranking")}}?type=powerballOddEven" @if(empty(Request::get("type")) || Request::get("type") == "powerballOddEven") class="on" @endif>홀/짝</a></div>
                <div class="right"><a href="{{route("ranking")}}?type=powerballUnderOver" @if(Request::get("type") == "powerballUnderOver") class="on" @endif>언더/오버</a></div>
            </div>
            <div class="rightMenu">
                <div class="subMenu"><a href="{{route("ranking")}}?type=numberOddEven" @if(Request::get("type") == "numberOddEven") class="on" @endif>홀/짝</a></div>
                <div class="subMenu"><a href="{{route("ranking")}}?type=numberUnderOver" @if(Request::get("type") == "numberUnderOver") class="on" @endif>언더/오버</a></div>
                <div class="subMenu none"><a href="{{route("ranking")}}?type=numberSize" @if(Request::get("type") == "numberSize") class="on" @endif>대중소</a></div>
            </div>
        </div>
        <div class="listBox tbl_head01 tbl_wrap">
            <table class="table table-bordered">
                <colgroup>
                    <col width="80">
                    <col>
                    <col width="130">
                    <col width="130">
                    <col width="130">
                    <col width="130">
                </colgroup>
                <thead>
                    <tr >
                        <th class="text-center">순위</th>
                        <th class="text-center">닉네임</th>
                        <th class="text-center">참여회차수</th>
                        <th class="text-center">승률</th>
                        <th class="text-center">승</th>
                        <th class="text-center">패</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($users))
                    @foreach($users as $user)
                        @php
                        $win_history = $user["winning_history"];
                        if(!empty($win_history))
                            $win_history = json_decode($user["winning_history"]);
                        @endphp
                <tr class="trEven">
                    <td class="number text-center">{{$first}}</td>
                    <td class="nick text-center"><img src="{{$user["get_level"]["value3"]}}" width="30" height="30"> {{$user["nickname"]}}</td>
                    <td class="number text-center">{{number_format($user[$win_bet])}}</td>
                    <td class="number text-center"> {{number_format($win_history->$win_prefer->win*100 / ($win_history->$win_prefer->win + $win_history->$win_prefer->lose),2)}}%</td>
                    <td class="number text-center">{{number_format($win_history->$win_prefer->win)}}</td>
                    <td class="number text-center">{{number_format($win_history->$win_prefer->lose)}}</td>
                </tr>
                        @php
                        $first--;
                        @endphp
                    @endforeach
                @endif
                </tbody></table>
            <div class="pagingBox"></div>
        </div>
    </div>
@endsection
