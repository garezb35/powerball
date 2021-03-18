@extends('includes.empty_header')
@section("header")
    @include('Analyse/analyse-menu')
@endsection
@section("content")
<script>
    var from = "{{$from}}";
    var to = "{{$to}}";
    var from_round = "{{$from_round}}";
    var to_round = "{{$to_round}}";
    var pb_type = "{{$mode}}";
</script>
<div class="mt-2"></div>
@include("Time.timebox")
<div class="mb-2"></div>
<div class="round_area">
    {!! Form::open(['action' =>'App\Http\Controllers\PowerballController@view', 'method' => 'get',"id"=>"round_form"]) !!}
    <input type="hidden" name="terms" value="roundbox">
    <div class="info">
        <div id="round_search_type" class="view_se1">
            <div id="single_search" class="se1 pl-3">
                <select id="single_from_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="fromRound">
                    @for($i=1;$i<=288;$i++)
                        <option @if($from_round == $i){{'selected'}} @endif value="{{$i}}">{{$i}}회차</option>
                    @endfor
                </select>
                <span class="dash">~</span>
                <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                    @for($i=1;$i<=288;$i++)
                        <option @if($to_round == $i){{'selected'}} @endif value="{{$i}}">{{$i}}회차</option>
                    @endfor
                </select>
                <select name="mode" id="mode" class="selectbox">
                    <option value="pb_oe" @if($mode =="pb_oe"){{'selected'}}@endif>파워볼 홀/짝</option>
                    <option value="pb_uo" @if($mode =="pb_uo"){{'selected'}}@endif>파워볼 언/오</option>
                    <option value="nb_oe" @if($mode =="nb_oe"){{'selected'}}@endif>일반볼합 홀/짝</option>
                    <option value="nb_uo" @if($mode =="nb_uo"){{'selected'}}@endif>일반볼합 언/오</option>
                </select>
            </div>
        </div>
        <ul class="switch_tab round_tab">
            <li><a href="{{route("p_analyse")}}?terms=round" rel="se1">단일회차</a></li>
            <li><a class="selected" href="{{route("p_analyse")}}?terms=roundbox" rel="se2">복수회차</a></li>
            <li><a href="{{route('p_analyse')}}?terms=lates&pageType=late">최근회차</a></li>
        </ul>
    </div>
    <div class="date_search_option">
        <div class="dateBox">
            <input type="text" name="from" value="{{$from}}" class="dateInput sp-dayspace_bg" id="startDate">
            <div class="bar1">~</div>
            <input type="text" name="to" value="{{$to}}" class="dateInput sp-dayspace_bg" id="endDate">
            <input type="submit" class="btn-jin-green btn btn-sm ml-2 pl-3 pr-3" value="검색">
        </div>
        <div class="btnBox">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/p_analyse?terms=roundbox&amp;dateType=2&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==2){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">2일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=4&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==4){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">4일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=7&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==7){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">7일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=15&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==15){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">15일</a>
                <a href="/p_analyse?terms=roundbox&amp;dateType=30&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==30){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">한달</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>
<div class="list_opt">
    <ul id="filter-btns" class="filter_btn_area mb-0">
        <li><a type="button" value="" class="selected">전체</a></li>
        <li><a type="button" value="sp-odd">홀강조</a></li>
        <li><a type="button" value="sp-even" class="">짝강조</a></li>
    </ul>
</div>
    <div style="width: 100%;overflow-x: scroll">
        <table class="table powerballBox mt-2">
            <thead class="border-jinblue jin-gradient">
            <tr>
                <th colspan="{{$to_round-$from_round+2}}" height="30">{{$title}}</th>
            </tr>
            </thead>
            <tbody class="roundbox-body"></tbody>
        </table>
    </div>
    @include("Analyse/roundbox")
@endsection
