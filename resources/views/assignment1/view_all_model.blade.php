@extends('welcome')
@section('admin')

                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <!-- Add Model modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-model">Add Model</button>
                                    	
                                        </ol>
                                    </div>
											 <h4 class="page-title">All Models</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif                                       
        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Model Name</th>
                    <th>Items Count</th>
                    <th>Action</th>
                </tr>
            </thead>
        
        
            <tbody>
            	@foreach($modelData as $key => $item )
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->items_count }}</td>
                    <td>
<button type="button" class="btn btn-primary passingID"  data-bs-toggle="modal" data-bs-target="#edit-model" data-id="{{$item->id}}" data-name="{{$item->name}}" data-brand="{{$item->brand_id}}">Edit Model</button>                                                    	<a href="{{ route('delete.modelsection', $item->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete">Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach    
                                            </tbody>
                                        </table>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

                        
                    </div> <!-- container -->

                </div> <!-- content -->


<!--_______________________________________________________________________-->

                                        <!-- Signup modal content -->
<div id="add-model" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <form class="px-3" method="post" action="{{ route('modelsection.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="modelname" class="form-label">Model Name</label>
                        <input class="form-control @error('modelname') is-invalid @enderror" type="text" id="modelname" name="modelname" required="" placeholder="Product model">
                    </div>
@php
   $brandData = \App\Models\Brand::latest()->get();
@endphp
                        <div class="form-group mb-3">
                         <label for="brand" class="form-label">Brand</label>                                    
                            <select class="form-select @error('brandid') is-invalid @enderror"  id="brandid" name="brandid">
                                <option selected disabled>Select Brand</option>
                            @foreach($brandData as  $item)    
                                <option value="{{$item->id}}" {{old('brand')==$item->id ? 'selected' : ''}}>{{$item->name}}</option>
                            @endforeach  
                            </select>    



                            
                        </div>



                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="edit-model" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <form class="px-3" method="post" action="{{ route('modelsection.update') }}">
                    @csrf

                    <input type="hidden" class="form-label" id="modelid" name="modelid">
                    <div class="mb-3">
                        <label for="modelname" class="form-label">Edit Model Name</label>
                        <input class="form-control" type="text" id="datamodelname" name="datamodelname" required placeholder="Product Model" value=""/>
                    </div>

@php
   $brandData = \App\Models\Brand::latest()->get();
@endphp
                        <div class="form-group mb-3">
                         <label for="brand" class="form-label">Brand</label>                                    
                            <select class="form-select @error('brandid') is-invalid @enderror"  id="brandid" name="brandid">
                                <option selected disabled>Select Brand</option>
                            @foreach($brandData as  $item)    
                                <option value="{{$item->id}}" id="option{{$item->id}}" {{old('brand')==$item->id ? 'selected' : ''}} >{{$item->name}}</option>
                            @endforeach  
                            </select>    



                            
                        </div>


                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--_____________________________________________________________________-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--Script function is use to keep edited id and transfer it to modal body and then from modal body to controller-->
<script type="text/javascript">
    
    $(".passingID").click(function () {
    var ids = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var brandid = $(this).attr('data-brand');
    $("#modelid").val( ids );
    $("#datamodelname").val( name);
    document.getElementById("option"+brandid).selected = true;   console.log(ids);//Select edited model brand
    console.log(name);
    console.log(brandid);
    $('#edit-model').modal('show');
});

</script>

@endsection