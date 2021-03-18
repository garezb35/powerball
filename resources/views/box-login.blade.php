<div class="box-login">
    @auth
        @php
            if($next_level ==0){
                $nextClass = Auth::user()->exp-$normal_level;
            }
            else
                $nextClass = $next_level - $normal_level;
        @endphp
    <div style="height:150px;">
        <table class="mt-2" style="width: 100%">
            <colgroup>
                <col width="110px">
            </colgroup>
            <tr>
                <td class="text-center align-middle" style="border-right: 1px solid">
                    <div class="mb-2"><img src="{{$user_level[0]["value3"]}}" width="50"></div>
                    <div class="mb-2 font-weight-bold">닉네임: {{Auth::user()->nickname}}</div>
                    <div><a href="{{ route('logout') }}" class="logout btn btn-gray btn-sm ft-btsize pr-2 pl-2">로그아웃</a></div>
                </td>
                <td>
                    <table class="table mb-0  user-info">
                        <colgroup>
                            <col width="75px">
                            <col width="*">
                            <col width="63px">
                        </colgroup>
                        <tr>
                            <td class="p-1 align-middle"><span class="list-item">보유코인:</span></td>
                            <td class="p-1 align-middle text-right"><span class="text-gam font-weight-bold">{{number_format(Auth::user()->coin)}}</span>개</td>
                            <td class="p-1 align-middle"><a href="" class="coin_charge">코인충전</a> </td>
                        </tr>
                        <tr >
                            <td class="p-1 align-middle"><span class="list-item">총알:</span></td>
                            <td class="p-1 align-middle text-right"><span class="text-gam font-weight-bold">{{number_format(Auth::user()->bullet)}}</span>개</td>
                            <td class="p-1 align-middle"></td>
                        </tr>
                        <tr>
                            <td class="p-1 align-middle"><span class="list-item">건빵:</span></td>
                            <td class="p-1 align-middle text-right"><span class="text-gam font-weight-bold">{{number_format(Auth::user()->bread)}}</span>개</td>
                            <td class="p-1 align-middle"></td>
                        </tr>
                        <tr>
                            <td class="p-1 align-middle"><span class="list-item">계급:</span></td>
                            <td class="p-1 align-middle text-right">
                                <a href="{{route("member")}}?type=level" target="mainFrame" class="text-gam font-weight-bold">{!! $user_level[0]["codename"] !!}</a>
                            </td>
                            <td class="p-1 align-middle"></td>
                        </tr>
                        <tr>
                            <td class="p-1 align-middle"><span class="list-item">경험치:</span></td>
                            <td colspan="2 align-middle" class="p-1 position-relative"> <div style="background:#aaa url('https://simg.powerballgame.co.kr/images/lv_line.png') no-repeat;width:100px;height:16px;">
                                    <div style="background:url('https://simg.powerballgame.co.kr/images/lv_bar.png') no-repeat;width:{{((Auth::user()->exp-$normal_level) / ($next_level - $normal_level))*100}}%;height:16px;line-height:19px;padding-left:6px;color:#000;" class="numberFont">
                                        <div style="position:absolute;top: 21px;left: 35px;"><span class="text-pa">{{Auth::user()->exp-$normal_level}}</span> / {{$nextClass}}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
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
                <td class="text-center">
                    {!! Form::submit('로그인', ['class' => 'btn btn-jin-green pb-1 pt-1']) !!}
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
