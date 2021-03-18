@extends('includes.empty_header')
@section("content")
<link rel="stylesheet" href="/assets/css/speedkeno.css">
<div style="width:830px;">
    <table  class="defaultTable table">
        <colgroup>
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
            <col width="20%">
        </colgroup>
        <tbody>
            <tr>
                <th class="menu on"><a href="/?view=speedkeno" class="tab1 on">스피드키노</a></th>
                <th class="menu none"><a href="#" onclick="return false;" class="tab2"></a></th>
                <th class="menu none"><a href="#" onclick="return false;" class="tab3"></a></th>
                <th class="menu none"><a href="#" onclick="return false;" class="tab4"></a></th>
                <th class="menu none"><a href="#" onclick="return false;" class="tab5"></a></th>
            </tr>
        </tbody>
    </table>
    <div id="guideBox">
        <div class="tit">스피드키노</div>
        <ul>
            <li class="first">본 게임은 <strong>동행복권의 스피드키노 게임을 기준</strong>으로 합니다.</li>
            <li>숫자합 마지막자리 홀짝 : 총 결과 숫자들의 합의 마지막자리 홀짝</li>
            <li>숫자합 마지막자리 언더오버 : 총 결과 숫자들의 합의 마지막자리 언더오버(4.5기준)</li>
        </ul>
    </div>
    <div class="speedkenoBox">
        <iframe src="http://ntry.com/scores/speedkeno/live.php" width="830" height="641" scrolling="no" frameborder="0"></iframe>
    </div>
    <div class="bannerArea" style="margin:5px 0;">
        <div style="display:inline-block;width:728px;height:90px;">
            <a href="http://qootoon.com/f5c1ec10" target="_blank">
                <img src="https://simg.powerballgame.co.kr/ad/toptoon_728_90_3.jpg">
            </a>
        </div>
        <a href="#" onclick="toggleBetting();return false;" style="float:right;">
            <img src="https://simg.powerballgame.co.kr/images/btn_pointbet_open.png?1" width="97" height="90" id="pointBetBtn">
        </a>
    </div>
    <div class="speed_iframe" style="display:none">
    @include("pick/pick2")
    </div>
    @include('Analyse/speedkeno')
    <div class="displayNone text-center d-none" id="pageDiv" pageval="6" round="1065675">
        <img src="https://simg.powerballgame.co.kr/images/loading2.gif" width="50" height="50">
    </div>
    <div class="moreBox"><a href="#" onclick="moreClick();return false;">더보기</a></div>
</div>
@endsection
