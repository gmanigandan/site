<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

 
    <title>{{ $meta_title ?? 'RadioQuery' }}</title>

    <meta name="description" content="{{ $meta_description ?? 'RadioQuery' }}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'RadioQuery' }}">
    <!-- BEGIN: Theme CSS-->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
        @livewireStyles
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/pages/page-auth.css') }}" />

</head>

<body>
    {{ $slot }}
</body>
@livewireScripts
<script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
 
<script data-navigate-once src="{{ asset('backend/assets/vendor/js/bootstrap.js') }}"></script>

</html>
