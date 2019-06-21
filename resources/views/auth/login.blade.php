@extends('layouts.app')

@section('content')
<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-left-primary shadow">
                <div class="text-primary h3 m-4">{{ __('Login') }}</div>
                <div class="card-body p-md-5">
                    <form method="POST" class="user" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user"
                                       name="email" value="{{ old('email') }}" required autofocus>

                                <label for="email" class="form-control-placeholder">
                                    {{ __('Email Address') }}
                                </label>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-user"
                                       name="password" required>


                                <label for="password" class="form-control-placeholder">
                                    {{ __('Password') }}
                                </label>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check text-left">
                                    <input class="form-check-input form-control-user" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md">
                                <button type="submit" class="btn btn-primary form-control-user w-50 p-3 shadow-sm"
                                        style="font-size: 1em">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
