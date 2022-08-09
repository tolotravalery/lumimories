<div class="modal fade" id="allumer-bougie-general" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="tab1">
            <form id="form-allumer-bougie-general" >
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" name="profil" id="profil-id">
                <div class="modal-header">
                    <h5 class="modal-title" id="light-candleLabel"><i class="icon-person"></i>{{ __('website.light-a-general-candle') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="message">{{ __('website.modal-allumer-message-general') }}</label>
                                <textarea class="form-control" name="message" placeholder="..." rows="4" id="message"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom-bougie btn-allumer" style="width: 100%;" onclick="allumerBougieGeneral('{{ url('/allumer-bougie-general') }}', '#form-allumer-bougie-general')">
                        <div class="spinner-border spinner-border-sm mr-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <i class="icon-fire-1 fire"></i>{{ __('website.light-a-candle') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-content bougie-allumer">
            <img width=100% src="{{ asset("public/front/img/bougie.gif") }}"/>
        </div>
        <div class="modal-content display-none" id="tab2">
            <div class="modal-header">
                <h5 class="modal-title" id="light-candleLabel"><i class="icon-person"></i>{{ __('website.light-a-candle') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <i class="icon-fire-1 fire-jaune"></i>
                        {{ __('website.modal-allumer-tab2-message1') }} <span class=" fire-jaune" id="nbreIncrementeBougie"></span> {{ __('website.modal-allumer-tab2-message2') }}
                    </div>
                </div>
                <div class="row card card-profil">
                    <div class="col-12 text-center">
                        <img class="photo-profil img-fluid noir-et-blanc margin-photo-profil" src="{{ asset("public/photo-profiles/default.jpg") }}" style="width: 50%;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 padding-top-15">
                        <p class="text-center">lumimories.com</p>
                    </div>
                </div>
            </div>
            {{--<div class="modal-footer">
                <a class="btn" id="facebook-share" onclick="facebook()">Facebook <i class="fa fa-1x fa-facebook-square"></i></a>
                <div class="separation"></div>
                <a class="btn" id="whatsapp-share" onclick="whatsapp()">Whatsapp <i class="fa fa-1x fa-whatsapp"></i></a>
                <div class="separation"></div>
                <a class="btn" id="twitter-share" onclick="twitter()">Twitter <i class="fa fa-1x fa-twitter-square"></i></a>
            </div>--}}
        </div>
    </div>
</div>
