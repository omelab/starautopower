@extends('layouts.app')
@section('pageTitle', 'Registration')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="login-panel">
            <h2><span class="login-icon"></span>  Registration</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="rname" type="text" class="form-field username-field{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Your Name" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="email" type="text" class="form-field username-field{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your Email" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- <div class="form-group row">
                    
                    <div class="col-md-12">
                        <span class="prefix-mobile">+88</span>
                        <input id="rmobile" type="number" class="form-field usermobtxt{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile Number" required autofocus>
                        <span class="ex-mobile">e.g. +8801880160966</span>
                
                        @if ($errors->has('mobile'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                </div> -->

               

                <div class="form-group row">
                    
                    <div class="col-md-12">
                        <input id="rpassword" type="password" class="form-field userpwdtxt{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
               <div class="form-group row">
                    <div class="col-md-12">
                        <input id="rcpassword" type="password" class="form-field userpwdtxt" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                </div>                

                <div class="form-group row">
                    <div class="col-md-12  text-center">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }}> {!! __('I Agree all of  <a href="#terms">terms and conditions</a>') !!}
                            </label>                            
                        </div>
                        @if ($errors->has('agree'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('agree') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-midum">
                            {{ __('Register Now') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
