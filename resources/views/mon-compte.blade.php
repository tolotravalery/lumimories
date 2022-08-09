@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div id="login-2">
                <h1>{{ __('website.my-account') }}</h1>
                <form action="{{ route('mon-compte') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    <div class="box_form clearfix">
                        <p class="step-title text-center">{{ __('website.my-account') }}</p>
                        <div class="box_login">
                            <div class="display-flex justify-content-between">
                                <div class="form-group width-49">
                                    <input type="text" class="form-control" placeholder="{{ __('website.your-name') }}" name="name" value="{{ Auth::user()->name }}">
                                    @error('name')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group width-49">
                                    <input type="text" class="form-control" placeholder="{{ __('website.your-first-name') }}" name="prenom" value="{{ Auth::user()->prenom }}">
                                    @error('prenom')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="{{ __('website.your-email-address') }}" name="email" value="{{ Auth::user()->email }}">
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
                            <div class="form-group">
                                <div class="form-password">
                                    <input type="password" class="form-control" placeholder="{{ __('website.confirm-password') }}" name="password_confirmation" id="password1">
                                    <i class="fa fa-eye" id="eye1" onclick="showPassword1()"></i>
                                </div>
                                @error('password')
                                <small class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="form-group text-center">
                                <input class="btn_1" type="submit" value="{{ __('website.edit-modif') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
