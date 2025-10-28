<!DOCTYPE html><!--
* CoreUI - Free Bootstrap Admin Template
* @version v5.3.0
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2025 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
-->
<html lang="en">
  <head>
    <base href="{{ asset('./') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>{{ $title??'Page Title'}}</title>
    <!-- Icons-->
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/coreui.min.css') }}"> --}}
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{ asset('css/examples.css') }}" rel="stylesheet">
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/color-modes.js') }}"></script>
  </head>
  <body>
    @include('admin.partials.sidebar')
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('admin.partials.header')
      <div class="body flex-grow-1">
        <div class="container-lg px-4">
            {{ $slot }}

        </div>
      </div>
    @include('admin.partials.footer')
    </div>
    @vite('resources/js/app.js')
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
  </body>
</html>
