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
                                            <!-- Add brand modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-brand">Add Brand</button>
                                    	
                                        </ol>
                                    </div>
											 <h4 class="page-title">All Brands</h4>
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
                    <th>Brand Name</th>
                    <th>Model Count</th>
                    <th>Items Count</th>
                    <th>Action</th>
                </tr>
            </thead>
        
        
            <tbody>
            	@foreach($brandData as $key => $item )
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->model_count }}</td>
                    <td>{{$item->items_count}}</td>
                    <td>
<button type="button" class="btn btn-primary passingID"  data-bs-toggle="modal" data-bs-target="#edit-brand" data-id="{{$item->id}}" data-name="{{$item->name}}">Edit Brand</button>                                                    	<a href="{{ route('delete.brand', $item->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete">Delete</a>
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
<div id="add-brand" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <form class="px-3" method="post" action="{{ route('brand.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="brandname" class="form-label">Brand Name</label>
                        <input class="form-control @error('brandname') is-invalid @enderror" type="text" id="brandname" name="brandname" required="" placeholder="Product Brand">
                    </div>


                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="edit-brand" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <form class="px-3" method="post" action="{{ route('brand.update') }}">
                    @csrf

                    <input type="hidden" class="form-label" id="brandid" name="brandid">
                    <div class="mb-3">
                        <label for="brandname" class="form-label">Edit Brand Name</label>
                        <input class="form-control @error('brandname') is-invalid @enderror" type="text" id="databrandname" name="databrandname" required placeholder="Product Brand" value=""/>
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
    $("#brandid").val( ids );
    $("#databrandname").val( name);
    $('#edit-brand').modal('show');
});

</script>

<script type="text/javascript">
$('.passingID').on('hide.bs.modal', function(e) {        
   // Submit data to server and in success callback write if to validate whether form data is valid or not . 
    if(invalidForm) {           
            e.preventDefault();
    }
});</script>

@endsection