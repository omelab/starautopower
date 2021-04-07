@extends('layouts.app')
@section('pageTitle', 'Shipping & Delivery')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/shipping-delivery') }}">Shipping & Delivery</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<p>We have our own delivery system and we have our trained delivery personnel with van who are dedicated to deliver any type of goods to your doorsteps.</p>
		<p><strong>Convenient Delivery:</strong> <br> We offer you convenience through our efficient delivery system. You will have the option to select the preferred timing of delivery of your desired goods. You only need to select your preferred date and time and the goods will be at your doorstep. <br>Delivery Charges <br> Delivery Charge: 20 Taka</p>	
	</div>
</section>
@endsection


