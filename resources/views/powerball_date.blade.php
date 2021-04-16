@extends('includes.empty_header')
@section("header")
    @include('Analyse/analyse-menu')
@endsection
@section("content")
    <div class="mt-2"></div>
    @include("Time.timebox")
    <script>
        var date = "{{$from}}";
    </script>

    <div class="dateInfo">
        <div class="date-box">

            <a href="/p_analyse?terms=date&from={{date('Y-m-d', strtotime('-1 day', strtotime($from)))}}&to={{date('Y-m-d', strtotime('-1 day', strtotime($from)))}}" class="sp-date_prev prev rollover">
                <span class="ic1">이전</span>
            </a>
            <span class="date">{{date("Y.m.d",strtotime($from))}}</span>
            <a href="/p_analyse?terms=date&from={{date('Y-m-d', strtotime('+1 day', strtotime($from)))}}&to={{date('Y-m-d', strtotime('+1 day', strtotime($from)))}}" class="sp-date_next next rollover">
                <span class="ic1">다음</span>
            </a>
            <a href="/p_analyse?terms=date&from={{date("Y-m-d")}}&to={{date("Y-m-d")}}" class="sp-date_today today rollover">오늘</a>
            <input type="text" class="sp-date_cal calendar rollover" id="datepicker" value="{{$from}}">
        </div>
        <div class="btnBox">
            <ul class="switch_tab">
                <li><a class="selected" href="/p_analyse?terms=date">하루씩 보기</a></li>
                <li><a  href="/p_analyse?terms=period&dateType=15">기한으로 보기</a></li>
            </ul>
            <a class="btn_refresh" id="btn_refresh" href="javascript:location.reload();" title="새로고침"><span class="ic"></span><span id="refresh-element">새로고침</span></a>
        </div>
    </div>
    @include('Analyse/patternTerms')
    @include('Analyse/patternAnalyseTable')
    @include('Analyse/roundAnalyseTable')
    @include('Analyse/seeAnalyseTable')
    @include('Analyse/head-info')
    @include('Analyse/chart')
@endsection
