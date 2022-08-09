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
                <h3 class="card-title">Photos {{ $title }} :</h3>
                @if (session('message'))
                    <div class="text-center">
                        <h4 class="mb-4 {{ session('css') }}"> {{ session('message') }}</h4>
                    </div>
                @endif
            </div>
            <div class="card-body">
                @include("admin.photos.table-list")
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
    <script>
        function modalDelete(id) {
            $('#deleteForm').attr('action','{{ url('/') }}/admin/photos/'+id);
        }
    </script>
@endsection
