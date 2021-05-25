@extends('includes.empty_header')
@section("content")
    <div class="memoBox">
        @include("member.memo-memu")
        <div class="content">
            <div class="top">
                <a href="#" onclick="memoDel();return false;">
                    <img src="/assets/images/powerball/btn_del_off.png" width="48" height="24">
                </a>
                <span class="cnt"><span>{{$result["not_read"]}}</span> / {{sizeof($result["list"])}}</span>
            </div>
            <form name="memoForm">
                @csrf
                <input type="hidden" name="mtype" value="save" />
                <table class="table-mail">
                    @if($result["type"] != "send")
                        <colgroup>
                            <col width="6%">
                            <col width="24%">
                            <col>
                            <col width="20%">
                        </colgroup>
                    @else
                        <colgroup>
                            <col width="6%">
                            <col width="24%">
                            <col>
                            <col width="15%">
                            <col width="15%">`
                        </colgroup>
                    @endif
                    <tbody>
                    <tr>
                        <th><input type="checkbox" onclick="checkAll(this.checked);"></th>
                        @foreach($result["menu"] as $menu)
                            <th>{{$menu}}</th>
                        @endforeach
                    </tr>
                    @if(!empty(sizeof($result["list"])))
                        @foreach($result["list"] as $mail)
                            @php
                                $mtype = "send";
                                $sed_rec_key  = "received_usr";
                                if($mail["toId"] == $result["cur"])
                                {
                                    $mtype = "receive";
                                    $sed_rec_key  = "send_usr";
                                }
                                $read = "read";
                                if($mail["view_date"] == null)
                                    $read  = "";
                            @endphp
                            <tr>
                                <td><input type="checkbox" name="check[]" class="check" value="{{$mail["id"]}}"></td>
                                <td class="left"><span style="position:relative;">
                                <img src="{{$mail[$sed_rec_key]["getLevel"]["value3"]}}" width="30" height="30">
                                @if($mail[$sed_rec_key]["isDeleted"] == 1 || $mail[$sed_rec_key]["user_type"] == "00")
                                <span style="position:absolute;left:0;z-index:99;">
                                    <img src="/assets/images/powerball/prison.png" width="30" height="30">
                                </span>
                                @endif
                            </span>
                                    <strong>{{$mail[$sed_rec_key]["nickname"]}}</strong>
                                </td>
                                <td class="left"><a href="{{"memo"}}?type=memoView&mid={{$mail["id"]}}&mtype={{$mtype}}" class="{{$read}}">
                                        <img src="/assets/images/powerball/giftBox.png" width="24" height="24">
                                        @if($mail["mail_type"] == 1)
                                            일반 쪽지입니다.
                                        @else
                                            랜덤 쪽지입니다.
                                        @endif
                                    </a>
                                </td>
                                <td class="{{$read}}">{{date("m-d H:i",strtotime($mail["created_at"]))}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="@if($result["type"] == "send"){{5}}@else{{4}}@endif">자료가 비였습니다.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </form>
            <div class="page">
                {{ $result["list"]->links() }}
            </div>
            <div class="guide">
                ※ 보관하지 않은 쪽지는 7일 후 자동삭제 됩니다.(보관쪽지는 30일 후 자동삭제 됩니다.)
            </div>
        </div>
    </div>
@endsection
