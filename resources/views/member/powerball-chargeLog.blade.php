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
                    <th>상태	</th>
                    <th>결제수단</th>
                    <th>충전코인</th>
                    <th>결제금액</th>
                    <th>일시</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">2</td>
                    <td><span class="text-danger">입금완료</span></td>
                    <td>무통장입금</td>
                    <td>30,000</td>
                    <td>33,000</td>
                    <td>2021-02-12 17:58:15</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
