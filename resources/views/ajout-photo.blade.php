@extends("template")
@section("content")
    <div class="bg_color_2">
        <div class="container margin_60_35">
            <div class="row justify-content-md-center">
                <div class="col-md-9">
                    <div class="step-block">
                        <form id="form-ajouter-anecdote" enctype="multipart/form-data" method="POST" action="{{ route('soumettre-photos') }}">
                            @csrf
                            <input type="hidden" name="profil" value="{{ $profil->id }}">
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <p>{{ __('website.for') }} {{ $profil->prenoms. " ". $profil->nom }}</p>
                                        <div class="form-group">
                                            <div class="fileupload"><input type="file" name="photos[]" multiple></div>
                                            @if ($errors->has('photos'))
                                                <small class="form-text text-danger text-left" id="error">{{ $errors->first('photos') }}</small>
                                            @endif
                                            @if ($errors->has('photos.*'))
                                                <small class="form-text text-danger text-left" id="error">{{ $errors->first('photos.*') }}</small>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="auteur" value="{{ old('nom') }}" placeholder="{{ __('website.enter-your-name') }}">
                                            @if ($errors->has('nom'))
                                                <small class="form-text text-danger text-left" id="error">{{ $errors->first('nom') }}</small>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('website.enter-your-email') }}">
                                            @if ($errors->has('email'))
                                                <small class="form-text text-danger text-left" id="error">{{ $errors->first('email') }}</small>
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
        </div>
    </div>
@endsection
