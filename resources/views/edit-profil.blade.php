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
                        <form action="{{ Route('modifier-profil') }}" method="POST" id="form-ajouter-profil" enctype="multipart/form-data" autocomplete="off">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @csrf
                            <input type="hidden" name="id" value="{{ $profil->id }}">
                            @if (session('message'))
                                <p class="step-title text-center text-{{ session('css') }}">{{ session('message') }}</p>
                            @endif
                            <div class="tab" id="tab-0">
                                <p class="step-title text-left">{{ __('website.his-identity') }}</p>
                                <p class="step-sub-title text-left" style="font-size: 18px;">{{ __('website.step-subtitle-0') }}</p>
                                <div class="radio-choice">
                                    <p class="step-sub-title">{{ __('website.famous-person') }} <input type="checkbox" name="regleNom" value="{{ $profil->regleNom }}" class="checkbox-style" onchange="valueRegleNom()" id="regleNom" {{ $profil->regleNom =="0" ? 'checked='.'"'.'checked'.'"' : '' }}/></p>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                        <p class="step-sub-title step-sub-title-custom font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.last-name') }} ?</span> <span class="step-sub-title-right-gris">{{ __('website.required-fields') }}</span></p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="text" name="nom" value="{{ $profil->nom }}" class="requis" required>
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
                                        @php
                                            $j = 1;
                                        @endphp
                                        @for($i =0; $i< count($prenoms); $i++)
                                            <input type="text" name="prenom{{$j}}" class="@if($i==0) requis @else @endif input-split mb-moin-10" value="{{ $prenoms[$i] }}" @if($i==0) required @else @endif>
                                            @php
                                                $j ++;
                                            @endphp
                                        @endfor
                                        <div class="field-ajouter-prenom"></div>
                                        <button class="btn-supl" id="ajouter-prenom" onclick="ajouterPrenom()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-first-name') }}</button>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('prenom1'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('prenom1') }}</small>
                                        @endif
                                    </div>
                                </div>
                                @if($profil->sexe =="Femme")
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                            <p class="step-sub-title step-sub-title-custom nom-de-jeune-fille font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.maiden-name') }} ?</span> <span class="step-sub-title-right-gris">{{ __('website.required-fields') }}</span></p>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <input type="text" name="nomDeJeuneFille" class="nom-de-jeune-fille-block" value="{{ $profil->nomDeJeuneFille }}">
                                        </div>
                                        <div class="col-12">
                                            @if ($errors->has('nomDeJeuneFille'))
                                                <small class="form-text text-danger text-left" id="error">{{ $errors->first('nomDeJeuneFille') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 display-inline-flex">
                                        <p class="step-sub-title step-sub-title-custom font-weight-bold"><span>{{ __('website.what-was-his') }} {{ __('website.nickname') }} ?</span></p>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        @php
                                            $j = 1;
                                        @endphp
                                        @for($i =0; $i< count($surnoms); $i++)
                                            <input type="text" name="surnom{{$j}}" class="input-split mb-moin-10" value="{{ $surnoms[$i] }}">
                                            @php
                                                $j ++;
                                            @endphp
                                        @endfor
                                        <div class="field-ajouter-surnom"></div>
                                        <button class="btn-supl" id="ajouter-surnom" onclick="ajouterSurnom()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-nickname') }}</button>
                                    </div>
                                </div>
                                <div class="radio-choice">
                                    <p class="step-sub-title padding-right-15px radio-sexe">{{ __('website.Femme') }} <input type="radio" name="sexe" value="Femme"  {{ $profil->sexe =="Femme" ? 'checked='.'"'.'checked'.'"' : '' }} /></p>
                                    <p class="step-sub-title radio-sexe">{{ __('website.Homme') }} <input type="radio" name="sexe" value="Homme"  {{ $profil->sexe =="Homme" ? 'checked='.'"'.'checked'.'"' : '' }} /></p>
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
                                            {{ __('website.edit-modif') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab" id="tab-2">
                                <p class="step-title text-center">{{ __('website.its-general-information') }}</p>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.date-of-birth') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="date" name="dateNaissance" id="date-naissance" value="{{ $profil->dateNaissance }}">
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
                                                <option value="{{ $p }}" {{ $profil->paysDeNaissance == $p ? "selected" : "" }}>{{ $p }}</option>
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
                                        <input type="date" name="dateDeces" id="date-deces" class="requis" value="{{ $profil->dateDeces }}" required>
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
                                            <option value="" selected="selected">{{ __('website.select-country') }} </option>
                                            @foreach($pays as $p)
                                                <option value="{{ $p }}" {{ $profil->pays == $p ? "selected" : "" }}>{{ $p }}</option>
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
                                        @php
                                            $j = 1;
                                        @endphp
                                        @for($i =0; $i< count($villesHabitees); $i++)
                                            <input type="text" name="villesHabitee{{$j}}" class="input-split mb-moin-10" value="{{ $villesHabitees[$i] }}">
                                            @php
                                                $j ++;
                                            @endphp
                                        @endfor
                                        <div class="field-ajouter-ville"></div>
                                        <button class="btn-supl" id="ajouter-ville" onclick="ajouterVille()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-city') }}</button>
                                    </div>
                                    <div class="col-12">
                                        @if ($errors->has('villesHabitees'))
                                            <small class="form-text text-danger text-left" id="error">{{ $errors->first('villesHabitees') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title"> {{ __('website.religion') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <select name="religion">
                                            <option value="" selected="selected">{{ __('website.select-religion') }} </option>
                                            <option value="judaisme" {{ $profil->religion == "judaisme" ? "selected" : "" }}>{{ __('website.judaism') }} </option>
                                            <option value="christianisme" {{ $profil->religion == "christianisme" ? "selected" : "" }}>{{ __('website.christianity') }} </option>
                                            <option value="islam" {{ $profil->religion == "islam" ? "selected" : "" }}>{{ __('website.islam') }} </option>
                                            <option value="hindouisme" {{ $profil->religion == "hindouisme" ? "selected" : "" }}>{{ __('website.hinduism') }} </option>
                                            <option value="bouddhisme" {{ $profil->religion == "bouddhisme" ? "selected" : "" }}>{{ __('website.buddhism') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.profession') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" name="profession" value="{{ $profil->session }}">
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
                                            {{ __('website.edit-modif') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="tab" id="tab-2">
                                <p class="step-title text-center">{{ __('website.his-biography') }}</p>
                                <p class="step-sub-title">{{ __('website.biography') }}</p>
                                <div class="row">
                                    <div class="col-12">
                                        --}}{{--<textarea class="textarea-input" name="biographie" id="biographie">{{ $profil->biographie }}</textarea>--}}{{--
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
                                <p class="step-title text-center">{{ __('website.his-resting-place') }}</p>
                                {{--<div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.reason-for-death') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <textarea class="textarea-input" name="motifDeces" rows="3" placeholder="{{ __('website.sickness') }}, {{ __('website.accident') }}, {{ __('website.other') }}">{{ $profil->motifDeces }}</textarea>
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
                                            <option value="buried" {{ $profil->lieuRepos ==  'buried' ? "selected" : "" }}>{{ __('website.buried') }}</option>
                                            <option value="cremated" {{ $profil->lieuRepos == 'cremated' ? "selected" : "" }}>{{ __('website.cremated') }}</option>
                                            <option value="unknown" {{ $profil->lieuRepos == 'unknown' ? "selected" : "" }}>{{ __('website.unknown') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-cemetery') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCimitiere" name="nomCimitiere" value="{{ $profil->nomCimitiere }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.division') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="division" name="division" value="{{ $profil->division }}">
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.aisle') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" name="allee" value="{{ $profil->allee }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.row') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" name="rang" value="{{ $profil->row }}">
                                    </div>
                                </div>--}}
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.number') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="numero" name="numero" value="{{ $profil->numero }}">
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.cemetery-card') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id='carteCimitiere' name="carteCimitiere" value="{{ $profil->carteCimitiere }}">
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
                                            {{ __('website.edit-modif') }}
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
                                        <input type="text" id="nomPere" name="nomPere" class="not-required recherche" value="{{ empty($genealogie[0]) == true ? "" : $genealogie[0][0][1] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomPereNumber" id="nomPereNumber" value="{{ empty($genealogie[0]) == true ? "" : $genealogie[0][0][0] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-mother') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomMere" name="nomMere" class="not-required recherche" value="{{ empty($genealogie[1]) == true ? "" : $genealogie[1][0][1] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomMereNumber" id="nomMereNumber" value="{{ empty($genealogie[1]) == true ? "" : $genealogie[1][0][0] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.husbands-name')  }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCH" name="nomCH" class="not-required recherche" value="{{ empty($genealogie[4]) == true ? "" : $genealogie[4][0][1] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomCHNumber" id="nomCHNumber" value="{{ empty($genealogie[4]) == true ? "" : $genealogie[4][0][0] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.wifes-name') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12">
                                        <input type="text" id="nomCF" name="nomCF" class="not-required recherche" value="{{ empty($genealogie[5]) == true ? "" : $genealogie[5][0][1] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomCFNumber" id="nomCFNumber" value="{{ empty($genealogie[5]) == true ? "" : $genealogie[5][0][0] }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-brothers') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 field-ajouter">
                                        <input type="text" id="nomFreres0" name="nomFreres[]" class="not-required recherche mb-moin-10" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][0][1] }}" oninput="changeSexe('Homme')">
                                        <input type="hidden" name="nomFreresNumber[]" id="nomFreres0Number" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][0][0] }}">
                                        @for($i = 1 ; $i< count($genealogie[2]); $i++)
                                            <input type="text" id="nomFreres{{ $i }}" name="nomFreres[]" class="not-required recherche" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][$i][1] }}">
                                            <input type="hidden" name="nomFreresNumber[]" id="nomFreres{{ $i }}Number" value="{{ empty($genealogie[2]) == true ? "" : $genealogie[2][$i][0] }}">
                                        @endfor
                                        <button class="btn-supl" id="ajouter-frere" onclick="ajouterFrere()" type="button"><i class="fa fa-plus"></i> {{ __('website.add-brother') }}</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <p class="step-sub-title">{{ __('website.name-of-sisters') }}</p>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 field-ajouter1">
                                        <input type="text" id="nomSoeurs0" name="nomSoeurs[]" class="not-required recherche mb-moin-10" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][0][1] }}" oninput="changeSexe('Femme')">
                                        <input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs0Number" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][0][0] }}">
                                        @for($i = 1 ; $i< count($genealogie[3]); $i++)
                                            <input type="text" id="nomSoeurs{{ $i }}" name="nomSoeurs[]" class="not-required recherche" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][$i][1] }}">
                                            <input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs{{ $i }}Number" value="{{ empty($genealogie[3]) == true ? "" : $genealogie[3][$i][0] }}">
                                        @endfor
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
                                            {{ __('website.edit-modif') }}
                                        </button>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="tab" id="tab-4">
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
                                            {{ __('website.edit-modif') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::check())
                                <input type="hidden" name="user" value="{{  Auth::user()->id }}">
                            @else
                                <div class="tab" id="tab-5">
                                    <input type="hidden" name="user">
                                    <p class="step-title text-center">{{ __('website.sign-in')}}</p>
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
                                    <div class="overflow-auto step-navigation">
                                        <div class="float-left display-none" id="form-error-6">
                                            <i class="pe-7s-attention"></i> {{ __('website.required-fields') }}
                                        </div>
                                        <div class="float-right display-inline-flex">
                                            <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="button-step">
                                                {{ __('website.back') }}
                                            </button>
                                            <button type="submit" class="btn btn-common btn-ajouter-profil display-none button-step">
                                                <div class="spinner-border spinner-border-sm mr-2" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                {{ __('website.edit-modif') }}
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
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.1/ckeditor.js"></script>--}}
    <script src="{{ asset("public/front/js/step.js") }}"></script>
    <script type="text/javascript">
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
        $(document).ready(function() {
            /*CKEDITOR.replace('biographiename');*/
            if( '{{ $profil->lieuRepos }}' === 'cremated' || '{{ $profil->lieuRepos }}' === 'unknown'){
                $('#carteCimitiere').val();
                $('#numero').val();
                $('#division').val();
                $('#nomCimitiere').val();

                $('#carteCimitiere').prop( "disabled", true );
                $('#numero').prop( "disabled", true );
                $('#division').prop( "disabled", true );
                $('#nomCimitiere').prop( "disabled", true );
            }
        });

        function checkLieuRepos(self){
            if(self.value === 'cremated' || self.value === 'unknown'){
                $('#carteCimitiere').val();
                $('#numero').val();
                $('#division').val();
                $('#nomCimitiere').val();

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
        @php $i = 0; @endphp
        var preloaded = [
            @foreach(explode("|",$profil->photoProfil) as $photo)
                {id: '{{ $i }}', src: '{{ asset($photo) }}'},
                @php $i ++ @endphp
            @endforeach

        ];
        $('.input-images').imageUploader({
            imagesInputName: 'photoProfil',
            labelFirst: '{{ __('website.add-picture-profile') }}',
            label: '{{ __('website.picture-number') }}',
            preloaded: preloaded

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
        var x = {{ count($genealogie[2]) == 0 ? 1 :  count($genealogie[2])}};
        var y = {{ count($genealogie[3]) == 0 ? 1 :  count($genealogie[3])}};
        function ajouterFrere() {
            $(wrapper).append('<div class="display-flex"><input type="text" name="nomFreres[]" id="nomFreres'+x+'" class="not-required recherche nomFreres"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a><input type="hidden" name="nomFreresNumber[]" id="nomFreres'+x+'Number"></div>');
            $('.nomFreres').on('input',function (e) {
                $('#sexe').val("Homme")
            })
            $(".recherche").autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax(url,{
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
                focus: function() {
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    terms.pop();
                    terms.push( ui.item.label );
                    terms.push("");
                    this.value = terms.join( "" );
                    $(this).val(ui.item.label)
                    var status = $(this).attr("id");
                    $("#"+status+"Number").val(ui.item.value);
                    $(this).addClass("highlight-input-text");
                    return false;
                }
            }).keydown(function (event) {
                if (event.keyCode == 8) {
                    var status = $(this).attr("id");
                    console.log(status);
                    $("#"+status+"Number").val("");
                } else {
                    console.log("not deete")
                } });
            x++;
        }
        $(wrapper).on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
        function ajouterSoeur() {
            $(wrapper1).append('<div class="display-flex"><input type="text" name="nomSoeurs[]" id="nomSoeurs'+y+'" class="not-required recherche nomSoeurs"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a><input type="hidden" name="nomSoeursNumber[]" id="nomSoeurs'+y+'Number"></div>');
            $('.nomSoeurs').on('input',function (e) {
                $('#sexe').val("Femme")
            })
            $(".recherche").autocomplete({
                minLength: 1,
                source: function (request, response) {
                    $.ajax(url,{
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
                focus: function() {
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    terms.pop();
                    terms.push( ui.item.label );
                    terms.push("");
                    this.value = terms.join( "" );
                    $(this).val(ui.item.label)
                    var status = $(this).attr("id");
                    $("#"+status+"Number").val(ui.item.value);
                    $(this).addClass("highlight-input-text");
                    return false;
                }
            }).keydown(function (event) {
                if (event.keyCode == 8) {
                    var status = $(this).attr("id");
                    console.log(status);
                    $("#"+status+"Number").val("");
                } else {
                    console.log("not deete")
                } });
            y++;
        }
        $(wrapper1).on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
        var countPrenom= {{ count($prenoms) }};*/

        function ajouterPrenom() {
            var wrapper = $(".field-ajouter-prenom");
            $(wrapper).append('<div class="display-flex"><input type="text" name="prenom'+countPrenom+'" class="not-required"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a></div>');
            countPrenom++;
            remove(wrapper);
        }

        var countVille= {{ count($villesHabitees) == 0 || count($villesHabitees) == 1 ? 2 :  count($villesHabitees)  }};

        function ajouterVille() {
            var wrapper = $(".field-ajouter-ville");
            $(wrapper).append('<div class="display-flex"><input type="text" name="villesHabitee'+countVille+'" class="not-required"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a></div>');
            countVille++;
            remove(wrapper);
        }

        var countSurnom= {{ count($surnoms) == 0 || count($surnoms) == 1 ? 2 :  count($surnoms)  }};

        function ajouterSurnom() {
            var wrapper = $(".field-ajouter-surnom");
            $(wrapper).append('<div class="display-flex"><input type="text" name="surnom'+countSurnom+'" class="not-required"/><a class="remove_field"><i class="fa fa-2x fa-trash-o"></i> </a></div>');
            countSurnom++;
            remove(wrapper);
        }

        function remove(wrapper) {
            $(wrapper).on("click", ".remove_field", function (e) {
                e.preventDefault();
                $(this).parent('div').remove();
            });
        }

    </script>
@endsection
