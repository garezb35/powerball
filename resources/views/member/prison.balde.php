@extends('includes.empty_header')

@section("content")
<div class="categoryTit">
    <ul>
      <li><a href="{{"board"}}?board_type=customer&board_category=notice" @if(Request::get("board_category") == "notice") class="on" @endif>공지사항</a></li>
      <li><a href="{{"board"}}?board_type=customer&board_category=event" @if(Request::get("board_category") == "event") class="on" @endif>이벤트</a></li>
      <li><a href="#">정지</a></li>
    </ul>
</div>
@endsection
