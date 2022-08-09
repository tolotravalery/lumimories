@extends('layouts.app')

@section('content')
    <p class="login-box-msg">{{ __('website.verify-your-email-address') }}</p>
    <div class="alert alert-success" role="alert">
        {{ __('website.fresh-verification-link') }}
    </div>
    {{ __('website.please-check-your-email') }}
    {{ __('website.if-not-receive-email') }}, <a href="{{ route('verification.resend') }}">{{ __('website.click-here-to-request-another') }}</a>.
@endsection
