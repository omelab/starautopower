@extends('layouts.admin-app')
@section('content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="{{ route('admin.list') }}">Admin Users</a> <i class="icon-angle-right"></i></li>
        <li><a href="#"> Add New Item</a></li>
    </ul>
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>All Admin Users</h2>
                <div class="box-icon">
                    <a href="{{ route('admin.list') }}" title="Add New Item" class="btn-add-new"><i class="icon-pencil"></i> Admin Users</a>
                </div>
            </div>
            <div class="box-content">
                {!! Form::open(['route'=>'admin.store-users', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal']) !!} 
                <fieldset>

                    <div class="control-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Name :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('name', old('name'), ['class'=>'input-xlarge', 'placeholder'=>'Enter Name']) !!}
                          <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>


                    <div class="control-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('email', old('email'), ['class'=>'input-xlarge', 'placeholder'=>'info@yourmail.com']) !!}
                          <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Password :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left"> 
                            {!! Form::password('password', old('password'), ['class'=>'input-xlarge', 'placeholder'=>'Enter Password']) !!}
                            </div>  
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                      </div>                                      
                    </div> 

                    <div class="control-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        {!! Form::label('password_confirmation', 'Confirm Password :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left">
                            {!! Form::password('password_confirmation', old('password_confirmation'), ['class'=>'input-xlarge', 'placeholder'=>'Password Confirmation']) !!}
                            </div>  
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
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