@extends('layouts.admin-app')
@section('content')
<style>
	.printBtn{
		float: right; 
	    margin: -8px;
	    font-size: 12px;
	    padding: 4px;
	    margin-left: 10px;
	    padding: 3px 7px;
	}
</style>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="{{ route('admin.dashboard') }}">Home</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="{{ route('admin.order', 'all') }}">Order</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li><a href="#">Order Details</a></li>
</ul>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>Order Details</h2>
			<button class="btn btn-primary printBtn" onclick="printOrder();"> Print Order</button>
			<div class="box-icon">
				<a href="{{ route('admin.order', 'pending') }}" class="btn btn-info bck-btn"><i class="icon-backward"></i> Back to Order </a>
			</div>
		</div>
		<div class="box-content">
			<div class="order-details" id="orderDetails">
				<style>
					@media print {
						table{
							width: 100%;
							border-collapse: collapse;
						}
						table td, table th{
							padding: 5px 10px;
							border: 1px solid #dd;
						}
						table th{
							background: #ddd;
						}
					}
				</style>	
				<div class="order-details-top">
					<div class="order-left">
						<h5> To, {{ $delivery->name??'' }}</h5>
						<p>Mobile: {{ $delivery->mobile??'' }} <br>
						Address: {{ $delivery->address??'' }} <br> 
						Area: {{ $delivery->area??'' }}</p>
					</div>
					<div class="order-right">
						<p>Order Date : <?php
	          				$timestamp = strtotime( $orditem->created_at);
	          				echo $date = date('d F, Y', $timestamp);
	          			?> <br>
	          				Delivery Date : {{ $delivery->day_slot??'' }}  <br> 
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
					  		@foreach($ordpitem as $key => $order)
				          	<tr>	          	
				          		<td>{{$key+1}}</td>
				          		<td>
				          			@if ($order->image !='')
									<img width="50" src="{{ url('images/'.$order->image) }}" alt="" class="float-left">
									@endif
									<p> {{ $order->name??'' }}

									@if($order->product)
										<br/>Style : {{ $order->product->sku ??''}}
									@endif

									@if( $order->size !='')
									<br/>Size : {{ $order->size ?? '' }} 
									@endif 

									@if( $order->color !='')
									<br/>Color : {{ $order->color??'' }}
									@endif 
									</p>       		
								</td>
								<td align="right">{{ $order->qty }}</td>
								<td align="right">{{ $order->price }}</td>
								<td align="right">{{ number_format($order->qty * $order->price, 2, '.', ',') }}</td>	
							</tr>									
				      		@endforeach	
				      		@endif					
						</tbody>
						<tfoot>
							<tr>
								<td rowspan="4" colspan="2">
									{{-- 'Pending','Confirm','Processing','Complete','Cancle','Payment Denied','Refund','Deleted' --}}
									@switch($orditem->status)
									  
									    @case('Confirm')
									        <div class="alert alert-success">
										  		<strong>Note: </strong>This Order is Confirmed
											</div>
									    @break

									    @case('Processing')
									        <div class="alert alert-success">
										  		<strong>Note: </strong>This Order is Processing
											</div>
									    @break

									    @case('Complete')
									        <div class="alert alert-success">
										  		<strong>Note: </strong>This Order is Complete
											</div>
									    @break

									    @case('Cancle')
									        <div class="alert alert-error">
										  		<strong>Note: </strong> This order is Cancled
											</div>
									    @break

									    @case('Payment Denied')
									        <div class="alert alert-error">
										  		<strong>Note: </strong> Payment Disqualified
											</div>
									    @break

									    @case('Refund')
									        <div class="alert alert-primary">
										  		<strong>Note: </strong> This order is Refunded
											</div>
									    @break

									    @case('Deleted')
									        <div class="alert alert-info">
										  		<strong>Note: </strong> This order is Deleted
											</div>
									    @break
 
									    @default
									       <div class="alert  alert-warning">
										  		<strong>Note: </strong>This Order is Pending
											</div>
										@endswitch 

									@if($orditem->status =='Pending' || $orditem->status =='Processing')

									 {{-- $orditem->status =='Confirm' --}}
										<div class="action-btn-group">
											@if($orditem->status =='Pending')
											<form style="display: inline-block;" id="orderC{{ $orditem->id }}" action="{{ route('admin.order.update', $orditem->id) }}" method="POST">
												@csrf
												<input type="hidden" name="status" value="Confirm">
												<button type="submit" class="btn btn-success" title="Click to Confirm this order"><i class="halflings-icon white check"></i> Confirm </button>
											</form>
											@endif

											@if($orditem->status =='Confirm')
											<form style="display: inline-block;" id="orderC{{ $orditem->id }}" action="{{ route('admin.order.update', $orditem->id) }}" method="POST">
												@csrf
												<input type="hidden" name="status" value="Processing">
												<button type="submit" class="btn btn-primary" title="Click to Processing this order"><i class="halflings-icon white check"></i> Processing</button>
											</form>
											@endif

											@if($orditem->status =='Processing')
											<form style="display: inline-block;" id="orderC{{ $orditem->id }}" action="{{ route('admin.order.update', $orditem->id) }}" method="POST">
												@csrf
												<input type="hidden" name="status" value="Complete">
												<button type="submit" class="btn btn-primary" title="Click to Processing this order"><i class="halflings-icon white check"></i> Complete</button>
											</form>
											@endif

											<form  style="display: inline-block;" id="orderC{{ $orditem->id }}" action="{{ route('admin.order.update', $orditem->id) }}" method="POST">
												@csrf
												<input type="hidden" name="status" value="Cancle">
												<button type="submit" class="btn btn-warning" title="Click to Cancel this order"><i class="halflings-icon white trash"></i> Cancel </button>
											</form>										
										</div>
									@endif

								</td>
								<td colspan="2" style="text-align: right;"><strong> Sub Total</strong></td>
								<td>{{ number_format($orditem->amount, 2, '.', ',') }}</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;"><strong> Delivery Charge</strong></td>
								<td>{{ number_format($orditem->delivery_charge, 2, '.', ',') }}</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;"><strong> Discount</strong></td>
								<td>{{ number_format($orditem->discount, 2, '.', ',') }}</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;"><strong> Total Price</strong></td>
								<td>{{ number_format($orditem->amount + $orditem->delivery_charge - $orditem->discount, 2, '.', ',') }}</td>
							</tr>
						</tfoot>
				  	</table> 
				</div>
			</div>    
		</div>
	</div><!--/span-->			
</div><!--/row-->
@endsection

@push('scripts')
<script>
	$(function(){
	  // bind change event to select
	  $('#ordSelect').on('change', function () {
	      var url = $(this).val(); // get selected value
	      if (url) { // require a URL
	         window.location = '{{ URL::to('admin/order') }}/'+ url; // redirect
	      }
	      return false;
	  });
	});	

	function printOrder(){
		var prtContent = document.getElementById("orderDetails");
		var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
		WinPrint.document.write(prtContent.innerHTML);
		WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		WinPrint.close();
	}
</script>
@endpush


