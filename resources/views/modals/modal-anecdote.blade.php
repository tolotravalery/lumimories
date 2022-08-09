<div class="modal fade" id="modal-anecdote" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="light-candleLabel">{{ __('website.add-anecdote') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-ajouter-anecdote" enctype="multipart/form-data" method="POST" action="{{ route('soumettre-anecdote') }}">
                @csrf
                <input type="hidden" name="profil" value="{{ $profil->id }}">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <p>{{ __('website.for') }} {{ $profil->prenoms. " ". $profil->nom }}</p>
                            @if(Auth::check() == false)
                                <div class="form-group">
                                    <input class="form-control" type="text" name="auteur" value="{{ old('auteur') }}" placeholder="{{ __('website.enter-your-first-and-last-name') }}">
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
                                <label>{{ __('website.your-anecdote') }}</label>
                                <textarea class="form-control" name="avis" rows="6">{{ old('avis') }}</textarea>
                                @if ($errors->has('avis'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('avis') }}</small>
                                @endif
                            </div>
                            {{--<div class="form-group">
                                <label>{{ __('website.add-photos-optionel') }}</label>
                                <div class="fileupload"><input type="file" name="photos[]" multiple></div>
                                @if ($errors->has('photos'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('photos') }}</small>
                                @endif
                                @if ($errors->has('photos.*'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('photos.*') }}</small>
                                @endif
                            </div>--}}
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
