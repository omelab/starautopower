@extends('layouts.app')
@section('pageTitle', $key)
@section('content')
<section class="banner-inner">
	<div class="container">
		<div class="serach-key"> <span>You have Search by :</span> {{ $key }}</div>
	</div>
</section>
<section class="container-main">
	<div class="container">
		<section class="latest-collection">
			<div class="section-content">	
				@if(!$products->count())
				<div class="not-found"><div class="alert alert-warning"><strong>Sorry!</strong> Product's not fund</div></div>
				@else
				<div class="row">
					@foreach ($products as $product)
					<div class="col-md-3 col-sm-4">
						<div class="product">
							<div class="product-img">
								@if($product->image !='')
									<a href="{{URL::to('images/' . $product->image)}}" class="fancybox" title="{{$product->title }}">
										<img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}">
									</a>
								@endif								
							</div>
							<div class="product-title">
								<a href="details.html"><h3>{{ $product->title }}</h3></a>					
							</div>
							<div class="product-bottom">
								<div class="product-price">
									@if($product->sale_price !=0)
										<span class="current-price">{{ intval($product->sale_price) }}Tk.</span>
									@endif
									@if($product->regular_price !=0)
										<span class="old-price">{{ intval($product->regular_price) }}Tk.</span>
									@endif
								</div>
								<a href="{{ url('/cart/add/'.$product->id)}}" id="product-item-{{ $product->id }}" class="addItemCart" data-product="{{ $product->id }}"> BUY NOW <i class="fa fa-cart-plus"></i> </a>	
							</div>
						</div>
					</div>
					@endforeach
				</div>	
				@endif
			</div>
		</section>
	</div>
</section>
@endsection
