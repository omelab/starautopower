@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="{{ route('admin.dashboard') }}">Home</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="{{ route('admin.area')}}">Area</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="">Add New Area</a>
	</li>
</ul>

<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Add New Area</h2>
			<div class="box-icon">
				<a href="{{ route('admin.area')}}" title="Add New Categories" class="btn-add-new"><i class="icon-tasks"></i> All Areas</a>
			</div>
		</div>
		<div class="box-content">
			{{-- @include('flash-message') --}}

			{!! Form::open(['route'=>'admin.add-area.submit', 'class'=>'form-horizontal']) !!}

				<fieldset>
					<div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
						{!! Form::label('title', 'Area Name/Title', array('class' => 'control-label')) !!}						
						<div class="controls">
						  {!! Form::text('title', old('title'), ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
						  <span class="text-danger">{{ $errors->first('title') }}</span>
						</div>
					</div>

					<div class="control-group {{ $errors->has('city_id') ? 'has-error' : '' }}">						
						{!! Form::label('area', 'Cities:', array('class' => 'control-label')) !!}
						<div class="controls">
							{!! Form::select('city_id', $cities, old('city_id'), ['class'=>'form-control', 'data-rel'=>'chosen', 'placeholder'=>'Select Area']) !!}
							<span class="text-danger">{{ $errors->first('city_id') }}</span>
						</div>
					</div>

					<div class="control-group {{ $errors->has('cat_id[]') ? 'has-error' : '' }}">
                        {!! Form::label('time_list', 'Time List :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('time_list[]', $time, old('time_list[]'), ['class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                            <span class="text-danger">{{ $errors->first('time_list[]') }}</span>           
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('delivery_charge') ? 'has-error' : '' }}">
						{!! Form::label('delivery_charge', 'Delivery Charge', array('class' => 'control-label')) !!}						
						<div class="controls">
						  {!! Form::text('delivery_charge', old('delivery_charge'), ['class'=>'input-xlarge', 'placeholder'=>'0']) !!}
						  <span class="text-danger">{{ $errors->first('delivery_charge') }}</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Checkboxes</label>
						<div class="controls">
							<label class="radio inline"><input type="radio" name="status" value="1"> Active </label>
							<label class="radio inline"><input type="radio" name="status"  value="0"> Inactive </label>
						</div>
					</div> 
					<div class="form-actions">
					  <button type="submit" class="btn btn-primary">Add Now</button>
					  <button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
	</div><!--/span-->
</div><!--/row-->
@endsection