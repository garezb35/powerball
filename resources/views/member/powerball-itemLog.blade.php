@extends('includes.empty_header')
@section("header")
    @include('member/member-menu')
@endsection
@php

    $page =  Request::get("page") ?? 1;
    $first = $count - ($page-1) * 10;

@endphp
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
            @if(!empty($item))
                @foreach($item as $value)
                    @php
                    $parsed_content = json_decode($value["content"]);
                    @endphp
                    <tr>
                        <td scope="row">{{$first}}</td>
                        <td><span class="text-@if($parsed_content->class == "use"){{"danger"}}@else{{"primary"}}@endif">{{$parsed_content->use}}</span></td>
                        <td>{{$parsed_content->name}}</td>
                        <td>{{$parsed_content->count}}</td>
                        <td>{{$parsed_content->price}}</td>
                        <td>{{$value["created_at"]}}</td>
                    </tr>
                    @php $first--; @endphp
                @endforeach
            @endif
            </tbody>
        </table>
        {{$item->links()}}
    </div>
@endsection
