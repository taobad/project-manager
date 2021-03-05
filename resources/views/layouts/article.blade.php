<!DOCTYPE html>
<html lang="en">

<head>
    @if(config('app.env') == 'production')
    @include('partial.g-analytics')
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ get_option('company_name') }} | @langapp('knowledgebase')</title>
    <meta name="author" content="{{ get_option('site_author') }}">
    <meta name="keywords" content="{{ get_option('site_keywords') }}">
    <meta name="description" content="{{ get_option('site_desc') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ getAsset('css/tailwind.css') }}" type="text/css" />
    <link rel="icon" type="image/png" href="{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_favicon')) }}">
    <link rel="apple-touch-icon" href="{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon')) }}" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    @livewireStyles
    @livewireScripts
    <style>
        html {
            font-family: 'Source Sans Pro', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased tracking-normal tracking-wider bg-gray-100">

    @yield('content')

</body>

</html>