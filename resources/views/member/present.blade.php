@extends("includes.empty_header")
@section("content")
    @php

    $date = empty(Request::get("type")) ? date("Y-m-d") : Request::get("type");
    $y = date("Y",strtotime($date));
    $m = date("m",strtotime($date));
    $d = date("d",strtotime($date));
    @endphp
    <script>
        var y = {{$y}};
        var m = {{$m}};
        var d = {{$d}};
        var month_days = "{{$month_days}}";
    </script>
    <link rel="stylesheet" href="/assets/calendar/simple-calendar.css">
    <script src="/assets/calendar/jquery.simple-calendar.js"></script>
    <div class="attendanceBox">
        <div class="titleBox">
            출석체크 <span>- 매일 매일 출석체크하고 랜덤아이템상자 받자!</span>
        </div>

        <div class="topBox">
            <div class="calendarBox">
            </div>
            <div class="ladderBox">
                <div class="choiceBox">
                    <div class="choiceNumber" style="left:40px;">1</div>
                    <div class="choiceNumber" style="left:210px;">2</div>
                    <div class="choiceNumber" style="left:380px;">3</div>
                </div>
                <div class="ladderContent">
                    <div id="ladderResult"></div>
                </div>

                <div class="contentArea">
                    <form name="attendanceForm" id="attendanceForm" method="post" action="/">
                        @csrf
                        <input type="hidden" name="selectNumber" id="selectNumber">
                        <input type="hidden" name="winNumber" value="{{$win_number}}">
                        <input type="hidden" name="api_token" value="{{$api_token}}">
                        <ul>
                            <li class="choice">1</li>
                            <li class="choice">2</li>
                            <li class="choice">3</li>
                        </ul>
                        <div class="text">출석 코멘트</div>
                        <div class="inputBox"><input type="text" name="comment" class="input" value="{{randomItemMessage()[$size]}}" readonly=""></div>
                        <div class="submit" style="background-color: #8ee2e2">출석체크</div>
                    </form>
                </div>

                <div class="choiceBox">
                    <div class="choiceNumber @if($win_number == 1) win @endif" style="left:40px;">@if($win_number == 1){{"당첨"}}@else{{"꽝"}}@endif</div>
                    <div class="choiceNumber @if($win_number == 2) win @endif" style="left:210px;">@if($win_number == 2){{"당첨"}}@else{{"꽝"}}@endif</div>
                    <div class="choiceNumber @if($win_number == 3) win @endif" style="left:380px;">@if($win_number == 3){{"당첨"}}@else{{"꽝"}}@endif</div>
                </div>
            </div>
        </div>

        <div class="listBox tbl_head01 tbl_wrap">
            <table class="table table-bordered">
                <colgroup>
                    <col width="50">
                    <col width="50">
                    <col width="80">
                    <col width="150">
                    <col>
                    <col width="100">
                </colgroup>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>결과</th>
                        <th class="text-center">개근</th>
                        <th>닉네임</th>
                        <th>코멘트</th>
                        <th class="text-center">출석시간</th>
                    </tr>
                </thead>
                <tbody>
{{--                <tr class="bgYellow">--}}
{{--                    <td class="number">15231</td>--}}
{{--                    <td class="result">당첨</td>--}}
{{--                    <td class="number">3일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M12.gif" width="23" height="23"> 박스주워배팅한다</td>--}}
{{--                    <td class="txt" data-hasqtip="191" oldtitle="꿈과 현실의 차이를 두려워하지 말아라. 꿈을 꿀 수 있다면 실현할 수 있다." title="" aria-describedby="qtip-191">꿈과 현실의 차이를 두려워하지 말아라. 꿈을 꿀 수 있다면 실현...</td>--}}
{{--                    <td class="number">21-05-24 00:55</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15230</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">2일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M19.gif" width="23" height="23"> 하나나님</td>--}}
{{--                    <td class="txt" data-hasqtip="199" oldtitle="나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다." title="">나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다...</td>--}}
{{--                    <td class="number">21-05-24 00:54</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15229</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M5.gif" width="23" height="23"> 요요미</td>--}}
{{--                    <td class="txt" data-hasqtip="207" oldtitle="균형을 잡는 행위는 균형 잡힌 삶을 사는 것과 다르다." title="" aria-describedby="qtip-207">균형을 잡는 행위는 균형 잡힌 삶을 사는 것과 다르다.</td>--}}
{{--                    <td class="number">21-05-24 00:54</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15228</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">50일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M15.gif" width="23" height="23"> 기독교</td>--}}
{{--                    <td class="txt" data-hasqtip="215" oldtitle="나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다." title="">나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다...</td>--}}
{{--                    <td class="number">21-05-24 00:51</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15227</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M16.gif" width="23" height="23"> 김수미</td>--}}
{{--                    <td class="txt" data-hasqtip="223" oldtitle="나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다." title="" aria-describedby="qtip-223">나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다...</td>--}}
{{--                    <td class="number">21-05-24 00:50</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15226</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M9.gif" width="23" height="23"> ekfak12</td>--}}
{{--                    <td class="txt" data-hasqtip="231" oldtitle="지금 안 한다면 언제 하겠는가?" title="" aria-describedby="qtip-231">지금 안 한다면 언제 하겠는가?</td>--}}
{{--                    <td class="number">21-05-24 00:49</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15225</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M5.gif" width="23" height="23"> 겨울백곰</td>--}}
{{--                    <td class="txt" data-hasqtip="239" oldtitle="두려움을 느껴라, 그리고 어떻게 해서든 하라." title="">두려움을 느껴라, 그리고 어떻게 해서든 하라.</td>--}}
{{--                    <td class="number">21-05-24 00:48</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15224</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">17일</td>--}}
{{--                    <td class="nick"><img src="/images/class/F19.gif" width="23" height="23"> 대장강이님</td>--}}
{{--                    <td class="txt" data-hasqtip="247" oldtitle="내면의 침묵 속으로 들어가 인생의 모든 것에 목적이 있다는 것을 배워라." title="" aria-describedby="qtip-247">내면의 침묵 속으로 들어가 인생의 모든 것에 목적이 있다는 것을...</td>--}}
{{--                    <td class="number">21-05-24 00:48</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15223</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">2일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M13.gif" width="23" height="23"> 링밖은목사</td>--}}
{{--                    <td class="txt" data-hasqtip="255" oldtitle="사람들이 사랑에 빠지는 것은 중력 탓이 아니다." title="" aria-describedby="qtip-255">사람들이 사랑에 빠지는 것은 중력 탓이 아니다.</td>--}}
{{--                    <td class="number">21-05-24 00:48</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15222</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M2.gif" width="23" height="23"> 코로11</td>--}}
{{--                    <td class="txt" data-hasqtip="263" oldtitle="실패는 불가능하다." title="">실패는 불가능하다.</td>--}}
{{--                    <td class="number">21-05-24 00:46</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15221</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">4일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M12.gif" width="23" height="23"> 사전</td>--}}
{{--                    <td class="txt" data-hasqtip="271" oldtitle="균형은 선택이 아니라 공존이다." title="" aria-describedby="qtip-271">균형은 선택이 아니라 공존이다.</td>--}}
{{--                    <td class="number">21-05-24 00:44</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15220</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">7일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M6.gif" width="23" height="23"> 나나나야</td>--}}
{{--                    <td class="txt" data-hasqtip="279" oldtitle="나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다." title="" aria-describedby="qtip-279">나는 소녀시절부터 키워온 꿈이 있다. 나는 세상을 지배하고 싶다...</td>--}}
{{--                    <td class="number">21-05-24 00:43</td>--}}
{{--                </tr>--}}

{{--                <tr class="bgYellow">--}}
{{--                    <td class="number">15219</td>--}}
{{--                    <td class="result">당첨</td>--}}
{{--                    <td class="number">19일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M13.gif" width="23" height="23"> 발키리사냥꾼</td>--}}
{{--                    <td class="txt" data-hasqtip="287" oldtitle="사람들이 사랑에 빠지는 것은 중력 탓이 아니다." title="">사람들이 사랑에 빠지는 것은 중력 탓이 아니다.</td>--}}
{{--                    <td class="number">21-05-24 00:42</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15218</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M11.gif" width="23" height="23"> 장수여왕벌</td>--}}
{{--                    <td class="txt" data-hasqtip="295" oldtitle="지금 안 한다면 언제 하겠는가?" title="">지금 안 한다면 언제 하겠는가?</td>--}}
{{--                    <td class="number">21-05-24 00:41</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15217</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M9.gif" width="23" height="23"> 남포동고래</td>--}}
{{--                    <td class="txt" data-hasqtip="303" oldtitle="기회가 오지 않는다면 기회를 만들어라." title="">기회가 오지 않는다면 기회를 만들어라.</td>--}}
{{--                    <td class="number">21-05-24 00:41</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15216</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">6일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M12.gif" width="23" height="23"> 티파니사장</td>--}}
{{--                    <td class="txt" data-hasqtip="311" oldtitle="기회가 오지 않는다면 기회를 만들어라." title="">기회가 오지 않는다면 기회를 만들어라.</td>--}}
{{--                    <td class="number">21-05-24 00:41</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15215</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">2일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M8.gif" width="23" height="23"> 유새봄</td>--}}
{{--                    <td class="txt" data-hasqtip="319" oldtitle="당신이 어떤 일을 할 수 있다고 생각하든 할 수 없다고 생각하든, 당신이 옳다." title="">당신이 어떤 일을 할 수 있다고 생각하든 할 수 없다고 생각하든...</td>--}}
{{--                    <td class="number">21-05-24 00:40</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15214</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">3일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M20.gif" width="23" height="23"> 로야르</td>--}}
{{--                    <td class="txt" data-hasqtip="327" oldtitle="지금 안 한다면 언제 하겠는가?" title="">지금 안 한다면 언제 하겠는가?</td>--}}
{{--                    <td class="number">21-05-24 00:39</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15213</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">1일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M15.gif" width="23" height="23"> 서산국민학교</td>--}}
{{--                    <td class="txt" data-hasqtip="335" oldtitle="두려움을 느껴라, 그리고 어떻게 해서든 하라." title="">두려움을 느껴라, 그리고 어떻게 해서든 하라.</td>--}}
{{--                    <td class="number">21-05-24 00:39</td>--}}
{{--                </tr>--}}

{{--                <tr class="">--}}
{{--                    <td class="number">15212</td>--}}
{{--                    <td class="result">꽝</td>--}}
{{--                    <td class="number">10일</td>--}}
{{--                    <td class="nick"><img src="/images/class/M2.gif" width="23" height="23"> 13579승</td>--}}
{{--                    <td class="txt" data-hasqtip="343" oldtitle="꿈과 현실의 차이를 두려워하지 말아라. 꿈을 꿀 수 있다면 실현할 수 있다." title="">꿈과 현실의 차이를 두려워하지 말아라. 꿈을 꿀 수 있다면 실현...</td>--}}
{{--                    <td class="number">21-05-24 00:35</td>--}}
{{--                </tr>--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
