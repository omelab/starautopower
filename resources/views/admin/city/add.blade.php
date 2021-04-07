@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="{{ route('admin.dashboard') }}">Home</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="{{ route('admin.area')}}">City</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="">Add New City</a>
	</li>
</ul>

<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Add New City</h2>
			<div class="box-icon">
				<a href="{{ route('admin.city')}}" title="Add New City" class="btn-add-new"><i class="icon-tasks"></i> All City</a>
			</div>
		</div>
		<div class="box-content">
			
			{{-- @include('flash-message') --}}

			{!! Form::open(['route'=>'admin.add-city.submit', 'class'=>'form-horizontal']) !!}
				<fieldset>
					<div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
						{!! Form::label('title', 'City Name/Title', array('class' => 'control-label')) !!}						
						<div class="controls">
						  {!! Form::text('title', old('title'), ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
						  <span class="text-danger">{{ $errors->first('title') }}</span>
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