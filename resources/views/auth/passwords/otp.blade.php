@extends('layouts.app')
@section('pageTitle', 'Forgot Password')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-panel">
            <h2><span class="password-icon"></span>Forgot Password</h2>
            <form method="POST" action="{{ route('password.otgRequest') }}">
                @csrf

                <div class="form-group row">
                    <div class="col-md-12">
                        <span class="prefix-mobile">+88</span>
                        <input id="forgotMobile" type="number" class="form-field usermobtxt {{ $errors->has('mobile') ? ' is-invalid' : '' }} " name="mobile" value="{{ old('mobile') }}" placeholder="Mobile Number" required="" autocomplete="off">
                        <span class="ex-mobile">e.g. +8801880160966</span>
                        @if ($errors->has('mobile'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div> 
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Reset Token') }}
                        </button>
                    </div>
                </div>
            </form>           
        </div>
    </div>
</div>
@endsection
