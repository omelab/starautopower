@extends('layouts.app')
@section('pageTitle', 'Reset Password')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-panel">
            <h2>Reset Password</h2>
             <form method="POST" action="{{ route('password.submit') }}">
                @csrf

                <div class="form-group row">
                    <label for="token" class="col-md-4 col-form-label text-md-right">{{ __('Provided Token') }}</label>

                    <div class="col-md-6">
                        <input id="token" type="text" class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}" name="token" value="{{ $token ?? old('token') }}" required autofocus>

                        @if ($errors->has('token'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('token') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="rpassword" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="rpassword" required>

                        @if ($errors->has('rpassword'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('rpassword') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="rpassword-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="rpassword-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="rpassword_confirmation" required>

                        @if ($errors->has('rpassword_confirmation'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('rpassword_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>                    
        </div>
    </div>
</div>
@endsection
