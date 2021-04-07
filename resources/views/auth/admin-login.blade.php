<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- start: Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end: Meta -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Star Auto Power</title>

    <!-- start: CSS -->
    <link id="bootstrap-style" href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/bootstrap-responsive.min.css')}}" rel="stylesheet">
    <link id="base-style" href="{{asset('backend/css/style.css')}}" rel="stylesheet">
    <link id="base-style-responsive" href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
    <!-- end: CSS -->
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link id="ie-style" href="css/ie.css" rel="stylesheet">
    <![endif]-->
    <!--[if IE 9]>
    <link id="ie9style" href="css/ie9.css" rel="stylesheet">
    <![endif]-->
    <!-- start: Favicon -->
    <link rel="shortcut icon" href="{{URL::to('/backend/img/favicon.png')}}">
    <!-- end: Favicon -->
    <style type="text/css">
      body { background: url({{asset('backend/img/bg-login.jpg')}}) !important; }
    </style>
  </head>
  <body>
    <div class="container-fluid-full">
      <div class="row-fluid">
        <div class="row-fluid">
          <div class="login-box">
            @include('flash-message')
            <h2 class="text-center"><strong><img src="{{asset('frontend/images/logo.png')}}" alt="LOGIN TO YOUR ACCOUNT"></strong></h2> 
              {!! Form::open(['route'=>'admin.login.submit']) !!}
              <fieldset>
                <div class="input-prepend" title="Username">
                  <span class="add-on"><i class="halflings-icon user"></i></span>
                  <input id="email" type="email" class="input-large span10{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="input-prepend" title="Password">
                  <span class="add-on"><i class="halflings-icon lock"></i></span>
                   <input id="password" type="password" class="input-large span10{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif                    
                </div>
                <div class="clearfix"></div>
                <div class="button-login">  
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </fieldset>
              <div class="clearfix"></div>
            {!! Form::close() !!}
          </div>
        </div>
        <!--/row-->
      </div>
      <!--/.fluid-container-->
    </div>

    <!--/fluid-row-->
    <!-- start: JavaScript-->
    <script src="{{asset('backend/js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery-migrate-1.0.0.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery-ui-1.10.0.custom.min.js')}}"></script>
    <script src="{{asset('backend/js/modernizr.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.cookie.js')}}"></script>
    <!-- end: JavaScript--> 
  </body>
</html>
