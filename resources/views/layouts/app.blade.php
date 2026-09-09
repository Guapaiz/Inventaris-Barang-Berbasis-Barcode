<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventaris SMKN 7 ')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('sbadmin2/img/logoSmk.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('sbadmin2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Google Fonts Nunito -->
    <link rel="stylesheet" href="{{ asset('fonts/nunito.css') }}">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Section untuk CSS tambahan seperti Flatpickr --}}
    @yield('head')
    <style>
        @media (max-width: 768px) {
            body {
                padding-bottom: 80px;
            }
        }
    </style>
</head>


<body id="page-top">

    <div id="wrapper">

        <x-sidebar />

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <x-topbar />

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <x-footer />
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>




    <!-- jQuery -->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery Easing -->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- SB Admin 2 JS -->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>
    <!-- Chart.js lokal -->
    <script src="{{ asset('vendor/chartjs/chart.umd.js') }}"></script>
    {{-- Section untuk JS tambahan seperti Flatpickr --}}
    @yield('scripts')
    {{-- Wajib agar @push('scripts') bisa berfungsi --}}
    @stack('scripts')
</body>

</html>