<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lumimories - BO</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('public/back/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/back/css/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/back/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset("public/back/css/font-awesome.min.css") }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url("/") }}">Lumimories</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('public/back/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/back/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/back/js/adminlte.min.js') }}"></script>
</body>
</html>
