@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="{{ route('admin.dashboard') }}">Home</a>
        <i class="icon-angle-right"></i> 
    </li>
    <li>
        <a href="{{ route('admin.products')}}">Products</a>
        <i class="icon-angle-right"></i> 
    </li>
    <li>
        <a href="">Add New Product</a>
    </li>
</ul>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Add New Product</h2>
            <div class="box-icon">
                <a href="{{ route('admin.products')}}" title="Add New Products" class="btn-add-new"><i class="icon-tasks"></i> All Products</a>
            </div>
        </div>
        <div class="box-content">
            
            {{-- @include('flash-message') --}}

            {!! Form::open(['route'=>'admin.add-products.submit', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal']) !!}

                <fieldset>
                    <div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Products Name/Title :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('title', old('title'), ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
                          <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('regular_price') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Regular Price :', array('class' => 'control-label')) !!}                        
                        <div class="controls">
                          {!! Form::text('regular_price', old('regular_price'), ['class'=>'input-xlarge', 'placeholder'=>'Enter regular price']) !!}
                          <span class="text-danger">{{ $errors->first('regular_price') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Sales Price :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('sale_price', old('sale_price'), ['class'=>'input-xlarge', 'placeholder'=>'Sales Price']) !!}
                          <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('price_unit') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Unit :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('price_unit', old('price_unit'), ['class'=>'input-xlarge', 'placeholder'=>'Unit']) !!}
                          <span class="text-danger">{{ $errors->first('price_unit') }}</span>
                        </div>
                    </div>
                    
                    <div class="control-group {{ $errors->has('cat_id[]') ? 'has-error' : '' }}">
                        {!! Form::label('category', 'Category :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('cat_id[]', $allCategories, old('cat_id[]'), ['class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                            <span class="text-danger">{{ $errors->first('cat_id[]') }}</span>           
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('city_id[]') ? 'has-error' : '' }}">
                        {!! Form::label('city', 'City :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('city_id[]', $allCities, old('city_id[]'), ['class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                            <span class="text-danger">{{ $errors->first('city_id[]') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                        {!! Form::label('detail', 'Description :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::textarea('detail', old('detail'), ['class'=>'cleditor', 'placeholder'=>'Enter Description',  'rows'=>3]) !!}
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        {!! Form::label('image', 'Feature Images :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left">
                            {!! Form::file('image', old('image'), ['class'=>'input-file uniform_on', 'id'=>'fileInput', 'placeholder'=>'Select File']) !!}
                            </div>  
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                      </div>                                      
                    </div>

                    <div class="control-group {{ $errors->has('photos') ? 'has-error' : '' }}">
                        {!! Form::label('Gallery Images', 'Gallery Images :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left">
                                <input type="file" class="input-file" name="photos[]" multiple />
                            </div>  
                        <span class="text-danger">{{ $errors->first('photos[]') }}</span>
                      </div>                                      
                    </div>

                    <div class="control-group">
                        <label class="control-label">Is Home</label>
                        <div class="controls">
                            <label class="radio inline"><input type="checkbox" name="is_home" value="1"> Yes </label>
                        </div>
                    </div> 

                    <div class="control-group">
                        <label class="control-label">Status :</label>
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
