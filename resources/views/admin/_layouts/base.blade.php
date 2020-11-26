<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0 shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | @lang('admin/common.site_title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset(mix('/assets/'. env('APP_ADMIN_DIR') .'/css/app.css')) }}" rel="stylesheet"/>
    <link rel="shortcut icon" href="{{ asset('assets/'. env('APP_ADMIN_DIR') .'/images/favicon.png') }}"/>
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
        currentUser: @json(Auth::user()),
        config: @json($settings),
    };
</script>
<script src="{{ asset(mix('/assets/'. env('APP_ADMIN_DIR') .'/js/app.js')) }}"></script>
</html>