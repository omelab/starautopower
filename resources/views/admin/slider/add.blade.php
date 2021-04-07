@extends('layouts.admin-app')
@section('content')
<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="{{ route('admin.dashboard') }}">Home</a>
        <i class="icon-angle-right"></i> 
    </li>
    <li>
        <a href="{{ route('admin.slider')}}">Slider</a>
        <i class="icon-angle-right"></i> 
    </li>
    <li>
        <a href="">Add New Item</a>
    </li>
</ul>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Add New Item</h2>
            <div class="box-icon">
                <a href="{{ route('admin.slider')}}" title="Add New Products" class="btn-add-new"><i class="icon-tasks"></i> All Slider</a>
            </div>
        </div>
        <div class="box-content">
            
            {{-- @include('flash-message') --}}

            {!! Form::open(['route'=>'admin.add-slider.submit', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal']) !!}

                <fieldset>
                    <div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Title :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('title', old('title'), ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
                          <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        {!! Form::label('image', 'Slider Images :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left">
                            {!! Form::file('image', old('image'), ['class'=>'input-file uniform_on', 'id'=>'fileInput', 'placeholder'=>'Select File']) !!}
                            </div>  
                        <span class="text-danger">{{ $errors->first('image') }}</span>
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
