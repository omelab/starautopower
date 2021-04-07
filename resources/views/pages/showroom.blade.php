@extends('layouts.app')
@section('pageTitle', 'Showroom Locaion')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/showroom-location') }}">Showroom Location</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<div class="row">
			<div class="col-sm-2 col-md-4">
				<div class="location-item">
					<h2>Baily Road Branch</h2>
					<ul>
						<li>3, New Baily Road, Dhaka</li>						
						<li>Email: <a href="mailto:cominfo@mcraftbd.com">info@mcraftbd.com</a></li>
						<li>Web: <a href="www.mcraftbd.com">www.mcraftbd.com</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-2 col-md-4">
				<div class="location-item">
					<h2>Baily Road Branch</h2>
					<ul>
						<li>Baily Feasta, 1, New Baily Road, Dhaka</li>						
						<li>Email: <a href="mailto:cominfo@mcraftbd.com">info@mcraftbd.com</a></li>
						<li>Web: <a href="www.mcraftbd.com">www.mcraftbd.com</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-2 col-md-4">
				<div class="location-item">
					<h2>Uttara Branch</h2>
					<ul>
						<li>Mascot Plaza (1st Floor), Sector - 7, Uttara, Dhaka</li>						
						<li>Email: <a href="mailto:cominfo@mcraftbd.com">info@mcraftbd.com</a></li>
						<li>Web: <a href="www.mcraftbd.com">www.mcraftbd.com</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-2 col-md-4">
				<div class="location-item">
					<h2>Uttara Branch</h2>
					<ul>
						<li>North Tower (1st Floor), Sector - 7, Uttara, Dhaka</li>						
						<li>Email: <a href="mailto:cominfo@mcraftbd.com">info@mcraftbd.com</a></li>
						<li>Web: <a href="www.mcraftbd.com">www.mcraftbd.com</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-2 col-md-4">
				<div class="location-item">
					<h2>Dhanmondi Branch</h2>
					<ul>
						<li>Orchard Point (1st Floor), Dhanmondi - 7, Dhaka</li>						
						<li>Email: <a href="mailto:cominfo@mcraftbd.com">info@mcraftbd.com</a></li>
						<li>Web: <a href="www.mcraftbd.com">www.mcraftbd.com</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection