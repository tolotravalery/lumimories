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
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($anecdotes as $anecdote)
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
                <form method="POST" action="{{ url("/admin/anecdote-check-validation")  }}">
                    @csrf
                    <td>
                        <input type="checkbox" name="valider" value="checked" @if($anecdote->valider == true) checked @endif>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="{{ $anecdote->id }}">
                        <input type="hidden" name="status" value="{{ $anecdote->valider == true ? "invalide" : "valide" }}">
                        <button type="submit" class="btn btn-success float-right">@if($anecdote->valider == true) Invalidé @else Validé @endif</button>
                    </td>
                </form>
                <td>
                    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" id="#modalCenter" onclick="modalDelete({{ $anecdote->id }})">Supprimer</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Etes-vous sûr de supprimer ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
                    <form method="POST" accept-charset="UTF-8" id="deleteForm" action="">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
