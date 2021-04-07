@extends('layouts.app')
@section('pageTitle', 'Home')
@section('content')
	<section class="order-track">
		<div class="container">
			<form action="#">
				<div class="row">
					<div class="col-md-12">
						<h3>Check Your Order Status</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
    					<input type="text" class="form-control" id="orderNumber"  placeholder="Provide your Order Number">  
					</div>
					<div class="col-md-3"><button type="submit" id="findOrder" class="btn btn-primary">Submit</button></div>
				</div> 
				<div class="statusResult"> Your Order #0011 Pending </div>
			</form>
		</div>
	</section>  
	<section class="container-main">
		<div class="container">			
			<section class="latest-collection">
				<div class="section-header">
					<h2>Latest Collection</h2>
				</div>
				<div class="section-content">
					<div class="row"> 
						<div class="col-md-3"> 
							<div class="menu romansnav">
				                <ul  id="tree-menu">
				                    @foreach($latestCategory as $category)
				                    <li  class="<?php echo RomansHelper::get_activeslug($category->slug); ?>">
				                    	<a href="{{ URL::to( 'category/'.$category->slug ) }}">{{$category->title }}</a>
				                        @if(count($category->childs))
				                            @include('admin.category.manageChild',['childs' => $category->childs])
				                        @endif
				                    </li>
				                    @endforeach                  
				                </ul>
				            </div>
						</div>
						<div class="col-md-9">
							<div class="row">
								@foreach ($products as $product)
								<div class="col-xl-4 col-sm-6">
									<div class="product">
										<div class="product-image">
											@if($product->image !='')
												<a href="{{URL::to('detsils/' . $product->id)}}" title="{{ $product->title }}"><img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}" srcset="{{URL::to('images/' . $product->image)}} 2x"></a>
											@endif
										</div>
										<div class="product-title">
											<a href="{{URL::to('detsils/' . $product->id)}}"><h3>{{ $product->title }}</h3><p>Style - {{ $product->sku }}</p></a>
										</div>
										<div class="product-bottom">
											<div class="product-price">
												@if($product->sale_price !=0)
													<span class="current-price"> Tk. {{ intval($product->sale_price) }}</span>
												@endif
												@if($product->regular_price !=0)
													<span class="old-price"> Tk. {{ intval($product->regular_price) }}</span>
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
						</div>  
					</div> 
				</div>
			</section>
			<section class="latest-collection">
				<div class="section-header">
					<h2>Services Collection</h2>
				</div>
				<div class="section-content">
					<div class="row">
						@foreach ($services as $product)
						<div class="col-xl-3 col-lg-4 col-sm-6">
							<div class="product">
								<div class="product-image">
									@if($product->image !='')
										<a href="{{URL::to('detsils/' . $product->id)}}" title="{{ $product->title }}"><img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}" srcset="{{URL::to('images/' . $product->image)}} 2x"></a>
									@endif
								</div>
								<div class="product-title">
									<a href="{{URL::to('detsils/' . $product->id)}}"><h3>{{ $product->title }}</h3><p>Style - {{ $product->sku }}</p></a>
								</div>
								<div class="product-bottom">
									<div class="product-price">
										@if($product->sale_price !=0)
											<span class="current-price"> Tk. {{ intval($product->sale_price) }}</span>
										@endif
										@if($product->regular_price !=0)
											<span class="old-price"> Tk. {{ intval($product->regular_price) }}</span>
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
				</div>
			</section>
			<!-- <section class="special-offer">
			    <div class="row">
			        <div class="col-md-6">
			            <a class="offer-item">
			                <img src="{{URL::to('frontend/images/special-01.jpg')}}" alt="">
			            </a>
			        </div>
			        <div class="col-md-6">
			            <a class="offer-item">
			                <img src="{{URL::to('frontend/images/special-02.jpg')}}" alt="">
			            </a>
			        </div>
			    </div>
			</section> -->
	  </div>
	</section>
	
@endsection

@push('scripts')
<script type="text/javascript">
    $('#bannerCarousel').carousel({
	  interval: 2000
	});


	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$('#findOrder').click(function(e) {
		e.preventDefault(); 
		var order = $('#orderNumber').val();  
		//var email = $("input[name=email]").val();

	    $.ajax({
	    	type:'POST',
	   		url:"{{ route('order-track') }}",
	    	data:{order:order},
	    	success:function(data){
	    		if (data.status !='error') {
	    			$('.statusResult').html("Congrats! Your Order is now  " + data.status );
	        		$('.statusResult').removeClass('show error');
	        		$('.statusResult').addClass('show success');

	    		}
	        	else{
	        		$('.statusResult').html("Sorry! we con't find any order information for " + order);
	        		$('.statusResult').addClass('show error');
	        	}
	    	}
	    }); 
	})
</script>	
@endpush