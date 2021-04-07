<ul>
	@foreach($childs as $child)
		@if( $child->status==1)
			<li class="{{ RomansHelper::get_activeslug($child->slug) }}"
            ><a href="{{ URL::to( 'category/'.$child->slug ) }}">{{ $child->title }}</a>			
				@if(count($child->childs))
					@include('admin.category.manageChild',['childs' => $child->childs])
			  @endif
			</li>
		@endif
	@endforeach
</ul>
