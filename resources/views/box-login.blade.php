
<div class="box-login">
    @auth
        @php
            if($next_level ==0){
                $nextClass = (Auth::user()->exp-$normal_level) <= 0 ? 1 : Auth::user()->exp-$normal_level;
            }
            else
                $nextClass = ($next_level - $normal_level) <=0 ? 1 : $next_level - $normal_level;
        @endphp
    <div style="height:204px;">
        <table class="mt-0" style="width: 100%">
            <colgroup>
                <col width="155px">
            </colgroup>
            <tr>
                <td class="text-left align-top p-1">
                    <div class="mb-2 ml-2"><img src="{{$user_level[0]["value3"]}}">
                        <span class="font-weight-bold  ll-he23 ja-color ft-thsize"><span class="grades">{{Auth::user()->nickname}}</span> (계급 : <a href="{{route("member")}}?type=level" target="mainFrame" class="text-gam font-weight-bold">{!! $user_level[0]["codename"] !!}</a>)</span>
                        <div style="margin-left: 33px;">
                            <span class="text-gam font-weight-bold" style="font-size: 13px">경험치</span>
                            <div class="mb-2 position-relative mt-1 exp-back">
                                <div style="width:{{((Auth::user()->exp-$normal_level) / $nextClass)*100}}%;" class="numberFont">
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
                               <col width="75px">
                               <col width="*">
                           </colgroup>
                           <tr>
                               <td class="pt-1 pb-1 pl-1 pr-1 align-middle">
                                   <span class="list-item"><img src="/assets/images/powerball/coin.png" height="15"/><span class="list-item coin-label"> 코인 </span>
                                    <a href="/member?type=charge" target="mainFrame" class="charge">충전</a>
                               </td>
                               <td class="pt-1 pb-1 pl-0   align-middle text-right" style="padding-right: 4px"><span class="text-blo font-weight-bold" id="coin_cnt">{{number_format(Auth::user()->coin)}}</span></td>
                           </tr>
                           <tr >
                               <td class="pt-0 pb-1 pl-1 pr-1 align-middle"><img src="/assets/images/powerball/dangun.png" height="15"/><span class="list-item dangun-label"> 당근 </span></td>
                               <td class="pt-0 pb-1 pl-0  align-middle text-right" style="padding-right: 4px"><span class="text-blo font-weight-bold" id="bullet_cnt">{{number_format(Auth::user()->bullet)}}</span>개</td>
                           </tr>
                           <tr>
                               <td class="pt-0 pb-1 pl-1 pr-1 align-middle"><span class="list-item dotori-label"><img src="/assets/images/powerball/dotori.png" height="15"/> 도토리 </span></td>
                               <td class="pt-0 pb-1 pl-0  align-middle text-right" style="padding-right: 4px"><span class="text-blo font-weight-bold">{{number_format(Auth::user()->bread)}}</span>개</td>
                           </tr>
                       </table>
                   </div>
                </td>
            </tr>
        </table>

        <table class="table box-menus mar-t-5 mb-0">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <tr>
                <td class="text-center align-middle active pt-2 pb-1 border-right-ja" >
                    <a href="{{route("member")}}" target="mainFrame">
                        <div class="position-relative">
                            <div class="mb-1">
                                <i class="fa fa-home"></i>
                            </div>
                            마이홈
                        </div>
                    </a>
                </td>
                <td class="text-center align-middle pt-2 pb-1 border-right-ja">
                    <a href="#" onclick="windowOpen('/memo','memo',600,600,'auto');return false;" >
                        <div class="position-relative">
                            <div class="mb-1">
                                <i class="fa fa-envelope"></i>
                            </div>
                            쪽지
                            <div class="itemCntBox" id="mail-count" style="display:@if($mail_count == 0){{"none"}}@else{{"block"}}@endif">{{$mail_count}}</div>
                        </div>
                    </a>
                </td>
                <td class="text-center align-middle pt-2 pb-1 border-right-ja">
                    <a href="{{route("member")}}?type=item" target="mainFrame">
                    <div class="position-relative">
                        <div class="mb-1">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                        </div>
                        아이템
                        @if($item_count > 0)<div class="itemCntBox" id="item-count">{{$item_count}}</div>@endif
                    </a>
                    </div>
                </td>
                <td class="text-center align-middle pt-2 pb-1" >
                    <a href="/logout">
                        <div class="position-relative">
                            <div class="mb-1">
                                <i class="fa fa-power-off" aria-hidden="true"></i>
                            </div>
                            로그아웃
                        </div>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="back-blue simu-head">
                    <div class="machine1">
                      <span class="text-gold font-weight-bold align-middle ll-he23">파워시뮬레이션</span>
                      @if(!empty($using_sim[0]) && !empty($using_sim[0]->format("%a")))
                      <span class="font-weight-bold text-white align-middle ll-he23">남은 기간</span>  <span class="text-gold font-weight-bold align-middle ll-he23">{{$using_sim[0]->format("%a")}}일</span>
                      <button class="btn btn-sm btn-jin-blue gopur_btn">사용중</button>
                      @else
                          <span class="font-weight-bold text-white align-middle ll-he23">남은 기간</span></span>
                          <button class="btn btn-sm btn-jin-blue gopur_btn" onclick="gomarket()">구매하러 가기</button>
                      @endif
                    </div>
                    <div class="machine2 d-none">
                      <span class="text-gold font-weight-bold align-middle ll-he23">연승제조기</span>
                      @if(!empty($using_sim[1]) && !empty($using_sim[1]->format("%a")))
                      <span class="font-weight-bold text-white align-middle ll-he23">남은 기간</span>  <span class="text-gold font-weight-bold align-middle ll-he23">{{$using_sim[1]->format("%a")}}일</span>
                      <button class="btn btn-sm btn-jin-blue gopur_btn">사용중</button>
                      @else
                          <span class="font-weight-bold text-white align-middle ll-he23">남은 기간</span></span>
                          <button class="btn btn-sm btn-jin-blue gopur_btn" onclick="gomarket()">구매하러 가기</button>
                      @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="p-0 align-middle border-0">
                    <div class="notice">
                        <span class="not-left">공지</span>
                        <div style="position: absolute; top: 0px;" id="scrollNotice">
                            <ul>
                                @if(!empty($notice))
                                @foreach($notice as $nitem)
                                        <li><a href="/board?board_type=customer&board_category=notice&bid={{$nitem["id"]}}&page=1" target="mainFrame">{{$nitem["title"]}}</a></li>
                                @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="mb-2"></div>
    </div>
    @endauth
    @guest
    <div class="pt-2 pb-0">
        {!! Form::open(['action' =>'App\Http\Controllers\Auth\LoginController@process_login', 'method' => 'post', 'enctype' => 'multipart/form-data','id'=>'login_form']) !!}
        <table class="ml-3">
            <colgroup>
                <col width="210px">
                <col width="110px">
            </colgroup>
            <tr>
                <td class="p-1">
                    {!! Form::text('loginId', '', ["required"=>true,'class' => 'input-green mb-1 w-100','autocomplete'=>"off"]) !!}
                    {!! Form::password('password', ["required"=>true,'class'=>'input-green w-100']) !!}
                </td>
                <td class="text-left p-1 pr-3">
                    {!! Form::submit('로그인', ['class' => 'btn btn-jin-greenoutline w-100 h-55']) !!}
                </td>
            </tr>
            <tr>
                <td class="pt-2 pb-2 pl-1" colspan="2">
                    @if(!empty($errors->first('failed')))
                    <div class="alert alert-danger mr-3 fade show alert-dismissible" role="alert">
                    {{$errors->first('failed')}}
                    </div>
                    @endif
                    <label class="container-radio">
                        <input type="checkbox" checked="checked" id="keep_login">
                        <span class="checkmark"></span>
                    </label>
                    <a style="color: #000 !important;margin-left: -11px;" class="mr-2" href="{{ route('register') }}">로그인상태유지</a>
                    <a class="text-blue mr-2" href="{{ route('register') }}">회원가입</a>
                    <a class="text-blue" href="{{ route('findIdPw') }}" target="mainFrame">아이디,비밀번호 찾기</a>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}
    </div>
    @endguest
</div>

<script>
    function gomarket(url = ""){
        var el = document.getElementById('mainFrame');
        if(url == "")
            el.src = "/market"; // assign url to src property
    }

</script>
