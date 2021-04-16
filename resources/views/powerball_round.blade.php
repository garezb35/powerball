@extends('includes.empty_header')
@section("header")
    @include('Analyse/analyse-menu')
@endsection
@section("content")
    <script>
        var from = "{{$from}}";
        var to = "{{$to}}";
        var round = {{$current_round}};
    </script>
    <div class="mt-2"></div>
    @include("Time.timebox")
    <div class="mb-2"></div>

    <div class="round_area">
        {!! Form::open(['action' =>'App\Http\Controllers\PowerballController@view', 'method' => 'get',"id"=>"round_form"]) !!}
        <input type="hidden" name="terms" value="round">
        <div class="info">
            <div id="round_search_type" class="view_se1">
                <div id="single_search" class="se1">
                    <a class="sp-date_prev prev rollover" href="{{route("p_analyse")}}?terms=round&toRound={{$prev}}&from={{$from}}&to={{$to}}" rel="down"><span class="ic">이전</span></a>
                    <span id="single_round" class="date">{{$current_round}}</span>
                    <a class="sp-date_next next rollover" href="{{route("p_analyse")}}?terms=round&toRound={{$next}}&from={{$from}}&to={{$to}}" rel="up"><span class="ic">다음</span></a>
                    <a class="btn_box" href="{{route("p_analyse")}}?terms=round&current=1" rel="current">현재회차</a>
                    <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                        @for($i=1;$i<=288;$i++)
                            <option @if($current_round == $i){{'selected'}} @endif value="{{$i}}">{{$i}}회차</option>
                        @endfor
                    </select>
                </div>
            </div>
            <ul class="switch_tab round_tab">
                <li><a class="selected" href="{{route("p_analyse")}}?terms=round" rel="se1">단일회차</a></li>
                <li><a class="" href="{{route("p_analyse")}}?terms=roundbox" rel="se2">복수회차</a></li>
                <li><a href="{{route('p_analyse')}}?terms=lates&pageType=late">최근회차</a></li>
            </ul>
        </div>
        <div class="date_search_option">
            <div class="dateBox">
                <input type="text" name="from" value="{{$from}}" class="dateInput sp-dayspace_bg" id="startDate">
                <div class="bar1">~</div>
                <input type="text" name="to" value="{{$to}}" class="dateInput sp-dayspace_bg" id="endDate">
                <input type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3" value="검색">
            </div>
            <div class="btnBox">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/p_analyse?terms=round&amp;dateType=2&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==2){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">2일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=4&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==4){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">4일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=7&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==7){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">7일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=15&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==15){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">15일</a>
                    <a href="/p_analyse?terms=round&amp;dateType=30&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==30){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">한달</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include("Analyse.all_analyseTable")
    @include('Analyse/seeAnalyseTable')
@endsection
