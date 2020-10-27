@extends('admin._layouts.base')

@section('title', trans('admin/common.site_title'))

@section('content')
    <div class="container">
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
                           class="form-control form-control-lg no-outline"
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
                <button type="submit" class="btn btn-success btn-block">
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
    </div>
@endsection