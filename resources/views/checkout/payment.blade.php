@extends('layouts.app')
@section('pageTitle', 'SHOPPING CART')
@section('content')
<div class="container">
    <div class="row">
		<section class="orderSuccess-panel">
			<div class="payment-top">
				<div class="p-container">
					<img src="{{ URL::to('frontend/images/shopping-bag-sucess.png') }}" alt="" class="soping-success">
					<?php
						$timestamp = strtotime($orderInfo->created_at);
						$date = date('d F, Y', $timestamp);
					?>
					<h3>Your order number <strong>{{ $orderInfo->order_code??'' }} </strong></h3>
					<p>Your order has been placed, we will confirm your order over the email, please pay with <span class="color-green">{{ $orderInfo->payment_method }}</span></p>
				</div>
			</div>

			<!-- @if($orderInfo->payment_method =='Cash on Delivery')
			<div class="payment-center">
				<h3>Do you want to <span class="color-green">Pay Now</span>?</h3>
				<div class="pay-row">
					<button type="button" class="payment-button credit-cart">
					<img src="{{ URL::to('frontend/images/credit-card.png') }}" alt=""> <br>Bangladeshi Credit / Debit Card</button>
				<button type="button" class="payment-button credit-cart">
					<img src="{{ URL::to('frontend/images/bkash-payment.png') }}" alt=""> <br>BKash</button>
				</div>
				<div class="pay-row"><span class="ro-btn">or</span><br>
					<button type="button" class="payment-button paypal-btn">
					<img src="{{ URL::to('frontend/images/paypal-carrds.jpg') }}" alt=""></button>
				</div>
			</div>
			@endif -->

			<div class="pay-alert">We are sorry, this order is no longer eligible for pre payment. You can pay by cash when it is delivered. Thank you</div>
			<div class="payment-footer">
				<div class="row">
					<div class="col-sm-6">
						<div class="delivery-info">
							<h3 class="dtitle">Delivery Address</h3>
							<p>{{ $deliveryInfo->address }}</p>
							<div class="disc-space"></div>
							<h3 class="dtitle">Preferred Delivery Timings</h3>
							<p>{{ $deliveryInfo->day_slot }} <br> <!-- {{ $deliveryInfo->time_slot }} --></p>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="order-summery">
							<h3 class="dtitle">Order Summary</h3>
							<table class="os-table">
								<tbody>
									<tr>
										<td class="label">Subtotal</td>
										<td class="val">৳ {{ (int) $orderInfo->amount }}</td>
									</tr>
									<tr>
										<td class="label">Delivery Charge</td>
										<td class="val">৳ {{ (int) $orderInfo->delivery_charge }}</td>
									</tr>
									<tr>
										<td class="label">Special</td>
										<td class="val">-৳ {{ (int) $orderInfo->discount }}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td class="label"><strong>Total</strong></td>
										<td class="val">৳ {{ (int)($orderInfo->amount + $orderInfo->delivery_charge - $orderInfo->discount) }}</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				@if($orderInfo->status ==1)
				<div class="cancel-order-panel">
					<p>Would you like to cancel this order?</p>
					<form id="cancelForm" class="order-cancel" method="POST" action="{{ route('checkout.cancel') }}">
						@csrf
						{{ method_field('DELETE') }}
						<input type="hidden" name="prefix" value="{{ date('ym', $timestamp) }}">
						<input name="order_id" type="hidden" value="{{ $orderInfo->id }}">
						<button type="submit" class="cancel-order">Cancel Order</button>
					</form>					
				</div>
				@endif
			</div>
		</section>
	</div>
</div>
@endsection
@push('scripts')	
	<script>
		"use strict";
		$('.payment-button').click(function(){
			$('.payment-center').addClass('hide');
			$('.pay-alert').addClass('active');
		});
	</script>

	<script type="text/javascript">
		document.getElementById("cancelForm").onsubmit = function onSubmit(form) {
	   		if (confirm("Are you sure to cancel this order?"))
	      		return true;
	   		else
	     		return false;
	     	endif;
	     }
	</script>
@endpush