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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap-responsive.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style-responsive.css')}}">
   
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
  </head>
  <body>
    <!-- start: Header -->
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{{ route('admin.dashboard') }}"><span>STAR AUTO</span></a>
          <!-- start: Header Menu -->
          <div class="nav-no-collapse header-nav">
            <ul class="nav pull-right"> 
              <!-- start: User Dropdown -->
              <li class="dropdown">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white user"></i>
                @if(auth()->check())
                {{ Auth::user()->name }}
                @endif
                <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="dropdown-menu-title">
                    <span>Account Settings</span>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('admin-logout-form').submit();
                    "> <i class="halflings-icon off"></i> Logout </a>
                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul>
              </li>
              <!-- end: User Dropdown -->
            </ul>
          </div>
          <!-- end: Header Menu -->
        </div>
      </div>
    </div>
    <!-- start: Header -->
    <div class="container-fluid-full">
      <div class="row-fluid">
        <!-- start: Main Menu -->
        <div id="sidebar-left" class="span2">
          <div class="nav-collapse sidebar-nav">
            <ul class="nav nav-tabs nav-stacked main-menu">
              <li><a href="{{ route('admin.dashboard') }}"><i class="icon-tasks"></i><span class="hidden-tablet"> Dashboard</span></a></li>

              <li><a href="{{URL::to('/admin/products')}}"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Products</span></a></li>

              <li><a href="{{ route('admin.category') }}"><i class="icon-tasks"></i><span class="hidden-tablet"> Categories</span></a></li>
              
              <li><a href="{{ route('admin.city') }}"><i class="icon-building"></i><span class="hidden-tablet"> City</span></a></li>

              <li><a href="{{ route('admin.area') }}"><i class="icon-map-marker"></i><span class="hidden-tablet"> Area</span></a></li>

              <li><a href="{{ route('admin.order', 'all') }}"><i class="icon-list-alt"></i><span class="hidden-tablet"> Order </span></a></li>

              <li><a href="{{ route('admin.slider') }}"><i class="icon-edit"></i><span class="hidden-tablet"> Slider</span></a></li>  

              @if(Auth::user()->job_title == 'admin')  
              <li><a href="{{ route('admin.list') }}"><i class="icon-edit"></i><span class="hidden-tablet"> Admin List</span></a></li>   
              @endif         
               

              <!-- <li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> All Brands</span></a></li>
              
              <li><a href="chart.html"><i class="icon-picture"></i><span class="hidden-tablet"> Banner </span></a></li>
              
              <li><a href="typography.html"><i class="icon-cogs"></i><span class="hidden-tablet"> Site Config</span></a></li>
              
              <li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Users</span></a></li> -->

            </ul>
          </div>
        </div>
        <!-- end: Main Menu -->
        <noscript>
          <div class="alert alert-block span10">
            <h4 class="alert-heading">Warning!</h4>
            <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
          </div>
        </noscript>
        <!-- start: Content -->
        <div id="content" class="span10">          
         {{-- @yield('admin_content') --}}
          @yield('content')
        </div>
        <!--/.fluid-container-->
        <!-- end: Content -->
      </div>
      <!--/#content.span10-->
    </div>
    <!--/fluid-row-->
    <div class="modal hide fade" id="myModal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Settings</h3>
      </div>
      <div class="modal-body">
        <p>Here settings can be configured...</p>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="#" class="btn btn-primary">Save changes</a>
      </div>
    </div>
    <div class="clearfix"></div>
    <footer>
      <p>
        <span style="text-align:left;float:left">&copy; 2018 <a href="http://firstitsolution.com/starauto" alt="Bootstrap Themes">starauto</a></span>
        <span class="hidden-phone" style="text-align:right;float:right">Powered by: <a href="http://omelab.net/" alt="Ome Lab Admin Templates" target="_blank">OmeLab</a></span>
      </p>
    </footer>

    <!-- start: JavaScript-->
    <script src="{{asset('backend/js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery-migrate-1.0.0.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery-ui-1.10.0.custom.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.ui.touch-punch.js')}}"></script>
    <script src="{{asset('backend/js/modernizr.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.cookie.js')}}"></script>
    <script src='{{asset('backend/js/fullcalendar.min.js')}}'></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>    
    <script src="{{asset('backend/js/excanvas.js')}}"></script>
    <script src="{{asset('backend/js/jquery.flot.js')}}"></script>
    <script src="{{asset('backend/js/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('backend/js/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('backend/js/jquery.flot.resize.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.chosen.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.uniform.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.cleditor.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.noty.js')}}"></script>
    <script src="{{asset('backend/js/jquery.elfinder.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.raty.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.iphone.toggle.js')}}"></script>
    <script src="{{asset('backend/js/jquery.uploadify-3.1.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.gritter.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.imagesloaded.js')}}"></script>
    <script src="{{asset('backend/js/jquery.masonry.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.knob.modified.js')}}"></script>
    <script src="{{asset('backend/js/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('backend/js/counter.js')}}"></script>
    <script src="{{asset('backend/js/retina.js')}}"></script>
    <script src="{{asset('backend/js/custom.js')}}"></script>
    <script src="{{asset('frontend/js/toastr.min.js')}}"></script>
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

    <script>
     $(document).ready(function(){
        $( "#city_id" ).change(function() 
      {
        $.getJSON("/starauto/admin/product/"+ $(this).val() +"/city", function(jsonData){
            select = '<select name="position" class="form-control input-sm " required id="position" >';
              $.each(jsonData, function(i,data)
              {
                   select +='<option value="'+data.id+'">'+data.title+'</option>';
               });
            select += '</select>';
            $("#area_id").html(select);
        });
      });
    });
    </script>
    <!-- end: JavaScript-->
    @stack('scripts')
  </body>
</html>