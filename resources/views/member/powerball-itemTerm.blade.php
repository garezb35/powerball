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
                <th>아이템명</th>
                <th>만료일</th>
            </tr>
            </thead>
            <tbody>
            @foreach($item as $value)
                @php
                if(empty($value["item"]["name"])) continue;
                @endphp
                <tr>
                    <td scope="row">{{$first}}</td>
                    <td>{{$value["item"]["name"]}}</td>
                    <td>{{$value["terms2"]}}</td>
                </tr>
                @php $first--; @endphp
            @endforeach
            </tbody>
        </table>
        {{$item->links()}}
    </div>
@endsection
