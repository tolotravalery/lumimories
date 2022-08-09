<div class="modal fade" id="modal-monument" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="light-candleLabel">{{ __('website.add-monument-profile') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-ajouter-monument" enctype="multipart/form-data" method="POST" action="{{ route('soumettre-monument') }}">
                @csrf
                <input type="hidden" name="profil" value="{{ $profil->id }}">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <p>{{ __('website.for') }} {{ $profil->prenoms. " ". $profil->nom }}</p>
                            <div class="form-group">
                                <input class="form-control" type="text" name="titreDuMonument" value="{{ old('titreDuMonument') }}" placeholder="{{ __('website.enter-title-monument') }}">
                                @if ($errors->has('titreDuMonument'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('titreDuMonument') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="adresseDuMonument" value="{{ old('adresseDuMonument') }}" placeholder="{{ __('website.enter-address-monument')." (". __('website.optional').")" }}">
                                @if ($errors->has('adresseDuMonument'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('adresseDuMonument') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="input-monument display-flex"></div>
                                @if ($errors->has('monuments'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('monuments') }}</small>
                                @endif
                                @if ($errors->has('monuments.*'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('monuments.*') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light-candle btn-anecdote">
                        {{ __('website.add') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
