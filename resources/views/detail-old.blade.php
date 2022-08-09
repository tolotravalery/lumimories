@extends('template')
@section('custom-css')
    <link href="{{ asset("public/front/css/image-uploader.css") }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container margin_60">
        <div class="row">
            <div class="col-md-11 margin-0-auto padding-0">
                <nav id="secondary_nav">
                    <div class="container">
                        <ul class="clearfix">
                            <li><a href="#info" class="active">{{ __('website.general-informations') }}</a></li>
                            <li><a href="#anecdote">{{ __('website.anecdotes') }}</a></li>
                            <li><a href="#genealogie">{{ __('website.genealogy') }}</a></li>
                            <li><a href="#photos">{{ __('website.pictures') }}</a></li>
                            <li><a href="#monuments">{{ __('website.monuments') }}</a></li>
                            @if(Auth::check())
                                @if(Auth::user()->id == $profil->user->id)
                                    <li><a href="{{ url('/edit-profil/'.$profil->id) }}">{{ __('website.edit') }}</a></li>
                                    <li><a data-toggle="modal" data-target="#modal-supprimer" onclick="modalDeleteProfil('{{ $profil->id }}', '{{ $profil->nomFirstProfil() }}')">{{ __('website.delete') }}</a></li>
                                    <li><a href="#check-genealogy">{{ __('website.check-genealogy') }}</a></li>
                                @endif
                            @endif
                        </ul>
                    </div>
                </nav>
                <div>
                    <div class="box_general_3" >
                        <div id="info">
                            <div class="row">
                                <div class="col-4 text-center margin-bottom-pc">
                                    <form method="post" action="{{ route('previous') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $profil->id }}">
                                        <input type="hidden" name="nom" value="{{ $profil->nom }}">
                                        <button class="btn-header" type="submit">{{ __('website.previous') }}</button>
                                    </form>
                                </div>
                                @if(Auth::check())
                                    @if(Auth::user()->id == $profil->user->id)
                                        <div class="col-4 text-center margin-bottom-pc">
                                            <a class="btn-header" href="{{ url('/edit-profil/'.$profil->id) }}"><i class="fa fa-edit"></i> {{ __('website.edit-modif') }} </a>
                                        </div>
                                    @else
                                        <div class="col-4 text-center margin-bottom-pc">
                                            @if (session('message-suivre'))
                                                <h4 class="text-success mb-4">
                                                    @if(Session::has('message-suivre'))
                                                        {{ Session::get('message-suivre') }}
                                                    @endif
                                                </h4>
                                            @endif
                                            <form method="post" action="{{ url('/suivre') }}">
                                                @csrf
                                                <input type="hidden" name="profil" value="{{ $profil->id }}">
                                                <button class="btn-header" href="#" id="{{ $systeme }}">{{ $systeme }} <i class="pe-7s-add-user font-weight-bolder"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-4 text-center margin-bottom-pc">
                                        @if (session('message-suivre'))
                                            <h4 class="text-success mb-4">
                                                @if(Session::has('message-suivre'))
                                                    {{ Session::get('message-suivre') }}
                                                @endif
                                            </h4>
                                        @endif
                                        <form method="post" action="{{ url('/suivre') }}">
                                            @csrf
                                            <input type="hidden" name="profil" value="{{ $profil->id }}">
                                            <button class="btn-header" href="#" id="{{ $systeme }}">{{ $systeme }} <i class="pe-7s-add-user font-weight-bolder"></i></button>
                                        </form>
                                    </div>
                                @endif
                                <div class="col-4 text-center margin-bottom-pc">
                                    <form method="post" action="{{ route('next') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $profil->id }}">
                                        <input type="hidden" name="nom" value="{{ $profil->nom }}">
                                        <button class="btn-header">{{ __('website.next') }}</button>
                                    </form>
                                </div>
                                <div class="col-lg-5 col-md-4">
                                    <div id="custCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                                        @if($profil->photoProfil != "")
                                            <div class="carousel-inner photo-carousel-inner">
                                                @php $i=0; @endphp
                                                @foreach(explode("|",$profil->photoProfil) as $photo)
                                                    <div class="carousel-item @if($i==0) active @endif photo-carousel-item"><img src="{{ asset($photo) }}" alt="{{ $profil->prenoms ." ". $profil->nom }}" class="img-fluid noir-et-blanc"></div>
                                                    @php $i++; @endphp
                                                @endforeach
                                            </div>
                                            @if(count(explode("|",$profil->photoProfil)) > 1)
                                            <ol class="carousel-indicators list-inline">
                                                @php $j=0; @endphp
                                                @foreach(explode("|",$profil->photoProfil) as $photo)
                                                    <li class="list-inline-item @if($j==0) active @endif"> <a id="carousel-selector-{{$j}}" @if($j==0) class="selected" @endif data-slide-to="{{$j}}" data-target="#custCarousel"> <img src="{{ asset($photo) }}" alt="" class="img-fluid noir-et-blanc"> </a> </li>
                                                    @php $j++; @endphp
                                                @endforeach
                                            </ol>
                                            @endif
                                        @else
                                            <div class="carousel-inner">
                                                <div class="carousel-item active "><img src="{{ asset("/public/photo-profiles/default.jpg") }}" alt="{{ $profil->prenoms ." ". $profil->nom }}" class="img-fluid noir-et-blanc"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-8">
                                    <h1 class="text-uppercase">{{ $profil->nomFirstProfil() }}</h1>
                                    <h5>{{ $profil->nomSecondProfil() }}</h5>
                                    <ul class="contacts">
                                        <li>
                                        @if($pere!= null)
                                            {{ $profil->sexe == "Homme" ? __('website.son-of') : __('website.daughter-of') }} {{ $pere->nom ? $pere->nom. " ". $pere->prenoms : "" }}
                                        @endif
                                        @if($pere != null && $mere != null)
                                            {{ __('website.and-of') }}
                                        @endif
                                        @if($pere == null && $mere != null)
                                            {{ $profil->sexe == "Homme" ? __('website.son-of') : __('website.daughter-of') }}
                                        @endif{{ $mere ? $mere->nom. " ". $mere->prenoms : ""  }}
                                        </li>
                                    </ul>
                                    <br/>
                                    <ul class="contacts">
                                        <li>
                                            <i class="icon-fire-1 fire-jaune"></i> <span class="nbreIncrementeBougie-{{ $profil->id }}">{{ $profil->nbreBougie }}</span> {{ __('website.candle') }}{{ $profil->nbreBougie >1 ? "s" : ""}}
                                        </li>
                                        <li>
                                            {{ __('website.born-on') }} {{ Carbon\Carbon::parse($profil->dateNaissance)->format('d-m-Y') }} {{ $profil->paysDeNaissance !="" ? __('website.to') ." ". $profil->paysDeNaissance : "" }}
                                        </li>
                                        <li>
                                            {{ __('website.deceased-on') }} {{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }} {{ $profil->pays !="" ? __('website.to') ." ". $profil->pays : "" }}
                                        </li>
                                        <li>
                                            <h6>{{ __('website.inhabited-cities') }}</h6>
                                            {{ $profil->villesHabitees }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if($profil->biographie!=null)
                            <div class="indent_title_in">
                                <i class="pe-7s-news-paper"></i>
                                <h3>{{ __('website.biography') }}</h3>
                            </div>
                            <div class="wrapper_indent">
                                <p>{!! $profil->biographie !!}</p>
                            </div>
                            <hr>
                        @endif
                        <div class="indent_title_in">
                            <i class="pe-7s-plus"></i>
                            <h3>{{ __('website.resting-place') }}</h3>
                        </div>
                        <div class="wrapper_indent">
                            <p>{{ __('website.resting-place') }} : {{ $profil->lieuRepos != null ? __('website.'.$profil->lieuRepos) : '' }}</p>
                            @if(__('website.'.$profil->lieuRepos) == __('website.buried'))
                                <p>{{ __('website.division') }} : {{ $profil->division }}</p>
                                <p>{{ __('website.number') }} : {{ $profil->numero }}</p>
                                <p>{{ __('website.cemetery-card') }} : {{ $profil->carteCimitiere }}</p>
                            @endif
                            {{--<p><a href="" target="_blank"> <strong>{{ __('website.view-on-map') }}</strong></a></p>--}}
                        </div>
                        <hr>
                        <div class="indent_title_in" id="anecdote">
                            <i class="pe-7s-global"></i>
                            <h3>{{ __('website.anecdotes') }}</h3>
                            @if (session('message'))
                                <h4 class="text-success mb-4">
                                    @if(Session::has('message'))
                                        {{ Session::get('message') }}
                                    @endif
                                </h4>
                            @endif
                        </div>
                        <div class="reviews-container">{{--owl-carousel owl-theme" id="anecdote-carousel--}}
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
                                            <div class="rev-info">
                                                [ {{ Carbon\Carbon::parse($anecdote->created_at)->format('d-m-Y') }} ] - {{ $anecdote->auteur }} :
                                            </div>
                                            <div class="rev-text">
                                                <p>
                                                    {{ str_limit($anecdote->avis, $limit = 250, $end = '...') }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="text-right"><a class="btn-light-candle" data-toggle="modal" data-target="#modal-anecdote">{{ __('website.add') }} {{ __('website.anecdote') }}</a></div>
                        <hr>
                        <div class="indent_title_in" id="genealogie">
                            <i class="pe-7s-albums"></i>
                            <h3>{{ __('website.genealogy') }}</h3>
                            @if(isset($profil->genealogie))
                                <p>{{ __('website.you-may-know') }}</p>
                            @endif
                        </div>
                        <div class="reviews-container">
                            @if(isset($profil->genealogie))
                                @include("carousel-genealogie")
                            @endif
                        </div>
                        <hr>
                        <div class="indent_title_in" id="photos">
                            <i class="pe-7s-albums"></i>
                            <h3>{{ __('website.pictures') }}</h3>
                            <span>{{ __('website.subtitle-photo') }}</span>
                            @if (session('message-photo'))
                                <h4 class="text-success mb-4">
                                    @if(Session::has('message-photo'))
                                        {{ Session::get('message-photo') }}
                                    @endif
                                </h4>
                            @endif
                        </div>
                        {{--<div class="text-right"><a class="btn-light-candle" href="{{ url('/ajout-photos/'.$profil->id) }}">{{ __('website.add') }} {{ __('website.picture') }}</a></div>--}}
                        <div class="text-right"><a class="btn-light-candle" data-toggle="modal" data-target="#modal-photo">{{ __('website.add') }} {{ __('website.picture') }}</a></div>
                        <div class="reviews-container photo-container">
                            <div class="row">
                                @php
                                    $nbreLigne = 1;
                                    $n = 9;
                                @endphp
                                @for($i = 0; $i<count($mesPhotos);$i++)
                                    <div class="col-lg-4 col-md-4 col-sm-12 photo-group afficher-{{$nbreLigne}}  @if($nbreLigne > 1) hidden @endif text-center">
                                        @if(Auth::check())
                                            @if(Auth::user()->id == $profil->user->id)
                                                <div class="views-supprimer"><a data-toggle="modal" data-target="#deleteModal" onclick="modalDelete({{ $mesPhotos[$i]->id }})"><i class="fa fa-2x fa-times views-supprimer-icone"></i></a> </div>
                                            @endif
                                        @endif
                                        <img class="photo" src="{{ asset($mesPhotos[$i]->image) }}" alt="{{ $mesPhotos[$i]->profil->user->email }}">
                                        <p class="margin-bottom-10">{{ $mesPhotos[$i]->dateDuPhoto }}</p>
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
                        <hr>
                        <div class="indent_title_in" id="monuments">
                            <i class="pe-7s-albums"></i>
                            <h3>{{ __('website.monuments') }}</h3>
                            @if (session('message-monument'))
                                <h4 class="text-success mb-4">
                                    @if(Session::has('message-monument'))
                                        {{ Session::get('message-monument') }}
                                    @endif
                                </h4>
                            @endif
                        </div>
                        <div class="text-right"><a class="btn-light-candle" data-toggle="modal" data-target="#modal-monument">{{ __('website.add') }} monument</a></div>
                        <div class="reviews-container photo-container">
                            <div class="row">
                                @foreach($profil->monuments as $multi)
                                    @foreach(explode("|",$multi->images) as $photo)
                                        <div class="col-lg-4 col-md-4 col-sm-12 photo-group">
                                            <img class="photo" src="{{ asset($photo) }}">
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        @if(Auth::check())
                            <hr>
                            @include('check-genealogie')
                        @endif
                        <hr/>

                        <ul class="ul-detail-form">
                            <li><button class="class-a"  data-toggle="modal" data-target="#modal-signaler"><i class="fa fa-flag font-weight-bolder"></i> {{ __('website.report-this-profile') }}</button></li>
                            <li><a class="class-a" href="{{ url('/edit-profil/'.$profil->id) }}"><i class="fa fa-edit font-weight-bolder"></i> {{ __('website.edit-modif') }}</a></li>
                        </ul>
                        {{--<ul class="ul-detail-form">
                            <li><button onclick="copyToClipboard()" class="class-a"><i class="fa fa-copy font-weight-bolder"></i> {{ __('website.copy-link') }}</button></li>
                            <li><button class="class-a"  data-toggle="modal" data-target="#modal-share"><i class="fa fa-share-alt font-weight-bolder"></i> {{ __('website.share') }}</button></li>
                        </ul>--}}
                        <ul class="ul-detail-form">
                            <li><button class="class-a"  data-toggle="modal" data-target="#modal-contact-admin"><i class="fa fa-envelope font-weight-bolder"></i> {{ __('website.contact-the-admin-by-email', ['name' =>$profil->nom." ".$profil->prenoms]) }}</button></li>
                            <li></li>
                        </ul>
                        <hr/>
                        <div class="indent_title_in" id="monuments">
                            <i class="pe-7s-share"></i>
                            <h3>{{ __('website.share') }}</h3>
                        </div>
                        <div class="display-flex justify-content-center">
                            <button class="button-social-media background-whatsapp" onclick="whatsapp()"><i class="fa fa-whatsapp"></i> <div>whatsapp</div></button>
                            <button class="button-social-media background-facebook" onclick="facebook()"><i class="fa fa-facebook"></i> <div>facebook</div></button>
                            <button class="button-social-media background-copy-link" onclick="copyToClipboard()"><i class="fa fa-copy"></i><div>{{ __('website.copy-link') }}</div></button>
                            <button class="button-social-media background-email" onclick='location.href="mailto:contact@lumimories.com"'><i class="fa fa-envelope"></i><div>{{ __('website.email') }}</div></button>
                        </div>
                    </div>
                    <div class="fixed-bottom-center">
                        <a href="#" class="btn-light-candle float-right" data-toggle="modal" data-target="#allumer-bougie" onclick="modals('@if($profil->photoProfil != ""){{asset(explode("|",$profil->photoProfil)[0])}} @else {{ asset("/public/photo-profiles/default.jpg") }} @endif','{{ $profil->prenoms." ".$profil->nom }}','<i class=\'icon-fire-1 fire-jaune\'></i><span class=\'nbreIncrementeBougie nbreIncrementeBougie-{{ $profil->id }}\'>{{ $profil->nbreBougie }}</span> {{ __('website.twinkling-candles') }}{{ $profil->nbreBougie >1 ? "s" : ""}}','@if($profil->nomPere != null || $profil->nomMere != null){{ $profil->sexe == "Homme" ? __('website.son-of') : __('website.daughter-of') }} {{ $profil->nomPere ? $profil->nomPere : "" }}\n'+
                            '@if($profil->nomPere != "" && $profil->nomMere)\n'+
                            ' {{ __('website.and-of') }}\n'+
                            '@endif {{ $profil->nomMere ? $profil->nomMere : ""  }} @else  @endif','{{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}','{{ Carbon\Carbon::parse($profil->dateNaissance)->format('d-m-Y') }}','{{ $profil->id }}','{{ Carbon\Carbon::parse($profil->dateDeces)->diff(Carbon\Carbon::parse($profil->dateNaissance))->format('%y') }} {{ __('website.years-old') }}')"><i class="icon-fire-1 fire"></i>{{ __('website.light-a-candle-in-his-memory') }}</a>
                    </div>
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

@endsection
@section('modal')
    @include("modals.modal-anecdote")
    @include("modals.modal-photo")
    @include("modals.modal-allumer-bougie")
    @include("modals.modal-media-sociaux")
    @include("modals.modal-signaler")
    @include("modals.modal-explication-suivre")
    @include("modals.modal-confirmation-supprimer")
    @include("modals.modal-contact-admin")
    @include("modals.modal-supprimer-profil")
    @include("modals.modal-edit-anecdote")
    @include("modals.modal-signaler-anecdote")
    @include("modals.modal-monument")
@endsection
@section("custom-js")
    <script src="{{ asset("public/front/js/image-uploader.js") }}"></script>
    <script>
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
        function modalSignalerAnecdote(id) {
            $('#anecdote-value').val(id);
        }
    </script>
    <script src="{{ asset("public/front/js/custom.js") }}"></script>
    <script>
        var copiedLink = "{{ URL::full() }}";
        //var imageLink = "{{ explode("|",$profil->photoProfil)[0] ? asset(explode("|",$profil->photoProfil)[0]) : asset("/public/photo-profiles/default.jpg") }}";
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

