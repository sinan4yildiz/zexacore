<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0 shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('admin/common.brand_name')</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset(mix('/assets/'. env('APP_ADMIN_DIR') .'/css/app.css')) }}" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{ asset('assets/'. env('APP_ADMIN_DIR') .'/images/favicon.png') }}"/>
    <link rel="apple-touch-icon" href="{{ asset('assets/'. env('APP_ADMIN_DIR') .'/images/apple-touch-icon.png') }}">
</head>
<body class="font-body bg-gray-200">

@yield('content')

</body>
<script type="text/javascript">
    window.data = {
        url: {
            base: '{{ env('APP_URL') }}',
            api: '{{ env('APP_URL') . 'api' }}',
            admin: '{{ env('APP_URL'). env('APP_ADMIN_DIR') }}'
        },
        app: {
            version: '{{ env('APP_VERSION') }}',
        },
        @auth
        currentUser: @json(Auth::user()),
        config: @json($settings),
        @endauth
    };
</script>
<script src="{{ asset(mix('/assets/'. env('APP_ADMIN_DIR') .'/js/app.js')) }}"></script>
</html>