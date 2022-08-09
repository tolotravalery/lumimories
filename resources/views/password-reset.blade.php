@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="login-2">
                <h1>{{ __('Reset Password') }}</h1>
                <form action="{{ route('password.update-front') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="box_form clearfix">
                        <div class="box_login">
                            <div class="form-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('website.your-email-address') }}" name="email" value="{{ $email ?? old('email') }}" required>
                                @error('email')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password">
                                @error('password')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation">
                            </div>
                            <div class="form-group">
                                <input class="btn_1" type="submit" value="{{ __('website.send') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
