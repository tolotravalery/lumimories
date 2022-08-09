@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="login-2">
                <form action="{{ route('register-front') }}" method="post">
                    @csrf
                    <input type="hidden" name="url" value="{{ $url }}">
                    <div class="box_form clearfix">
                        <div class="box_login">
                            <h1>{{ __('website.sign-up') }}</h1>
                            <div class="display-flex justify-content-between">
                                <div class="form-group width-49">
                                    <input type="text" class="form-control" placeholder="{{ __('website.your-name') }}" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group width-49">
                                    <input type="text" class="form-control" placeholder="{{ __('website.your-first-name') }}" name="prenom" value="{{ old('prenom') }}">
                                    @error('prenom')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="{{ __('website.your-email-address') }}" name="email" value="{{ old('email') }}">
                                @error('email')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-password">
                                    <input type="email" class="form-control" placeholder="{{ __('website.confirm-email') }}" name="email_confirmation">
                                </div>
                                @error('email')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group ">
                                <div class="form-password">
                                    <input type="password" class="form-control" placeholder="********" name="password" id="password">
                                    <i class="fa fa-eye" id="eye" onclick="showPassword()"></i>
                                </div>
                                @error('password')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group text-center">
                                <input class="btn_1" type="submit" value="{{ __('website.register') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
