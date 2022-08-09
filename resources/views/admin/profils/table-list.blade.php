<h5>Anecdotes</h5>
<form method="POST" action="{{ url("/admin/profil-anecdotes-validation")  }}">
    @csrf
    <input type="hidden" name="id" value="{{ $profil->id }}">
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Profil</th>
            <th>Auteur</th>
            <th>Email</th>
            <th>Avis</th>
            <th>Photos</th>
            <th>Date</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($profil->anecdotes as $anecdote)
            <tr>
                <td>{{ $anecdote->profil->nom ." ". $anecdote->profil->prenoms}}</td>
                <td>{{ $anecdote->auteur }}</td>
                <td>{{ $anecdote->email }}</td>
                <td>{{ str_limit($anecdote->avis, $limit = 250, $end = '...') }}</td>
                <td>
                    @if($anecdote->photos != "")
                        @foreach(explode("|",$anecdote->photos) as $photo)
                            <img src="{{ asset($photo) }}" alt="{{ $anecdote->profil->prenoms ." ".$anecdote->profil->nom }}" class="img-circle" style="width: 100px;">
                        @endforeach
                    @endif
                </td>
                <td>{{ Carbon\Carbon::parse($anecdote->created_at)->format('d-m-Y') }}</td>
                <td>
                    <input type="checkbox" name="ids[]" value="{{ $anecdote->id }}" @if($anecdote->valider == true) checked @endif>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-success float-right">Mise à jour</button>
</form>
