@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="index.html">Home</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li><a href="#">Orders</a></li>
</ul>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>All Orders</h2>
			<div class="box-icon">
				<?php $segment3 = Request::segment(3);?>  
				<select name="" id="ordSelect" class="right-select"> 
					<option value="all" {{$segment3=='all'?'selected':''}}>All</option>
					<option value="Pending" {{$segment3=='Pending'?'selected':''}}>Pending</option>
					<option value="Confirm" {{$segment3=='Confirm'?'selected':''}}>Confirm</option>
					<option value="Processing" {{$segment3=='Processing'?'selected':'' }}>Processing</option>
					<option value="Complete" {{$segment3=='Complete'?'selected':''}}>Complete</option>
					<option value="Cancle" {{$segment3=='Cancle'?'selected':''}}>Cancle</option>{{-- 
					<option value="Payment Denied" {{$segment3=='Payment Denied'?'selected':''}}>Payment Denied</option>
					<option value="Refund" {{$segment3=='Refund'?'selected':''}}>Refund</option> --}}
				</select>

				{{-- <a href="{{route('admin.order.new')}}" title="Create New Order" class="btn-add-new" style="float: right; margin-left: 15px;"><i class="icon-pencil"></i>Create New Order</a> --}}
			</div>
		</div>
		<div class="box-content">
			<table id="datatable" class="table table-striped table-bordered bootstrap-datatable">
			  	<thead>
				 	<tr>
						<th width="15">ID</th>
						<th>Order Date</th>	
						<th>Custoer Name</th>	
						<th>Mobile</th>	
						<th>Payment Method</th>	
						<th>Price Amount</th>
						<th>Delivery Charge</th>			  
						<th width="80">Status</th>
						<th width="50">Actions</th>
				  	</tr>
			  	</thead>   
			  	<tbody>				

			  		@foreach($orders as $order)	   

	          		<?php
			  			$timestamp = strtotime($order->created_at);
			  			$date = date('d-m-Y', $timestamp) 
			  		?>
				    <tr>	          	
		          		<td> #ord{{ $order->order_code??'' }} </td>
		          		<td> {{ $date }}</td>
		          		<td> {{ $order->user->name??'' }}</td>
		          		<td> {{ $order->user->mobile??'' }}</td>
		          		<td>{{ $order->payment_method }}</td>
		          		<td>৳ {{ $order->amount }}</td>
		          		<td>৳ {{ $order->delivery_charge }}</td>
						<td class="center"> {{ $order->status ?? ''}} </td>
						<td class="center">
						<a href="{{ route('admin.order.details', $order->id) }}" class="btn btn-info"><i class="halflings-icon white edit"></i></a>
						</td>	
					</tr>			
		      		@endforeach						
				</tbody>
		  	</table>            
		</div>
	</div><!--/span-->			
</div><!--/row-->
@endsection

@push('scripts')
<script>
$(function(){  
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        bSort : false,
        pageLength: 30,
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } ); 

  // bind change event to select
  $('#ordSelect').on('change', function () {
      var url = $(this).val(); // get selected value
      if (url) { // require a URL
          window.location = '{{ URL::to('admin/order') }}/'+ url; // redirect
      }
      return false;
  });
});	
</script>
@endpush


