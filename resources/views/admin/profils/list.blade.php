@extends("admin.template")
@section("custom-css")
    <link rel="stylesheet" href="{{ asset("public/back/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("public/back/css/responsive.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("public/back/css/buttons.bootstrap4.min.css") }}">
@endsection
@section("content")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profils :</h3>
                @if (session('message'))
                    <div class="text-center">
                        <h4 class="mb-4 {{ session('css') }}"> {{ session('message') }}</h4>
                    </div>
                @endif
            </div>
            <div class="card-body">

                <table id="table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Date décés</th>
                        <th>Genealogie</th>
                        <th>Bougies</th>
                        <th>Utilisateur</th>
                        <th>Date d'ajout</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i=0; @endphp
                    @foreach($profils as $profil)
                        <tr>
                            <form method="POST" action="{{ url('/admin/check-validation') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $profil->id }}">
                                <input type="hidden" name="status" value="@php echo $profil->validerParAdmin == true ? "invalide" : "valide"; @endphp">
                                <td class="text-center">
                                    @if($profil->photoProfil != "")
                                        <img src="{{ asset(explode("|",$profil->photoProfil)[0]) }}"
                                             alt="{{ $profil->prenoms ." ".$profil->nom }}" class="img-circle"
                                             style="width: 100px;">
                                    @else
                                        <img src="{{ asset("/public/photo-profiles/default.jpg") }}"
                                             alt="{{ $profil->prenoms ." ".$profil->nom }}" class="img-circle"
                                             style="width: 100px;">
                                    @endif

                                </td>
                                <td>{{ $profil->nom ." ". $profil->prenoms}}</td>
                                <td>{{ Carbon\Carbon::parse($profil->dateDeces)->format('d-m-Y') }}</td>
                                <td>
                                    @foreach($genealogies[$i] as $p)
                                        <a href="{{ url('/admin/profils/'.$p->id) }}">{{ $p->prenoms." ".$p->nom }}</a>
                                    @endforeach
                                </td>
                                <td>{{ $profil->nbreBougie }}</td>
                                <td>{{ $profil->user->name =="" ? $profil->user->email : $profil->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($profil->createdAt)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/admin/profils/'.$profil->id) }}"><i class="fa fa-eye"></i></a>
                                </td>
                                <td><button type="submit" class="btn btn-success float-right">@if($profil->validerParAdmin == true) Invalidé @else Validé @endif</button></td>
                            </form>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section("custom-js")
    <script src="{{ asset("public/back/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("public/back/js/dataTables.bootstrap4.min.js") }}"></script>
    <script>
        $('#table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
@endsection
