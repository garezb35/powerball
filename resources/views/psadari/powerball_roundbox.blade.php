@extends('includes.empty_header')
@section("header")
    @include('Analyse/psadari/analyse-menu')
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
        {!! Form::open(['action' =>'App\Http\Controllers\PowerSadariController@view', 'method' => 'get',"id"=>"round_form"]) !!}
        <input type="hidden" name="terms" value="roundbox">
        <div class="info">
            <div id="round_search_type" class="view_se1">
                <div id="single_search" class="se1 pl-2">
                    <select id="single_from_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="fromRound">
                        @for($i=1;$i<=288;$i++)
                            <option @if($from_round == $i){{'selected'}} @endif value="{{$i}}">{{$i}}회차</option>
                        @endfor
                    </select>
                    <select id="single_to_round" class="selectbox" title="회차" onchange="$('#round_form').submit();" name="toRound">
                        @for($i=1;$i<=288;$i++)
                            <option @if($to_round == $i){{'selected'}} @endif value="{{$i}}">{{$i}}회차</option>
                        @endfor
                    </select>
                    <select name="mode" id="mode" class="selectbox">
                        <option value="odd_even" @if($mode =="odd_even"){{'selected'}}@endif>홀/짝</option>
                        <option value="three_four" @if($mode =="three_four"){{'selected'}}@endif>3/4</option>
                        <option value="left_right" @if($mode =="left_right"){{'selected'}}@endif>좌/우</option>
                        <option value="total" @if($mode =="total"){{'selected'}}@endif>출줅</option>
                    </select>
                </div>
            </div>
            <ul class="switch_tab round_tab">
                <li><a href="{{route("psadari_analyse")}}?terms=round" rel="se1">단일회차</a></li>
                <li><a class="selected" href="{{route("psadari_analyse")}}?terms=roundbox" rel="se2">복수회차</a></li>
                <li><a href="{{route('psadari_analyse')}}?terms=lates&pageType=late">최근회차</a></li>
            </ul>
        </div>
        <div class="date_search_option pl-3">
            <div class="dateBox" style="width: 100%">
                <input type="text" name="from" value="{{$from}}" class="dateInput sp-dayspace_bg" id="startDate">
                <div class="bar1">~</div>
                <input type="text" name="to" value="{{$to}}" class="dateInput sp-dayspace_bg" id="endDate">
                <button type="submit" class="btn-jin-greenoutline btn btn-sm ml-2 pl-3 pr-3"><i class="fa fa-search"></i>&nbsp;&nbsp;검색</button>
                <div class="btn-group ml-2" role="group" aria-label="Basic example">
                    <a style="border-top-left-radius: 5px;border-bottom-left-radius:5px" href="/psadari_analyse?terms=roundbox&amp;dateType=7&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==7 || empty(Request::get("dateType"))){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">7일</a>
                    <a href="/psadari_analyse?terms=roundbox&amp;dateType=30&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==30){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">30일</a>
                    <a href="/psadari_analyse?terms=roundbox&amp;dateType=60&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==60){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">60일</a>
                    <a href="/psadari_analyse?terms=roundbox&amp;dateType=150&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==150){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">150일</a>
                    <a style="border-top-right-radius: 5px;border-bottom-right-radius:5px" href="/psadari_analyse?terms=roundbox&amp;dateType=365&toRound={{$to_round}}&fromRound={{$from_round}}&mode={{$mode}}" class="btn @if(Request::get("dateType") ==365){{'btn-jin-green'}}@else{{'btn-green'}}@endif btn-sm pl-3 pr-3">365일</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <div class="list_opt">
        <ul id="filter-btns" class="filter_btn_area mb-0">
            <li><a type="button" value="" class="selected">전체</a></li>
            @if($mode == "odd_even")
                <li><a type="button" value="sp-odd">홀강조</a></li>
                <li><a type="button" value="sp-even" class="">짝강조</a></li>
            @endif
            @if($mode == "left_right")
                <li><a type="button" value="sp-odd">좌강조</a></li>
                <li><a type="button" value="sp-even" class="">우강조</a></li>
            @endif
            @if($mode == "three_four")
                <li><a type="button" value="sp-odd">3강조</a></li>
                <li><a type="button" value="sp-even" class="">4강조</a></li>
            @endif
            @if($mode == "total")
                <li><a type="button" value="sp-odd1">좌3짝강조</a></li>
                <li><a type="button" value="sp-odd2" class="">좌4홀강조</a></li>
                <li><a type="button" value="sp-odd3" class="">우3홀강조</a></li>
                <li><a type="button" value="sp-odd4" class="">우4짝강조</a></li>
            @endif
        </ul>
    </div>
    <div style="width: 100%;overflow-x: scroll;padding-top:15px">
        <h5 class="text-center">{{$title}}<div class="half-label" style="width: 608px"></div></h5>
        <table class="table powerballBox mt-2 table-bordered">
            <tbody class="roundbox-body"></tbody>
        </table>
    </div>
    </div>
    @include("Analyse/psadari/roundbox")
@endsection
