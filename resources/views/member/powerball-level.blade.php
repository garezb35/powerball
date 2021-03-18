@extends('includes.empty_header')

@section("header")
    @include('member/member-menu')
@endsection
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
                        <img src="{{$value["value3"]}}" width="23" height="23" alt="" class="@if($value["code"] != $user_level)grayscale @endif">
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
            <table class="table logBox">
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
                    <tr>
                        <td scope="row">1</td>
                        <td>10</td>
                        <td>2021-02-22 첫 로그인 경험치 지급</td>
                        <td>2021-02-22 02:46:47</td>
                        <td>61.75.61.129</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
