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
                    <th>결제수단</th>
                    <th>충전코인</th>
                    <th>결제금액</th>
                    <th>일시</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($item))
                @foreach($item as $value)
                    @php
                    $alias= "입금신청";
                    if($value["accept"] == 1)
                        $alias = "입금완료";
                    if($value["accept"] == 2)
                        $alias = "입금거절";
                    @endphp
                    <tr>
                        <td scope="row">{{$first}}</td>
                        <td><span class="text-danger">{{$alias}}</span></td>
                        <td>무통장입금</td>
                        <td>{{number_format($value["coin"])}}</td>
                        <td>{{number_format($value["money"])}}</td>
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
