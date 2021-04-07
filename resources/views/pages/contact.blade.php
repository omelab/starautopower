@extends('layouts.app')
@section('pageTitle', 'Contact Us')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/contact') }}">Contact Us</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<div class="row">
			<div class="col-md-6">
				<h3>Location :</h3>
				<p>Ka 21/2, Somir uddin Super Market, South Kuril, Vatara-1229 (5.67 mi) Dhaka, Bangladesh 1229</p>
				<p><i class="fa fa-phone"></i>  01911-861426, 01811-861426</p> 
				<p><i class="fa fa-envelope-o"></i>  md.rhalamin@gmail.com</p> 
			</div>
			<div class="col-md-6">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.1782764910395!2d90.41850701429817!3d23.812258792328826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c73cf05b0993%3A0xe1c12152b19d5756!2sStar%20Auto%20Power!5e0!3m2!1sen!2sbd!4v1583180259216!5m2!1sen!2sbd" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
			</div>
		</div> 
	</div>
</section>
@endsection

