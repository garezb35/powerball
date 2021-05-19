@php
    $x = array();
    $x[0]=1;
    $x[1]=1;
@endphp
@extends('includes.empty_header')
@section("content")
<div class="marketBox">
    <input type="hidden" id="api_token" value="{{AUth::user()->api_token}}">
    <div class="title">
        <ul>
            <li><a href="{{route("market")}}" target="mainFrame" @if(empty(Request::get("type"))) class="on" @endif>전체</a></li>
            <li><a href="{{route("market")}}?type=item" target="mainFrame" @if(Request::get("type") =="item") class="on" @endif>아이템</a></li>
            <li><a href="{{route("market")}}?type=use" target="mainFrame" @if(Request::get("type") =="use") class="on" @endif>이용권</a></li>

            <li class="right"><a href="/member?type=charge" target="mainFrame">코인충전</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="tit none"><strong>코인</strong> 으로 구매 가능한 아이템입니다.</div>
        <ul class="itemList">
        @if(!empty($item[1]))
            @foreach($item[1] as $key=>$value)
               <x-item :list="$value" :key="$key" coin="코인" head=""/>
            @endforeach
        @endif
        </ul>
		<div class="tit"><strong>도토리</strong> 로 구매 가능한 아이템입니다.</div>
		<ul class="itemList">
            @if(!empty($item[2]))
                @foreach($item[2] as $key=>$value)
                    <x-item :list="$value" :key="$key" coin="개" head="건빵"/>
                @endforeach
            @endif
		</ul>
    </div>
</div>
@endsection
