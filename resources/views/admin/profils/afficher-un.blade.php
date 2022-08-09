@extends("admin.template")
@section("content")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profil du {{ $profil->nom ." ". $profil->prenoms }}:</h3>
                <h3 class="card-title float-right"><i class="fas fa-arrow-right"></i> {{ $profil->sexe }}</h3>
                @if (session('message'))
                    <div class="text-center">
                        <h4 class="mb-4 {{ session('css') }}"> {{ session('message') }}</h4>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="callout callout-danger">
                            <h5>Date de décés</h5>
                            <p>{{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="callout callout-danger">
                            <h5>Date de naissance</h5>
                            <p>{{ Carbon\Carbon::parse($profil->dateNaissance)->format('d-m-Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="callout callout-danger">
                    <h5>Lieu de repos</h5>
                    <p>{{ __('website.'. $profil->lieuRepos) }}</p>
                </div>
                <div class="callout callout-info">
                    <h5>Biographie</h5>
                    <p>{{ $profil->biographie }}</p>
                </div>
                <div class="row">
                    <div class="col-12">
                        @include("admin.profils.genealogie")
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @include("admin.profils.table-list")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
