<div class="modal fade" id="modal-signaler-anecdote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">{{ __('website.report-this-profile') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="POST" action="{{ route('signaler-anecdote') }}">
                @csrf
                <input type="hidden" name="anecdote" id="anecdote-value">
                <input type="hidden" name="profil" value="{{ $profil->id }}">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <p>{{ __('website.for') }} {{ $profil->prenoms. " ". $profil->nom }}</p>
                            <div class="form-group">
                                <label>{{ __('website.your-reason') }}</label>
                                <textarea class="form-control" name="raison" rows="11">{{ old('raison') }}</textarea>
                                @if ($errors->has('raison'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('raison') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light-candle btn-anecdote">
                        {{ __('website.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
