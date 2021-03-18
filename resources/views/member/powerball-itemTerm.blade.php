@extends('includes.empty_header')

@section("header")
    @include('member/member-menu')
@endsection
@section("content")
    <div class="content">
        <table class="table logBox">
            <thead>
            <tr class="title">
                <th>번호</th>
                <th>아이템명</th>
                <th>만료일</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td scope="row">2</td>
                <td>슈퍼채팅 이용권</td>
                <td>2021-02-12 17:58:15</td>
            </tr>
            <tr>
                <td scope="row">1</td>
                <td>프리미엄 분석기</td>
                <td>2020-11-28 14:27:20</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
