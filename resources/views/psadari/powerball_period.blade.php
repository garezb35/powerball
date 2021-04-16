@extends('includes.empty_header')
@section("header")
    @include('Analyse/psadari/analyse-menu')
@endsection
@section("content")
    <div class="mt-2"></div>
    @include("Time.timebox")
    <script>
        var from = "{{$from}}";
        var to = "{{$to}}";
    </script>
    <div class="periodBox" style="border-bottom: none">
        <div class="dateBox">
            <span class="from-date float-left ml-4">{{$from}}</span>
            <div class="bar">~</div>
            <span class="to-date">{{$to}}</span>
            <span class="period-date">({{$diff}}일간)</span>
        </div>
        <div class="btnBox">
            <ul class="switch_tab">
                <li><a  href="/psadari_analyse?terms=date">하루씩 보기</a></li>
                <li><a class="selected" href="/psadari_analyse?terms=period&dateType=15">기한으로 보기</a></li>
            </ul>
            <a class="btn_refresh" id="btn_refresh" href="javascript:location.reload();" title="새로고침"><span class="ic"></span><span id="refresh-element">새로고침</span></a>
        </div>
    </div>
    <div class="periodBox">
        <div class="dateBox">
            {!! Form::open(['action' =>'App\Http\Controllers\PowerSadariController@view', 'method' => 'get']) !!}
            <input type="hidden" name="terms" value="period">
            <input type="text" name="from" value="{{$from}}" class="dateInput sp-dayspace_bg " id="startDate"/>
            <div class="bar1">~</div>
            <input type="text" name="to" value="{{$to}}" class="dateInput sp-dayspace_bg " id="endDate"/>
            <input type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3" value="검색">
            {!! Form::close() !!}
        </div>

        <div class="btnBox">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/psadari_analyse?terms=period&dateType=2" class="btn @if(Request::get("dateType") ==2){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">2일</a>
                <a href="/psadari_analyse?terms=period&dateType=4" class="btn @if(Request::get("dateType") ==4){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">4일</a>
                <a href="/psadari_analyse?terms=period&dateType=7" class="btn @if(Request::get("dateType") ==7){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">7일</a>
                <a href="/psadari_analyse?terms=period&dateType=15" class="btn @if(Request::get("dateType") ==15 || (empty(Request::get("dateType")) && empty(Request::get("from")))){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">15일</a>
                <a href="/psadari_analyse?terms=period&dateType=30" class="btn @if(Request::get("dateType") ==30){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">한달</a>
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
