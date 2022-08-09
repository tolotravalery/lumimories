@extends("template")
@section("content")
    @if(Config::get('app.locale')=="fr")
        @php
            setlocale (LC_TIME, 'fr_FR.utf8','fra');
        @endphp
    @endif
    <div class="min-height-1100">
        <div class="container margin_60_35">
            <div class="row  background-white">
                <div class="col-12 padding-top-40 padding-bottom-40">
                    <h1 class="text-center">{{ __('website.title-index-page',['date-du-jour' =>  strftime("%d %B") ]) }}</h1>
                </div>
                <div class="col-12">
                    <h2>{{ __('website.filter') }}</h2>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-12">
                    <select name="anneeDeNaissance" onchange="filtre(this)">
                        <option value="" selected="selected">{{ __('website.year-of-birth') }}</option>
                        @for($i =  Carbon\Carbon::now()->format('Y'); $i>=1900 ; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-12">
                    <select name="anneeDeDeces" onchange="filtre(this)">
                        <option value="" selected="selected">{{ __('website.year-of-death') }}</option>
                        @for($i =  Carbon\Carbon::now()->format('Y'); $i>=1900 ; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-12">
                    <select name="religion" onchange="filtre(this)">
                        <option value="" selected="selected">{{ __('website.select-religion') }} </option>
                        <option value="judaisme" {{ "judaisme" == old('religion') ? "selected" : "" }}>{{ __('website.judaism') }} </option>
                        <option value="christianisme" {{ "christianisme" == old('religion')  ? "selected" : "" }}>{{ __('website.christianity') }} </option>
                        <option value="islam" {{ "islam" == old('religion')  ? "selected" : "" }}>{{ __('website.islam') }} </option>
                        <option value="hindouisme" {{ "hindouisme" == old('religion')  ? "selected" : "" }}>{{ __('website.hinduism') }} </option>
                        <option value="bouddhisme" {{ "bouddhisme" == old('religion')  ? "selected" : "" }}>{{ __('website.buddhism') }} </option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-12">
                    <select name="sexe" id="sexe" onchange="filtre(this)">
                        <option value="" selected="selected">Sexe </option>
                        <option value="{{ __('website.Homme') }}">{{ __('website.Homme') }}</option>
                        <option value="{{ __('website.Femme') }}">{{ __('website.Femme') }}</option>
                    </select>
                </div>
                @foreach($profils as $profil)
                    <div class="card col-lg-3 col-md-3 col-sm-12 cursor-pointer myList" onclick="location.href='{{ url('/detail/'.$profil->id) }}'">
                        @if($profil->photoProfil != "")
                            <img class="img-fluid noir-et-blanc card-img-top same-height" src="{{ asset(explode("|",$profil->photoProfil)[0]) }}" alt="{{ $profil->prenoms }}">
                        @else
                            <img class="img-fluid noir-et-blanc card-img-top same-height" src="{{ asset("/public/photo-profiles/default.jpg") }}" alt="{{ $profil->prenoms }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $profil->nomFirstProfil() }}</h5>
                            <p class="text-center">{{ $profil->nomSecondProfil() }}</p>
                            <p class="display-none"> {{ \Carbon\Carbon::parse($profil->dateNaissance)->format('d-m-Y') }}</p>
                            <p class="display-none"> {{ \Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}</p>
                            <p class="display-none"> {{ $profil->religion }}</p>
                            <p class="display-none"> {{ $profil->sexe }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 padding-bottom-40">
                    {{ $profils->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section("custom-js")
    <script>
        function filtre(input)
        {
            var value = $(input).val().toLowerCase();
            $(".myList").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        }
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
