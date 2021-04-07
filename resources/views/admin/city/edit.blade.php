@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="{{ route('admin.dashboard') }}">Home</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="{{ route('admin.city') }}">City</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="">Edit City</a>
	</li>
</ul>
			
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Edit Category Item</h2>
			<div class="box-icon">
				<a href="{{ route('admin.city') }}" title="Add New Categories" class="btn-add-new"><i class="icon-tasks"></i> All Areas</a>
			</div>
		</div>
		<div class="box-content">
			{{--  @if ($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ $message }}</strong>
			</div>
			@endif --}}
				
			{!! Form::open(['route'=>['admin.edit-city.update', $city->id], 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal']) !!}
			
				<fieldset>
					<div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
						{!! Form::label('title', 'City Name/Title', array('class' => 'control-label')) !!}						
						<div class="controls">
						  {!! Form::text('title', $city->title, ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
						  <span class="text-danger">{{ $errors->first('title') }}</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Checkboxes</label>
						<div class="controls">
							<label class="radio inline"><input type="radio" name="status" value="1"
								@if($city->status == 1)
							        checked
							    @endif
							 > Active </label>
							<label class="radio inline"><input type="radio" name="status"  value="0"
								@if($city->status == 0)
							        checked
							    @endif
							> Inactive </label>
						</div>
					</div> 
					<div class="form-actions">
					  <button type="submit" class="btn btn-primary">Save changes</button>
					  <button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			</form> 
		</div>
	</div><!--/span-->
</div><!--/row-->
@endsection