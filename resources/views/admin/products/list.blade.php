@extends('layouts.admin-app')
@section('content')
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="index.html">Home</a> 
			<i class="icon-angle-right"></i>
		</li>
		<li><a href="{{ route('admin.products') }}">Products</a> <i class="icon-angle-right"></i></li>
		<li><a href="{{ route('admin.add-products') }}"> Create New Product</a></li>
	</ul>
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon user"></i><span class="break"></span>All Products</h2>
				<div class="box-icon">
					<a href="{{ route('admin.add-products') }}" title="Add New Categories" class="btn-add-new"><i class="icon-pencil"></i> Add New</a>
				</div>
			</div>
			<div class="box-content">
				<table id="datatable" class="table table-striped table-bordered bootstrap-datatable">
				    <thead>
					    <tr>
					    	<th>#</th>
							<th>Image</th>
							<th>Title</th>
							<th width="80">Style</th>
							<th width="80">Sales Price</th>
							<th width="100">Regular Price</th>
							<th width="100">Stock</th>
							<th width="80">Category</th>
							<th width="80">City</th>
							<th width="80">Is Home</th>
							<th width="80">Status</th>							
							<th width="100">Actions</th>
					    </tr>
				  	</thead>   
				  	<tbody>
				  		@php 
				  			$i =0
				  		@endphp
				  		@foreach ($products as $product)
						<tr>
							<td>{{ ++$i }}</td>
							<td>
								@if($product->image !='')
				          		<img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}" width="80" srcset="{{URL::to('images/' .$product->image)}} 2x">
				          		@endif
				          	</td>							
							<td>{{ $product->title }}</td>
							<td>{{ $product->sku }}</td>
							<td><span class="sale-price">{{ $product->sale_price }}</span></td>
							<td><span class="regular-price">{{ $product->regular_price }}</span></td>
							<td>{{ $product->stock_qty }}</td>
							<td>
								@foreach($product->categories as $cat)
							        <p>{{ $cat->title }}</p>
							    @endforeach
							</td>							
							<td>
								@foreach($product->cities as $ci)
							        <p>{{ $ci->title }}</p>
							    @endforeach
							</td>
							<td>@if($product->is_home==1)  Yes @else No @endif</td>
							<td>@if($product->status==1)  Yes @else No @endif</td>							
							<td>
								<form action="{{ route('products.destroy',$product->id) }}" method="POST">
									<!-- <a class="btn btn-success" href="{{ route('admin.show-products',$product->id) }}">
											<i class="halflings-icon white zoom-in"></i>
									</a> -->
									<a class="btn btn-info" href="{{ route('admin.edit-products',$product->id) }}">
										<i class="halflings-icon white edit"></i>  
									</a>
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger"><i class="halflings-icon white trash"></i></button>
								</form>
							</td>
						</tr>
						@endforeach					
				  	</tbody>
			 	</table> 
				<div class="row-fluid pagination">{{-- !! $products->links() !! --}}</div>
			</div>
		</div><!--/span-->			
	</div><!--/row-->
@endsection

@push('scripts')
<script>
$(function(){  
    $('#datatable').DataTable( {
       // dom: 'Bfrtip',
        bSort : false,
        pageLength: 30, 
    } );  
});	
</script>
@endpush