@extends('layouts.app')
@section('pageTitle', 'SHOPPING CART')
@section('content')
<div class="container">
    <div class="row">
		<section class="orderSuccess-panel">
			<div class="payment-top">
				<div class="p-container">
					<img src="{{ URL::to('frontend/images/cancel.png') }}" srcset="{{ URL::to('frontend/images/cancel.png') }} 2x" alt="" srcset="{{ URL::to('frontend/images/cancel.png') }} 2x" class="soping-success">
					<h3>Your order no <strong> {{ $id }}</strong> is cancelled.</h3> <br><br>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection
@push('scripts')
@endpush