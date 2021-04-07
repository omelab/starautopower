@foreach($childs as $child)
	</tr><tr>
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
			<form action="{{ route('area.destroy',$child->id) }}" method="POST">
				<a class="btn btn-info" href="{{ route('admin.edit-area', $child->id) }} ">
					<i class="halflings-icon white edit"></i>  
				</a>
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-danger"><i class="halflings-icon white trash"></i></button>
			</form>
		</td>
		@if(count($child->childs))
			@include('admin.area.child',['childs' => $child->childs])
		@endif	
@endforeach
