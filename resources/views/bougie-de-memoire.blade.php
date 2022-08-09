@extends('template')
@section('content')
    <div class="min-height-1100">
        <div class="container margin_60">
            <div class="row">
                <div class="col-12 margin-bottom-pc" id="section-1-bougie">
                    <h1>{{ __('website.light-a-candle') }}</h1>
                    <p>{{ __('website.text-candle-memories') }}</p>
                    <div class="text-nbre-bougie">
                        {!! __('website.text-candle',['nbre' =>$count]) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 padding-bottom-40" id="section-other-bougie">
                    <div class="box_general_3 box-bougie-memoire">
                        <p>{{ __('website.light-a-personal-candle') }}</p>
                        <form method="POST" action="{{ url('/rechercher') }}" role="search">
                            @csrf
                            <input type="hidden" name="sexe" value="tous">
                            <div class="input-group">
                                <input type="text" class=" search-query recherche" placeholder="{{ __('website.search-by-name') }}" name="q">
                            </div>
                            <div class="input-group">
                                <button class="btn-custom-bougie" type="submit">{{ __('website.search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 padding-bottom-40" id="section-other-bougie">
                    <div class="box_general_3 box-bougie-memoire background-custom">
                        <p style="margin-bottom: 12px;">{{ __('website.light-a-general-candle') }}</p>
                        <form id="form-allumer-bougie-general" >
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <p>{{ __('website.subtitle-light-general-candle') }}</p>
                            <div class="input-group">
                                <button type="button" class="btn-custom-bougie btn-allumer" style="width: 100%;" onclick="allumerBougieGeneral('{{ url('/allumer-bougie-general') }}', '#form-allumer-bougie-general')">
                                    <div class="spinner-border spinner-border-sm mr-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <i class="icon-fire-1 fire"></i>{{ __('website.light-a-candle') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('modal')
    @include("modals.modal-video-allumer")
@endsection
@section('custom-js')
    <script src="{{ asset("public/front/js/custom.js") }}"></script>
    <script>
        $( function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = "{{ route('autocomplete') }}";
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }
            function deleteLast( term ) {
                var newStr = term.substring(0, term.length - 1);
                var resArray = newStr.split(",");
                var poppedItem = resArray.pop();
                return resArray.toString();
            }
            $(".recherche").autocomplete({
                minLength: 0,
                source: function (request, response) {
                    $.ajax(url,{
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            term: extractLast(request.term)
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
                    this.value = terms.join( "," );
                    var status = $(this).attr("name");
                    $("#"+status).val($("#"+status).val()+ ui.item.value+",")
                    return false;
                }
            });
        });
    </script>
@endsection
