@extends('layouts.app')
@section('pageTitle', 'Checkout')
@section('content')
<section class="banner-inner">
	<div class="container">
		<ul class="breadcumbs">
			<li><a href="{{ url('/') }}"> Home</a></li>
			<li><span><i class="fa fa-angle-right"></i></span> <a href="{{ url('/checkout') }}">Checkout</a></li>
		</ul>	
	</div>
</section>
<section class="container-main">
	<div class="container"> 
		<section class="checkout-panel">
			<div class="checkoutStep {{ is_object($deliveryInfo) ? 'Complete':'' }}" id="first-step">			
				<div class="checkoutStepTitle">
					<div class="titleLeft">
						<div class="stepIcon"><i class="fa fa-map-marker"></i></div>
						<h2>Delivery Address</h2>
							<p id="saddres">{{ is_object($deliveryInfo) ? $deliveryInfo->address : '' }}</p>
							<div class="btn-actions" id="btnActions">
								@if( is_object($deliveryInfo) )	
								<button class="change-btn" type="button" onclick="changeAdd()">Change</button>
								<button class="close-change-btn" type="button" onclick="closeChangeAdd()">Close</button>	
								@endif
							</div>
					</div>
				</div>
				
				<div class="checkoutStepContent">
					<div class="area-alert {{ !is_object($deliveryInfo)? 'hide':'' }}">
						<p class="address">	
							<i class="fa fa-check-circle"></i> <span id="aladdress">	{{ is_object($deliveryInfo) ? $deliveryInfo->address : '' }}</span>
							</p>
							<p class="area" id="alarea"> {{ is_object($deliveryInfo) ? $deliveryInfo->area : '' }}
						</p>
						<button class="edit-info" onclick="editOpen()">Edit</button>
					</div>
					<form action=""  method="POST" id="EditForm" class="{{ !is_object($deliveryInfo)? 'hide':'' }}">	
						@csrf				
						<div class="form-group row">
			      	<label for="cname" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>
			      	<div class="col-md-9">
			      		<input id="cname" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ is_object($deliveryInfo) ? $deliveryInfo->name : '' }}" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label for="caddress" class="col-md-3 col-form-label text-md-right">{{ __('address') }}</label>
							<div class="col-md-9">
								<textarea name="address" id="caddress" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" required autofocus> {{ is_object($deliveryInfo) ? $deliveryInfo->address : '' }}</textarea>							  
							</div>
						</div>
						<div class="form-group row">
						 	<label for="cmobile" class="col-md-3 col-form-label text-md-right">{{ __('Mobile') }}</label>
						  <div class="col-md-9">
					  		<span class="prefix-mobile">+88</span>
					      <input id="cmobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ is_object($deliveryInfo) ? $deliveryInfo->mobile : '' }}" required autofocus>
						  </div>
						</div>	          
	        	<div class="form-group row">
            	<label for="carea" class="col-md-3 col-form-label text-md-right">{{ __('Area') }}</label>
	            <div class="col-md-9"> 
									{!! Form::select('area', $area, isset( $deliveryInfo->area_id)? $deliveryInfo->area_id : old('area'), ['class'=>'form-control', 'id'=>'carea', 'data-rel'=>'chosen', 'placeholder'=>'Select Area']) !!}
	            </div>
	        	</div>
						<div class="form-group row">
							<div class="col-md-9 offset-md-3">
								<button id="cfirmBtn" type="button" class="btn btn-primary" onclick="editDelivery()">
									{{ __('Confirm') }}
								</button>
							</div>
						</div>
					</form>

					<button class="new-address-btn {{ !is_object($deliveryInfo)? 'hide':'' }}" id="addNewAddress" onclick="addNew()">
						<i class="fa fa-plus"></i> Add New Address
					</button>

					<form action=""  method="POST" id="NewForm" style="display: {{ !is_object($deliveryInfo)? 'block':'none'}};">	
						@csrf				
						<div class="form-group row">
			      	<label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>
			      	<div class="col-md-9">
			      		<input id="new_name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label for="address" class="col-md-3 col-form-label text-md-right">{{ __('address') }}</label>
							<div class="col-md-9">
								<textarea name="address" id="new_address" class="form-control" placeholder="House Number, Road Number, Location, Area/Thana, Zip Code, City" required autofocus></textarea>						  
							</div>
						</div>
						<div class="form-group row">
						 	<label for="mobile" class="col-md-3 col-form-label text-md-right">{{ __('Mobile') }}</label>

						  <div class="col-md-9">
						  		<span class="prefix-mobile">+88</span>
						      <input id="new_mobile" type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}" required autofocus>
						  </div>
						</div>	          
			        	<div class="form-group row">
			            	<label for="area" class="col-md-3 col-form-label text-md-right">{{ __('Area') }}</label>
				            <div class="col-md-9">
				            	{!! Form::select('area', $area, old('area'), ['class'=>'form-control', 'id'=>'new_area', 'data-rel'=>'chosen', 'placeholder'=>'Select Area', 'required'=>true]) !!} 
				            </div>
			        	</div>
						<div class="form-group row">
							<div class="col-md-9 offset-md-3">
								<button id="newformBtn" type="button" class="btn btn-primary" onclick="newDelivery()">
									{{ __('Submit') }}
								</button>
							</div>
						</div>
					</form>
				</div>				
			</div>
				
			<form id="checkoutForm" method="POST" action="{{ route('checkout.submit') }}">
					@csrf
					
				<input id="deliveryId" type="hidden" name="delivery_id" value="{{ is_object($deliveryInfo)? $deliveryInfo->id: '' }}">

				<div class="checkoutStep  {{ is_object($deliveryInfo)? 'activeSlog': 'checkoutSlot' }} " id="secondStep">
					<div class="checkoutStepTitle">
						<div class="titleLeft">
							<div class="stepIcon"><i class="fa fa-clock-o"></i></div>
							<h2>Preferred Time & Comments</h2>
						</div>
					</div>
					<div class="checkoutStepContent">
						<div class="row">
							<div class="col-sm-6">
								<section class="day">
									<label class="select-label">Pick Delivery Day :</label>
									<?php 
										$curh = date('H') == '00'? 24 : date('H');
									?>

									<select name="day_slot" class="c-select" id="daySlot" onchange="DeliveryTime(this)"> 

										<option value="<?php echo  date("l, d M", time()+86400);?>">Tomorrow, <?php echo  date("d M", time()+86400);?></option>

										<option value="<?php echo  date("l, M d", time()+172800);?>"><?php echo  date("l, M d", time()+172800);?></option>

										<option value="<?php echo  date("l, M d", time()+259200);?>"><?php echo  date("l, M d", time()+259200);?></option>
									</select>
									@if ($errors->has('day_slot'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('day_slot') }}</strong>
                    </span>
                  @endif
								</section>
							</div> 
						</div>
						<div class="row"> 
							<div class="col-sm-9" style="margin-top: 20px;">
			      		<label class="select-label">COMMENTS :</label>
			      		<textarea class="form-control" name="comments" id="comments" cols="30" rows="5"></textarea>  
			      	</div>
						</div>
					</div>
				</div>
				<div class="placeOrderFooter">
					<div class="paymentMethodInstruction"><p>Payment options available on the next page</p></div>
					<div class="confirmBtnContainer">
						<div class="footNote" id="footNote">৳ {{ $charge }} Shipping fee included</div>
						<input type="hidden" name="delivery_charge" id="deliveryCharge" value="{{ $charge }}">

						<button type="button" class="confirmBtn {{ !is_object($deliveryInfo)? 'disabled': '' }}" id="proceedBtn" onclick="formSubmit()">
								<div class="placeOrderText">Proceed</div>
								<div class="placeOrderPrice">৳ {{ Cart::total(0, false, false) + $charge }}</div>
						</button>
							<p class="termConditionText">By clicking/tapping proceed, I agree to roman's <a href="{{ URL::to('terms-of-use') }}" target="_blank">Terms of Services</a></p>
					</div>					
				</div>
			</form>
		</section>
	</div>
