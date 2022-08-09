@extends('template')
@section('custom-css')
    <link href="{{ asset("public/front/css/image-uploader.css") }}" rel="stylesheet">
    <style>
        .notifyjs-corner {
            top: 170px !important;
            left: 20% !important;
            right: 20% !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 preview-next preview-next-algin-2">
                <form method="post" action="{{ route('previous') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $profil->id }}">
                    <input type="hidden" name="nom" value="{{ $profil->nom }}">
                    <button class="btn-header width-100-px" type="submit">{{ __('website.previous') }}</button>
                </form>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 preview-next preview-next-algin-1">
                <form method="post" action="{{ route('next') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $profil->id }}">
                    <input type="hidden" name="nom" value="{{ $profil->nom }}">
                    <button class="btn-header width-100-px">{{ __('website.next') }}</button>
                </form>
            </div>
            <div class="col-12">
                @if (session('message'))
                    <p class="form-text step-title text-center text-success">{{ session('message') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="offset-lg-1 offset-md-1 col-lg-4 col-md-4 col-sm-12 container-detail-head">
                <div id="custCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                    @if(Carbon\Carbon::parse($profil->dateDeces)->format('d') == Carbon\Carbon::today()->day && Carbon\Carbon::parse($profil->dateDeces)->format('m') == Carbon\Carbon::today()->month)
                        <div class="carousel-inner photo-carousel-inner">
                            <div class="carousel-item active photo-carousel-item"><img src="{{ asset($profil->photoanniveraire) }}" alt="{{ $profil->nomFirstProfil() }}" class="img-fluid"></div>
                        </div>
                    @else
                        @if($profil->photoProfil != "")
                            <div class="carousel-inner photo-carousel-inner">
                                @php $i=0; @endphp
                                @foreach(explode("|",$profil->photoProfil) as $photo)
                                    <div class="carousel-item @if($i==0) active @endif photo-carousel-item"><img src="{{ asset($photo) }}" alt="{{ $profil->nomFirstProfil() }}" class="img-fluid noir-et-blanc"></div>
                                    @php $i++; @endphp
                                @endforeach
                            </div>
                            @if(count(explode("|",$profil->photoProfil)) > 1)
                                <ol class="carousel-indicators list-inline">
                                    @php $j=0; @endphp
                                    @foreach(explode("|",$profil->photoProfil) as $photo)
                                        <li class="list-inline-item @if($j==0) active @endif"> <a id="carousel-selector-{{$j}}" @if($j==0) class="selected" @endif data-slide-to="{{$j}}" data-target="#custCarousel"> <img src="{{ asset($photo) }}" alt="" class="img-fluid noir-et-blanc"> </a> </li>
                                        @php $j = $j+1; @endphp
                                    @endforeach
                                </ol>
                            @endif
                        @else
                            <div class="carousel-inner photo-carousel-inner">
                                <div class="carousel-item active photo-carousel-item"><img src="{{ asset("/public/photo-profiles/default.jpg") }}" alt="{{ $profil->nomFirstProfil() }}" class="img-fluid noir-et-blanc"></div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 container-detail-head">
                <div class="information-generale">
                    <h1 class="text-uppercase text-white font-weight-normal">{{ $profil->nomFirstProfil() }}</h1>
                    <h5 class="text-white font-weight-normal">{{ $profil->nomSecondProfil() }}</h5>
                    @if(Carbon\Carbon::parse($profil->dateDeces)->format('d') == Carbon\Carbon::today()->day && Carbon\Carbon::parse($profil->dateDeces)->format('m') == Carbon\Carbon::today()->month)
                        <p class="text-left fire-jaune">{{ Carbon\Carbon::today()->diff(Carbon\Carbon::parse($profil->dateDeces))->format('%y') }} {{ __("website.text-anniversary") }}</p>
                    @endif
                    @if(Auth::check())
                        @if(Auth::user()->id == $profil->user->id)
                            <a class="btn-suivre" href="{{ url('/edit-profil/'.$profil->id) }}"><i class="fa fa-edit"></i> {{ __('website.edit-modif') }} </a>
                        @else
                            <form method="post" action="{{ url('/suivre') }}">
                                @csrf
                                <input type="hidden" name="profil" value="{{ $profil->id }}">
                                <div class="tooltip-extra">
                                    <button class="btn-suivre" id="{{ $systeme }}">@if(__('website.follow') != $systeme) <i class="fa fa-check"></i> @endif{{ $systeme }}</button>
                                    {{--@if(__('website.follow') == $systeme)<span class="tooltiptext">{{ __('website.info-subscriber') }}</span>@endif--}}
                                </div>
                            </form>
                        @endif
                    @else
                        <form method="post" action="{{ url('/suivre') }}">
                            @csrf
                            <input type="hidden" name="profil" value="{{ $profil->id }}">
                            <div class="tooltip-extra">
                                <button class="btn-suivre" id="{{ $systeme }}">@if(__('website.follow') != $systeme) <i class="fa fa-check"></i> @endif{{ $systeme }}</button>
                                {{--@if(__('website.follow') == $systeme)<span class="tooltiptext">{{ __('website.info-subscriber') }}</span>@endif--}}
                            </div>
                        </form>
                    @endif
                    <ul class="contacts">
                        <li>
                            <i class="icon-fire-1 fire-jaune"></i> <span class="nbreIncrementeBougie-{{ $profil->id }}">{{ $profil->nbreBougie }}</span> {{ __('website.candle') }}{{ $profil->nbreBougie >1 ? "s" : ""}}
                        </li>
                        <li>
                            {{ __('website.deceased-on-text-show-profil',['date' => Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y'),'age' => Carbon\Carbon::parse($profil->dateDeces)->diff(Carbon\Carbon::parse($profil->dateNaissance))->format('%y')]) }}
                        </li>
                        <li>
                            {{ __('website.resting-place') }} : <br/>
                            @if($profil->lieuRepos != null)
                                @switch($profil->lieuRepos)
                                    @case("buried")
                                    {{ __('website.resting-place-text-show-profil',['type' => __('website.'.$profil->lieuRepos)]) }}
                                    {{ $profil->nomCimitiere != null ? __('website.resting-place-text-show-profil-cimitiere',['cimitiere' => $profil->nomCimitiere]) : ''}}
                                    {{ $profil->numero != null ? __('website.resting-place-text-show-profil-numero',['num' => $profil->numero]).',' : ''}}
                                    {{ $profil->division != null ? __('website.resting-place-text-show-profil-division',['division' => $profil->division]).',' : '' }}
                                    {{ $profil->rang != null ? __('website.resting-place-text-show-profil-rang',['rang' => $profil->rang]) : ''}}
                                    @break
                                    @case("cremated")
                                    {{ __('website.resting-place-text-show-profil',['type' => __('website.'.$profil->lieuRepos)]) }}
                                    @break
                                    @case("unknown")
                                    {{ __('website.resting-place-text-show-profil',['type' => __('website.'.$profil->lieuRepos)]) }}
                                    @break
                                    @default
                                    @break
                                @endswitch
                            @endif
                        </li>
                        @if($profil->nomCimitiere != null)
                            <li>
                                <a class="btn-suivre" href="https://www.google.com/maps/search/{{$profil->nomCimitiere}}" target="_blank"><i class="fa fa-map-marker"></i> {{ __('website.even-on-the-map') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="offset-lg-1 offset-md-1 col-lg-10 col-md-10 col-sm-12 container-detail">
                <div class="accordion" id="accordion-detail">
                    <div class="card card-detail">
                        <div class="card-header" id="headingSix">
                            <div class="display-meme-ligne">
                                <h2>
                                    <i class="fa fa-2x fa-angle-down cursor-pointer" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix"></i>
                                    <button class="btn text-left" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                        {{ __('website.biography') }}
                                    </button>
                                </h2>
                                <h2 class="h2-right">
                                    <a class="btn fire-jaune" href="{{ route('edit-biographie',['id' => $profil->id]) }}"><i class="fa fa-plus"></i> {{ __('website.complete-biography') }}</a>
                                </h2>
                            </div>
                        </div>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion-detail">
                            <div class="card-body">
                                <div class="padding-20">{!! $profil->biographie !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-detail">
                        <div class="card-header" id="headingOne">
                            <div class="display-meme-ligne">
                                <h2>
                                    <i class="fa fa-2x fa-angle-down cursor-pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></i>
                                    <button class="btn text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('website.monuments') }}
                                    </button>
                                </h2>
                                <h2 class="h2-right">
                                    <a class="btn fire-jaune" data-toggle="modal" data-target="#modal-monument"><i class="fa fa-plus"></i> {{ __('website.add-monument-profile') }}</a>
                                </h2>
                            </div>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-detail">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($profil->monuments as $multi)
                                        @foreach(explode("|",$multi->images) as $photo)
                                            <div class="col-lg-4 col-md-12 col-sm-12 photo-group">
                                                <img class="photo" src="{{ asset($photo) }}">
                                                <p class="margin-bottom-10">{{ $multi->titreDuMonument }}</p>
                                                <p class="margin-bottom-10"><a href="https://www.google.com/maps/search/{{ $multi->adresseDuMonument }}" target="_blank">{{ $multi->adresseDuMonument }}</a></p>
                                                @if($multi->nom !=null || $multi->nom !="")<p class="margin-bottom-10">{{ $multi->nom }}</p>@endif
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-detail">
                        <div class="card-header" id="headingTwo">
                            <div class="display-meme-ligne">
                                <h2>
                                    <i class="fa fa-2x fa-angle-down cursor-pointer" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"></i>
                                    <button class="btn text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        {{ __('website.anecdotes') }}
                                    </button>
                                </h2>
                                <h2 class="h2-right">
                                    <a class="btn fire-jaune" data-toggle="modal" data-target="#modal-anecdote"><i class="fa fa-plus"></i> {{ __('website.add') ." ". __('website.anecdote') }}</a>
                                </h2>
                            </div>

                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-detail">
                            <div class="card-body">
                                @if (session('message'))
                                    <h4 class="text-success mb-4">
                                        @if(Session::has('message'))
                                            {{ Session::get('message') }}
                                        @endif
                                    </h4>
                                @endif
                                    <div class="reviews-container owl-carousel owl-theme" id="anecdote-carousel">
                                        @foreach($profil->anecdotes as $anecdote)
                                            @if($anecdote->valider == true)
                                                <div class="review-box clearfix">
                                                    <div class="rev-content">
                                                        @if(Auth::check())
                                                            @if(Auth::user()->id == $profil->user->id)
                                                                <div class="rev-navigation">
                                                                    <ul class="display-flex float-right cursor-pointer">
                                                                        <li class="ml-3">
                                                                            <a class="dropdown dropdown-toggle" data-toggle="dropdown"><i class="fa fa-2x fa-ellipsis-h"></i></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a class="dropdown-item" data-toggle="modal" data-target="#modal-edit-anecdote" onclick="modalEditAnecdote('{{ $anecdote->id }}','{{ $anecdote->auteur }}','{{ $anecdote->email }}','{{ $anecdote->avis }}')">
                                                                                    {{ __('website.update') }}
                                                                                </a>
                                                                                <div class="divider-extra"></div>
                                                                                <a class="dropdown-item" data-toggle="modal" data-target="#modal-signaler-anecdote" onclick="modalSignalerAnecdote({{ $anecdote->id }})">{{ __('website.report') }}</a>
                                                                            </div>
                                                                        </li>
                                                                        <li class="ml-3"><a data-toggle="modal" data-target="#deleteModal" onclick="modalDeleteAnecdote({{ $anecdote->id }})"><i class="fa fa-2x fa-close views-supprimer-icone"></i></a></li>

                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        <div class="rev-text">
                                                            <p class="avis">
                                                                {{ str_limit($anecdote->avis, $limit = 250, $end = '...') }}
                                                            </p>
                                                            <p class="auteur"> {{ $anecdote->auteur }} </p>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-detail">
                        <div class="card-header" id="headingThree">
                            <div class="display-meme-ligne">
                                <h2>
                                    <i class="fa fa-2x fa-angle-down cursor-pointer" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree"></i>
                                    <button class="btn text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                        {{ __('website.pictures') }}
                                    </button>
                                </h2>
                                <h2 class="h2-right">
                                    <a class="btn fire-jaune" data-toggle="modal" data-target="#modal-photo"><i class="fa fa-plus"></i> {{ __('website.add')." ".__('website.picture') }}</a>
                                </h2>
                            </div>

                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-detail">
                            <div class="card-body">
                                @if (session('message-photo'))
                                    <h4 class="text-success mb-4">
                                        @if(Session::has('message-photo'))
                                            {{ Session::get('message-photo') }}
                                        @endif
                                    </h4>
                                @endif
                                <div class="row">
                                    @php
                                        $nbreLigne = 1;
                                        $n = 9;
                                    @endphp
                                    @for($i = 0; $i<count($mesPhotos);$i++)
                                        <div class="col-lg-4 col-md-12 col-sm-12 photo-group afficher-{{$nbreLigne}}  @if($nbreLigne > 1) hidden @endif text-center">
                                            @if(Auth::check())
                                                @if(Auth::user()->id == $profil->user->id)
                                                    <div class="rev-navigation">
                                                        <ul class="display-flex float-right cursor-pointer">
                                                            <li class="ml-3">
                                                                <a class="dropdown dropdown-toggle" data-toggle="dropdown"><i class="fa fa-2x fa-ellipsis-h"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modal-edit-photo" onclick='modalEditPhoto("{{ $mesPhotos[$i]->id }}","{{ $mesPhotos[$i]->auteur }}","{{ $mesPhotos[$i]->email }}","{{$mesPhotos[$i]->nomDesGens}}","{{$mesPhotos[$i]->dateDuPhoto}}","{{$mesPhotos[$i]->commentaires}}")'>
                                                                        {{ __('website.update') }}
                                                                    </a>
                                                                </div>
                                                            </li>
                                                            <li class="ml-3"><a data-toggle="modal" data-target="#deleteModal" onclick="modalDelete({{ $mesPhotos[$i]->id }})"><i class="fa fa-2x fa-close views-supprimer-icone"></i></a></li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endif
                                            <img class="photo cursor" src="{{ asset($mesPhotos[$i]->image) }}" alt="{{ $mesPhotos[$i]->profil->user->email }}" data-toggle="modal" data-target="#agrandir-photo" onclick="currentSlide({{ $i+1 }})">
                                            <p class="margin-bottom-10" id="mes-photo-nom-des-gens-{{$i+1}}">{{ $mesPhotos[$i]->nomDesGens }}</p>
                                            <p class="margin-bottom-10" id="mes-photo-date-du-photo-{{$i+1}}">{{ $mesPhotos[$i]->dateDuPhoto }}</p>
                                            <p>{{ $mesPhotos[$i]->commentaires }}</p>
                                        </div>
                                        @if($i == $n-1 && $n < count($mesPhotos))
                                            @php $nbreLigne++; $n= $n+9;@endphp
                                            @if(count($mesPhotos)> count($mesPhotos)-$n)
                                                <div class="col-12 bouton-{{$nbreLigne-1}} @if($nbreLigne > 2) hidden @endif">
                                                    <div class="text-center"><a class="a-voir-plus" onclick="seemore({{ $nbreLigne }})">{{ __('website.see-more') }}</a></div>
                                                </div>
                                            @endif
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-detail">
                        <div class="card-header" id="headingFour">
                            <div class="display-meme-ligne">
                                <h2>
                                    <i class="fa fa-2x fa-angle-down cursor-pointer" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour"></i>
                                    <button class="btn text-left" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                        {{ __('website.genealogy') }}
                                    </button>
                                </h2>
                                <h2 class="h2-right">
                                    <a class="btn fire-jaune" href="{{ route('edit-genealogie',['id' => $profil->id]) }}"><i class="fa fa-plus"></i> {{ __('website.complete-genealogy') }}</a>
                                </h2>
                            </div>

                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion-detail">
                            <div class="card-body">
                                @if(isset($profil->genealogie))
                                    <p class="padding-top-15">{{ __('website.you-may-know') }}</p>
                                @endif
                                <div class="reviews-container">
                                    @if(isset($profil->genealogie))
                                        @include("carousel-genealogie")
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::check())
                        @if(Auth::user()->id == $profil->user->id)
                            <div class="card card-detail">
                                <div class="card-header" id="headingFive">
                                    <div class="display-meme-ligne">
                                        <h2>
                                            <i class="fa fa-2x fa-angle-down cursor-pointer" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive"></i>
                                            <button class="btn text-left" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                {{ __('website.check-genealogy') }}
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion-detail">
                                    <div class="card-body">
                                        @if(isset($profil->genealogie))
                                            <p class="padding-top-15">{{ __('website.you-may-know') }}</p>
                                        @endif
                                        @include("check-genealogie")
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-1 padding-0">
                <div class="sticky-menu">
                    <button class="button-sticky-menu background-facebook" onclick="facebook()"><i class="fa fa-facebook"></i></button>
                    <button class="button-sticky-menu background-whatsapp" onclick="whatsapp()"><i class="fa fa-whatsapp"></i></button>
                    <button class="button-sticky-menu background-twitter" onclick="twitter()"><i class="fa fa-twitter"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="offset-lg-1 offset-md-1 col-lg-10 col-md-10 col-sm-12">
                <ul class="ul-detail-form">
                    <li><button class="class-a"  data-toggle="modal" data-target="#modal-signaler"><i class="fa fa-flag font-weight-bolder"></i> {{ __('website.report-this-profile') }}</button></li>
                    <li><a class="class-a" href="{{ url('/edit-profil/'.$profil->id) }}"><i class="fa fa-edit font-weight-bolder"></i> {{ __('website.edit-modif') }}</a></li>
                    <li><button class="class-a"  data-toggle="modal" data-target="#modal-contact-admin"><i class="fa fa-envelope font-weight-bolder"></i> {{ __('website.contact-the-admin-by-email', ['name' =>$profil->nom." ".$profil->prenoms]) }}</button></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-bottom-center">
        <form id="form-allumer-bougie">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" name="profil" value="{{ $profil->id }}">
            <button type="button" class="btn-light-my-candle" data-toggle="modal" data-target="#allumer-bougie" onclick="allumerBougie('@if($profil->photoProfil != ""){{asset(explode("|",$profil->photoProfil)[0])}} @else {{ asset("/public/photo-profiles/default.jpg") }} @endif','{{ $profil->prenoms." ".$profil->nom }}','<i class=\'icon-fire-1 fire-jaune\'></i><span class=\'nbreIncrementeBougie nbreIncrementeBougie-{{ $profil->id }}\'>{{ $profil->nbreBougie }}</span> {{ __('website.twinkling-candles') }}{{ $profil->nbreBougie >1 ? "s" : ""}}','@if($profil->nomPere != null || $profil->nomMere != null){{ $profil->sexe == "Homme" ? __('website.son-of') : __('website.daughter-of') }} {{ $profil->nomPere ? $profil->nomPere : "" }}\n'+
                    '@if($profil->nomPere != "" && $profil->nomMere)\n'+
                    ' {{ __('website.and-of') }}\n'+
                    '@endif {{ $profil->nomMere ? $profil->nomMere : ""  }} @else  @endif','{{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}','{{ Carbon\Carbon::parse($profil->dateNaissance)->format('d-m-Y') }}','{{ $profil->id }}','{{ Carbon\Carbon::parse($profil->dateDeces)->diff(Carbon\Carbon::parse($profil->dateNaissance))->format('%y') }} {{ __('website.years-old') }}','{{ url('/allumer-bougie') }}','#form-allumer-bougie')"><i class="icon-fire-1"></i>{{ __('website.light-my-candle') }}</button>
        </form>

    </div>
@endsection
@section('modal')
    @include("modals.modal-anecdote")
    @include("modals.modal-photo")
    @include("modals.modal-allumer-bougie")
    @include("modals.modal-media-sociaux")
    @include("modals.modal-signaler")
    {{--@include("modals.modal-explication-suivre")--}}
    @include("modals.modal-confirmation-supprimer")
    @include("modals.modal-contact-admin")
    @include("modals.modal-supprimer-profil")
    @include("modals.modal-edit-anecdote")
    @include("modals.modal-signaler-anecdote")
    @include("modals.modal-monument")
    @include("modals.modal-edit-photo")
    @include("modals.modal-agrandir-photo")
    @include("modals.modal-explication")
@endsection
@section("custom-js")
    <script src="{{ asset("public/front/js/notify.min.js") }}"></script>
    <script>
        @if (session('message-suivre'))
            $(document).ready(function () {
                $.notify("{{ (__('website.follow') == $systeme) ? __('website.unfollow-message') : __('website.follow-message') }}",{ className : "success", hideDuration: 4000000});
            })
        @endif
    </script>
    <script src="{{ asset("public/front/js/image-uploader.js") }}"></script>
    <script>
        var countLoad = sessionStorage.getItem("countLoad") == null ? 0 : sessionStorage.getItem("countLoad");
        $(window).on('load',function(){
            if(countLoad == 0){
                $('#modal-explication').modal('show');
            }
            countLoad++;
            sessionStorage.setItem("countLoad", countLoad);
        });
        function closeModal() {
            document.getElementById("agrandir-photo").style.display = "none";
        }
        var slideIndex = 1;
        @if(count($mesPhotos) > 0)
            showSlides(slideIndex);
        @endif
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        $(document).on('keydown',function(e) {
            var code = (e.keyCode || e.which);
            if(code == 39) {
                plusSlides(1)
            }
            else if(code == 37){
                plusSlides(-1)
            }
        });
        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex-1].style.display = "block";
            $c1 = document.getElementById("mes-photo-nom-des-gens-"+slideIndex);
            $c2 = document.getElementById("mes-photo-date-du-photo-"+slideIndex);
            $('#caption-container-1').html($c1.textContent)
            $('#caption-container-2').html($c2.textContent)
        }
        function modalDeleteProfil(id, nom) {
            $('#supprimer-form').attr('action','{{ url('/') }}/supprimer-profil/'+id);
            $('#nom-profil').html(nom);
        }
        $('.input-photo').imageUploader({
            imagesInputName: 'photos',
            labelFirst: '{{ __('website.add-picture-profile') }}',
            label: '{{ __('website.picture-number') }}'
        });
        $('.input-monument').imageUploader({
            imagesInputName: 'monuments',
            labelFirst: '{{ __('website.add-monument-profile') }}',
            label: '{{ __('website.picture-number') }}'
        });
    </script>
    <script>
        function modalDelete(id) {
            $('#deleteForm').attr('action','{{ url('/') }}/supprimer-photo/'+id);
        }
        function modalDeleteAnecdote(id) {
            $('#deleteForm').attr('action','{{ url('/') }}/supprimer-anecdote/'+id);
        }
        function modalEditAnecdote(id, auteur, email, avis) {
            $('#form-edit-anecdote').attr('action','{{ url('/') }}/modifier-anecdote/'+id);
            $('#id').val(id);
            $('#auteur').val(auteur);
            $('#email').val(email);
            $('#avis').val(avis);
        }
        function modalEditPhoto(id,nom,email,nomDesGen,date,commentaire){
            $('#form-edit-photo').attr('action','{{ url('/') }}/modifier-photo/'+id);
            $('#id-photo').val(id);
            $('#auteur').val(auteur);
            $('#email').val(email);
            $('#commentaires').val(commentaire);
            $('#nomDesGens').val(nomDesGen);
            $('#dateDuPhoto').val(date);
        }
        function modalSignalerAnecdote(id) {
            $('#anecdote-value').val(id);
        }
    </script>
    <script src="{{ asset("public/front/js/custom.js") }}"></script>
    <script>
        var copiedLink = "{{ URL::full() }}";
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
        function copyToClipboard() {
            var inputc = document.body.appendChild(document.createElement("input"));
            inputc.value = window.location.href;
            inputc.focus();
            inputc.select();
            document.execCommand('copy');
            inputc.parentNode.removeChild(inputc);
        }
    </script>
@endsection

