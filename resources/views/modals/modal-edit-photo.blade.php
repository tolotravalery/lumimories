<div class="modal fade" id="modal-edit-photo" tabindex="-1" aria-labelledby="light-candleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="light-candleLabel">{{ __('website.edit')." ".__('website.picture') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-edit-photo" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="id" id="id-photo">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <p class="margin-bottom-10">{{ __('website.for') }} {{ $profil->nomFirstProfil() }}</p>
                        </div>
                        @if(Auth::check() == false)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="auteur" value="{{ old('auteur') }}" placeholder="{{ __('website.enter-your-name') }}" id="auteur" disabled>
                                    @if ($errors->has('auteur'))
                                        <small class="form-text text-danger text-left" id="error">{{ $errors->first('auteur') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('website.enter-your-email') }}" id ="email" disabled>
                                    @if ($errors->has('email'))
                                        <small class="form-text text-danger text-left" id="error">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="auteur" value="{{ Auth::user()->name ." ". Auth::user()->prenom }}">
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        @endif
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" type="text" name="nomDesGens" value="{{ old('nomDesGens') }}" id="nomDesGens" placeholder="{{ __('website.name-of-people-in-the-picture') }}">
                                @if ($errors->has('nomDesGens'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('nomDesGens') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="dateDuPhoto" value="{{ old('dateDuPhoto') }}" id="dateDuPhoto" onfocus="(this.type='date')" placeholder="{{ __('website.photo-date') }}">
                                @if ($errors->has('dateDuPhoto'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('dateDuPhoto') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="commentaires" rows="1" id="commentaires" placeholder="{{ __('website.comment-the-photo') }}">{{ old('commentaires') }}</textarea>
                                @if ($errors->has('commentaires'))
                                    <small class="form-text text-danger text-left" id="error">{{ $errors->first('commentaires') }}</small>
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
