@extends('includes.empty_header')
@section("header")
    @include('Analyse/analyse-menu')
@endsection
@section("content")
    <script>
        var old_date=date = "{{date("Y-m-d")}}";
        var old_round=round = {{$next_round}};
    </script>
    <div class="option_area type2">
        <div class="pattern_area">
            <div class="info">
                <form id="pattern_count" action="" method="get">
                    <input type="hidden" name="type" value="powerball_odd_even">
                    <input type="hidden" name="count" value="10">
                    <a class="btn_date btn_minus" href="javascript:;" rel="down"><span class="ic">패턴추가</span></a>
                    <span class="date tx">10</span>
                    <a class="btn_date btn_plus" href="javascript:;" rel="up"><span class="ic">패턴삭제</span></a>
                </form>
                <a class="btn_refresh" id="btn_refresh" href="javascript:location.reload();" title="새로고침" >
                    <span class="ic fa fa-refresh"></span><span id="refresh-element">새로고침</span>
                </a>
            </div>
        </div>
    </div>
    <div class="">
        <ul class="nav nav-tabs border-bottom-0" id="pattern-sec" role="tablist">
            <li class="nav-item">
                <a href="javascript:void(0)" class="btn btn-jin-green btn-sm pl-3 pr-3 nav-link on1" rel="pb_oe">파워볼 홀/짝</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="btn btn-green btn-sm pl-3 pr-3 nav-link" rel="pb_uo">파워볼 언더/오버</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="btn btn-green btn-sm pl-3 pr-3 nav-link" rel="nb_oe">숫자합 홀/짝</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="btn btn-green btn-sm pl-3 pr-3 nav-link" rel="nb_uo">숫자합 언더/오버</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="btn btn-green btn-sm pl-3 pr-3 nav-link" rel="nb_size">숫자합 대/중/소</a>
            </li>
        </ul>
    </div>
    <div class="pattern_select">
        <div class="tit">
            <span class="t1">패턴수</span>
            <span class="t2">결과</span>
            <span class="t2">회차</span>
        </div>
        <div class="inner">
            <ul id="patternSet">

            </ul>
        </div>
    </div>
    @php
    $title = "패턴별 통계데이터";
    @endphp
    @include("Analyse.patternTerms")
    <table id="patternLogBox" class="patternBox table table-bordered" style="margin-top: 5px;">
        <colgroup>
            <col width="89" />
            <col />
            <col width="91" />
        </colgroup>
        <tbody class="content">
        <tr class="subTitle">
            <td height="40" class="align-middle text-center" width="90px">날짜</td>
            <td class="align-middle text-center">패턴</td>
            <td class="align-middle text-center">다음회차 결과</td>
        </tr>
        <tr>
            <td colspan="3" class="border-none p-0">
                <table class="innerTable table">
                    <tbody id="patternList">

                    </tbody>
                </table>
            </td>
        </tbody>
    </table>
    <div class="displayNone text-center d-none" id="pageDiv" pageval="6" round="1065675" style="display: block;">
        <img src="https://simg.powerballgame.co.kr/images/loading2.gif" width="50" height="50">
    </div>
    <div class="moreBox"><a href="#" onclick="searchPattern(2,date,round);return false;">더보기</a></div>
    @include("Analyse/pattern")
    @include("Analyse/pattern_next")
    @include("Analyse.chart")
@endsection
