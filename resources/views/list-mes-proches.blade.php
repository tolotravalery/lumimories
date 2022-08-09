@extends("template")
@section("content")
    @if(Config::get('app.locale')=="fr")
        @php
            setlocale (LC_TIME, 'fr_FR.utf8','fra');
        @endphp
    @endif
    <div class="min-height-1100">
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    {{--<div class="button-mobile">
                        <a href="{{ url('/ajout-profil') }}"
                           class="btn-header white display-inherit"><i class="fa fa-plus-square-o"></i> <span class="font-weight-bold">{{ __('website.register-a-loved-one') }}</span>
                        </a>
                    </div>--}}
                    <h1 class="text-center">{{ __('website.my-relatives') }}</h1>
                    @if (session('message'))
                        <h2 class="text-success text-center">
                            @if(Session::has('message'))
                                {{ Session::get('message') }}
                            @endif
                        </h2>
                    @endif
                    @foreach($profils as $profil)
                        <div class="strip_list fadeIn animated {{ $profil->sexe }}">
                            <div class="cursor-pointer" onclick="location.href='{{ url("/detail/".$profil->id) }}'">

                                <div class="div-mes-proches">
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
                                <div class="div-mes-proches">
                                    <p>Date</p>
                                    <p>{{ Carbon\Carbon::parse($profil->created_at)->format('d-m-Y H:i') }}</p>
                                </div>
                                <div class="div-mes-proches">
                                    <div class="div-mes-proches-cadre tooltip-extra"><i class="fa fa-eye"></i> {{ $profil->visit }}<span class="tooltiptext">{{ __('website.nbr-visitor') }}</span></div>
                                    <div class="div-mes-proches-cadre tooltip-extra"><i class="fa fa-heart"></i> {{ count($profil->usersSuivre) }}<span class="tooltiptext">{{ __('website.nbr-subscribers') }}</span></div>
                                    <div class="div-mes-proches-cadre tooltip-extra"><i class="fa fa-envelope"></i> {{ count($profil->contacts) }}<span class="tooltiptext">{{ __('website.nbr-contacts') }}</span></div>
                                </div>
                            </div>
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
                                @if($profil->operation == true)
                                    <li><a class="btn-modifier" href="{{ url('/edit-profil/'.$profil->id) }}">{{ __('website.update') }}</a></li>
                                    <li>
                                        <a class="btn-supprimer" data-toggle="modal" data-target="#modal-supprimer" onclick="modalDelete('{{ $profil->id }}', '{{ $profil->nomFirstProfil() }}')"><i class="fa fa-trash"></i></a>
                                    </li>
                                @endif
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
    @include("modals.modal-supprimer-profil")
@endsection
@section("custom-js")
    <script src="{{ asset("public/front/js/custom.js") }}"></script>
    <script>
        function modalDelete(id, nom) {
            $('#supprimer-form').attr('action','{{ url('/') }}/supprimer-profil/'+id);
            $('#nom-profil').html(nom);
        }
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
