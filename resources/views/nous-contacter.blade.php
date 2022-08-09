@extends('template')
@section('custom-css')
    <style>
        .contact-subtitle{
            text-align: left;
            border-bottom: 1px solid;
            padding: 5px 0;
        }
    </style>
@endsection
@section('content')
    <div class="">
        <div class="container margin_60_35">
            <form id="form-nous-contacter">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="row  background-white">
                    <div class="col-12">
                        <small class="form-text text-danger text-left" id="error"></small>
                        <small class="form-text text-success text-left" id="success"></small>
                    </div>
                    <div class="col-12  padding-bottom-40">
                        <h1>{{ __('website.contact-form') }}</h1>
                        <p class="contact-subtitle">{{ __('website.contact-form-subtitle') }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 padding-bottom-20">
                        <label>{{ __('website.last-name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nom" value="{{ old('nom') }}">
                        @if ($errors->has('nom'))
                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('nom') }}</small>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 padding-bottom-20">
                        <label>{{ __('website.first-name') }}</label>
                        <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}">
                        @if ($errors->has('prenom'))
                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('prenom') }}</small>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 padding-bottom-20">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('email') }}</small>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 padding-bottom-20">
                        <label>Telephone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="telephone" value="{{ old('telephone') }}" required>
                        @if ($errors->has('telephone'))
                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('telephone') }}</small>
                        @endif
                    </div>
                    <div class="col-12 padding-bottom-20">
                        <label>{{ __('website.message-subject') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="objet" value="{{ old('objet') }}" required>
                        @if ($errors->has('objet'))
                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('objet') }}</small>
                        @endif
                    </div>
                    <div class="col-12 padding-bottom-20">
                        <label>{{ __('website.your-message') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="message" rows="3" required>{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('message') }}</small>
                        @endif
                    </div>
                    <div class="col-12">
                        <button class="btn btn-light-candle btn-nous-contacter float-right"  onclick="nousContacter('{{ route('nous-contacter') }}', '#form-nous-contacter')" type="button">
                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            {{ __('website.send') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-js')
    <script src="{{ asset("public/front/js/custom.js") }}"></script>
@endsection