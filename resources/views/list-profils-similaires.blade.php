@extends('template')
@section('custom-css')
    <link href="{{ asset("public/front/css/image-uploader.css") }}" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLUKdzMJrBPN0X49DX6fgon44GwjqZ46o&libraries=places"></script>
    <link href="{{ asset("public/front/css/editor.css") }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    @if(Auth::check())
                    @else
                        <div class="tab" id="tab-extra">
                            <p class="step-title text-left">{{ __('website.hello') }}</p>
                            <p class="step-sub-title text-left" style="font-size: 18px;">{{ __('website.sub-title-choose') }}</p>
                            <a href="{{ url('/login-front/ajout-profil') }}" class="btn btn-primary">
                                {{ __('website.log-in-extra') }}
                            </a>
                            <a href="{{ url('/register-front/ajout-profil') }}" class="btn btn-outline-primary">
                                {{ __('website.create-an-account') }}
                            </a>
                        </div>
                    @endif
                    <div class="tab" id="tab-0">
                        <p class="step-title text-left">{{ __('website.register-a-loved-one') }}</p>
                        <p class="step-sub-title text-left" style="font-size: 18px;">{{ __('website.step-subtitle-0') }}</p>
                        @if (session('message'))
                            <p class="text-left text-success underline">{{ session('message') }}</p>
                            <div class="row">
                                @foreach(session('estEgale') as $profil)
                                    <div class="col-lg-4 col-md-4 col-sm-12 cursor-pointer" onclick="location.href='{{ url('/detail/'.$profil->id) }}'">
                                        @if($profil->photoProfil != "")
                                            <img class="img-fluid noir-et-blanc card-img-top same-height" src="{{ asset(explode("|",$profil->photoProfil)[0]) }}" alt="{{ $profil->prenoms }}">
                                        @else
                                            <img class="img-fluid noir-et-blanc card-img-top same-height" src="{{ asset("/public/photo-profiles/default.jpg") }}" alt="{{ $profil->prenoms }}">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $profil->nomFirstProfil() }}</h5>
                                            <p class="text-center">{{ $profil->nomSecondProfil() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="padding-top-40 boutons-recherche text-center">
                                    <a href="{{ route('mes-proches') }}" class="btn-light-candle-in-page-search">
                                        <i class="fa fa-heart"></i> {{ __('website.my-relatives') }}
                                    </a>
                                    <a href="{{ url('/ajout-profil') }}" class="btn-light-candle-in-page-search">
                                        <i class="fa fa-arrow-circle-right"></i> {{ __('website.continue') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="sexe">
@endsection
@section('custom-js')
    <script src="{{ asset("public/front/js/image-uploader.js") }}"></script>
    <script src="{{ asset("public/front/js/custom-ajout-profil.js") }}"></script>
    <script src="{{ asset("public/front/js/step.js") }}"></script>
    <script type="text/javascript">
        function afficherChampsExtra() {
            if($('#div-afficher-champs-inscription').hasClass("display-none") === true) $('#div-afficher-champs-inscription').removeClass("display-none");
            else $('#div-afficher-champs-inscription').addClass("display-none");
        }
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#date-deces').attr('max', maxDate);
        $('#date-naissance').attr('max', maxDate);
        $('#date-naissance').change(function() {
            $('#date-deces').attr('min', $(this).val());
        });
        $('#date-deces').change(function() {
            $('#date-naissance').attr('max', $(this).val());
        });
        /*CKEDITOR.replace('biographiename');*/
        function checkLieuRepos(self){
            if(self.value === 'cremated' || self.value === 'unknown'){
                $('#carteCimitiere').prop( "disabled", true );
                $('#numero').prop( "disabled", true );
                $('#division').prop( "disabled", true );
                $('#nomCimitiere').prop( "disabled", true );
            }
            else{
                $('#carteCimitiere').prop( "disabled", false );
                $('#numero').prop( "disabled", false );
                $('#division').prop( "disabled", false );
                $('#nomCimitiere').prop( "disabled", false );
            }
        }
        google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('nomCimitiere'));
            google.maps.event.addListener(places, 'place_changed', function () {
            });
        });
    </script>
    <script>
        function valueRegleNom() {
            if ($('#regleNom').is(':checked')) {
                $('#regleNom').val(0);
            }
            else $('#regleNom').val(1);
        }
        function changeSexe(value){
            $('#sexe').val(value)
        }
        $('.input-images').imageUploader({
            imagesInputName: 'photoProfil',
            label: '{{ __('website.picture-number') }}',
            labelFirst: '{{ __('website.add-picture-profile') }}',
        });
    </script>
@endsection
