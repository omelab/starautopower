@extends('layouts.admin-app')
@section('content')
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="index.html">Home</a> 
			<i class="icon-angle-right"></i>
		</li>
		<li><a href="{{ route('admin.slider') }}">Slider</a> <i class="icon-angle-right"></i></li>
		<li><a href="{{ route('admin.add-slider') }}"> Add New Item</a></li>
	</ul>
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon user"></i><span class="break"></span>All Slider</h2>
				<div class="box-icon">
					<a href="{{ route('admin.add-slider') }}" title="Add New Item" class="btn-add-new"><i class="icon-pencil"></i> Add New Item</a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				    <thead>
					    <tr>
					    	<th width="5">#</th>
							<th width="250">Image</th>
							<th>Title</th>
							<th width="80">Status</th>							
							<th width="130">Actions</th>
					    </tr>
				  	</thead>   
				  	<tbody>
				  		@php 
				  			$i =0
				  		@endphp
				  		@foreach ($sliders as $slider)
						<tr>
							<td>{{ ++$i }}</td>
							<td>
								@if($slider->image !='')
				          		<img src="{{URL::to('images/' . $slider->image)}}" alt="{{$slider->title }}" width="80">
				          		@endif
				          	</td>	
				          	<td>{{ $slider->title }}</td>							
							<td>@if($slider->status==1)  Active @else Inactive @endif</td>
							<td>
								<form action="{{ route('slider.destroy',$slider->id) }}" method="POST">
									<a class="btn btn-info" href="{{ route('admin.edit-slider',$slider->id) }}">
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