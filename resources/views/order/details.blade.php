@extends('layouts.app')
@section('pageTitle', 'Order Details')
@section('content')
<div class="container" style="padding-top: 50px;">
    <div class="row">
    	<div class="area-title" style="width: 100%">
    		<h2 style="display: block;">Order <a href="{{ URL::to('users/order') }}" class="back-btn" style="float: right;">Order List</a></h2>
    	</div>
		<section class="order-panel">
			<div class="order-details">
				<div class="order-details-top">
					<div class="order-left">
						<h5> To, {{ $delivery->name }}</h5>
						<p>Mobile: {{ $delivery->mobile }} <br>
						Address: {{ $delivery->address }} <br> 
						Area: {{ $delivery->area }}</p>
					</div>
					<div class="order-right">
						<p>Order Date : <?php
	          				$timestamp = strtotime( $orditem->created_at);
	          				echo $date = date('d F, Y', $timestamp);
	          			?> <br>
	          				Delivery Date : {{ $delivery->day_slot }}  <br> {{ $delivery->time_slot }} 
	          			</p>

					</div>
					
				</div>
				<div class="order-details-middle">
					<table class="table table-striped table-bordered bootstrap-datatable">
					  	<thead>
						 	<tr>
								<th width="15">#</th>
								<th>Description</th>
								<th width="150">Quantity</th>
								<th width="150">Price</th>
								<th width="150">Total</th>
						  	</tr>
					  	</thead>   
					  	<tbody>
					  		@if(is_object($ordpitem))
					  		@foreach($ordpitem as $key => $product)
				          	<tr>	          	
				          		<td>{{$key+1}}</td>
				          		<td>
				          			@if ($product->image !='')
									<img width="50" src="{{ url('images/'.$product->image) }}" alt="" class="float-left" srcset="{{URL::to('images/' . $product->image)}} 2x">
									@endif
									<p>{{ $product->name }}</p>		          		
								</td>
								<td>{{ $product->qty }}</td>
								<td>{{ $product->price }}</td>
								<td>{{ (int)($product->qty * $product->price) }}</td>	
							</tr>									
				      		@endforeach	
				      		@endif					
						</tbody>
						<tfoot>
							<tr>
								<td rowspan="4" colspan="2">
									@switch($orditem->status)
									    @case(3)
									        <div class="alert alert-warning">
										  		<strong>Note: </strong>Your order is cancled
											</div>
									        @break

									    @case(2)
									        <div class="alert alert-success">
										  		<strong>Note: </strong> Your order is completed
											</div>
									        @break

									    @default
									        <div class="alert alert-info">
										  		<strong>Note: </strong> Your order is Processing to complete
											</div>
									@endswitch
									

									@if($orditem->status ==1)
									<div class="action-btn-group">										
										<form id="orderC{{ $orditem->id }}" action="{{ route('user.order.update', $orditem->id) }}" method="POST">
											@csrf
											<input type="hidden" name="status" value="3">
											<button type="submit" class="btn btn-warning" title="Click to Cancel this order"><i class="halflings-icon white trash"></i> Cancel this order</button>
										</form>										
									</div>
									@endif

								</td>
								<td colspan="2" style="text-align: right;"><strong> Sub Total</strong></td>
								<td>{{ (int)($orditem->amount) }}</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;"><strong> Delivery Charge</strong></td>
								<td>{{ (int)($orditem->delivery_charge) }}</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;"><strong> Discount</strong></td>
								<td>{{ (int)($orditem->discount) }}</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;"><strong> Total Price</strong></td>
								<td>{{ (int)($orditem->amount + $orditem->delivery_charge - $orditem->discount) }}</td>
							</tr>
						</tfoot>
				  	</table> 
				</div>
			</div>
		</section>
	</div>
</div>
@endsection