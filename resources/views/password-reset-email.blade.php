@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="login-2">
                <h1>{{ __('website.reset-password') }}</h1>
                <form action="{{ route('send-reset-link-email') }}" method="post">
                    @csrf
                    <div class="box_form clearfix">
                        <div class="box_login">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('website.your-email-address') }}" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
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
