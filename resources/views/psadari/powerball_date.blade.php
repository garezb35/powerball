@extends('includes.empty_header')
@section("header")
    @include('Analyse/psadari/analyse-menu')
@endsection
@section("content")
<script>
    var date = "{{$from}}";
</script>

<div class="dateInfo">
    <div class="date-box pl-2" style="width: 80%">
        <a href="/psadari_analyse?terms=date&from={{date('Y-m-d', strtotime('-1 day', strtotime($from)))}}&to={{date('Y-m-d', strtotime('-1 day', strtotime($from)))}}" class="sp-date_prev prev rollover">
            <i class="fa fa-angle-left"></i>
        </a>
        <span class="date">{{date("Y.m.d",strtotime($from))}}</span>
        <a href="/psadari_analyse?terms=date&from={{date('Y-m-d', strtotime('+1 day', strtotime($from)))}}&to={{date('Y-m-d', strtotime('+1 day', strtotime($from)))}}" class="sp-date_next next rollover">
            <i class="fa fa-angle-right"></i>
        </a>
        <a href="/psadari_analyse?terms=date&from={{date("Y-m-d")}}&to={{date("Y-m-d")}}" class="sp-date_today today rollover">오늘</a>
        <input type="text" class="sp-date_cal calendar rollover" id="datepicker" value="{{$from}}">
        <span style="margin-left: 40px">
            <ul class="switch_tab" >
                <li><a class="selected" href="/psadari_analyse?terms=date">하루씩 보기</a></li>
                <li><a  href="/psadari_analyse?terms=period&dateType=15">기한으로 보기</a></li>
            </ul>
        </span>
    </div>
    <div class="btnBox" style="width: 19%;float: left;">
        <a class="btn_refresh" id="btn_refresh" href="javascript:location.reload();" title="새로고침"><span class="ic"></span><span id="refresh-element">새로고침</span></a>
    </div>
</div>
@include('Analyse/psadari/patternAnalyseTable')
@include('Analyse/psadari/patternTerms')
@include('Analyse/psadari/roundAnalyseTable')
@include('Analyse/psadari/seeAnalyseTable')
@include('Analyse/psadari/head-info')
@include('Analyse/psadari/chart')
@endsection
