<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <link rel="icon" href="https://etikto-admin-dashboard.multipurposethemes.com/bs5/images/favicon.ico"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <title>@yield('title', 'Dashboard - Combrim')</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('css/horizontal-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin_color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @livewireStyles


    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> --}}
</head>

<body class="layout-top-nav light-skin theme-primary">

    <div class="wrapper">




        @include('components.navbar')
        @yield('content')

        @livewireScripts


        <!-- /.content-wrapper -->
        <footer class="main-footer text-center">
            &copy; <span id="current-year"></span>. Sistema de Gerenciamento 2006 / <span id="start-year">2024</span>.
            Todos os direitos reservados.
        </footer>

        <script>
            const currentYear = new Date().getFullYear();
            document.getElementById('current-year').textContent = currentYear;
        </script>


        <!-- Vendor JS -->
        <script src="{{ asset('js/vendors.min.js') }}"></script>
        {{-- <script src="js/pages/chat-popup.js"></script> --}}
        <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/icons/feather-icons/feather.min.js">
        </script>

        <script
            src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/jquery-knob/js/jquery.knob.js">
        </script>

        <script src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/raphael/raphael.min.js">
        </script>
        {{-- <script
            src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/morris.js/morris.min.js">
        </script> --}}
        {{-- <script
            src="https://etikto-admin-dashboard.multipurposethemes.com/bs5/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js">
        </script> --}}

        <!-- Etikto Admin App -->
        <script src="js/jquery.smartmenus.js"></script>
        <script src="js/menus.js"></script>
        <script src="js/template.js"></script>
        {{-- <script src="js/pages/dashboard2.js"></script> --}}
        {{-- <script src="js/pages/calendar.js"></script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const today = new Date().toISOString().split('T')[0]; // Data atual no formato "YYYY-MM-DD"
                document.querySelectorAll('input[type="date"]').forEach(function (input) {
                    if (!input.value) { // Apenas define se não houver valor
                        input.value = today;
                    }
                });
            });
        </script>

</body>

</html>
