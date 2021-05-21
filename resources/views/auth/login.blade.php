@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login_page">
            <div class="card">
                <div class="card-header">{{ __('로그인') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="loginId" type="text" class="form-control @error('loginId') is-invalid @enderror" name="loginId" value="{{ old('loginId') }}" required autocomplete="loginId" autofocus placeholder="{{ __('아이디') }}">
                                @error('loginId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('암호') }}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('로그인') }}
                                </button>
                            </div>
                        </div>
                        <div class="login_menu">
                            <ul>
                                <li><a href="#">아이디 찾기</a></li>
                                @if (Route::has('password.request'))
                                <li><a href="{{ route('password.request') }}">비밀번호 찾기</a></li>
                                @endif
                                <li><a href="{{ route('register') }}">회원가입</a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
