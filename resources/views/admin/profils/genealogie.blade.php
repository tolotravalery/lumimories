<h5>Généalogie</h5>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Profil</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
        $j = 0;
    @endphp
    @foreach($profils as $p)
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $p->prenoms." ".$p->nom }}</td>
            <td>{{ $gene[$j] }}</td>
        </tr>
        @php
            $i++;
            $j++;
        @endphp
    @endforeach
    </tbody>
</table>
