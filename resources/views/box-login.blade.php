<div class="box-login">
    @auth
        @php
            if($next_level ==0){
                $nextClass = Auth::user()->exp-$normal_level;
            }
            else
                $nextClass = $next_level - $normal_level;
        @endphp
    <div style="height:230px;">
        <table class="mt-2" style="width: 100%">
            <colgroup>
                <col width="160px">
            </colgroup>
            <tr>
                <td class="text-left align-top p-1">
                    <div class="mb-2 ml-2"><img src="{{$user_level[0]["value3"]}}">
                        <span class="font-weight-bold ml-2 ll-he23 ja-color ft-thsize"><span class="grades">{{Auth::user()->nickname}}</span> (계급 : <a href="{{route("member")}}?type=level" target="mainFrame" class="text-gam font-weight-bold">{!! $user_level[0]["codename"] !!}</a>)</span>
                        <div style="margin-left: 33px;">
                            <span class="text-gam font-weight-bold">경험치</span>
                            <div class="mb-2 position-relative mt-1 exp-back">
                                <div style="width:{{((Auth::user()->exp-$normal_level) / ($next_level - $normal_level))*100}}%;" class="numberFont">
                                    <div style="position:absolute;left: 35px;" class="text-white font-weight-bold"><span>{{Auth::user()->exp-$normal_level}}</span> / {{$nextClass}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="p-1">
                   <div style="border: 1px solid #d5d9db;border-radius: 5px">
                       <table class="table mb-0  user-info">
                           <colgroup>
                               <col width="60px">
                               <col width="*">
                           </colgroup>
                           <tr>
                               <td class="p-1 align-middle"><span class="list-item"><img src="/assets/images/powerball/coin.png" /><span class="list-item coin-label"> 코인 </span></td>
                               <td class="p-1 align-middle text-right"><span class="text-blo font-weight-bold">{{number_format(Auth::user()->coin)}}</span>개</td>
                           </tr>
                           <tr >
                               <td class="p-1 align-middle"><img src="/assets/images/powerball/dangun.png" /><span class="list-item dangun-label"> 당근 </span></td>
                               <td class="p-1 align-middle text-right"><span class="text-blo font-weight-bold">{{number_format(Auth::user()->bullet)}}</span>개</td>
                               <td class="p-1 align-middle"></td>
                           </tr>
                           <tr>
                               <td class="p-1 align-middle"><span class="list-item dotori-label"><img src="/assets/images/powerball/dotori.png" /> 도토리 </span></td>
                               <td class="p-1 align-middle text-right"><span class="text-blo font-weight-bold">{{number_format(Auth::user()->bread)}}</span>개</td>
                               <td class="p-1 align-middle"></td>
                           </tr>
                       </table>
                   </div>
                </td>
            </tr>
        </table>
        <table class="table box-menus mar-t-10 mb-0">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <tr>
                <td class="text-center align-middle active pt-2 pb-1 border-right-ja">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-home"></i>
                        </div>
                        <a href="{{route("member")}}" target="mainFrame">마이홈</a>
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1 border-right-ja">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <a href="#" onclick="windowOpen('/?view=memo','memo',600,600,'auto');return false;" >쪽지</a>
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1 border-right-ja">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                        </div>
                        <a href="{{route("member")}}?type=item" target="mainFrame">아이템</a>
                        @if($item_count > 0)<div class="itemCntBox">{{$item_count}}</div>@endif
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1" >
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                        </div>
                        <a href="/logout">로그아웃</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="back-blue simu-head p-2">
                    <span class="text-gold font-weight-bold">파워모의배팅</span> <span class="font-weight-bold text-white">남은 기간</span>  <span class="text-gold font-weight-bold">30일</span>
                    <button class="ml-2 btn btn-sm btn-jin-blue">구매하러 가기</button>
                </td>
            </tr>
        </table>
        <div class="mb-2"></div>
    </div>
    @endauth
    @guest
    <div class="pt-2 pb-0">
        {!! Form::open(['action' =>'App\Http\Controllers\Auth\LoginController@process_login', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        <table class="ml-3">
            <colgroup>
                <col width="210px">
                <col width="110px">
            </colgroup>
            <tr>
                <td class="p-1">
                    {!! Form::text('loginId', '', ['class' => 'input-green mb-1 w-100','placeholder'=>"아이디 입력",'autocomplete'=>"off"]) !!}
                    {!! Form::password('password', ['class'=>'input-green w-100','placeholder'=>"비밀번호 입력"]) !!}
                </td>
                <td class="text-left p-1">
                    {!! Form::submit('로그인', ['class' => 'btn btn-jin-green w-100 h-55']) !!}
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
        <table class="table mb-0">
            <colgroup>
                <col width="50%">
            </colgroup>
            <tr>
                <td class="pr-1 pt-1 pb-0 pl-0">
                    <a class="btn btn-jin-green w-100 ft-btsize" href="{{ route('register') }}">회원가입</a>
                </td>
                <td class="pr-0 pt-1 pb-0 pl-1">
                    <a class="btn btn-jin-green w-100 pl-1 pr-1 ft-btsize" href="{{ route('password.request') }}" target="mainFrame">아이디,비밀번호 찾기</a>
                </td>
            </tr>
        </table>
    </div>
    @endguest

</div>
