@extends('includes.empty_header')
@section("header")
    @include('Analyse/psadari/analyse-menu')
@endsection
@section("content")
{{--    <div class="mt-2"></div>--}}
{{--    @include("Time.timebox")--}}
    <script>
        var from = "{{$from}}";
        var to = "{{$to}}";
    </script>
    <div class="periodBox" style="border-bottom: none">
        <div class="dateBox" style="width: 80%">
            <span class="from-date float-left">{{$from}}</span>
            <div class="bar">~</div>
            <span class="to-date">{{$to}}</span>
            <span class="period-date">({{$diff}}일간)</span>
            <span>
                <ul class="switch_tab">
                    <li><a href="/psadari_analyse?terms=date" style="margin-top: 5px">하루씩 보기</a></li>
                    <li><a class="selected" href="/psadari_analyse?terms=period&amp;dateType=7" style="margin-top: 5px">기한으로 보기</a></li>
                </ul>
            </span>
        </div>
        <div class="btnBox" style="width: 20%">
            <a  class="btn_refresh" id="btn_refresh" href="javascript:location.reload();" title="새로고침">
                <span class="ic fa fa-refresh"></span><span id="refresh-element">새로고침</span>
            </a>
        </div>
    </div>
    <div class="periodBox" style="padding-bottom: 20px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
        <div class="dateBox" style="width: 100%">
            {!! Form::open(['action' =>'App\Http\Controllers\PowerSadariController@view', 'method' => 'get']) !!}
            <input type="hidden" name="terms" value="period">
            <input type="text" name="from" value="{{$from}}" class="dateInput sp-dayspace_bg " id="startDate"/>
            <div class="bar1">~</div>
            <input type="text" name="to" value="{{$to}}" class="dateInput sp-dayspace_bg " id="endDate"/>
            <input type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3" value="검색">
            {!! Form::close() !!}
            <div class="btn-group ml-2" role="group" aria-label="Basic example">
                <a style="border-top-left-radius: 5px;border-bottom-left-radius: 5px" href="/psadari_analyse?terms=period&dateType=7" class="btn @if(Request::get("dateType") ==7 || (empty(Request::get("dateType")) && empty(Request::get("from")))){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">7일</a>
                <a href="/psadari_analyse?terms=period&dateType=30" class="btn @if(Request::get("dateType") ==30){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">30일</a>
                <a href="/psadari_analyse?terms=period&dateType=60" class="btn @if(Request::get("dateType") ==60){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">60일</a>
                <a href="/psadari_analyse?terms=period&dateType=150" class="btn @if(Request::get("dateType") ==150){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">150일</a>
                <a style="border-top-right-radius: 5px;border-bottom-right-radius: 5px" href="/psadari_analyse?terms=period&dateType=365" class="btn @if(Request::get("dateType") ==365){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">365일</a>
            </div>
        </div>
    </div>

    <div style="margin-top: 10px"></div>
    <div class="mt-4"></div>
    @include('Analyse/psadari/patternTerms')
    @include('Analyse/psadari/maxminAnalyse')
    <table  id="ladderLogBox" class="powerballBox table table-bordered mt-1">
        <thead>
        <tr class="thirdTitle">
            <th class="p-2"></th>
            <th class="p-2">좌</th>
            <th class="p-2">우</th>
            <th class="p-2">3개</th>
            <th class="p-2">4개</th>
            <th class="p-2">홀</th>
            <th class="p-2">짝</th>
            <th class="p-2">좌4홀</th>
            <th class="p-2">우3홀</th>
            <th class="p-2">좌3짝</th>
            <th class="p-2">우4짝</th>
        </tr>
        </thead>
        <tbody class = "minmaxday-t">
        </tbody>
    </table>
    @include("Analyse/psadari/maxminDay")
    @include('Analyse/psadari/chart')
@endsection
