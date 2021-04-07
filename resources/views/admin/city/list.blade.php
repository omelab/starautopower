@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="index.html">Home</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li><a href="#">City</a></li>
</ul>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>All Cities</h2>
			<div class="box-icon">
				<a href="{{route('admin.add-city')}}" title="Add New Areas" class="btn-add-new"><i class="icon-pencil"></i> Add New</a>
			</div>
		</div>
		<div class="box-content">

			{{-- @include('flash-message') --}}

			<table class="table table-striped table-bordered bootstrap-datatable">
			  	<thead>
				 	<tr>
						<th width="15">#</th>
						<th>Area Name</th>				  
						<th width="80">Satus</th>
						<th width="150">Actions</th>
				  	</tr>
			  	</thead>   
			  	<tbody>
					
					{{-- $i=1--}}
					@php $i=1 @endphp

			  		@foreach($cities as $city)
		          	<tr>	          	
		          		<td>{{$i++}}</td>
		          		<td>{{$city->title }}</td>		          
						<td class="center">
						@if($city->status==1)
							<span class="label label-success">Active</span>
						@else
							<span class="label label-warning">Inactive</span>
						@endif
						</td>
						<td class="center">
						<form id="arda{{ $city->id }}" action="{{ route('city.destroy',$city->id) }}" method="POST">
						<a class="btn btn-info" href="{{ route('admin.edit-city', $city->id) }} ">
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
