@php
$po = $pu = array();
$po[0]="<div class=\"sp-odd\">홀</div>";
$po[1]="<div class=\"sp-even\">짝</div>";
$pu[0]="<div class='sp-under'></div>";
$pu[1]="<div class='sp-over''></div>";
@endphp
@extends('includes.empty_header')
@section("content")
<ul class="nav nav-pills mb-2" id="powerball-category" role="tablist">
    <li class="nav-item mr-2">
        <a class="nav-link btn-green-gradient btn border-round-none pr-4 pl-4 active" id="powerball-tab" data-toggle="pill" href="#powerball-content" role="tab" aria-controls="powerball-content" aria-selected="true">파워볼</a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn-green-gradient btn border-round-none pr-4 pl-4" id="nb-tab" data-toggle="pill" href="#nb-content" role="tab" aria-controls="nb-content" aria-selected="false">일반볼</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="powerball-content" role="tabpanel" aria-labelledby="pills-home-tab">
        <table class="table table-bordered table-gray table-pad">
            <tbody>
            <tr class="green-back">
                <td colspan="4" class="text-center" width="50%">파워볼</td>
                <td colspan="4" class="text-center" width="50%">파워볼언옵</td>
            </tr>
            <tr>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">AI번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">현재연승</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">다음회차픽</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">AI번호</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">현재연승</span>
                </td>
                <td class="text-center gray_gradient">
                    <span class="font-weight-bold text-secondary">다음회차픽</span>
                </td>
            </tr>
            @if(!empty($pb_oe))
                @for($i = 0 ;$i <50;$i++)
                    <tr>
                        <td class="text-center">{{$i+1}}</td>
                        <td class="text-center">{{$pb_oe[$i]["ai_id"]}}</td>
                        <td class="text-center">{{$pb_oe[$i]["winning_num"]}}</td>
                        <td class="text-center">{!! $po[$pb_oe[$i]["pick"]] !!}</td>
                        <td class="text-center">{{$i+1}}</td>
                        <td class="text-center">{{$pb_uo[$i]["ai_id"]}}</td>
                        <td class="text-center">{{$pb_uo[$i]["winning_num"]}}</td>
                        <td class="text-center">{!! $pu[$pb_uo[$i]["pick"]] !!}</td>
                    </tr>
                @endfor
            @else
                <tr>
                    <td colspan="8" class="text-center">배팅대기중...</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nb-content" role="tabpanel" aria-labelledby="pills-profile-tab">
        <table class="table table-bordered table-gray table-pad">
            <tbody>
                <tr class="green-back">
                    <td colspan="4" class="text-center" width="50%">일반볼</td>
                    <td colspan="4" class="text-center" width="50%">일반볼언옵</td>
                </tr>
                <tr>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">AI번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">현재연승</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">다음회차픽</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">AI번호</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">현재연승</span>
                    </td>
                    <td class="text-center gray_gradient">
                        <span class="font-weight-bold text-secondary">다음회차픽</span>
                    </td>
                </tr>
                @if(!empty($nb_oe))
                    @for($i = 0 ;$i <50;$i++)
                        <tr>
                            <td class="text-center">{{$i+1}}</td>
                            <td class="text-center">{{$nb_oe[$i]["ai_id"]}}</td>
                            <td class="text-center">{{$nb_oe[$i]["winning_num"]}}</td>
                            <td class="text-center">{!! $po[$nb_oe[$i]["pick"]] !!}</td>
                            <td class="text-center">{{$i+1}}</td>
                            <td class="text-center">{{$nb_uo[$i]["ai_id"]}}</td>
                            <td class="text-center">{{$nb_uo[$i]["winning_num"]}}</td>
                            <td class="text-center">{!! $pu[$nb_uo[$i]["pick"]] !!}</td>
                        </tr>
                    @endfor
                @else
                    <tr>
                        <td colspan="8" class="text-center">배팅대기중...</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
