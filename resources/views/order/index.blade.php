@extends('layouts.app')
@section('pageTitle', 'Order List')
@section('content')
<div class="container">
    <div class="row">
    	<div class="section-title">
    		<h3>Order</h3>
    	</div>
		<section class="order-panel">

			@if(is_object($orderInfo))

				@if(!$orderInfo->count())

				<div class="not-found"><div class="alert alert-warning"><strong>Sorry!</strong> You have no order information.</div></div>
				@else

					<table id="datatable" class="table table-striped table-bordered bootstrap-datatable order-table">
					  	<thead>
						 	<tr>
								<th width="15">ID</th>
								<th>Order Date</th>	
								<th>Payment Method</th>	
								<th>Price Amount</th>
								<th>Delivery Charge</th>
								<th width="80">Status</th>
								<th width="220">Actions</th>
						  	</tr>
					  	</thead>   
					  	<tbody>
					  		@foreach($orderInfo as $order)
					  		<?php
					  			$timestamp = strtotime($order->created_at);
					  			$date = date('d F, Y', $timestamp) 
					  		?>
				          	<tr>	          	
				          		<td>#ord{{ $order->order_code??'' }}</td>
				          		<td> {{ $date }}</td>
				          		<td>{{ $order->payment_method }}</td>
				          		<td>৳ {{ $order->amount }}</td>
				          		<td>৳ {{ $order->delivery_charge }}</td>
								<td class="center">{{$order->status??''}}</td>
								<td class="center">
									<a href="{{ route('user.order.details', $order->id) }}" class="btn btn-info" title="View Details"><i class="fa fa-link"></i> Details</a>
									@if($order->status ==1)
									<form id="orderC{{ $order->id }}" action="{{ route('user.order.update',$order->id) }}" method="POST" style="display: inline-block;">
										@csrf
										<input type="hidden" name="status" value="3">
										<button type="submit" class="btn btn-worning" title="Click to Cancel this order"><i class="halflings-icon white trash"></i> Cancel</button>
									</form>
									@endif	
								</td>	
							</tr>			
				      		@endforeach						
						</tbody>
				  	</table>

				@endif

			@endif

		</section>
	</div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script>
$(function(){  
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );  
});	
</script>
@endpush