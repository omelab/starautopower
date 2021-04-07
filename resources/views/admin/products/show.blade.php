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
        <a href="">Product Details</a>
    </li>
</ul>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Products Details</h2>
            <div class="box-icon">
                <a href="{{ route('admin.products')}}" title="Add New Products" class="btn-add-new"><i class="icon-tasks"></i> All Products</a>
            </div>
        </div>
        <div class="box-content">
            <div class="form-horizontal">
                <div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {!! Form::label('title', 'Products Name/Title', array('class' => 'control-label')) !!}                      
                    <div class="controls">
                      {!! Form::text('title', $product->title, ['disabled'=>true, 'class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
                      <span class="text-danger">{{ $errors->first('title') }}</span>
                    </div>
                </div>
                <div class="control-group {{ $errors->has('regular_price') ? 'has-error' : '' }}">
                    {!! Form::label('title', 'Regular Price :', array('class' => 'control-label')) !!}                        
                    <div class="controls">
                      {!! Form::text('regular_price', $product->regular_price, ['disabled'=>true,'class'=>'input-xlarge', 'placeholder'=>'Enter regular price']) !!}
                      <span class="text-danger">{{ $errors->first('regular_price') }}</span>
                    </div>
                </div>

                <div class="control-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                    {!! Form::label('title', 'Sales Price :', array('class' => 'control-label')) !!}                      
                    <div class="controls">
                      {!! Form::text('sale_price', $product->sale_price, ['disabled'=>true,'class'=>'input-xlarge', 'placeholder'=>'Sales Price']) !!}
                      <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                    </div>
                </div>

                <div class="control-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                    {!! Form::label('title', 'Unit :', array('class' => 'control-label')) !!}                      
                    <div class="controls">
                      {!! Form::text('price_unit', $product->price_unit, ['disabled'=>true,'class'=>'input-xlarge', 'placeholder'=>'Sales Price']) !!}
                      <span class="text-danger">{{ $errors->first('price_unit') }}</span>
                    </div>
                </div>

                <div class="control-group {{ $errors->has('cat_id[]') ? 'has-error' : '' }}">
                    {!! Form::label('category', 'Category :', array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('cat_id[]', $allCategories, $product->categories, ['disabled'=>true,'class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                        <span class="text-danger">{{ $errors->first('cat_id[]') }}</span>           
                    </div>
                </div>

                <div class="control-group {{ $errors->has('city_id[]') ? 'has-error' : '' }}">
                    {!! Form::label('city', 'City :', array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('city_id[]', $allCities, $product->cities, ['disabled'=>true,'class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                        <span class="text-danger">{{ $errors->first('city_id[]') }}</span>
                    </div>
                </div>
                

                <div class="control-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                    {!! Form::label('detail', 'Description:', array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::textarea('detail', $product->detail, ['disabled'=>true,'class'=>'cleditor', 'placeholder'=>'Enter Description',  'rows'=>3]) !!}
                    </div>
                </div>

                
                <div class="control-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    {!! Form::label('image', 'Product Images:', array('class' => 'control-label')) !!}
                    <div class="controls">
                    <div class="old-cat-img">
                        <img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}" width="50">
                    </div>  
                  </div>                                      
                </div>

                <div class="control-group">
                    <label class="control-label">Status</label>
                    <div class="controls">
                        <label class="radio inline"><input type="radio" disabled="" name="status" value="1"
                            @if($product->status == 1)
                                checked
                            @endif> Active </label>
                        <label class="radio inline"><input type="radio" disabled="" name="status"  value="0" @if($product->status == 0)
                                checked
                            @endif> Inactive </label>
                    </div>
                </div> 
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->
@endsection