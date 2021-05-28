@extends('includes.empty_header')

@section("header")
    @include('member/member-menu')
@endsection
@section("content")
    <div class="content">
        <input type="hidden" id="api_token" value="{{$api_token}}">
        <ul class="itemList">
            @if(!empty($pur_item))
                @foreach($pur_item as $item)
                    @php
                    if(empty($item->items->image))
                        continue;
                    @endphp

                <li>
                    <img src="{{$item->items->image}}" width="115" height="115">
                    <div class="name">{{$item->items->name}}</div>
                    <div class="amountSet">
                        <input type="text" name="{{$item->items->code}}" value="{{$item["count"]}}개" rel="{{$item["count"]}}" limit="{{$item["count"]}}" style="ime-mode:disabled;" onkeydown="return isNumber(event);" onblur="countChk(this);">
                        <span class="up" rel="item"></span>
                        <span class="down" rel="item"></span>
                    </div>
                    <div class="btns">
                        <a href="#" class="btn_use btn-danger btn-sm btn" itemcode="{{$item->items->code}}" title="{{$item->items->name}}" period="{{$item->items->period}}">사용</a>
                    </div>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection
