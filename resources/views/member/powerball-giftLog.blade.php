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
        <div style="margin-bottom:5px;">
            <a href="/member?type=giftLog&giftType=give" class="b">■ 선물한 내역</a> &nbsp;
            <a href="/member?type=giftLog&giftType=take" class="">■ 선물 받은 내역</a>
        </div>
        <table class="table logBox table-bordered">
            <thead>
            <tr class="title">
                <th>번호</th>
                <th>선물종류</th>
                <th>{{$alias}}</th>
                <th>수량</th>
                <th>일시</th>
            </tr>
            </thead>
            <tbody>
                @if(!empty($item))
                @foreach($item as $value)
                    @php
                        if(empty($value[$self]["nickname"])) continue;
                        $parsed_content = json_decode($value["content"]);
                    @endphp
                    <tr>
                        <td scope="row">{{$first}}</td>
                        <td>{{$parsed_content->type}}</td>
                        <td>{{$value[$self]["nickname"]}}</td>
                        <td>{{$parsed_content->count}}</td>
                        <td>{{$value["created_at"]}}</td>
                    </tr>
                    @php $first--; @endphp
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
