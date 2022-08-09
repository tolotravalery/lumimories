@extends('template')
@section('custom-css')
    <link href="{{ asset("public/front/css/editor.css") }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="step-block" style="height: auto!important;">
                        <form id="form-modifier-biographie">
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $profil->id }}">
                            <div class="tab" id="tab-0">
                                <p class="step-title text-center">{{ __('website.his-biography') }}</p>
                                <p class="step-sub-title">{{ __('website.biography')." ".__('website.of')." ".$profil->nomFirstProfil() }}</p>
                                <p class="form-text text-danger text-center" id="error"></p>
                                <p class="form-text text-success text-center" id="success"></p>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="biographiename">
                                            {!! $profil->biographie !!}
                                        </div>
                                        <input type="hidden" name="biographie" id="biographie">
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('biographie'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('biographie') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-2">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="button" class="btn btn-common btn-modifier-biographie" onclick="modifierBiographie('{{ route('modifier-biographie') }}', '#form-modifier-biographie')">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.validate') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="sexe">
@endsection
@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.1/ckeditor.js"></script>
    <script src="{{ asset("public/front/js/step.js") }}"></script>
    <script src="{{ asset("public/front/js/custom-modifier-biographie.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('biographiename');
        });
    </script>
@endsection
