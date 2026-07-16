<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') ?? 'Founders' }}</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="shortcut icon" type="image/png" class="rounded-pill" href="{{ asset('asset/images/f.jpg') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    @stack('css')
    @livewireStyles
</head>

<body style="font-family: 'cairo', sans-serif;">
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden min-vh-100 ">
            <div class="d-flex align-items-center justify-content-center w-100" style="zoom: 80%;">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    @livewireScripts
</body>

</html>
