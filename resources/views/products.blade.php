@extends('layouts.app')
@section('pageTitle', $category->title??'')
@section('content')
<section class="banner-inner">
	<div class="container">
		{!! RomansHelper::get_breadcumb() !!}		
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
					<div class="col-xl-3 col-lg-4 col-sm-6">
						<div class="product">
							<div class="product-img">
								@if($product->image !='')
									<a href="{{URL::to('detsils/' . $product->id)}}"  title="{{$product->title }}"> <img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}" srcset="{{URL::to('images/' . $product->image)}} 2x">
									</a>
								@endif								
							</div>
							<div class="product-title">
								<a href="{{URL::to('detsils/' . $product->id)}}"><h3>{{ $product->title }}</h3><p>Style - {{ $product->sku }}</p></a>					
							</div>
							<div class="product-bottom">
								<div class="product-price">
									@if($product->sale_price !=0)
										<span class="current-price">Tk. {{ intval($product->sale_price) }}</span>
									@endif
									@if($product->regular_price !=0)
										<span class="old-price">Tk. {{ intval($product->regular_price) }}</span>
									@endif
								</div>

								@php
									$option = $product->options;
								@endphp
								@if($product->stock_qty >0)
									@if(!$option->count())
										<a href="{{ url('/cart/add/'.$product->id)}}" id="product-item-{{ $product->id }}" class="cartbtn addItemCart" data-product="{{ $product->id }}">
											<i class="fa fa-shopping-cart"></i>  Add to Cart
										</a>
									@else
										<a href="{{URL::to('detsils/' . $product->id)}}"  class="cartbtn"><i class="fa fa-shopping-cart"></i>  Add to Cart</a>
									@endif
								@else
									<span class="out-stock"><i class="fa fa-exclamation-triangle"></i>Out of stock </span>
								@endif

								<div class="fb-share-button" 
    								data-href="{{URL::to('detsils/' . $product->id)}}" data-layout="button_count">
								</div>
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
