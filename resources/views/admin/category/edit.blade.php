@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="{{ route('admin.dashboard') }}">Home</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="{{ route('admin.category') }}">Category</a>
		<i class="icon-angle-right"></i> 
	</li>
	<li>
		<a href="">Edit Category</a>
	</li>
</ul>
	
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span>Edit Category Item</h2>
			<div class="box-icon">
				<a href="{{ route('admin.category') }}" title="Add New Categories" class="btn-add-new"><i class="icon-tasks"></i> All Categories</a>
			</div>
		</div>
		<div class="box-content">
			{!! Form::open(['route'=>['admin.edit-category.update', $category->id], 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal']) !!}
			
				<fieldset>
					<div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
						{!! Form::label('title', 'Cagetory Name/Title', array('class' => 'control-label')) !!}						
						<div class="controls">
						  {!! Form::text('title', $category->title, ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
						  <span class="text-danger">{{ $errors->first('title') }}</span>
						</div>
					</div>

					<div class="control-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">						
						{!! Form::label('category', 'Parent Category:', array('class' => 'control-label')) !!}
						<div class="controls">
							{!! Form::select('parent_id',$allCategories, $category->parent_id, ['class'=>'form-control', 'data-rel'=>'chosen', 'placeholder'=>'Select Category']) !!}
							<span class="text-danger">{{ $errors->first('parent_id') }}</span>							
						</div>
					</div>					
					<div class="control-group {{ $errors->has('image') ? 'has-error' : '' }}">
						{!! Form::label('image', 'Category Images:', array('class' => 'control-label')) !!}
						<div class="controls">
							<div class="float-left">
							{!! Form::file('image', old('image'), ['class'=>'input-file uniform_on', 'id'=>'fileInput', 'placeholder'=>'Select File']) !!}
							</div>
						<div class="old-cat-img">
					  		<img src="{{URL::to('images/' . $category->image)}}" alt="{{$category->title }}" width="30">
					  	</div>	
					  	<span class="text-danger">{{ $errors->first('image') }}</span>
					  	<input type="hidden" name="oldfile" value="{{$category->image}}">
					  </div>					  				  
					</div>
					<div class="control-group {{ $errors->has('position') ? 'has-error' : '' }}">
						{!! Form::label('position', 'Position', array('class' => 'control-label')) !!}						
						<div class="controls">
						  {!! Form::number('position', $category->position, ['class'=>'input-xlarge', 'placeholder'=>'Enter Display Position']) !!}
						  <span class="text-danger">{{ $errors->first('position') }}</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Status</label>
						<div class="controls">
							<label class="radio inline"><input type="radio" name="status" value="1"
								@if($category->status == 1)
							        checked
							    @endif
							 > Active </label>
							<label class="radio inline"><input type="radio" name="status"  value="0"
								@if($category->status == 0)
							        checked
							    @endif
							> Inactive </label>
						</div>
					</div> 
					<div class="form-actions">
					  <button type="submit" class="btn btn-primary">Update Now</button>
					  <button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			</form> 
		</div>
	</div><!--/span-->
</div><!--/row-->
@endsection