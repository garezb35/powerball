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
                    <th>상태</th>
                    <th>아이템명</th>
                    <th>수량</th>
                    <th>총금액</th>
                    <th>일시</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">2</td>
                    <td><span class="text-primary">사용</span></td>
                    <td>랜덤 아이템 상자</td>
                    <td>1</td>
                    <td>10,000</td>
                    <td>2021-02-17 14:22:53</td>
                </tr>
                <tr>
                    <td scope="row">1</td>
                    <td><span class="text-danger">구매</span></td>
                    <td>총알 10개</td>
                    <td>4</td>
                    <td>40,000</td>
                    <td>2021-02-04 16:02:40</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
