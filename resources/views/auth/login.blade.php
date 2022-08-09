@extends('layouts.app')

@section('content')
    <p class="login-box-msg">{{ __('Login') }}</p>

    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3 @error('email') is-invalid @enderror">
            <input type="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" name="email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
            <small class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
        <div class="input-group mb-3 @error('password') is-invalid @enderror">
            <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
            <small class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
            </div>
        </div>
    </form>

    {{--<p class="mb-1">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        @endif
    </p>
    <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">{{ __('Register') }}</a>
    </p>--}}
@endsection
