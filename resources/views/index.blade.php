@extends("template-index")
@section("content")
    <div class="hero_home version_1" >
        <div class="content">
            <h3 class="fadeInUp animated">Lumimories</h3>
            <p class="fadeInUp animated">
                {{ __('website.an-eternal-memory-for-your-loved-ones') }}
            </p>
            @include("recherche")
        </div>
    </div>
    <div class="bg_color_1">
        <div class="container margin_120_95">
            <div class="main_title">
                @if(Config::get('app.locale')=="fr")
                    @php
                        setlocale (LC_TIME, 'fr_FR.utf8','fra');
                    @endphp
                @endif
                <h2><a href="{{ url('/list-profil-decedes-aujourdhui') }}">{{ __('website.title-index-page',['date-du-jour' =>  strftime("%d %B") ]) }}</a></h2>
                <p></p>
            </div>
            @include("carousel")
        </div>
    </div>
@endsection
@section("custom-js")
    <script>
        function clearInputDate() {
            $("input[type=date]").val("");
            $("#date-value").val("{{ __('website.date-of-death') }}");
        }
        function valueDateBetween() {
            var dateDebut = $.datepicker.formatDate('dd-mm-yy', new Date($("#dateDebut").val()));
            var dateFin = $.datepicker.formatDate('dd-mm-yy', new Date($("#dateFin").val()));
            if(dateFin === "NaN-NaN-NaN"){
                $("#date-value").html("{{ __('website.date-greater-than') }} "+ dateDebut )
            }
            if(dateDebut === "NaN-NaN-NaN"){
                $("#date-value").html("{{ __('website.date-less-than') }} "+  dateFin)
            }
            if(dateDebut !== "NaN-NaN-NaN" && dateFin !== "NaN-NaN-NaN"){
                $("#date-value").html("{{ __('website.date-between') }} : " + dateDebut +" {{ __('website.and') }} "+ dateFin)
            }
        }
    </script>
@endsection
