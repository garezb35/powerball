@extends('includes.empty_header')
@section("header")
<table width="100%" border="0" class="defaultTable">
    <colgroup>
        <col width="50%">
        <col width="50%">
    </colgroup>
	<tbody>
        <tr>
			<th class="menu"><a href="{{ route('pick-powerball') }}" >파워볼게임</a></th>
			<th class="menu on"><a href="{{ route('pick-speedkeno') }}" class="on">스피드키노</a></th>
		</tr>
	</tbody>
</table>
@include("pick/pick2")
@endsection
@section("content")
<table  id="powerballLogBox" class="powerballBox table table-bordered table-striped" style="margin-top: 5px;">
    <colgroup>
        <col width="110">
        <col>
        <col width="110">
        <col width="110">
        <col width="110">
        <col width="110">
    </colgroup>
    <tbody>
        <tr>
            <th height="30" colspan="6" class="title">스피드키노 픽 내역 (최근 3개월만 보관됩니다.)</th>
        </tr>
        <tr class="subTitle">
            <th rowspan="3" style="height: 60px;">회차</th>
            <th rowspan="3">참여시간</th>
            <th colspan="2" rowspan="2">숫자합 마지막자리</th>
            <th colspan="2">적중여부</th>
        </tr>
        <tr class="subTitle">
            <th colspan="2">숫자합 마지막자리</th>
        </tr>
        <tr class="thirdTitle">
            <th style="height: 40px;">홀짝</th>
            <th>언더오버</th>
            <th>홀짝</th>
            <th>언더오버</th>
        </tr>
        @foreach ($picks as $pick_item)
            @php
                $pick_content = json_decode($pick_item->content);
            @endphp
            <tr class="trEven">
                <td height="40" align="center" class="numberText">{{date("m.d",strtotime($pick_item->created_date))}}-{{$pick_item->round}}회</td>
                <td align="center" class="numberText">{{date("m-d H:i",strtotime($pick_item->pick_date))}}</td>
                <td align="center">
                    @if(!empty($pick_content->speed_oe))
                        @if($pick_content->speed_oe->pick == "1" )
                            <img src="https://simg.powerballgame.co.kr/images/odd.png" width="29" height="29" />
                        @else
                            <img src="https://simg.powerballgame.co.kr/images/even.png" width="29" height="29" />
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td align="center">
                    @if(!empty($pick_content->speed_uo))
                        @if($pick_content->speed_uo->pick == "1" )
                            <img src="https://simg.powerballgame.co.kr/images/under.png" width="29" height="29" />
                        @else
                            <img src="https://simg.powerballgame.co.kr/images/over.png" width="29" height="29" />
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td align="center">
                    @if(!empty($pick_content->speed_oe))

                        @if($pick_content->speed_oe->is_win == "1" )
                            <span class="text-danger font-weight-bold">적중</span>
                        @elseif($pick_content->speed_oe->is_win == "-1" )
                            -
                        @else
                            <span class="lightgray">미적중</span>
                        @endif

                    @else
                        -
                    @endif
                </td>
                <td align="center">
                    @if(!empty($pick_content->speed_uo))

                        @if($pick_content->speed_uo->is_win == "1" )
                            <span class="text-danger font-weight-bold">적중</span>
                        @elseif($pick_content->speed_uo->is_win == "-1" )
                            -
                        @else
                            <span class="lightgray">미적중</span>
                        @endif

                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
