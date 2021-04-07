@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="index.html">Home</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li><a href="#">Areas</a></li>
</ul>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>All Areas</h2>
			<div class="box-icon">
				<a href="{{route('admin.add-area')}}" title="Add New Areas" class="btn-add-new"><i class="icon-pencil"></i> Add New</a>
			</div>
		</div>
		<div class="box-content">

			{{-- @include('flash-message') --}}

			<table class="table table-striped table-bordered bootstrap-datatable">
			  	<thead>
				 	<tr>
						<th>Area Name</th>	
						<th>City Name</th>				  
						<th width="80">Satus</th>
						<th width="150">Actions</th>
				  	</tr>
			  	</thead>   
			  	<tbody>
			  		@foreach($areas as $area)
		          	<tr>	          	
		          		<td>{{$area->title }}</td>
		          		<td>
		          			@if (isset($area->city))
		          			{{$area->city->title }}
		          			@endif
		          		</td>		          
						<td class="center">
						@if($area->status==1)
							<span class="label label-success">Active</span>
						@else
							<span class="label label-warning">Inactive</span>
						@endif
						</td>
						<td class="center">
						<form id="arda{{ $area->id }}" action="{{ route('area.destroy',$area->id) }}" method="POST">
						<a class="btn btn-info" href="{{ route('admin.edit-area', $area->id) }} ">
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
		</div>
	</div><!--/span-->			
</div><!--/row-->
@endsection
