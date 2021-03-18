@extends('includes.empty_header')

@section("header")
    @include('member/member-menu')
@endsection
@section("content")
    <div class="content">
        <div style="margin-bottom:5px;">
            <a href="https://www.powerballgame.co.kr?view=mypage&amp;type=giftLog&amp;giftType=give" class="b">■ 선물한 내역</a> &nbsp;
            <a href="https://www.powerballgame.co.kr?view=mypage&amp;type=giftLog&amp;giftType=take" class="">■ 선물 받은 내역</a>
        </div>
        <table class="table logBox">
            <thead>
            <tr class="title">
                <th>번호</th>
                <th>선물종류</th>
                <th>선물 받은 회원</th>
                <th>수량</th>
                <th>일시</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td scope="row">2</td>
                <td>총알</td>
                <td>독고다이소나타</td>
                <td>10</td>
                <td>2021-02-12 17:58:15</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
