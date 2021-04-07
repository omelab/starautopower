@extends('layouts.app')
@section('pageTitle', 'About Us')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/about-us') }}">About Us</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<h3>What is Lorem Ipsum?</h3>
		<p><strong>Lorem Ipsum </strong>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. <br><br> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> 
	</div>
</section>
@endsection
