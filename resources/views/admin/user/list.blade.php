@extends('layouts.admin-app')
@section('content')
	<ul class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="index.html">Home</a> 
			<i class="icon-angle-right"></i>
		</li>
		<li><a href="{{ route('admin.list') }}">Admin Users</a> <i class="icon-angle-right"></i></li>
		<li><a href="{{ route('admin.add-users') }}"> Add New Item</a></li>
	</ul>
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2><i class="halflings-icon user"></i><span class="break"></span>All Admin Users</h2>
				<div class="box-icon">
					<a href="{{ route('admin.add-users') }}" title="Add New Item" class="btn-add-new"><i class="icon-pencil"></i> Add New Users</a>
				</div>
			</div>
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				    <thead>
					    <tr>
					    	<th width="5">#</th>
							<th width="250">Name</th>
							<th>Email</th> 							
							<th width="130">Actions</th>
					    </tr>
				  	</thead>   
				  	<tbody>
				  		@php 
				  			$i =0
				  		@endphp
				  		@foreach ($admins as $user)
						<tr>
							<td>{{ ++$i }}</td> 
				          	<td>{{ $user->name??'' }}</td>							
				          	<td>{{ $user->email??'' }}</td>							 
							<td>
								<form action="{{ route('admin.delete-users',$user->id) }}" method="POST">
									<a class="btn btn-info" href="{{ route('admin.edit-users',$user->id) }}">
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