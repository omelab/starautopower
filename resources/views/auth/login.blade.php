@extends('layouts.app')
@section('pageTitle', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-panel">
            <h2><span class="login-icon"></span>  Login </h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group row">                   
                    <div class="col-md-12"> 
                      <span class="prefix-mobile">+88</span>
                      <input id="rMobile" type="text" class="form-field usermobtxt {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Mobile Number" style="padding-left: 70px;" required="" autocomplete="off">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input type="password" class="form-field userpwdtxt{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  placeholder="Password" required autocomplete="off">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                       <a class="fpas" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        <a href="{{ url('/register') }}" class="RegistrationPopUpLink" onclick="openRegister(event)">New User ? Register</a>  
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-midum">
                            {{ __('Login') }}
                        </button>                 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
