@extends('includes.empty_header')
@section("header")
    @include('Analyse/psadari/analyse-menu')
    <script>
        var limit = {{$limit}};
    </script>
    @if(Request::get("pageType") =="display")
    <div id="powerballMiniViewDiv" class="mb-2">
        @include('powerballSadariMiniview')
    </div>
    @endif
    @if(Request::get("pageType") =="late")
    <div class="mt-2"></div>
    @include("Time.timebox")
    <div class="round_area" style="height: 63px;
    margin-top: 8px;
    margin-bottom: 10px;">
        <div class="view_se1">
            <div id="single_search" class="se1">
                <a class="sp-date_prev prev rollover" href="{{route("p_analyse")}}?terms=lates&pageType=late&limit={{$prev}}" rel="down"><span class="ic">이전</span></a>
                <span id="single_round" class="date">{{$limit}}</span>
                <a class="sp-date_next next rollover" href="{{route("p_analyse")}}?terms=lates&pageType=late&limit={{$next}}" rel="up"><span class="ic">다음</span></a>
                <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                    @for ($i = 50; $i <= 2000; $i+=50)
                        <option value="{{$i}}" @if ($i ==$limit) selected @endif>{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <ul class="switch_tab round_tab">
            <li><a  href="{{route("p_analyse")}}?terms=round" rel="se1">단일회차</a></li>
            <li><a class="" href="{{route("p_analyse")}}?terms=roundbox" rel="se2">복수회차</a></li>
            <li><a class="selected" href="{{route('p_analyse')}}?terms=lates&pageType=late">최근회차</a></li>
        </ul>
    </div>
    @endif
    @include('Analyse/psadari/patternAnalyseTable')
    @include('Analyse/psadari/patternTerms')
    @include('Analyse/psadari/seeAnalyseTable')
    @include('Analyse/psadari/head-info')
    @include('Analyse/psadari/chart')
@endsection
