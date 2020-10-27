<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0 shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | @lang('admin/common.site_title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset(mix('/assets/'. env('APP_ADMIN_DIR') .'/css/app.css')) }}" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{ asset('assets/'. env('APP_ADMIN_DIR') .'/images/favicon.png') }}" />
</head>
<body>

<main>
    @yield('content')
</main>

</body>
<script src="{{ asset(mix('/assets/'. env('APP_ADMIN_DIR') .'/js/app.js')) }}"></script>
</html>