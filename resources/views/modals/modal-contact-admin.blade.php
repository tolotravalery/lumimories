<div class="modal fade" id="modal-contact-admin" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="light-candleLabel">{{ __('website.contact-the-admin-by-email', ['name' =>$profil->nom." ".$profil->prenoms]) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-contacter-admin">
                @csrf
                <input type="hidden" name="profil" value="{{ $profil->id }}">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="col-12 pt-20 pb-20">
                                <small class="form-text text-danger text-left" id="error"></small>
                                <small class="form-text text-success text-left" id="success"></small>
                            </div>
                            @if(Auth::check() == false)
                                <div class="form-group">
                                    <input class="form-control" type="text" name="auteur" value="{{ old('auteur') }}" placeholder="{{ __('website.enter-your-name') }}">
                                    @if ($errors->has('auteur'))
                                        <small class="form-text text-danger text-left" id="error">{{ $errors->first('auteur') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('website.enter-your-email') }}">
                                    @if ($errors->has('email'))
                                        <small class="form-text text-danger text-left" id="error">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                            @else
                                <input type="hidden" name="auteur" value="{{ Auth::user()->name ." ". Auth::user()->prenom }}">
                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            @endif
                            <div class="form-group">
                                <label>{{ __('website.your-message') }}</label>
                                <textarea class="form-control" name="message" rows="11">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('message') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-candle btn-contacter-admin"  onclick="contacterAdmin('{{ route('contact') }}', '#form-contacter-admin')" type="button">
                        <div class="spinner-border spinner-border-sm mr-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        {{ __('website.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
