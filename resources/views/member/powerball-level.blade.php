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
        <div class="exp-box">
            <span class="text">나의경험치</span><span class="exp">{{$user_exp}}</span><span class="ea">EXP</span>
        </div>
        <div class="box-level">
            <ul>
                @if(!empty($level_list))
                    @foreach($level_list as $value)

                <li @if($value["code"] == $user_level)on @endif>
                    <div>
                        <img src="{{$value["value3"]}}" width="30" height="30" alt="" class="@if($value["code"] != $user_level)grayscale @endif">
                        <p>{!! $value["description"] !!}</p>
                        <span class="text" style="display: @if($value["code"] == $user_level)block @else none @endif">
                            <b>{{$value["value1"]}}</b> EXP
                            <span class="ar"></span>
                        </span>
                    </div>
                </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div>
            <table class="table logBox table-bordered">
                <thead>
                    <tr class="title">
                        <th>번호</th>
                        <th>EXP</th>
                        <th>내용</th>
                        <th>일시</th>
                        <th>아이피</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($items))
                @foreach($items as $value)
                    @php
                        $parsed_content = json_decode($value["content"]);
                    @endphp
                <tr>
                    <td scope="row">{{$first}}</td>
                    <td>{{$parsed_content->exp}}</td>
                    <td>{{$parsed_content->msg}}</td>
                    <td>{{$value["created_at"]}}</td>
                    <td>{{$value["ip"]}}</td>
                </tr>
                    @php $first--; @endphp
                @endforeach
                @endif
                </tbody>
            </table>
            {{$items->links()}}
        </div>
    </div>
@endsection
