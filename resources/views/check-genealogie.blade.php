<div class="reviews-container">
    <form method="POST" action="{{ url('/check-genealogie') }}">
        <input type="hidden" name="profil" value="{{$profil->id}}">
        @csrf
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @php
                $i = 1;
            @endphp
            @foreach($profil->checkgenealogie as $ck)
                @if($ck->valider ==false && $ck->profil_value->validerParAdmin == true)
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ __('website.'.$ck->status) }}</td>
                        <td>{{ $ck->profil_value->nom ." ".$ck->profil_value->prenoms }}</td>
                        <td><input type="checkbox" name="ids[]" value="{{ $ck->id }}"
                                   @if($ck->valider == true) checked @endif></td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endif
            @endforeach
            </tbody>
        </table>
        <div class="text-right padding-20">
            <button class="btn-light-candle" type="submit">{{ __('website.validate') }}</button>
        </div>
    </form>
</div>