</section>
@endsection

@push('scripts')	
	<script>
		"use strict";

		(function() {
			[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
				new SelectFx(el);
			} );
		})();

		var step 	= {{ is_object($deliveryInfo)? '2': '1' }};
		var mobilePattern =  /^[01]{2}[0-9]{9}$/;


	  	function DeliveryTime(ev) {
	  		var dayval = $(ev).val();
	  		var delId  = $('#deliveryId').val();
	  		$.getJSON("/timelist/"+ delId +"/"+dayval, function(jsonData){
	        var select = '';
	        $.each(jsonData, function(i, data){
	        	select +='<option value="'+data.val+'">'+data.val+'</option>';
	        });
	        $("#timeSlot").html(select);
	      });    		
	  	}   

	    function changeAdd(){
	    	$('#first-step').removeClass('Complete');
	    	$('#secondStep').removeClass('activeSlog').addClass('checkoutSlot');
	    	$('#EditForm').removeClass('active');
	    	$('.area-alert,  #addNewAddress').css({
	    		'display':'Block'
	    	});
	    	$('#proceedBtn').addClass('disabled').removeAttr( "onclick");	    	
	    	step 	= 1;
	    }

	    function closeChangeAdd(){
	    	$('#first-step').addClass('Complete');
	    	$('#secondStep').addClass('activeSlog').removeClass('checkoutSlot');
	    	$('#proceedBtn').removeClass('disabled').attr( "onclick", "formSubmit()" );
	    	$('.area-alert,  #addNewAddress, #NewForm').css({
	    		'display':'none'
	    	});
	    	if ( $('#deliveryId').val() !='' ) { step 	= 2; }
	    }

	    function editOpen() {
	    	$('#EditForm').addClass('active');
	    	$('.area-alert, #addNewAddress').css({
	    		'display':'none'
	    	});
	    }

	    function addNew() {
	    	$('#addNewAddress').css('display', 'none');
	    	$('.area-alert').css('display', 'none');
	    	$('#NewForm').css('display', 'block');
	    }

	    //Add New Delivery Forms
	    function newDelivery(){
	     
	     
	    	var cartprice		= <?php echo Cart::total(0, false, false);?>,
	  			new_name 		= $('#new_name').val(),
	  			new_address 	= $('#new_address').val(), 
	  			new_mobile 		= $('#new_mobile').val(),
	  			new_area 		= $('#new_area').val();

	  		if (new_name=='') {
	  			$('#new_name').addClass('error');
	  		}else{
	  			$('#new_name').removeClass('error');
	  		}

	  		if (new_address=='') {
	  			$('#new_address').addClass('error');
	  		}else{
	  			$('#new_address').removeClass('error');
	  		}

	  		if (! mobilePattern.test(new_mobile)) {
	  			$('#new_mobile').addClass('error');
	  		}else{
	  			$('#new_mobile').removeClass('error');
	  		}

	  		if (new_area=='') {
	  			$('#new_area').addClass('error');
	  		}else{
	  			$('#new_area').removeClass('error');
	  		}

	    	if (new_name !='' && new_address !='' && $.isNumeric(new_mobile) &&  mobilePattern.test(new_mobile) && new_area!='') {
				 	
				 	$.ajaxSetup({
				 		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		      });

					jQuery.ajax({
				    url: "{!! route('delivery.add') !!}",
				    type: 'POST',
				    dataType: "json",
				    data: { method: 'post', name: new_name, address: new_address, mobile: new_mobile, area: new_area }, 

				    success: function(result){
					    if (!result.errors) {
					    	$('#footNote').html('৳ ' + result.charge + ' Shipping fee included'); 
					    	$('#placeOrderPrice').html('৳ '+ (cartprice + result.charge));

					    	$('#deliveryCharge').val(result.charge);

					    	var deliverinfo = result.delivery;

					    	$('#deliveryId').val(deliverinfo.id);
					    	$('#cname').val(deliverinfo.name);
					    	$('#caddress').val(deliverinfo.address);
					    	$('#aladdress').html(deliverinfo.address);
					    	$('#cmobile').val(deliverinfo.mobile);
					    	$('#carea').val(deliverinfo.area_id);
					    	$('#alarea').html(deliverinfo.area);
					    	
					    	var select = ''; 
					    	$.each(result.timeslot, function(i, time){
			          	select +='<option value="'+time.val+'">'+time.val+'</option>';
			          });
					    	$("#timeSlot").html(select);

					    	var dayslct = ''; 
					    	$.each(result.dayslot, function(i, day){
			          	dayslct +='<option value="'+day.key+'">'+day.val+'</option>';
			          });

					    	$("#daySlot").html(dayslct);			    	
					    	$('#NewForm').css('display', 'none');
					    	$('#new_name, #new_address, #new_mobile').val('');
					    	$('#first-step').addClass('Complete');
			    			$('#secondStep').removeClass('checkoutSlot').addClass('activeSlog');
			    			$('#saddres').html(deliverinfo.address);

			    			$('#btnActions').html('<button class="change-btn" type="button" onclick="changeAdd()">Change</button><button class="close-change-btn" type="button" onclick="closeChangeAdd()">Close</button>');

			    			$('#proceedBtn').removeClass('disabled').attr( "onclick", "formSubmit()" );

			    			step 	= 2;
					    }	
				    }
					});
				} 
	  	}

	  	//Edit Delivery Forms
	  	function editDelivery(){
	  		var cartprice = <?php echo Cart::total(0, false, false);?>

	  		var	$name 		= $('#cname').val(),
						$address 	= $('#caddress').val(),
						$mobile 	= $('#cmobile').val(),
						$area 		= $('#carea').val(),
						delId 		= $('#deliveryId').val();

	  		if ($name=='') {
	  			$('#cname').addClass('error');
	  		}else{
	  			$('#cname').removeClass('error');
	  		}

	  		if ($address=='') {
	  			$('#caddress').addClass('error');
	  		}else{
	  			$('#caddress').removeClass('error');
	  		}

	  		if (! mobilePattern.test($mobile)) {
	  			$('#cmobile').addClass('error');
	  		}else{
	  			$('#cmobile').removeClass('error');
	  		}

	  		if ($area=='') {
	  			$('#carea').addClass('error');
	  		}else{
	  			$('#carea').removeClass('error');
	  		}
	  		if ($name !='' && $address !='' && $.isNumeric($mobile) &&  mobilePattern.test($mobile) && $area!='') {
	    		$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		      });
					jQuery.ajax({
				    url: "{{ URL::to('/delivery') }}/"+delId,
				    type: 'POST',
				    dataType: "json",
				    data: { method: 'post', name: $name, address: $address, mobile: $mobile, area: $area }, 
				    success: function(result){
				    	if (!result.errors) {
					    	$('#footNote').html('৳ ' + result.charge + ' Shipping fee included'); 
					    	$('#placeOrderPrice').html('৳ '+ (cartprice + result.charge));

					    	$('#deliveryCharge').val(result.charge);

					    	var deliverinfo = result.delivery;
					    	$('#deliveryId').val(deliverinfo.id);
					    	$('#cname').val(deliverinfo.name);
					    	$('#caddress').val(deliverinfo.address);
					    	$('#aladdress').html(deliverinfo.address);
					    	$('#cmobile').val(deliverinfo.mobile); 
					    	$('#carea').val(deliverinfo.area_id);
					    	$('#alarea').html(deliverinfo.area);
					    	
					    	var select = ''; 
					    	$.each(result.timeslot, function(i, time){
		          	select +='<option value="'+time.val+'">'+time.val+'</option>';
			          });
					    	$("#timeSlot").html(select);

					    	var dayslct = ''; 
					    	$.each(result.dayslot, function(i, day){
			          	dayslct +='<option value="'+day.key+'">'+day.val+'</option>';
			          });

					    	$("#daySlot").html(dayslct);
					    	
					    	$('#NewForm').css('display', 'none');
					    	
					    	$('#first-step').addClass('Complete');
			    			$('#secondStep').removeClass('checkoutSlot').addClass('activeSlog');
			    			$('#saddres').html(deliverinfo.address);
			    			$('#btnActions').html('<button class="change-btn" type="button" onclick="changeAdd()">Change</button><button class="close-change-btn" type="button" onclick="closeChangeAdd()">Close</button>');
			    			$('#proceedBtn').removeClass('disabled').attr( "onclick", "formSubmit()" );
			    			step 	= 2;
				    	}
					  }
					});    			
	  		}    		
	  	}

		function formSubmit(){
			var dval = $('#deliveryId').val();
			if (step == 2 && dval !='') {
				$('#checkoutForm').submit();
			}else{
				toastr.error("Please add delivery information first.");
			}
		}
  </script>
@endpush