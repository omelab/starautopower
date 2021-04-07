@extends('layouts.app')

@section('pageTitle', 'Verify Your Account')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="login-panel">
            <h2><span class="login-icon"></span>{{ __('Verify Your Account') }} </h2>

            <form method="POST" action="{{ route('check-verify') }}">
                @csrf
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Security Code') }}</label>

                    <div class="col-md-8">
                        <input id="otp" type="text" class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}" name="otp" value="{{ old('otp') }}" required autofocus>

                        @if ($errors->has('otp'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('otp') }}</strong>
                            </span>
                        @endif
                    </div>
                </div> 
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Verify Now') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
