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
                <th>이전닉네임</th>
                <th>변경닉네임</th>
                <th>변경날짜</th>
                <th>아이피</th>
                <th>관리</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">2</td>
                    <td>테스트</td>
                    <td>파워볼</td>
                    <td>2021-02-12</td>
                    <td>43.45.23.233</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
