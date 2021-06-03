@extends('admin._layouts.base')

@section('title', trans('auth.heading'))

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 pt-6 pb-24 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">

            {{-- Logo --}}
            <a href="{{ route('admin.login') }}" class="block w-40 mx-auto mb-12">@svg('logo')</a>

            <form class="bg-white shadow-sm rounded mt-8 py-16 px-12" action="{{ route('admin.login') }}" method="post">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="input-email" class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">@lang('auth.text_email')</label>
                    <input type="text" name="email" id="input-email" value="{{ old('email') }}" placeholder="@lang('auth.placeholder_email')" class="form-input block w-full py-3 px-4 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out" autocomplete="email" autofocus required>
                    @error('email')
                    <div class="text-sm text-red-500 mt-1 ml-1" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="input-password" class="block text-sm font-medium leading-5 text-gray-700 mb-1 ml-1">@lang('auth.text_password')</label>
                    <input type="password" name="password" id="input-password" placeholder="@lang('auth.placeholder_password')" class="form-input block w-full py-3 px-4 text-sm border border-gray-300 focus:border-blue-400 focus:shadow-outline-blue rounded-md shadow-sm transition duration-150 ease-in-out placeholder-gray-400" required>
                </div>

                {{-- Remember and forgot password --}}
                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="form-checkbox border-gray-400 h-4 w-4 text-blue-600 transition duration-150 ease-in-out focus:border-blue-600 focus:shadow-outline-blue" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm leading-5 text-gray-600 hover:text-gray-700 select-none">
                            @lang('auth.text_remember')
                        </label>
                    </div>
                    <div class="text-sm leading-5">
                        <a href="#" class="font-medium text-sm text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            @lang('auth.text_forgotten_password')
                        </a>
                    </div>
                </div>

                {{-- Submit button --}}
                <div class="mt-6">
                    <button type="submit" class="w-full py-3 px-4 text-sm leading-5 font-bold rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                        @lang('auth.button_sign_in')
                    </button>
                </div>
            </form>

            {{-- Go to the front --}}
            <div class="mt-5 ml-2">
                <a href="#" class="inline-flex items-center text-gray-500 hover:text-blue-600 transition duration-150 ease-in-out">
                    @svg('icons/solid/arrow-narrow-left, fill-current text-gray-500 w-5 mr-2') @lang('auth.text_view_the_website')
                </a>
            </div>
        </div>
    </div>
@endsection
