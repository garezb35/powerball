@extends('includes.empty_header')

@section("header")
    @include('member/member-menu')
@endsection
@section("content")
    <div class="content">
        <table class="table logBox table-bordered">
            <thead>
                <tr class="title">
                    <th>번호</th>
                    <th>접속일시</th>
                    <th>접속IP</th>
                    <th>접속기기</th>
                    <th>결과</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">2</td>
                    <td>2021-02-22 17:47:33</td>
                    <td>169.56.74.227</td>
                    <td>PC</td>
                    <td>성공</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
