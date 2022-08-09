<div id="reccomended" class="owl-carousel owl-theme">
    @php
        $i = 0;
    @endphp
    @foreach($profils as $profil)
        <div class="item">
            <a href="{{ url('/detail/'.$profil->id) }}">
                <div class="views"><i class="icon-fire-1 fire"></i>{{ $profil->nbreBougie }}</div>
                <div class="title">
                    <h4 class="text-uppercase">{{ $profil->nomFirstProfil() }} <em> {{ __('website.was') }} {{ $adjectifs[$i] }} {{ $gene[$i] }}</em></h4>
                </div>
                @if($profil->photoProfil != "")
                    <img class="noir-et-blanc" src="{{ asset(explode("|",$profil->photoProfil)[0]) }}" alt="{{ $profil->prenoms }}">
                @else
                    <img class="noir-et-blanc" src="{{ asset("/public/photo-profiles/default.jpg") }}" alt="{{ $profil->prenoms }}">
                @endif
            </a>
        </div>
        @php
            $i ++;
        @endphp
    @endforeach
</div>
