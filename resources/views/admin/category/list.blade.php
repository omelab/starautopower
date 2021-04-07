@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="index.html">Home</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li><a href="#">Categories</a></li>
</ul>

<div class="row-fluid">	
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>All Categories</h2>
			<div class="box-icon">
				<a href="{{route('admin.add-category')}}" title="Add New Categories" class="btn-add-new"><i class="icon-pencil"></i> Add New</a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable">
			  	<thead>
					<tr>
						<th width="50">Image</th>
						<th>Category Name</th>				  
						<th width="80">Satus</th>
						<th width="150">Actions</th>
					</tr>
			    </thead>   
			    <tbody>
				 	@foreach($cats as $category)
				        <tr>
				          	<td class="center">
				          		@if($category->image !='')
				          		<img src="{{URL::to('images/' . $category->image)}}"  srcset="{{URL::to('images/' . $category->image)}} 2x" alt="{{$category->title }}" width="30" style="margin-top:5px; display: inline-block;">
				          		@else
				          		<img src="{{URL::to('images/default-img.jpg')}}" alt="{{$category->title }}" srcset="{{URL::to('images/default-img.jpg')}} 2x"  width="30" style="margin-top:5px; display: inline-block;">
				          		@endif
				          	</td>	          	
				          	<td>{{$category->title }}</td>		          
							<td class="center">
								@if($category->status==1)
									<span class="label label-success">Active</span>
								@else
									<span class="label label-warning">Inactive</span>
								@endif
							</td>
							<td class="center">
								<form class="delform"  action="{{ route('category.destroy',$category->id) }}" method="POST">
								<a class="btn btn-info" href="{{ route('admin.edit-category', $category->id) }} ">
									<i class="halflings-icon white edit"></i>  
								</a>
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger"><i class="halflings-icon white trash"></i></button>
								</form>
							</td>
						</tr>
						@if(count($category->childs))
						@foreach($category->childs as $childs)
							<tr>
					          	<td class="center">
					          		@if($childs->image !='')
					          		<img src="{{URL::to('images/' . $childs->image)}}" srcset="{{URL::to('images/' . $childs->image)}} 2x"  alt="{{$childs->title }}" width="20" style="margin-top:5px; display: inline-block;">
					          		@endif
					          	</td>	          	
					          	<td> - {{$childs->title }}</td>		          
								<td class="center">
									@if($childs->status==1)
										<span class="label label-success">Active</span>
									@else
										<span class="label label-warning">Inactive</span>
									@endif
								</td>
								<td class="center">
									<form class="delform"  action="{{ route('category.destroy',$childs->id) }}" method="POST">
									<a class="btn btn-info" href="{{ route('admin.edit-category', $childs->id) }} ">
										<i class="halflings-icon white edit"></i>  
									</a>
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger"><i class="halflings-icon white trash"></i></button>
									</form>
								</td>
							</tr>
								@if(count($childs->childs))
								@foreach($childs->childs as $childs2)
									<tr>
							          	<td class="center">
							          		@if($childs->image !='')
							          		<img src="{{URL::to('images/' . $childs2->image)}}" srcset="{{URL::to('images/' . $childs2->image)}} 2x"  alt="{{$childs2->title }}" width="20" style="margin-top:5px; display: inline-block;">
							          		@endif
							          	</td>	          	
							          	<td> - - {{$childs2->title }}</td>		          
										<td class="center">
											@if($childs2->status==1)
												<span class="label label-success">Active</span>
											@else
												<span class="label label-warning">Inactive</span>
											@endif
										</td>
										<td class="center">
											<form class="delform" action="{{ route('category.destroy',$childs2->id) }}" method="POST">
											<a class="btn btn-info" href="{{ route('admin.edit-category', $childs2->id) }} ">
												<i class="halflings-icon white edit"></i>  
											</a>
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger"><i class="halflings-icon white trash"></i></button>
											</form>
										</td>
									</tr>
								@endforeach				
							@endif
						@endforeach				
						@endif				
      				@endforeach						
				</tbody>
		  	</table>            
		</div>
	</div><!--/span-->			
</div><!--/row-->
@endsection