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
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Edit Products</h2>
            <div class="box-icon">
                <a href="{{ route('admin.products')}}" title="Add New Products" class="btn-add-new"><i class="icon-tasks"></i> All Products</a>
            </div>
        </div>
        <div class="box-content">
            {{-- @include('flash-message') --}}

            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {!! Form::open(['route'=>['admin.edit-products.update', $product->id], 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal']) !!}

                <fieldset>
                    <div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Products Name/Title', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('title', $product->title, ['class'=>'input-xlarge', 'placeholder'=>'Enter Title']) !!}
                          <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('regular_price') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Regular Price :', array('class' => 'control-label')) !!}                        
                        <div class="controls">
                          {!! Form::text('regular_price', $product->regular_price, ['class'=>'input-xlarge', 'placeholder'=>'Enter regular price']) !!}
                          <span class="text-danger">{{ $errors->first('regular_price') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Sales Price :', array('class' => 'control-label')) !!}                      
                        <div class="controls">
                          {!! Form::text('sale_price', $product->sale_price, ['class'=>'input-xlarge', 'placeholder'=>'Sales Price']) !!}
                          <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('cat_id[]') ? 'has-error' : '' }}">
                        {!! Form::label('category', 'Category :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('cat_id[]', $allCategories, $product->categories, ['class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                            <span class="text-danger">{{ $errors->first('cat_id[]') }}</span>           
                        </div>
                    </div>

                    <div class="control-group {{ $errors->has('city_id[]') ? 'has-error' : '' }}">
                        {!! Form::label('city', 'City :', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('city_id[]', $allCities, $product->cities, ['class'=>'form-control', 'multiple' => true, 'data-rel'=>'chosen']) !!}
                            <span class="text-danger">{{ $errors->first('city_id[]') }}</span>
                        </div>
                    </div>
                    

                    <div class="control-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                        {!! Form::label('detail', 'Description:', array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::textarea('detail', $product->detail, ['class'=>'cleditor', 'placeholder'=>'Enter Description',  'rows'=>3]) !!}
                        </div>
                    </div>

                    
                    <div class="control-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        {!! Form::label('image', 'Product Images:', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left">
                            {!! Form::file('image', old('image'), ['class'=>'input-file uniform_on', 'id'=>'fileInput', 'placeholder'=>'Select File']) !!}
                            </div>
                        <div class="old-cat-img">
                            <img src="{{URL::to('images/' . $product->image)}}" alt="{{$product->title }}" width="50">
                        </div>  
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                        <input type="hidden" name="oldfile" value="{{$product->image}}">
                      </div>                                      
                    </div>


                    <div class="control-group {{ $errors->has('photos') ? 'has-error' : '' }}">
                        {!! Form::label('photos', 'Gallery Images:', array('class' => 'control-label')) !!}
                        <div class="controls">
                            <div class="float-left">
                             <input type="file" class="'input-file" name="photos[]" multiple />
                             <span class="text-danger">{{ $errors->first('photos') }}</span>
                            </div>
                            <div id="galleryimg" class="gallery-images">
                               
                                @foreach($product->images as $pimage)
                                    <div class="pro-img">
                                        <a href="javascript:void(0)" onclick="delimg(this)" class="delimg" data-img="{{ $pimage->id }}"><i class="halflings-icon white trash"></i></a>
                                        <img src="{{URL::to('images/' . $pimage->filename)}}" alt="{{$product->title }}" width="70">
                                    </div>  
                                @endforeach
                                                             
                            </div>                        
                      </div>                                      
                    </div>

                    <div class="control-group">
                        <label class="control-label">Is Home</label>
                        <div class="controls">
                            <label class="radio inline"><input type="checkbox" name="is_home" value="1"
                                @if($product->is_home == 1)
                                    checked
                                @endif> Yes </label>
                        </div>
                    </div> 

                    <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls">
                            <label class="radio inline"><input type="radio" name="status" value="1"
                                @if($product->status == 1)
                                    checked
                                @endif> Active </label>
                            <label class="radio inline"><input type="radio" name="status"  value="0" @if($product->status == 0)
                                    checked
                                @endif> Inactive </label>
                        </div>
                    </div>

                    
                    <div class="form-actions editopt">
                      <button type="submit" class="btn btn-primary">Update Now</button>
                      <button type="reset" class="btn">Cancel</button>
                    </div>
                </fieldset>
            {!! Form::close() !!}


            <div class="products-options">
                <h3 class="title">Products Options</h3>
                <div class="options-table-wrap">
                    <table class="options-table">
                        <thead>
                            <tr>
                                <th>SIZE</th>
                                <th>COLOR</th>
                                <th>PRICE</th>
                                <th>SALES PRICE</th>
                                <th>QTY</th>
                                <th>IMAGES</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="resdata">
                            @foreach($product->options as $option)                            
                            <tr>                                        
                                <td>{{ $option->size }}</td>
                                <td>{{ $option->color }}</td>
                                <td>{{ $option->regular_price }}</td>
                                <td>{{ $option->sales_price }}</td>
                                <td>{{ $option->quantity }}</td>
                                <td><img src="{{URL::to('images/' . $option->images)}}" width="70"></td>
                                <td><form action="{{ route('admin.deloptions',$option->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="halflings-icon trash white"></i> Delete</button>
                                </form></td>
                            </tr>
                            @endforeach  
                        </tbody>
                        <tfoot>
                            <tr>                                        
                                <td><input type="text" class="form-control" id="size" name="size"/></td>
                                <td><input type="text" class="form-control" id="color" name="color"/></td>
                                <td><input type="text" class="form-control" id="regular_price" name="regular_price"/></td>
                                <td><input type="text" class="form-control" id="sales_price" name="sales_price"/></td>
                                 <td><input type="text" class="form-control" id="quantity" name="quantity"/></td>
                                <td><input type="file" class="input-file"  id="images" name="images"/></td>
                                <td><input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}" />
                                <button class="btn btn-info" type="button" onclick="addOptions(this); return false;"><i class="halflings-icon add white"></i> Add</button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div> 

        </div>
    </div><!--/span-->
</div><!--/row-->
@endsection

@push('scripts')
    <script type="text/javascript">

        //Add Options
        function addOptions(event){
            var error = '';            
            var form_data = new FormData();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            form_data.append("_token", CSRF_TOKEN);

            var product_id = "{{ $product->id }}";
            form_data.append("product_id", product_id);

            var size = $('#size').val();
            form_data.append("size", size);

            var color = $('#color').val();
            form_data.append("color", color);

            var regular_price = $('#regular_price').val();
            form_data.append("regular_price", regular_price);

            var sales_price = $('#sales_price').val();
            form_data.append("sales_price", sales_price);

            var quantity = $('#quantity').val();
            form_data.append("quantity", quantity);

            var images = $('#images')[0].files;
         
            if(images.length > 0){
                var imgName = images[0].name;
                var extension = imgName.split('.').pop().toLowerCase();
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
                    error += "Invalid  Image File";
                }else{
                    form_data.append("images", images[0]);
                }
            }
            if(error) {
                toastr.error(error);
            }else{
                $.ajax({
                    url:"{{ route('admin.adoptions')}}",
                    method:"POST",
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                        $(event).html("Loading...");
                    },
                    success:function(data){

                        var result = data.options;

                        var output="";

                        $.each(result, function(i){
                            output+='<tr><td>'+ result[i].size +'</td><td>'+ result[i].color +'</td><td>'+ result[i].regular_price +'</td><td>'+ result[i].sales_price +'</td><td>'+ result[i].quantity +'</td><td><img src="{{URL::to('images')}}/'+ result[i].images +'" width="70"></td><td><form action="{{URL::to('options')}}/'+ result[i].id +'" method="POST"> @csrf @method('DELETE') <button class="btn btn-danger"><i class="halflings-icon trash white"></i> Delete</button></form></td></tr>';    
                        });

                        $('#resdata').html(output); 
                    },
                    error: function (request, status, error) {
                        json = $.parseJSON(request.responseText);
                        $.each(json.errors, function(key, value){
                            toastr.error(value);
                        });
                    },
                    complete: function() {
                        $('#size', '#color', '#regular_price', '#sales_price', '#quantity', '#images', '#product_id').val('');
                        $(event).html('<i class="halflings-icon add white"></i> Add');
                    }
                })
            }
        }

        //Delete Options
        function delOption(elem){
            if (confirm("Are you sure to delete this Option?")) {
                var $id = $(elem).data('option');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url:"{{ route('admin.adoptions')}}",
                    method:"POST",
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                        $(event).html("Loading...");
                    },
                    success:function(data){

                        var result = data.options;

                        var output="";

                        $.each(result, function(i){
                            output+='<tr><td>'+ result[i].size +'</td><td>'+ result[i].color +'</td><td>'+ result[i].regular_price +'</td><td>'+ result[i].sales_price +'</td><td>'+ result[i].quantity +'</td><td><img src="{{URL::to('images')}}/'+ result[i].images +'" width="70"></td><td><form action="{{URL::to('options')}}/'+ result[i].id +'" method="POST"> @csrf @method('DELETE') <button class="btn btn-danger"><i class="halflings-icon trash white"></i> Delete</button></form></td></tr>';    
                        });

                        $('#resdata').html(output); 
                    },
                    error: function (request, status, error) {
                        json = $.parseJSON(request.responseText);
                        $.each(json.errors, function(key, value){
                            toastr.error(value);
                        });
                    },
                    complete: function() {
                        $(elem).html('<i class="halflings-icon add white"></i> Add');
                    }
                })
            }
            return false;
        };


        //Delete Gallery Images
        function delimg(elem){
            if (confirm("Are you sure to delete this image?")) {
                var $id = $(elem).data('img');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('admin.delimg')}}',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, imgid:$id},
                    dataType: 'JSON',                    
                    success: function (data) { 
                        //console.log(data.images);

                        var result = data.images;
                        var output="";
                        for (var i in result) {
                            output+='<div class="pro-img"><a href="javascript:void(0)" onclick="delimg(this)" class="delimg" data-img="'+result[i].id+'"><i class="halflings-icon white trash"></i></a><img src="{{URL::to('images/')}}/'+result[i].filename+'" alt="'+result[i].filename+'" width="70"></div>';
                        }
                        $('#galleryimg').html(output);                        
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                        alert("Something wrong please try latar");
                    } 
                }); 
            }
            return false;
        };
    </script>
@endpush
