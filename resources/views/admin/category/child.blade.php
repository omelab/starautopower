@foreach($childs as $child)
	</tr><tr>		
		<td class="center">
			@if($child->image !='')
      		<img src="{{URL::to('images/' . $child->image)}}" alt="{{$child->title }}" width="20" style="margin-top: 5px; display: inline-block;">
      		@endif
		</td>
		<td>
			{{$child->title }}
		</td>
		<td class="center">
			@if($child->status==1)
				<span class="label label-success">Active</span>
			@else
				<span class="label label-warning">Inactive</span>
			@endif
		</td>
		<td class="center">
			<form action="{{ route('category.destroy',$child->id) }}" method="POST">
				<a class="btn btn-info" href="{{ route('admin.edit-category', $child->id) }} ">
					<i class="halflings-icon white edit"></i>  
				</a>
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-danger"><i class="halflings-icon white trash"></i></button>
			</form>
		</td>
		@if(count($child->childs))
			@include('admin.category.child',['childs' => $child->childs])
		@endif	
@endforeach
