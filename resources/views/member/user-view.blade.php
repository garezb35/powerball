@extends('includes.empty_header')
@section("header")
@endsection
@section("content")
<div class="categoryTit">
  <ul>
    <li><a href="/user-view?type=agree" <?=Request::get("type") == "agree" ? 'class="on"':''?>>이용약관</a></li>
    <li><a href="/user-view?type=privacy" <?=Request::get("type") == "privacy" ? 'class="on"':''?>>개인정보처리방침</a></li>
    <li><a href="/user-view?type=youth" <?=Request::get("type") == "youth" ? 'class="on"':''?>>청소년보호정책</a></li>
    <li style="width:150px"><a href="/user-view?type=rejectemail" <?=Request::get("type") == "rejectemail" ? 'class="on"':''?>>이메일주소무단수집거부</a></li>
  </ul>
</div>
<div class="tbl_head01 tbl_wrap">
  {!!$page["content"] !!}
</div>
@endsection
