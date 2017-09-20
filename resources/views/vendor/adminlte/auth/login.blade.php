@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/home') }}">@lang('aisya/body.login_welcome')</a>
            </div><!-- /.login-logo -->

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @lang('aisya/alert.title')
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-{{ session('message')['type'] }}">
                    @lang('aisya/alert.title')
                    <ul>
                            <li>{{ session('message')['text'] }}</li>
                    </ul>
                </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg"> @lang('aisya/body.login_title') </p>
                
                <form action="{{ url('/login') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="@lang('auth.placeholder_user')" id="npk" name="npk" autofocus />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="password" type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input style="display:none;" type="checkbox" name="remember" id="remember" checked /> {{ trans('adminlte_lang::message.remember') }}
                                </label>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.buttonsign') }}</button>
                        </div><!-- /.col -->
                    </div>
                </form>

                {{-- dev-1.0, Ferry, 20170823, menghilangkan social facebook login ## @include('adminlte::auth.partials.social_login') --}}

                <a href="{{ url('/password/reset') }}">@lang('aisya/body.login_forgot')</a><br>
                <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </div>
    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
        $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
        });
        });

        $('#remember').iCheck('check')

        $( "#npk" ).keypress(function( event ) {
            if ( event.keyCode == 124 ) {
                event.preventDefault();
                $( "#password" ).focus();
            }
        });

    </script>
</body>

@endsection