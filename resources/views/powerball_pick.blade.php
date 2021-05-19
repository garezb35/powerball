@extends('includes.empty_header')
@section("header")
@include("pick/pick1")
@endsection

@section("content")
<table  id="powerballLogBox" class="powerballBox table table-bordered table-striped" style="margin-top: 5px;">
    <colgroup>
        <col width="110" />
        <col />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
        <col width="55" />
    </colgroup>
    <tbody>
        <tr>
            <th height="30" colspan="12" class="title pt-2 pb-2 border-top-bora ggray">파워볼게임 픽 내역 (최근 3개월만 보관됩니다.)</th>
        </tr>
        <tr class="subTitle ggray">
            <th class="ggray" rowspan="3" style="height: 60px;">회차</th>
            <th class="ggray" rowspan="3">참여시간</th>
            <th class="ggray" colspan="2" rowspan="2">홀/짝</th>
            <th class="ggray" colspan="2" rowspan="2">언더/오버</th>
            <th class="ggray" rowspan="2">대중소</th>
            <th class="ggray" colspan="5">적중여부</th>
        </tr>
        <tr class="subTitle ggray">
            <th class="ggray" colspan="2">홀/짝</th>
            <th class="ggray" colspan="2">언더/오버</th>
            <th class="ggray">대중소</th>
        </tr>
        <tr class="thirdTitle ggray">
            <th class="ggray" style="height: 40px;">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">파워볼</th>
            <th class="ggray">숫자합</th>
            <th class="ggray">숫자합</th>
        </tr>
        @if(!empty($current_picks))

        @endif
        @foreach ($picks as $pick_item)
            @php
            $pick_content = json_decode($pick_item->content);
            @endphp
        <tr class="trOdd">
            <td height="40" align="center" class="numberText">{{date("m.d",strtotime($pick_item->created_date))}}-{{$pick_item->round}}회</td>
            <td align="center" class="numberText">{{date("m-d H:i",strtotime($pick_item->pick_date))}}</td>
            <td align="center">
                @if(!empty($pick_content->pb_oe))
                    @if($pick_content->pb_oe->pick == "1" )
                        <div class="sp-odd">홀</div>
                    @else
                        <div class="sp-even">짝</div>
                    @endif
                @else
                    -
                @endif

            </td>
            <td align="center">
                @if(!empty($pick_content->nb_oe))
                    @if($pick_content->nb_oe->pick == "1" )
                        <div class="sp-odd">홀</div>
                    @else
                        <div class="sp-even">짝</div>
                    @endif
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->pb_uo))
                    @if($pick_content->pb_uo->pick == "1" )
                        <div class="sp-under"></div>
                    @else
                        <div class="sp-over"></div>
                    @endif
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->nb_uo))
                    @if($pick_content->nb_uo->pick == "1" )
                        <div class="sp-under"></div>
                    @else
                        <div class="sp-over"></div>
                    @endif
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->nb_size))
                    @if($pick_content->nb_size->pick == "1" )
                        <div class="sp-small">소</div>
                    @elseif($pick_content->nb_size->pick == "2" )
                        <div class="sp-middle">중</div>
                    @else
                        <div class="sp-big">대</div>
                    @endif
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->pb_oe))
                <span class="lightgray">
                    @if($pick_content->pb_oe->is_win == "1" )
                        <span class="text-danger font-weight-bold">적중</span>
                    @elseif($pick_content->pb_oe->is_win == "-1" )
                        -
                    @else
                        <span class="lightgray">미적중</span>
                    @endif
                </span>
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->nb_oe))

                    @if($pick_content->nb_oe->is_win == "1" )
                        <span class="text-danger font-weight-bold">적중</span>
                    @elseif($pick_content->nb_oe->is_win == "-1" )
                        -
                    @else
                        <span class="lightgray">미적중</span>
                    @endif

                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->pb_uo))
                    @if($pick_content->pb_uo->is_win == "1" )
                        <span class="text-danger font-weight-bold">적중</span>
                    @elseif($pick_content->pb_uo->is_win == "-1" )
                        -
                    @else
                        <span class="lightgray">미적중</span>
                    @endif
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->nb_uo))

                    @if($pick_content->nb_uo->is_win == "1" )
                        <span class="text-danger font-weight-bold">적중</span>
                    @elseif($pick_content->nb_uo->is_win == "-1" )
                        -
                    @else
                        <span class="lightgray">미적중</span>
                    @endif
                    </span>
                @else
                    -
                @endif
            </td>
            <td align="center">
                @if(!empty($pick_content->nb_size))
                    @if($pick_content->nb_size->is_win == "1" )
                        <span class="text-danger font-weight-bold">적중</span>
                    @elseif($pick_content->nb_size->is_win == "-1" )
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
{{ $picks->links() }}
@endsection
