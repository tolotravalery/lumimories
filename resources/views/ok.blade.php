@extends('template')
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div class="row justify-content-md-center">
                <div class="col-md-9">
                    <div class="step-block padding-40">
                        <p class="step-title text-success text-center">{{ __('website.we-thank-you') }}</p>
                        <p class="step-title text-center">
                            {{ __('website.welcome',['nom' => session('userName')]) }} <br/>
                        </p>
                        <p class="step-title text-center">
                            {{ __('website.your-account-created') }} <br/>
                        </p>
                        @if (session('message'))
                            <p class="step-title text-center">{{ session('message') }}</p>
                        @endif

                        <p class="text-center">
                            <i class="text-success fa fa-4x fa-check-circle"></i>
                        </p>
                        <div class="text-center">
                            <a class="btn btn-common margin-auto" href="{{ url('/') }}">
                                {{ __('website.back-to-homepage') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
