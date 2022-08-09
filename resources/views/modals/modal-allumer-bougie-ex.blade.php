<div class="modal fade" id="allumer-bougie" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="tab1">
            <form id="form-allumer-bougie">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" name="profil" id="profil-id">
                <div class="modal-header background-modal-allumer-bougie">
                    <h5 class="modal-title text-white" id="light-candleLabel"><i class="icon-person"></i>{{ __('website.light-a-candle-in-memory-of') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-4 col-sm-12 text-center">
                            <div>
                                <img class="photo-profil img-fluid noir-et-blanc">
                                {{--<img src="{{ asset("/public/front/img/candle.gif") }}" class="img-bougie-anime">--}}
                                <p class="p-nbre-bougie"><span class="nbre-bougie"></span></p>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-8 col-sm-12">
                            <span class="nom-mobile nom font-size-25 font-weight-500 text-capitalize"></span>
                            <ul class="modal-info">
                                <li class="parent font-size-22"></li>
                                <li>{{ __('website.deceased-on') }} <span class="date-deces"></span></li>
                                <li>{{ __('website.at-the-age-of') }} <span class="age"></span></li>
                            </ul>
                            <div class="form-group">
                                <input class="form-control" name="nom" id="nom" type="text"
                                       @if(Auth::check())
                                       @if(Auth::user()->name == null && Auth::user()->prenom == null)
                                       @elseif(Auth::user()->name != null && Auth::user()->prenom == null)
                                       value="{{ Auth::user()->name }}"
                                       @elseif(Auth::user()->prenom != null  && Auth::user()->name == null)
                                       value="{{ Auth::user()->prenom }}"
                                       @elseif(Auth::user()->name != null && Auth::user()->prenom != null)
                                       value="{{ Auth::user()->prenom . " " . Auth::user()->name }}"
                                    @endif
                                    @endif
                                @if(Auth::check()==false)
                                    placeholder="{{ __('website.modal-allumer-name') }}"
                                @endif
                                >
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="3" id="message" placeholder="{{ __('website.your-message') }} ({{ __('website.optional') }})"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-candle btn-allumer margin-0-auto" onclick="allumerBougie('{{ url('/allumer-bougie') }}', '#form-allumer-bougie')">
                        <div class="spinner-border spinner-border-sm mr-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <i class="icon-fire-1 fire"></i>{{ __('website.light-my-candle') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-content bougie-allumer">
            <img width=100% src="{{ asset("public/front/img/bougie.gif") }}"/>
        </div>
        <div class="modal-content display-none" id="tab2">
            <div class="modal-header background-modal-allumer-bougie">
                <h5 class="modal-title text-white" id="light-candleLabel"><i class="icon-person"></i>{{ __('website.light-a-candle') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 col-md-4 col-sm-12 text-center">
                        <div>
                            <img class="photo-profil img-fluid noir-et-blanc">
                        </div>
                        <div class="text-bottom">
                            <p class="mb-1 text-modal-allumer"><span class="nom"></span></p>
                            <p class="mb-1 text-modal-allumer"><span class="date-naissance"></span></p>
                            <p class="mb-1 text-modal-allumer"><span class="date-deces"></span></p>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-8 col-sm-12 margin-10-0-pourcent">
                        <p class="merci">{{ __('website.thanks') }},</p>
                        <p>{{ __('website.tab2-modal-allumer-bougie-1') }}<span class=" fire-jaune" id="nbre"></span>{{ __('website.tab2-modal-allumer-bougie-2') }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span>{{ __('website.text-share-modal') }}</span>
                <a class="btn padding-5" id="facebook-share" onclick="facebook()"> <i class="fa fa-2x fa-facebook-square"></i></a>
                <a class="btn padding-5" id="whatsapp-share" onclick="whatsapp()"> <i class="fa fa-2x fa-whatsapp"></i></a>
                <a class="btn padding-5" id="twitter-share" onclick="twitter()"> <i class="fa fa-2x fa-twitter-square"></i></a>
            </div>
        </div>
    </div>
</div>
