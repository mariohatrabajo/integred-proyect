<!DOCTYPE html>
<html lang="en">
<!-- Head start -->

<head>
    <title>Zaisén</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/responsive.bootstrap5.min.css') }}">
    <style>
        .card-body .dataTables_wrapper .row .col-md-5,
        .card-body .dataTables_wrapper .row .col-md-7 {
            display: none;
        }

        .card-body .dataTables_wrapper .row .col-md-6,
        .card-body .dataTables_wrapper .row .col-md-6 {
            display: none;
        }

        td.child ul.dtr-details li {
            display: flex;
            flex-flow: row wrap;
            align-items: center;
            align-content: center;
        }
    </style>


    <!-- Font Family -->
    <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}" id="main-font-link" />

    <!-- Tabler Icons https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}" />
    <!-- Feather Icons https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('fonts/feather.css') }}" />
    <!-- Font Awesome Icons https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}" />
    <!-- Material Icons https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('fonts/material.css') }}" />
    <!-- Template CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('css/style-preset.css') }}" />
    <!-- JS Validation's Styles -->
    <link rel="stylesheet" href="{{ asset('css/js-validations.css') }}" />
</head>


<body>
    @include('nav_bar') <!-- Incluir la barra de navegación común a todas las páginas -->


    @yield('content') <!-- Aquí se incluirá el contenido específico de cada página -->




    @include('footer') <!-- Incluir el pie de página común a todas las páginas -->