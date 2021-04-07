@extends('layouts.app')
@section('pageTitle', 'SHOPPING CART')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/cart') }}">Shopping Cart</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<section class="cart-area">
			<div class="section-header">
				<h2>SHOPPING CART</h2>
			</div>
			<div class="products-warp">		
				@if(!$cartItems->count())
				<div class="not-found"><div class="alert alert-warning"><strong>Sorry!</strong> Your Cart is Empty.</div></div>
				@else
				<div class="row">
					<div class="col-md-8">
						<table class="cart-table">
							<thead>
								<th width="40%" style="text-align: left;">TITLE</th>
								<th width="15%">QTY</th>
								<th width="15%">TOTAL</th>
								<th width="15%">ACTION</th>
							</thead>
							<tbody id="cartBody">
								@php
									$i=1;
								@endphp
								@foreach($cartItems as $item)
								<tr>
									<td style="text-align: left;">
										<table>
											<tr>
												<td width="40%">
													@if ($item->options->has('image'))
													<a href="{{ url('images/'.$item->options->image) }}" class="fancybox">
														<img width="100" src="{{ url('images/'.$item->options->image) }}" alt="">
													</a>
													@endif 
												</td>
												<td width="60%">
													{{ $item->name }}<br>

													@if ($item->options->has('size'))
													Size : {{ $item->options->size }}<br>
													@endif 

													@if ($item->options->has('color'))
													Size : {{ $item->options->color }}<br>
													@endif 
													 
												</td>
											</tr>
										</table> 
										
									</td>
									<td> <span class="qty"> Qty : </span>
										<div class="cartItemQuty">
			                                <input type="number" min="1" step="1" value="{{ $item->qty }}" class="cartqty" data-id="{{ $item->id }}" data-rowid="{{ $item->rowId }}"  onchange="upCart(this);">
			                              </div>
			                          </td>
									<td>Tk. {{ $item->price * $item->qty }}</td>
									<td>
										<form id="arda{{ $item->id }}{{ $i++ }}" action="{{ route('cart.delete',$item->rowId) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="delete-item"><i class="fa fa-trash"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-4">
						<table class="cart-summery-table">
							<tbody>
								<tr>
									<th colspan="2"> <h3>TOTAL AMMOUNT</h3></th>
								</tr>
								<tr>
									<td>Sub Total:</td>
									<td id="subt">Tk. {{ Cart::subtotal(0, false, false) }}	</td>
								</tr>
								<tr>
									<td>Tax(If Any):</td>
									<td id="tx">Tk. {{ Cart::tax() }} </td>
								</tr>
								<tr>
									<td>Total:</td>
									<td id="tot">Tk. {{ Cart::total(0, false, false) }} </td>
								</tr>
								<tr>
									<td colspan="2">
										<a href="{{ URL::to('/') }}" class="btn btn-shoping">CONTINUE SHOPPING</a>
										<a href="{{ URL::to('/checkout') }}" class="btn  btn-checkout">CHECK OUT</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>				
				</div>	
				@endif		
			</div>
		</section>
	</div>
</section>
@endsection

@push('scripts')	
	<script>

   	</script>
@endpush
