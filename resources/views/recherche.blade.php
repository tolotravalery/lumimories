<form method="POST" class="fadeInUp animated" action="{{ url('/rechercher') }}" role="search">
    @csrf
    <div id="recherche">
        <div class="input-group" id="rechercher">
            <input type="text" class=" search-query" placeholder="{{ __('website.search-by-name') }}" name="q">
            <button class="btn-search" type="submit">{{ __('website.search') }}</button>
        </div>
        @if ($errors->has('dateDebut'))
            <small class="form-text text-danger text-left" id="error">{{ $errors->first('dateDebut') }}</small>
        @endif
        @if ($errors->has('dateFin'))
            <small class="form-text text-danger text-left" id="error">{{ $errors->first('dateFin') }}</small>
        @endif
        {{--<ul>
            <li>
                <input type="radio" id="all" name="sexe" value="tous" checked>
                <label for="all">{{ __('website.all') }}</label>
            </li>
            <li>
                <input type="radio" id="men" name="sexe" value="Homme">
                <label for="men">{{ __('website.men') }}</label>
            </li>
            <li>
                <input type="radio" id="femal" name="sexe" value="Femme">
                <label for="femal">{{ __('website.women') }}</label>
            </li>
        </ul>--}}
        <input type="hidden" name="sexe" value="tous">
        <div class="padding-top-40 boutons-recherche">
            <a href="{{ url('/ajout-profil') }}" class="btn-light-candle-in-page-search"><i class="fa fa-plus-square-o"></i> {{ __('website.register-a-loved-one') }}</a>
            <a href="{{ route('bougie-de-memoire') }}" class="btn-light-candle-in-page-search"><i class="icon-fire-1 fire"></i>{{ __('website.light-a-candle') }}</a>
        </div>
    </div>
</form>
