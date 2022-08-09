<div class="modal fade" id="modal-edit-anecdote" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="light-candleLabel">{{ __('website.edit-anecdote') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-edit-anecdote" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <p>{{ __('website.for') }} {{ $profil->prenoms. " ". $profil->nom }}</p>
                            <div class="form-group">
                                <input class="form-control" type="text" name="auteur" id="auteur" value="{{ old('auteur') }}" placeholder="{{ __('website.enter-your-name') }}">
                                @if ($errors->has('auteur'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('auteur') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('website.enter-your-email') }}">
                                @if ($errors->has('email'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>{{ __('website.your-anecdote') }}</label>
                                <textarea class="form-control" name="avis" id="avis" rows="6">{{ old('avis') }}</textarea>
                                @if ($errors->has('avis'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('avis') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light-candle btn-anecdote">
                        {{ __('website.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
