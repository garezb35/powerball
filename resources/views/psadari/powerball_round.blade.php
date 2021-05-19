@extends('includes.empty_header')
@section("header")
    @include('Analyse/psadari/analyse-menu')
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
        {!! Form::open(['action' =>'App\Http\Controllers\PowerSadariController@view', 'method' => 'get',"id"=>"round_form"]) !!}
        <input type="hidden" name="terms" value="round">
        <div class="info">
            <div id="round_search_type" class="view_se1">
                <div id="single_search" class="se1">
                    <a class="sp-date_prev prev rollover" style="line-height: 61px;" href="{{route("p_analyse")}}?terms=round&toRound={{$prev}}&from={{$from}}&to={{$to}}" rel="down"><i class="fa fa-angle-left" style="/* font-size:24px */"></i></a>
                    <span id="single_round" class="date">{{$current_round}}</span>
                    <a class="sp-date_next next rollover" style="line-height: 61px;" href="{{route("p_analyse")}}?terms=round&toRound={{$next}}&from={{$from}}&to={{$to}}" rel="up"><i class="fa fa-angle-right" style="/* font-size:24px */"></i></a>
                    <a class="btn_box" href="{{route("p_analyse")}}?terms=round&current=1" rel="current">현재회차</a>
                    <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                        @for($i=1;$i<=288;$i++)
                            <option @if($current_round == $i){{'selected'}} @endif value="{{$i}}">{{$i}}회차</option>
                        @endfor
                    </select>
                </div>
            </div>
            <ul class="switch_tab round_tab">
                <li><a class="selected" href="{{route("psadari_analyse")}}?terms=round" rel="se1">단일회차</a></li>
                <li><a class="" href="{{route("psadari_analyse")}}?terms=roundbox" rel="se2">복수회차</a></li>
                <li><a href="{{route('psadari_analyse')}}?terms=lates&pageType=late">최근회차</a></li>
            </ul>
        </div>
        <div class="date_search_option">
            <div class="dateBox" style="width: 100%">
                <input type="text" name="from" value="{{$from}}" class="dateInput sp-dayspace_bg" id="startDate">
                <div class="bar1">~</div>
                <input type="text" name="to" value="{{$to}}" class="dateInput sp-dayspace_bg" id="endDate">
                <button type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3"><i class="fa fa-search"></i>&nbsp;&nbsp;검색</button>
                <div class="btn-group ml-2" role="group" aria-label="Basic example">
                    <a style="border-top-left-radius: 5px;border-bottom-left-radius:5px" href="/psadari_analyse?terms=round&amp;dateType=7&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==7 || empty(Request::get("dateType"))){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">7일</a>
                    <a href="/psadari_analyse?terms=round&amp;dateType=30&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==30){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">30일</a>
                    <a href="/psadari_analyse?terms=round&amp;dateType=60&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==60){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">60일</a>
                    <a href="/psadari_analyse?terms=round&amp;dateType=150&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==150){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">150일</a>
                    <a style="border-top-right-radius: 5px;border-bottom-right-radius:5px" href="/psadari_analyse?terms=round&amp;dateType=365&toRound={{$current_round}}" class="btn @if(Request::get("dateType") ==365){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">365일</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include("Analyse.psadari.all_analyseTable")
    @include('Analyse/psadari/seeAnalyseTable')
@endsection
