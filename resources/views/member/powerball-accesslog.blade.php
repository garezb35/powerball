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
                </tr>
            </thead>
            <tbody>
                @foreach($loginlog as $log)
                    <tr>
                        <td>{{$log["id"]}}</td>
                        <td>{{$log["created_at"]}}</td>
                        <td>{{$log["ip"]}}</td>
                        <td>@if($log["machine"] == 1){{'PC'}}@else{{"mobile"}}@endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$loginlog->links()}}
    </div>
@endsection
