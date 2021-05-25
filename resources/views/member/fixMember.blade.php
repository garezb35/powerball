@extends('includes.empty_header')
@section("content")
    @php
        $paramt = "friend";
        if(Request::get("searchVal") == "B")
            $paramt = "block";
    @endphp
    <div class="memoBox">
        @include("member.memo-memu")
        <div class="content">
            <div class="name-search">
                <a href="#" onclick="listDel('{{$paramt}}');return false;"><img src="/assets/images/powerball/btn_del_off.png" width="48" height="24"></a>
                <span>
					<input type="text" placeholder="고정멤버검색" class="input" id="searchValue" value="{{Request::get("nickname")}}" onkeypress="if(event.keyCode==13){friendSearch('fixMember');return false;}">
					<a href="#" onclick="friendSearch('fixMember');return false;"><img src="https://simg.powerballgame.co.kr/images/memo/btn_search_off.png" width="48" height="24"></a>
				</span>
            </div>
            <form name="friendListForm" method="post" action="/processFrd">
                <input type="hidden" name="rtnUrl" value="/memo?type=fixMember&searchVal=all">
                <input type="hidden" name="searchVal" id="searchVal">
                <input type="hidden" name="nickname" id="nickname">
                <input type="hidden" name="friendType">
                @csrf
                <div class="listBox">
                    <ul>
                        @foreach(getUserPrefix() as $prf_val)
                            <li class="{{$prf_val["class"]}}" >
                                <a
                                    @if(Request::get("searchVal") == $prf_val["key"] || (empty(Request::get("searchVal")) && $prf_val["key"]== "all"))
                                    class="on"
                                    @endif
                                    href="/memo?type=fixMember&searchVal={{$prf_val["key"]}}"
                                >{{$prf_val["alias"]}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <table class="table-mail" style="margin-top:5px;">
                    <colgroup>
                        <col width="50">
                        <col width="*">
                        <col width="200">
                    </colgroup>
                    <thead>
                    <tr>
                        <th scope="col"><span class="line"><input type="checkbox" onclick="checkAll(this.checked);"></span></th>
                        <th scope="col"><span class="line">닉네임</span></th>
                        <th scope="col">접속상태</th>
                    </tr>
                    </thead>
                </table>
                <div id="resultDiv">
                    <table class="table-mail" style="position:relative;top:-1px;">
                        <caption></caption>
                        <colgroup>
                            <col width="50">
                            <col width="*">
                            <col width="200">
                        </colgroup>
                        <tbody>
                        @if(sizeof($result["list"]) > 0)
                            @foreach($result["list"] as $frd_usr)
                                <tr>
                                    <td style="text-align:center;"><input type="checkbox" name="check[]" class="check" value="{{$frd_usr["userIdKey"]}}"></td>
                                    <td style="text-align:left;"><img src="{{$frd_usr["getLevel"]["value3"]}}" width="30" height="30"> <strong>{{$frd_usr["nickname"]}}</strong></td>
                                    <td class="time" style="font-size:11px;"><img src="/assets/images/powerball/offline.gif" width="20" height="20"> 미접속</td>
                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="3">자료가 비였습니다.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection
