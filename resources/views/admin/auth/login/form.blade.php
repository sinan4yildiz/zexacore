@extends('admin._layouts.base')

@section('title', trans('admin/modules/auth/login.heading'))

@section('content')
    {{--<div class="container">
        <section class="inner">
            <div class="logo">
                @svg('logo')
            </div>
            <h1 class="mt-5 mb-4">@lang('admin/modules/auth/login.heading')</h1>
            <form action="{{ route('admin.auth.login') }}" method="post" class="mb-5">@csrf
                <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                <div class="form-group form-group-icon-lg mb-0">
                    <label for="input-method" class="icon">@icon('user')</label>
                    <input type="text"
                           name="method"
                           id="input-method"
                           class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                           placeholder="@lang('admin/modules/auth/login.input_method')"
                           value="{{ old('method') }}"
                           @if(!old('method')) autofocus @endif>
                </div>
                <div class="form-group form-group-icon-lg">
                    <label for="input-method" class="icon">@icon('key')</label>
                    <input type="password"
                           name="password"
                           id="input-password"
                           class="form-control form-control-lg no-outline"
                           placeholder="@lang('admin/modules/auth/login.input_password')"
                           @if($errors->has('password') or old('method')) autofocus @endif>
                </div>
                <button type="submit" class="border border-indigo-500 text-indigo-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-indigo-600 focus:outline-none focus:shadow-outline">
                    @lang('admin/modules/auth/login.button_login')
                </button>
                @if ($errors->any())
                    <div class="alert alert-danger border-0 mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
            <a href="{{ route('admin.auth.forgotten_password') }}">
                @lang('admin/modules/auth/login.text_forgotten_password')
            </a>
        </section>
        <a href="{{ route('web.home') }}" class="with-icon mx-2 d-inline-flex align-items-center">
            @icon('arrow-left') @lang('admin/modules/auth/login.text_view_the_website')
        </a>
    </div>--}}

    <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-on-white.svg" alt="Workflow">
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-gray-600">
                    Or
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        start your 14-day free trial
                    </a>
                </p>
            </div>
            <form class="mt-8" action="#" method="POST">
                <input type="hidden" name="remember" value="true">
                <div class="rounded-md shadow-sm">
                    <div>
                        <input aria-label="Email address" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5" placeholder="Email address">
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5" placeholder="Password">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                        <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection