@extends('includes.empty_header')
@php
    $self = "received_usr";
    $other = "send_usr";
    if($result["mtype"] == "send"){
        $self = "send_usr";
        $other = "received_usr";
    }

@endphp
@section("content")
    <div class="memoBox">
        @include("member.memo-memu")
        <div class="content">
            <div class="top">
                <a href="#" onclick="memoDel();return false;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_del_off.png" width="48" height="24" ></a>
                @if($self == "received_usr" && $result["memo"]["state"] != 1)
                    <a href="#" onclick="memoSave();return fasle;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_save_off.png" ></a>
                @endif
                @if($result["memo"]["report"] != 2 && $result["memo"]["report"] != 3)
                <a href="#" onclick="memoReport();return false;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_report_off.png" width="48" height="24" ></a>
                @endif
                <span class="list-btn">
                <a href="{{route("memo")}}?type={{$result["mtype"]}}"><img src="https://simg.powerballgame.co.kr/images/memo/btn_list_off.png" width="48" height="24" alt="목록" ></a>
                @if(!empty($previous))
                <a href="/memo?type=memoView&mtype={{$result["mtype"]}}&mid={{$previous}}"><img src="https://simg.powerballgame.co.kr/images/memo/btn_prev_off.png" width="48" height="24" alt="이전" ></a>
                @endif
               @if(!empty($next ))
                <a href="/memo?type=memoView&mtype={{$result["mtype"]}}&mid={{$next}}"><img src="https://simg.powerballgame.co.kr/images/memo/btn_next_off.png" width="48" height="24" alt="다음" ></a>
                @endif
                </span>
            </div>
            <div class="viewTitle">
                <div style="position:absolute">
                    <img src="{{$result["memo"][$other]["getLevel"]["value3"]}}" width="23" height="23">
                    @if($result["memo"][$self]["isDeleted"] == 1 || $result["memo"][$self]["user_type"] == "00")
                    <span style="position:absolute;left:0;z-index:99;">
                        <img src="/assets/images/powerball/prison.png" width="23" height="23">
                    </span>
                    @endif
                </div>
                <span style="margin-left:27px;">
                    @if(Request::get("mtype") == "receive")
                    <strong>{{$result["memo"][$other]["nickname"]}}</strong> 님에게 {{date("y.m.d H:i",strtotime($result["memo"]["created_at"]))}} 에 받은 쪽지 입니다.
                    @else
                        <strong>{{$result["memo"][$other]["nickname"]}}</strong> 님에게 {{date("y.m.d H:i",strtotime($result["memo"]["created_at"]))}} 에 보낸 쪽지 입니다.
                    @endif
                </span>
            </div>
            <div class="viewContent">
                @if($result["memo"][$self]["isDeleted"] == 1 || $result["memo"][$self]["user_type"] == "00")
                    <p class="tooltip-ban" style="margin-bottom:3px;">해당 회원은 접속 차단된 회원입니다.<a href="#" onclick="$(this).closest('p').hide();" class="btn-close"></a></p>
                @endif
                <div class="msg">
                    {!! nl2br(e($result["memo"]["content"])) !!}
                </div>
            </div>
            <div class="btnBox">
                @if($self == "received_usr")
                <a href="{{route("memo")}}?type=write&nickname={{$result["memo"][$other]["nickname"]}}" class="btnSend">답장보내기</a>
                @endif
                <a href="{{route("memo")}}?type={{$result["mtype"]}}" class="btnCancel">목록</a>
            </div>
        </div>
    </div>
    <form name="memoForm">
        @csrf
        <input type="hidden" name="check[]" value="{{$result["memo"]["id"]}}">
        <input type="hidden" name="mtype" value="{{$result["mtype"]}}" />
    </form>
@endsection
