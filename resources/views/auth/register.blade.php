@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="simpleJoinBox">
            <div class="card">
                <div class="card-body">
                    <div class="content">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="loginId" type="text" class="form-control @error('loginId') is-invalid @enderror" name="loginId" value="{{ old('loginId') }}" required autocomplete="name" autofocus
                                    placeholder="{{ __('아이디를 입력하세요...') }}">

                                    @error('loginId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                                    placeholder="{{ __('비밀번호') }}">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="{{ __('비밀번호 확인') }}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus
                                    placeholder="닉네임을 입력하세요...">

                                    @error('nickName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="이름을 입력하세요...">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <input id="phoneNumber" type="text" class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber" require value="{{ old('phoneNumber') }}" required autocomplete="phoneNumber" autofocus
                                               placeholder="휴대폰번호를 입력하세요">
                                        <div class="input-group-append">
                                            <button class="btn btn-jin-greenoutline" type="button">휴대폰번호 발송</button>
                                        </div>
                                    </div>

                                    @error('phoneNumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <input id="smsAuthNum" type="text" class="form-control @error('smsAuthNum') is-invalid @enderror" name="smsAuthNum" value="{{ old('smsAuthNum') }}" required autocomplete="phoneNumber" autofocus
                                               placeholder="인증번호를 입력하세요...">
                                        <div class="input-group-append">
                                            <button class="btn btn-jin-greenoutline" type="button">인증번호 확인</button>
                                        </div>
                                    </div>
                                    @error('smsAuthNum')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('이메일을 입력하세요...') }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-jin-greenoutline btn-block">
                                        {{ __('회원가입하기') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="footer">
                        <p>이미 몬스터파워볼 회원이세요? <a href="{{ route('login') }}" class="text-blue">로그인하기</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
