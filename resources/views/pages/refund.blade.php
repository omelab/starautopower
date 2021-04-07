@extends('layouts.app')
@section('pageTitle', 'Return  and Refund Policy')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/return-refund') }}">Return  and Refund Policy</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<h4>Return Policy</h4>
			<p> <strong>A user may return any product during the time of delivery, or within 7 days if:</strong> <br>
				a)     Product does not meet user’s expectation. <br>

				b)    Found damaged during delivery<br>

				c)     Have doubt about the product quality and quantity<br>

				d)    Received in an unhealthy/ unexpected condition<br>

				e)     Is not satisfied with the packaging<br>

				f)      Finds product unusable<br>
			</p>

			<p><strong>A user may return any unopened, item within 7 days of receiving the item. But following products may not be eligible for return or replacement:</strong><br>

				a)     Damages due to misuse of product <br>

				b)    Incidental damage due to malfunctioning of product<br>

				c)     Any consumable item which has been used/installed<br>

				d)    Products with tampered or missing serial/UPC numbers<br>

				e)     Any damage/defect which are not covered under the manufacturer's warranty<br>

				f)      Any product that is returned without all original packaging and accessories, including the box, manufacturer's packaging if any, and all other items originally included with the product/s delivered.				
			</p>
				

			<h4>Refund Policy</h4>
			<p>romansstore.com tries its best to serve the users. But if under any circumstances, we fail to fulfill our commitment or to provide the service, we will notify you within 24 hours via phone/ text/ email. If the service, that romansstore.com fails to complete, requires any refund, it be done maximum within 10 Days after our acknowledgement. <br><br> Refund requests will be processed under mentioned situation:<br> Unable to serve with any product.<br>Customer return any product from a paid order.</p>		
	</div>
</section>
@endsection


