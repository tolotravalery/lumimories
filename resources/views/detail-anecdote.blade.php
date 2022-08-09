@extends('template')
@section('content')
    <div class="container margin_60">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <nav id="secondary_nav">
                    <div class="container">
                        <ul class="clearfix">
                            <li><a href="#info" class="active">{{ __('website.anecdote-for') ." ". $anecdote->profil->prenoms ." ".$anecdote->profil->nom }}</a></li>
                            <li class="white-right">{{ Carbon\Carbon::parse($anecdote->created_at)->format('d-m-Y') }}</li>
                        </ul>
                    </div>
                </nav>
                <div>
                    <div class="box_general_3" >
                        <div class="profile" id="info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5>{{ __('website.author') }} :</h5>
                                    <p>{{ $anecdote->auteur }}</p>
                                </div>
                                <div class="col-lg-12">
                                    <h5>{{ __('website.notice') }} :</h5>
                                    <p>{{ $anecdote->avis }}</p>
                                </div>
                                <div class="col-lg-12">
                                    <h5>{{ __('website.pictures') }} :</h5>
                                </div>
                                @if($anecdote->photos != "")
                                    @foreach(explode("|",$anecdote->photos) as $photo)
                                        <div class="col-lg-4 col-md-4 col-sm-6">
                                            <img src="{{ asset($photo) }}" alt="{{ $anecdote->profil->prenoms ." ".$anecdote->profil->nom }}" class="img-fluid">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
