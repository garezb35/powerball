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
                <th>이전닉네임</th>
                <th>변경닉네임</th>
                <th>변경날짜</th>
                <th>아이피</th>
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
                    <td>{{$parsed_content->old}}</td>
                    <td>{{$parsed_content->new}}</td>
                    <td>{{$parsed_content->date}}</td>
                    <td>{{$value["ip"]}}</td>
                </tr>
                    @php $first-- @endphp
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
