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
                    <div class="step-block">
                        <form action="{{ route('soumettre-profil') }}" method="POST" id="form-ajouter-profil" enctype="multipart/form-data" autocomplete="off">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            @csrf
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
                                <div class="radio-choice">
                                    <p class="step-sub-title">{{ __('website.famous-person') }} <input type="checkbox" name="regleNom" value="1" class="checkbox-style" onchange="valueRegleNom()" id="regleNom"/></p>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                        <p class="step-sub-title step-sub-title-custom font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.last-name') }} ?</span> <span class="step-sub-title-right-gris">{{ __('website.required-fields') }}</span></p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" class="requis" required >
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('nom'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('nom') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                        <p class="step-sub-title step-sub-title-custom font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.first-name') }} ?</span> <span class="step-sub-title-right-gris">{{ __('website.required-fields') }}</span></p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="text" name="prenom1" class="requis input-split mb-moin-10" value="{{ old('prenom1') }}" required>
                                        <div class="field-ajouter-prenom"></div>
                                        <button class="btn-supl" id="ajouter-prenom" onclick="ajouterPrenom()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-first-name') }}</button>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('prenom1'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('prenom1') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                        <p class="step-sub-title step-sub-title-custom nom-de-jeune-fille font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.maiden-name') }} ?</span> <span class="step-sub-title-right-gris">{{ __('website.required-fields') }}</span></p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="text" name="nomDeJeuneFille" class="nom-de-jeune-fille" value="{{ old('nomDeJeuneFille') }}">
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('nomDeJeuneFille'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('nomDeJeuneFille') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                        <p class="step-sub-title step-sub-title-custom font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.nickname') }} ?</span></p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="text" name="surnom1" class="input-split mb-moin-10" value="{{ old('surnom1') }}">
                                        <div class="field-ajouter-surnom"></div>
                                        <button class="btn-supl" id="ajouter-surnom" onclick="ajouterSurnom()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-nickname') }}</button>
                                    </div>
                                </div>
                                <div class="radio-choice">
                                    <p class="step-sub-title padding-right-15px radio-sexe">{{ __('website.Femme') }} <input type="radio" name="sexe" value="Femme" {{ old('sexe')=="Femme" ? 'checked='.'"'.'checked'.'"' : '' }} onchange="openNomDeJeuneFille()"/></p>
                                    <p class="step-sub-title radio-sexe">{{ __('website.Homme') }} <input type="radio" name="sexe" value="Homme"  {{ old('sexe')=="Homme" ? 'checked='.'"'.'checked'.'"' : '' }} onchange="openNomDeJeuneFille()"/></p>
                                </div>
                                @if ($errors->has('sexe'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('sexe') }}</small>
                                @endif
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-0">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                            {{ __('website.back') }}
                                        </button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class="button-step">
                                            {{ __('website.continue') }}
                                        </button>
                                        <button type="submit" class="btn btn-common btn-ajouter-profil display-none">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab" id="tab-1">
                                <p class="step-title text-center">{{ __('website.its-general-information') }}</p>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.date-of-birth') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="date" name="dateNaissance" id="date-naissance" value="{{ old('dateNaissance') }}">
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('dateNaissance'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('dateNaissance') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.native-country') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <select name="paysDeNaissance">
                                            <option value="" selected="selected">{{ __('website.select-country') }}</option>
                                            @foreach($pays as $p)
                                                <option value="{{ $p }}" {{ old('paysDeNaissance') == $p ? "selected" : "" }}>{{ $p }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('paysDeNaissance'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('paysDeNaissance') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.date-of-death') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="date" name="dateDeces" id="date-deces" class="requis" value="{{ old('dateDeces') }}" required>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('dateDeces'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('dateDeces') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.country-of-death') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <select name="pays" class="requis" required>
                                            <option value="" selected="selected">{{ __('website.select-country') }}</option>
                                            @foreach($pays as $pa)
                                                <option value="{{ $pa }}" {{ old('pays') == $pa ? "selected" : "" }}>{{ $pa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('pays'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('pays') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.inhabited-cities') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" name="villesHabitee1" class="input-split mb-moin-10" value="{{ old('villesHabitee1') }}">
                                        <div class="field-ajouter-ville"></div>
                                        <button class="btn-supl" id="ajouter-ville" onclick="ajouterVille()"><i class="fa fa-plus"></i> {{ __('website.add-city') }}</button>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('villesHabitee1'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('villesHabitee1') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.religion') }} </p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <select name="religion">
                                            <option value="" selected="selected">{{ __('website.select-religion') }} </option>
                                            <option value="judaisme" {{ "judaisme" == old('religion') ? "selected" : "" }}>{{ __('website.judaism') }} </option>
                                            <option value="christianisme" {{ "christianisme" == old('religion')  ? "selected" : "" }}>{{ __('website.christianity') }} </option>
                                            <option value="islam" {{ "islam" == old('religion')  ? "selected" : "" }}>{{ __('website.islam') }} </option>
                                            <option value="hindouisme" {{ "hindouisme" == old('religion')  ? "selected" : "" }}>{{ __('website.hinduism') }} </option>
                                            <option value="bouddhisme" {{ "bouddhisme" == old('religion')  ? "selected" : "" }}>{{ __('website.buddhism') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.profession') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" name="profession" value="{{ old('profession') }}">
                                    </div>
                                </div>
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-1">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                            {{ __('website.back') }}
                                        </button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class="button-step">
                                            {{ __('website.continue') }}
                                        </button>
                                        <button type="submit" class="btn btn-common btn-ajouter-profil display-none">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="tab" id="tab-2">
                                <p class="step-title text-center">{{ __('website.his-biography') }}</p>
                                <p class="step-sub-title">{{ __('website.biography') }}</p>
                                <div class="row">
                                    <div class="col-12">
                                        --}}{{--<textarea class="textarea-input" name="biographie" rows="6" id="biographie">{{ old('biographie') }}</textarea>--}}{{--
                                        <div id="biographiename">
                                            {!! old('biographie') !!}
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
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                            {{ __('website.back') }}
                                        </button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class="button-step">
                                            {{ __('website.continue') }}
                                        </button>
                                        <button type="submit" class="btn btn-common btn-ajouter-profil display-none">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="tab" id="tab-2">
                                <p class="step-title text-center">{{ __('website.his-resting-place') }}</p>
                                {{--<div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.reason-for-death') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <textarea class="textarea-input" name="motifDeces" rows="3" placeholder="{{ __('website.sickness') }}, {{ __('website.accident') }}, {{ __('website.other') }}">{{ old('motifDeces') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('motifDeces'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('motifDeces') }}</small>
                                        @endif
                                    </div>
                                </div>--}}
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.resting-place') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <select name="lieuRepos" id="lieuRepos" onchange="checkLieuRepos(this)">
                                            <option value="buried" {{ old('lieuRepos') == 'buried' ? "selected" : "" }}>{{ __('website.buried') }}</option>
                                            <option value="cremated" {{ old('lieuRepos') == 'cremated' ? "selected" : "" }}>{{ __('website.cremated') }}</option>
                                            <option value="unknown" {{ old('lieuRepos') == 'unknown' ? "selected" : "" }}>{{ __('website.unknown') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-cemetery') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCimitiere" name="nomCimitiere" value="{{ old('nomCimitiere') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.division') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="division" name="division" value="{{ old('division') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.number') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="numero" name="numero" value="{{ old('numero') }}">
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.cemetery-card') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id='carteCimitiere' name="carteCimitiere" value="{{ old('carteCimitiere') }}">
                                    </div>
                                </div>--}}
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-3">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                            {{ __('website.back') }}
                                        </button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class="button-step">
                                            {{ __('website.continue') }}
                                        </button>
                                        <button type="submit" class="btn btn-common btn-ajouter-profil display-none">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="tab" id="tab-4">
                                <p class="step-title text-center">{{ __('website.his-genealogy') }}</p>
                                <p class="step-sub-title text-center">{{ __('website.list-family-members') }}</p>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-father') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomPere" name="nomPere" class="not-required recherche" value="{{ old('nomPere') }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomPereNumber" id="nomPereNumber" value="{{ old("nomPereNumber") }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-mother') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomMere" name="nomMere" class="not-required recherche" value="{{ old('nomMere') }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomMereNumber" id="nomMereNumber" value="{{ old("nomMereNumber") }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.husbands-name')  }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCH" name="nomCH" class="not-required recherche" value="{{ old('nomCH') }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomCHNumber" id="nomCHNumber" value="{{ old("nomCHNumber") }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.wifes-name') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCF" name="nomCF" class="not-required recherche" value="{{ old('nomCF') }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomCFNumber" id="nomCFNumber" value="{{ old("nomCFNumber") }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-brothers') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 field-ajouter">
                                        <input type="text" id="nomFreres0" name="nomFreres[]" class="not-required recherche mb-moin-10" value="{{ old('nomFreres')[0] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomFreresNumber[]" id="nomFreres0Number" value="{{ old("nomFreresNumber")[0] }}">
                                        <button class="btn-supl" id="ajouter-frere" onclick="ajouterFrere()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-brother') }}</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-sisters') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 field-ajouter1">
                                        <input type="text" id="nomSoeurs0" name="nomSoeurs[]" class="not-required recherche mb-moin-10" value="{{ old('nomSoeurs')[0] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs0Number" value="{{ old("nomSoeursNumber")[0] }}">
                                        <button class="btn-supl" id="ajouter-soeur" onclick="ajouterSoeur()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-sister') }}</button>
                                    </div>
                                </div>
                                <div class="new-input">
                                    <input type="hidden" value="1" id="total-input-text">
                                </div>
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-4">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                            {{ __('website.back') }}
                                        </button>
                                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class="button-step">
                                            {{ __('website.continue') }}
                                        </button>
                                        <button type="submit" class="btn btn-common btn-ajouter-profil display-none">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="tab" id="tab-3">
                                <p class="step-title text-center">{{ __('website.profile-picture') }}</p>
                                <p class="step-sub-title text-center">{!! __('website.description-picture') !!}</p>
                                <div class="input-images display-flex"></div>
                                @if ($errors->has('photoProfil'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('photoProfil') }}</small>
                                @endif
                                @if ($errors->has('photoProfil.*'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('photoProfil.*') }}</small>
                                @endif
                                <div class="overflow-auto step-navigation">
                                    <div class="float-left display-none" id="form-error-5">
                                        <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                    </div>
                                    <div class="float-right display-inline-flex">
                                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                            {{ __('website.back') }}
                                        </button>
                                        @if(Auth::check())
                                        @else
                                            <button type="button" id="nextBtn" onclick="nextPrev(1)" class="button-step">
                                                {{ __('website.continue') }}
                                            </button>
                                        @endif
                                        <button type="submit" class="btn btn-common btn-ajouter-profil display-none">
                                            <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            {{ __('website.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::check())
                                <input type="hidden" name="user" value="{{  Auth::user()->id }}">
                            @else
                                <div class="tab" id="tab-4">
                                    <p class="step-title text-center">{{ __('website.sign-in') ." ". __('website.or') ." ". __('website.sign-up') }}</p>
                                    <p class="step-sub-title">{{ __('website.email') }}</p>
                                    <input type="text" name="email" class="requis" value="{{ Auth::check() == true ? Auth::user()->email : old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <small class="form-text text-danger text-left" id="error">{{ $errors->first('email') }}</small>
                                    @endif

                                    <p class="step-sub-title">{{ __('website.password') }}</p>
                                    <input type="password" name="password" class="requis" value="{{ old('password') }}" required>
                                    @if ($errors->has('password'))
                                        <small class="form-text text-danger text-left" id="error">{{ $errors->first('password') }}</small>
                                    @endif
                                    <div>
                                        <button onclick="afficherChampsExtra()" class="btn fire-jaune" type="button">{{ __('website.add-information') }}</button>
                                    </div>
                                    <div id="div-afficher-champs-inscription" class="display-none">
                                        <p class="step-sub-title">{{ __('website.first-name') }}</p>
                                        <input type="text" name="nomUtilisateur">
                                        @if ($errors->has('nomUtilisateur'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('nomUtilisateur') }}</small>
                                        @endif

                                        <p class="step-sub-title">{{ __('website.last-name') }}</p>
                                        <input type="text" name="prenomUtilisateur">
                                        @if ($errors->has('prenomUtilisateur'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('prenomUtilisateur') }}</small>
                                        @endif
                                    </div>

                                    <div class="overflow-auto step-navigation">
                                        <div class="float-left display-none" id="form-error-6">
                                            <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                        </div>
                                        <div class="float-right display-inline-flex">
                                            <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                                {{ __('website.back') }}
                                            </button>
                                            <button type="submit" class="btn btn-common btn-ajouter-profil button-step display-none">
                                                <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                {{ __('website.add') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="sexe">
@endsection
@section('custom-js')
    <script src="{{ asset("public/front/js/image-uploader.js") }}"></script>
    <script src="{{ asset("public/front/js/custom-ajout-profil.js") }}"></script>{{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.1/ckeditor.js"></script>--}}
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
        /*var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = "{{ route('autocomplete') }}";
        function extractLast( term ) {
            return split( term ).pop();
        }
        function split( val ) {
            return val.split( /,\s*!/ );
        }
        var urlAutre = "{{ route('autocompleteautre') }}";

        $(".recherche").each(function() {
            $(this).autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax(url, {
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            term: extractLast(request.term),
                            sexe: $('#sexe').val()

                        }),
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    terms.pop();
                    terms.push(ui.item.label);
                    terms.push("");
                    this.value = terms.join("");
                    $(this).val(ui.item.label)
                    var status = $(this).attr("id");
                    $("#" + status + "Number").val(ui.item.value);
                    $(this).addClass("highlight-input-text");
                    return false;
                }
            }).keydown(function (event) {
                if (event.keyCode == 8) {
                    var status = $(this).attr("id");
                    $("#" + status + "Number").val("");
                } else {
                    console.log("not deete")
                }
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li><div><img src='" + item.image + "'><span>" + item.label + "</span></div></li>").appendTo(ul);
            };
        });
        var wrapper = $(".field-ajouter");
        var wrapper1 = $(".field-ajouter1");
        var x = 1;
        var y = 1;
        function ajouterFrere() {
            $(wrapper).append('<div class="display-flex"><input type="text" name="nomFreres[]" id="nomFreres'+x+'" class="not-required recherche nomFreres"><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a><input type="hidden" name="nomFreresNumber[]" id="nomFreres'+x+'Number"></div>');
            $('.nomFreres').on('input',function (e) {
                $('#sexe').val("Homme")
            })
            $(".recherche").each(function() {
                $(this).autocomplete({
                    minLength: 1,
                    source: function (request, response) {
                        $.ajax(url, {
                            headers: {
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            method: "POST",
                            contentType: "application/json",
                            data: JSON.stringify({
                                term: extractLast(request.term),
                                sexe: $('#sexe').val()
                            }),
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    focus: function () {
                        return false;
                    },
                    select: function (event, ui) {
                        var terms = split(this.value);
                        terms.pop();
                        terms.push(ui.item.label);
                        terms.push("");
                        this.value = terms.join("");
                        $(this).val(ui.item.label)
                        var status = $(this).attr("id");
                        $("#" + status + "Number").val(ui.item.value);
                        $(this).addClass("highlight-input-text");
                        return false;
                    }
                }).keydown(function (event) {
                    if (event.keyCode == 8) {
                        var status = $(this).attr("id");
                        $("#" + status + "Number").val("");
                    } else {
                        console.log("not deete")
                    }
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    return $("<li><div><img src='" + item.image + "'><span>" + item.label + "</span></div></li>").appendTo(ul);
                };
            });
            x++;
        }

        function ajouterSoeur() {
            $(wrapper1).append('<div class="display-flex"><input type="text" name="nomSoeurs[]" id="nomSoeurs'+y+'" class="not-required recherche nomSoeurs"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a><input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs'+y+'Number"></div>');
            $('.nomSoeurs').on('input',function (e) {
                $('#sexe').val("Femme")
            })
            $(".recherche").each(function() {
                $(this).autocomplete({
                    minLength: 1,
                    source: function (request, response) {
                        $.ajax(url, {
                            headers: {
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            method: "POST",
                            contentType: "application/json",
                            data: JSON.stringify({
                                term: extractLast(request.term),
                                sexe: $('#sexe').val()
                            }),
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    focus: function () {
                        return false;
                    },
                    select: function (event, ui) {
                        var terms = split(this.value);
                        terms.pop();
                        terms.push(ui.item.label);
                        terms.push("");
                        this.value = terms.join("");
                        $(this).val(ui.item.label)
                        var status = $(this).attr("id");
                        $("#" + status + "Number").val(ui.item.value);
                        $(this).addClass("highlight-input-text");
                        return false;
                    }
                }).keydown(function (event) {
                    if (event.keyCode == 8) {
                        var status = $(this).attr("id");
                        $("#" + status + "Number").val("");
                    } else {
                        console.log("not deete")
                    }
                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    return $("<li><div><img src='" + item.image + "'><span>" + item.label + "</span></div></li>").appendTo(ul);
                };
            });
            y++;
        }
        $(wrapper).on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
        $(wrapper1).on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });*/

    </script>
@endsection
