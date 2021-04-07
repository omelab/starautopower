<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <meta name="description" content="">
  <meta name="author" content="">  

{{--   <meta property="og:url"                content="hhttp://starautopower.com/detsils/14" />
  <meta property="og:type"               content="article" />
  <meta property="og:title"              content="ECO+ TOASTER BLACK COLOR" />
  <meta property="og:description"        content=" 2 Slices Toaster Cancel Function VDE French Plug Seven Time Setting Removable Crumb Tray Automatic Shut Off And Pop-up Warranty: 06(Six) Month Spare Parts & 01(One) Year Service" />
  <meta property="og:image"              content="http://starautopower.com/images/1582832520-Eco-Plus-toaster.jpg" />
 --}}
  <link rel="shortcut icon" href="{{asset('frontend/images/fevicon.png')}}" />
  <link rel="apple-touch-icon" href="{{asset('frontend/images/fevicon.png')}}" />
  <link rel="apple-touch-icon-precomposed" href="{{asset('frontend/css/fevicon.png')}}" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>@yield('pageTitle') | Star Auto Power</title> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i">
  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
  
  <link rel="stylesheet" href="{{asset('frontend/css/toastr.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/css/styles.min.css')}}">
 

  <!-- Load Facebook SDK for JavaScript --> 
 

  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
