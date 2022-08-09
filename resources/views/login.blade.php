@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="login-2">
                <form action="{{ route('login-front') }}" method="post">
                    @csrf
                    <input type="hidden" name="url" value="{{ $url }}">
                    <div class="box_form clearfix">
                        <div class="box_login">
                            <h1>{{ __('website.hello') }}</h1>
                            <h2>{{ __('website.subtitle-login-page') }}</h2>
                            <div class="form-group">
                                <p class="step-sub-title text-left font-weight-bold margin-bottom-10">{{ __('website.email') }}</p>
                                <input type="email" class="form-control" name="email">
                                @error('email')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p class="step-sub-title text-left font-weight-bold margin-bottom-10">{{ __('website.password') }}</p>
                                <div class="form-password">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <i class="fa fa-eye" id="eye" onclick="showPassword()"></i>
                                </div>
                                @error('password')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <a href="{{ route('password-reset-front') }}" class="forgot"><small>{{ __('website.forgot-password') }}</small></a>
                            </div>
                            <div class="form-group">
                                <input class="btn_1 float-right" type="submit" value="{{ __('website.log-in') }}">
                                <a class="" href="{{ url('/register-front') }}">{{ __('website.create-an-account') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /login -->
        </div>
    </div>
@endsection
