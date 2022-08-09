@extends("template")
@section("content")
    <form method="POST" class="fadeInUp animated padding-bottom-20" action="{{ url('/rechercher-profil') }}" role="search">
        @csrf
        <div id="results">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="switch-field">
                            <input type="radio" id="all" name="sexe" value="tous" {{ $sexe == 'tous' ? "checked" : "" }} onclick="showListBy('Tous')">
                            <label for="all">{{ __('website.all') }}</label>
                            <input type="radio" id="men" name="sexe" value="Homme" {{ $sexe == 'Homme' ? "checked" : "" }} onclick="showListBy('Homme')">
                            <label for="men">{{ __('website.men') }}</label>
                            <input type="radio" id="women" name="sexe" value="Femme" {{ $sexe == 'Femme' ? "checked" : "" }} onclick="showListBy('Femme')">
                            <label for="women">{{ __('website.women') }}</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12">
                        <div class="switch-field">
                            <a class="plus @if(isset($ville) || isset($religion)) cacher-plus-filtre @endif" id="afficher-plus-filtre">{{ __('website.show-more-filter') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="search_bar_list">
                            <input type="text" class="form-control" placeholder="{{ __('website.search-by-name') }}" name="q" value="@if(isset($q)) {{ $q }} @endif">
                            {{--<input type="submit" value="{{ __('website.search') }}">--}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 plus-filtre" @if(isset($ville) || isset($religion)) style="display: block;" @endif>
                        <div class="search_bar_list">
                            <i class="fa fa-2x fa-map-marker icon-in-input"></i>
                            <input type="text" class="form-control padding-left-35" placeholder="{{ __('website.enter-city') }}" name="ville" value="@if(isset($ville)) {{ $ville }} @endif">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 plus-filtre" @if(isset($ville) || isset($religion)) style="display: block;" @endif>
                        <div class="search_bar_list">
                            <select name="religion" class="form-control">
                                <option value="" selected="selected">{{ __('website.select-religion') }} </option>
                                <option value="judaisme"  @if(isset($religion)){{ $religion == 'judaisme' ? "selected" : "" }} @endif>{{ __('website.judaism') }} </option>
                                <option value="christianisme" @if(isset($religion)){{ $religion == 'christianisme' ? "selected" : "" }} @endif>{{ __('website.christianity') }} </option>
                                <option value="islam" @if(isset($religion)){{ $religion == 'islam' ? "selected" : "" }} @endif>{{ __('website.islam') }} </option>
                                <option value="hindouisme" @if(isset($religion)){{ $religion == 'hindouisme' ? "selected" : "" }} @endif>{{ __('website.hinduism') }} </option>
                                <option value="bouddhisme" @if(isset($religion)){{ $religion == 'bouddhisme' ? "selected" : "" }} @endif>{{ __('website.buddhism') }} </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 plus-filtre" @if(isset($ville) || isset($religion)) style="display: block;" @endif>
                        <div class="search_bar_list">
                            <input type="text"  class="form-control" placeholder="{{ __('website.profession') }}" name="profession">
                        </div>
                    </div>
                    <div class="div-special-recherche">
                        <input class="btn-special-recherche" type="submit" value="{{ __('website.search') }} ({{ count($profils) ." ". __('website.results')}})">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="min-height-1100">
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="button-mobile">
                        <a href="{{ url('/ajout-profil') }}"
                           class="btn-header white display-inherit"><i class="fa fa-plus-square-o"></i> <span class="font-weight-bold">{{ __('website.register-a-loved-one') }}</span>
                        </a>
                    </div>
                    <p class="padding-top-65">{{ __('website.about') }} {{ count($profils) }} {{ __('website.result') }}{{ count($profils)>1 ? "(s)" :"" }} {{ __('website.for-research') }} "..<span class="text-blue">{{ implode(', ',explode(' ',$q)) }}</span>.." - @if(isset($sexe)){{ __('website.'.$sexe) }}@endif  @if(isset($religion)) - {{ __('website.religion'). ' : ' . $religion }}@endif @if(isset($ville)) - {{ __('website.inhabited-cities'). ' : ' . $ville }}@endif</p>
                    @foreach($profils as $profil)
                        <div class="strip_list fadeIn animated {{ $profil->sexe }}">
                            <div class="cursor-pointer" onclick="location.href='{{ url("/detail/".$profil->id) }}'">
                                <figure>
                                    <a href="{{ url('/detail/'.$profil->id) }}">
                                        @if($profil->photoProfil != "")
                                            <img class="noir-et-blanc" src="{{ asset(explode("|",$profil->photoProfil)[0]) }}" alt="{{ $profil->nomFirstProfil() }}">
                                        @else
                                            <img class="noir-et-blanc" src="{{ asset("/public/photo-profiles/default.jpg") }}" alt="{{ $profil->nomFirstProfil() }}">
                                        @endif
                                    </a>
                                </figure>
                                <h3 class="text-uppercase cursor-pointer" onclick="location.href='{{ url('/detail/'.$profil->id) }}'">{{ $profil->nomFirstProfil() }}</h3>
                                <small><i class="icon-fire-1 fire-jaune"></i> <span class="nbreIncrementeBougie-{{ $profil->id }}">{{ $profil->nbreBougie }}</span> {{__('website.candle')}}{{ $profil->nbreBougie >1 ? "s" : ""}}</small>
                                <small class="text-capitalize">
                                    @if($profil->nomPere != null || $profil->nomMere != null)
                                        {{ $profil->sexe == "Homme" ? __('website.son-of') : __('website.daughter-of') }} {{ $profil->nomPere ? $profil->nomPere : "" }}
                                        @if($profil->nomPere != "" && $profil->nomMere)
                                            {{ __('website.and-of') }}
                                        @endif {{ $profil->nomMere ? $profil->nomMere : ""  }}
                                    @else
                                    @endif
                                </small>
                                <small class="text-capitalize">{{ __('website.deceased-on') }} {{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}</small>
                                <small class="text-capitalize">{{ $profil->lieuDeRepos != "" ? __('website.rests-at')." ".$profil->lieuDeRepos : ""}}</small>
                                <small class="text-capitalize">{{ __('website.at-the-age-of')}} {{ Carbon\Carbon::parse($profil->dateDeces)->diff(Carbon\Carbon::parse($profil->dateNaissance))->format('%y') }} {{ __('website.years-old') }}</small>
                            </div>
                            {{--<a href="badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="{{ asset("public/front/img/badges/badge_1.svg") }}" width="15" height="15" alt=""></a>--}}
                            <ul>
                                <li>
                                    <form id="form-allumer-bougie">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <input type="hidden" name="profil">
                                        <button type="button" class="btn_listingbtn-light-candle" data-toggle="modal" data-target="#allumer-bougie" onclick="allumerBougie('@if($profil->photoProfil != ""){{asset(explode("|",$profil->photoProfil)[0])}} @else {{ asset("/public/photo-profiles/default.jpg") }} @endif','{{ $profil->prenoms." ".$profil->nom }}','<i class=\'icon-fire-1 fire-jaune\'></i><span class=\'nbreIncrementeBougie nbreIncrementeBougie-{{ $profil->id }}\'>{{ $profil->nbreBougie }}</span> {{ __('website.twinkling-candles') }}{{ $profil->nbreBougie >1 ? "s" : ""}}','@if($profil->nomPere != null || $profil->nomMere != null){{ $profil->sexe == "Homme" ? __('website.son-of') : __('website.daughter-of') }} {{ $profil->nomPere ? $profil->nomPere : "" }}\n'+
                                                '@if($profil->nomPere != "" && $profil->nomMere)\n'+
                                                ' {{ __('website.and-of') }}\n'+
                                                '@endif {{ $profil->nomMere ? $profil->nomMere : ""  }} @else  @endif','{{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}','{{ Carbon\Carbon::parse($profil->dateNaissance)->format('d-m-Y') }}','{{ $profil->id }}','{{ Carbon\Carbon::parse($profil->dateDeces)->diff(Carbon\Carbon::parse($profil->dateNaissance))->format('%y') }} {{ __('website.years-old') }}','{{ url('/allumer-bougie') }}','#form-allumer-bougie')"><i class="icon-fire-1 fire"></i>{{ __('website.light-my-candle') }}</button>
                                    </form>
                                </li>
                                <li><a href="{{ url('/detail/'.$profil->id) }}">{{ __("website.life-story") }}</a></li>
                            </ul>
                        </div>
                    @endforeach
                    {{ $profils->appends(Request::all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    @include("modals.modal-allumer-bougie")
@endsection
@section("custom-js")
    <script>
        $('#afficher-plus-filtre').click(function () {
            if($('#afficher-plus-filtre').hasClass('cacher-plus-filtre')){
                $('.plus-filtre').css('display','none');
                $('#afficher-plus-filtre').removeClass("cacher-plus-filtre");
            }
            else{
                $('.plus-filtre').css('display','block');
                $('#afficher-plus-filtre').addClass("cacher-plus-filtre");
            }
        });
    </script>
    <script src="{{ asset("public/front/js/custom.js") }}"></script>
    <script>
        var copiedLink = "{{ Request::url() }}";
        function facebook() {
            window.open("https://www.facebook.com/sharer/sharer.php?u=" + copiedLink, 'facebook-share-dialog', "width=626, height=436");
        }
        function whatsapp() {
            var win = window.open('https://api.whatsapp.com/send?text=' + copiedLink, '_blank');
            win.focus();
        }
        function twitter() {
            window.open("https://twitter.com/intent/tweet?url=" + copiedLink);
        }
    </script>
@endsection