</head>
<body>
  <div class="wrapper">
    <header class="header-main">
      <div class="header-top">
        <div class="container">
          <div class="left-content"> 
            <a href="{{ url('/') }}" class="brand-logo"> <img src="{{URL::to('frontend/images/logo.png')}}" alt="Romans"></a>
          </div>
          <div class="right-content">
            <div class="top-link">             
              <ul class="topnav">
                @if(Session::has('s_area'))
                <li> <a href="#" class="open-pop"><i class="fa fa-map-marker"></i> {{ Session::get('s_area')->title}}</a></li>
                @endif <!-- 
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ URL::to('contact') }}">Contact</a></li>   -->               
                @guest
                <li>
                    <a href="{{ url('/register') }}" class="sign-in" id="reg" onclick="openRegister(event)">Register</a>
                </li>
                <li> <a href="{{ url('/login') }}" class="sign-in" id="login" onclick="openLogin(event)">Login</a>
                </li>
                @else
                <li class="dropdown sign-area">                              
                  <a id="UserDropdown" class="login-btn dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> <i class="fa fa-user"></i>
                    {{ Auth::user()->name }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('user.order') }}"> {{ __('Order') }}</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('password.request') }}"> {{ __('Change Password') }}</a>
                    </li>

                    <li><a class="dropdown-item" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form></li>                     
                  </ul>
                </li>
                @endguest
              </ul>
            </div>
            <div class="bottom-action">
              <ul>
                <li class="hotline"><img src="{{URL::to('frontend/images/icon-call.png')}}" alt=""> HOTLINE: <strong>01911861426</strong></li>
                <li class="cart-option">
                  <div class="top-cart" onclick="window.location.replace('{{url::to("/cart")}}');">
                    <div class="icon"><img src="{{URL::to('frontend/images/icon-cart.png')}}" alt=""></div>
                    <div class="item-count">
                      <strong>SHOPPING CART</strong>
                      <div class="cartitemCount-top ItemNum"><span class="itemcount">{{ Cart::content()->count() }}</span> @if(Cart::content()->count()>1) ITEMS @else  ITEM  @endif</div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>                      
          </div>
        </div>
      </div>
      <div class="header-bottom">
          <div class="container">
              <div class="nav-wrap">              
                  <div class="nav-main">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="fa fa-bars"></span></button>
                    <div class="collapse navbar-collapse" id="mainNav">

                        <ul class="nav-menu">
                            <li><a href="{{ url('/') }}">Home</a></li> 
                             <li><a href="{{ url('/about') }}">About</a></li> 
                             <li><a href="{{ url('/services') }}">Services</a></li> 
                             <li><a href="{{ url('/products') }}">Product</a></li> 
                             <li><a href="{{ url('/contact') }}">contact Us</a></li> 
                            <!-- @foreach($latestCategory as $category)
                                         <li class="nav-item @if(count($category->childs)) dropdown @endif  {{ RomansHelper::get_activeslug($category->slug) }}">
                                            
                                             @if(count($category->childs)) 
                                                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             @else
                                                 <a href="{{ URL::to( 'category/'.$category->slug ) }}">
                                             @endif
                                                 {{$category->title }} </a>
                                         
                                             @if(count($category->childs))
                                             <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                 @foreach($category->childs as $child)
                                                     @if( $child->status==1)
                                                         <li class="{{ RomansHelper::get_activeslug($child->slug) }}"
                                                         ><a href="{{ URL::to( 'category/'.$child->slug ) }}">{{ $child->title }}</a>            
                                                         </li>
                                                     @endif
                                                 @endforeach
                                             </ul>
                                                 {{-- @include('admin.category.manageChild',['childs' => $category->childs]) --}}
                                             @endif
                                           </li>
                                         @endforeach -->             
                        </ul>
                    </div>

                      {!! Form::open(['route'=>'search', 'method' => 'get', 'class'=>'search']) !!}
                      <input type="text" name="ps" class="serach-field" placeholder="Enter Keyword" 
                      @if(isset($key))
                      value="{{ $key }}" 
                      @endif                      
                      >
                      <button type="submit" class="serach-btn"><img src="{{asset('frontend/images/icon-search.png')}}" alt=""></button>
                      {{ Form::close() }}                  
                  </div>
              </div>
          </div>              
      </div>          
    </header>
    <div class="main-container">
      @yield('content')
    </div>
    <section class="feature">
      <div class="container">
        <ul>
          <li><img src="{{URL::to('frontend/images/icon-order.png')}}" alt=""> <span>Order IN Online</span></li>
          <li><img src="{{URL::to('frontend/images/icon-phone.png')}}" alt=""> <span>Order BY PHONE</span></li>
          <li><img src="{{URL::to('frontend/images/icon-walet.png')}}" alt=""> <span>CASH ON DELIVERY</span></li>
        </ul>
      </div>
    </section>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="widget">
              <a href="{{URL::to('/')}}" class="brand-logo"><img src="{{URL::to('frontend/images/logo.png')}}" alt=""></a>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget text-center">             
              <h4>PAYMENT WITH</h4>
              <img src="{{URL::to('frontend/images/payment-icon.png')}}" alt="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget text-right">
              <h3>FOLLOW US</h3>
              <ul class="social">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="copy">Copyright © 2018 starautopower, Bangladesh. All rights reserved. Developed by: <a href="http://firstitsolution.com" target="_blank">firstitsolution</a></div>
      </div>      
    </footer>

    <div class="pay-options">
      <div class="bkash">
        <img src="{{asset('frontend/images/bkash.png')}}" alt=""> <span>01976612353</span>
      </div>
      <div class="bkash roket">
        <img src="{{asset('frontend/images/roket.png')}}" alt=""> <span>01717612353</span>
      </div>
    </div>
  </div>

  <!--********* Popup Area *************-->
  <!-- <div class="area-pop" 
      @if(Session::has('s_city')) 
          style="display: none" 
      @endif
      >
      <div class="pop-content">
          <a href="javascript:void(0);" class="close-pop">close</a>
          <img src="{{ asset('/frontend/images/Location-top-icon.png') }}" alt="" class="location-top-image">
          <h2>SELECT YOUR DELIVERY LOCATION</h2>
          {!! Form::open(['route'=>'setlocation.submit']) !!}
          <?php  $cities = RomansHelper::get_cities(); ?>
  
              @if(Session::has('s_city'))
              {!! Form::select('city_id', $cities, Session::get('s_city')->id, ['id'=>'city', 'required'=>true, 'placeholder'=>'Selet Your City']) !!}
              @else
              {!! Form::select('city_id', $cities, old('city_id'), ['id'=>'city', 'required'=>true, 'placeholder'=>'Selet Your City']) !!}
              @endif
  
              @if(Session::has('s_city'))
              <?php  $areas = RomansHelper::get_area_cities(Session::get('s_city')->id);?>
              {!! Form::select('area_id', $areas, Session::get('s_area')->id, ['id'=>'area', 'required'=>true, 'placeholder'=>'Selet Your Area']) !!}
              @else            
              <select name="area_id" id="area" required="">
                   <option value="">Select City First</option>
              </select>
              @endif
  
              <button type="submit" class="submit-btn">SUBMIT</button>
           {!! Form::close() !!}
          <p>All of romans store, now at your fingertips</p>
      </div>
  </div> -->
  <div class="login-pop
      @if ( ( old('email') ) && ( $errors->has('email') || $errors->has('password') ) )
      active
      @endif
      " id="loginPop">
      <div class="login-panel">
          <a href="javascript:void(0);" class="close-login-pop" id="clpop" onclick="closeLogin(event);">close</a>
          <h2><span class="login-icon"></span>  Login </h2>

          <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="form-group row">
                  <div class="col-md-12"> 
                      <span class="prefix-mobile">+88</span>
                      <input id="lMobile" type="text" class="form-field usermobtxt {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Mobile Number" required autocomplete="off">
                      <span class="ex-mobile">e.g. 01911861426</span> 
                      @if ($errors->has('email'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group row">
                  <div class="col-md-12">
                      <input id="password" type="password" class="form-field userpwdtxt{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

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
                  <div class="col-md-12">
                      <button type="submit" class="btn btn-primary btn-midum">
                          {{ __('Login') }}
                      </button>             
                  </div>
              </div>
          </form>
      </div>
  </div>
  <div class="register-pop
      @if ( old('agree') || $errors->has('agree') )
      active
      @endif
      " id="registerPop">
      <div class="login-panel">
          <a href="javascript:void(0);" class="close-register-pop" id="crpop" onclick="closeRegister(event)">close</a>
          <h2><span class="login-icon"></span>  Registration</h2>
          <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="form-group row">
                  <div class="col-md-12">
                      <input id="name" type="text" class="form-field username-field {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Your Name" autocomplete="off" required autocomplete="off">

                      @if ($errors->has('name'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <span class="prefix-mobile">+88</span>
                      <input id="rMobile" type="text" class="form-field usermobtxt {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile Number" style="padding-left: 70px;" required autocomplete="off">
                      <span class="ex-mobile">e.g. 01911861426</span>

                      @if ($errors->has('mobile'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('mobile') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12"> 
                      <input id="email" type="email" class="form-field useremtxt {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="Email" autocomplete="off">
                      <span class="ex-mobile">e.g. youremail@gmail.com</span>

                      @if ($errors->has('email'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <input id="your-password" type="password" class="form-field userpwdtxt {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autocomplete="off" placeholder="Password" required>

                      @if ($errors->has('password'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
             <div class="form-group row">
                  <div class="col-md-12">
                      <input id="password-confirm" type="password" class="form-field userpwdtxt" name="password_confirmation" placeholder="Confirm Password" autocomplete="off" required>
                  </div>
              </div>                

              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }}> {!! __('I Agree all of  <a href="'. url('/terms') .'">terms and conditions</a>') !!}
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
                  <div class="col-md-12">
                      <button type="submit" class="btn btn-primary btn-midum">
                          {{ __('Register Now') }}
                      </button>
                  </div>
              </div>
          </form>
      </div>
  </div>

  <!-- Scripts -->    
  <script src="{{asset('frontend/js/main.min.js')}}"></script>
  <script src="{{asset('frontend/js/toastr.min.js')}}"></script>
  <script src="{{asset('frontend/js/TreeMenu.js')}}"></script>
  <script>
    //add cart item
    (function($){
      $('.addItemCart').click(function(e) {
        e.preventDefault();
        
        pId = $(this).data('product');
        Qty = $('#qtyval').val() != undefined ? $('#qtyval').val(): 1; 

        $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        jQuery.ajax({
          url: "{{ url('/cart/add') }}",
          method: 'post',
          data: { pid: pId, item: Qty },
          success: function(result){
            if (result.success) {
              window.location.replace('{{ url("/cart") }}'); 
              toastr.success("{{ "Cart Item Add Successfully" }}");
            }else{
              if (result.error) {
                toastr.error(result.error);
              }
            }
          }
        });
      });
    })(jQuery);

    //Update Cart Item
    function updateCart(argument) {
      rowId = jQuery(argument).data('rowid');
      quantity = jQuery(argument).val();
      var self = jQuery(argument);
      //console.log(rowId);
      $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      jQuery.ajax({
        url: "{!! route('cart.update') !!}",
        type: 'post',
        data: {method: 'post', rowid: rowId, qty:quantity},                   
        success: function(result){

          if (result.success) {

            if (result.count>1) { $('.ItemNum').html('<span class="itemcount">'+result.count+'</span> ITEMS'); }
            if (result.count==1) {$('.ItemNum').html('<span class="itemcount">'+result.count+'</span> ITEM');}

            $('.cptotal').html(result.total);
            $('#discPrice').html('৳ ' + result.discount);

            if (result.count>0) {
              itms = '<div class="cartItems">';
              $.each(result.data, function(i,data){
              itms +='<div class="cart-item"><div class="cartItemQuty"><input type="number" min="1" step="1" value="'+data.qty+'" class="cartqty" data-id="'+data.id+'" data-rowid="'+data.rowId+'" onchange="updateCart(this);"></div><div class="cartItemImg"><img width="50" src="{{ url('/images') }}/'+data.options.image+'" alt=""></div><div class="cartItemTitle">'+data.name+'</div><div class="cartItemPrice">৳ '+data.price * +data.qty+'</div><div class="cartItemClose"><a href="javascript:void(0);" onclick="removeCart(this)" id="'+data.rowId+'"><i class="fa fa-close"></i></a></div></div>';
              });
              itms += '</div><div class="cartButtons"><a href="{{url('/checkout') }}" class="placeOrder">Place Order</a><div class="cartTotal">৳ '+result.total+'</div></div>';
              $("#cartItemsWrap").html(itms);
              inputChange('.cartItemQuty');
            }else{
              itms ='<div class="cart-empty"><div class="empty-icons"><img src="{{ URL::to('frontend/images/shopping-empty-bag.jpg') }}" alt=""></div><h5>No items in your cart</h5><div class="cartempty-message">Your favourite items are just a click away</div></div>';
              $("#cartItemsWrap").html(itms);
            }

          }else{

            self.val( quantity - 1 );

            if (result.error) {
              toastr.error(result.error);
            }

          }
        }
      });
    }
    //Delete Cart Item
    function removeCart(element) { 
      rId = $(element).attr('id');
      $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      jQuery.ajax({
        url: "{!! route('cart.destroy') !!}",
        type: 'delete',
        data: {method: 'delete', rowid: rId},                   
        success: function(result){
          if (result.success) {

            if (result.count>1) { $('.ItemNum').html('<span class="itemcount">'+result.count+'</span> ITEMS'); }
            if (result.count==1) {$('.ItemNum').html('<span class="itemcount">'+result.count+'</span> ITEM');}

            $('.cptotal').html(result.total);

            $('#discPrice').html('৳ ' + result.discount);

            if (result.count>0) {
              itms = '<div class="cartItems">';
              $.each(result.data, function(i,data){
              itms +='<div class="cart-item"><div class="cartItemQuty"><input type="number" min="1" step="1" value="'+data.qty+'" class="cartqty" data-id="'+data.id+'" data-rowid="'+data.rowId+'" onchange="updateCart(this);"></div><div class="cartItemImg"><img width="50" src="{{ url('/images') }}/'+data.options.image+'" alt=""></div><div class="cartItemTitle">'+data.name+'</div><div class="cartItemPrice">৳ '+data.price * +data.qty+'</div><div class="cartItemClose"><a href="javascript:void(0);" onclick="removeCart(this)" id="'+data.rowId+'"><i class="fa fa-close"></i></a></div></div>';
              });
              itms += '</div><div class="cartButtons"><a href="{{url('/checkout') }}" class="placeOrder">Place Order</a><div class="cartTotal">৳ '+result.total+'</div></div>';
              $("#cartItemsWrap").html(itms);
              inputChange('.cartItemQuty');
            }else{
              itms ='<div class="cart-empty"><div class="empty-icons"><img src="{{ URL::to('frontend/images/shopping-empty-bag.jpg') }}" alt=""></div><h5>No items in your cart</h5><div class="cartempty-message">Your favourite items are just a click away</div></div>';
              $("#cartItemsWrap").html(itms);
              window.location.replace("{{ route('home') }}");  
            }
          }
        }
      });
    }


    //Update Cart From Cart Page
    function upCart(argument) {
      rowId = jQuery(argument).data('rowid');
      quantity = jQuery(argument).val();
      var self = jQuery(argument);
      //console.log(rowId);
      $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      jQuery.ajax({
        url: "{!! route('cart.update') !!}",
        type: 'post',
        data: {method: 'post', rowid: rowId, qty:quantity},                   
        success: function(result){
          console.log(result.data);
          if (result.success) {
            location.reload();
          }else{
            self.val( quantity - 1 );
            if (result.error) {
              toastr.error(result.error);
            }
          }
        }
      });
    }
  </script>
  <script>
    @if(Session::has('success'))
      toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('info'))
      toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
      toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('error'))
      toastr.error("{{ Session::get('error') }}");
    @endif
  </script>

  <script type="text/javascript">make_tree_menu('tree-menu');</script>
  @stack('scripts')
</body>
</html>

