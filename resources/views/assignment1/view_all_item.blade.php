@extends('welcome')
@section('admin')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-item">Add Item</button>
                                            <a class="btn btn-info p-2 mx-2" href="{{ route('item.create.pdf') }}">Export to PDF</a>

                                        </ol>
                                            <!-- Add Model modal -->



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
              <th>Item Name</th>
              <th>Amount</th>
              <th>Brand</th>
              <th>Model</th>
              <th>Action</th>
          </tr>
      </thead>
  
  
      <tbody>
      	@foreach($itemData as $key => $item )
          <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $item->name}}</td>
              <td>{{$item->amount}}</td>
              <td>{{ $item->brand->name}}</td>
              <td>
                @if(!empty($item->model->name))
                
                      {{ $item->model->name}}
                   @php   
                      $varLocal = $item->model_id; 
                   @endphp  
                    @else
                   @php 
                    $varLocal = 0;
                   @endphp   
                      No Medel is Linked

                @endif  
              </td> 
              <td> 
<button type="button" class="btn btn-primary passingID"  data-bs-toggle="modal" data-bs-target="#edit-item" data-id="{{$item->id}}" data-name="{{$item->name}}" data-amount="{{$item->amount}}" data-brand="{{$item->brand_id}}" data-model="{{$varLocal}}" title="Edit"><i class='fa fa-edit'></i></button>                                                    	<a href="{{ route('item.delete', $item->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<div id="add-item" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <form class="px-3" method="post" action="{{ route('item.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="itemname" class="form-label">Item Name</label>
                        <input class="form-control @error('itemname') is-invalid @enderror" type="text" id="itemname" name="itemname" required="" placeholder="Product item">
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input class="form-control @error('amount') is-invalid @enderror" type="text" id="amount" name="amount" required="" placeholder="Amount item">
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
                         <label for="model" class="form-label">Model</label>                                    
                            <select class="form-select @error('model') is-invalid @enderror"  id="modelAdd" name="modelAdd">
                                <option selected disabled>Select Brand First</option>
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

<div id="edit-item" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
              <center><h3>Edit Section</h3></center>
                <form class="px-3" method="post" action="{{ route('item.update') }}">
                    @csrf

                    <input type="hidden" class="form-label" id="edititemid" name="edititemid">
                    <div class="mb-3">
                        <label for="edititemname" class="form-label">Item Name</label>
                        <input class="form-control @error('edititemname') is-invalid @enderror" type="text" id="edititemname" name="edititemname" required="" placeholder="Product item">
                    </div>

                    <div class="mb-3">
                        <label for="editamount" class="form-label">Amount</label>
                        <input class="form-control @error('editamount') is-invalid @enderror" type="text" id="editamount" name="editamount" required="" placeholder="Amount item">
                    </div>

@php
   $brandData = \App\Models\Brand::latest()->get();
@endphp
                        <div class="form-group mb-3">
                         <label for="editbrandid" class="form-label">Brand</label>                                    
                            <select class="form-select @error('editbrandid') is-invalid @enderror"  id="editbrandid" name="editbrandid">
                                <option selected disabled>Select Brand</option>
                            @foreach($brandData as  $item)    
                                <option id="editoption{{$item->id}}" value="{{$item->id}}" {{old('brand')==$item->id ? 'selected' : ''}}>{{$item->name}}</option>
                            @endforeach  
                            </select>    



                            
                        </div>
                         <label for="editmodelAdd" class="form-label">Model</label>                                    
                            <select class="form-select @error('editmodelAdd') is-invalid @enderror"  id="editmodelAdd" name="editmodelAdd">
                                <option id="editmodel0" selected disabled>Select Brand First</option>
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
    var amount = $(this).attr('data-amount');

    var brandid = $(this).attr('data-brand');
    var modelid = $(this).attr('data-model');
    $("#edititemid").val( ids );
    $("#edititemname").val( name );
    $("#editamount").val( amount );
    document.getElementById("editoption"+brandid).selected = true;   console.log(ids);//Select edited model brand
    console.log(name);
    console.log(modelid);

     $('#editmodelAdd').find('option').not(':first').remove();

     var restURL="http://127.0.0.1:8000/particularmodel/item/"+brandid;
//     var urlDummy= {{url('/')}}; 
//     console.log(urlDummy);

     $.ajax({
       type: 'get',
       url: restURL,
       dataType: 'json',
       success: function(response){
        //console.log(response['data']);
         var len = 0;
         if(response['data'] != null){
           len = response['data'].length;
        //console.log(len);
         }
         if(len > 0){
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].id;
             var name = response['data'][i].name;
        //console.log(name);
          if(id==modelid)
          {
              var option = "<option id='editmodel"+id+"' value='"+id+"' selected>"+name+"</option>";            
          }
          else{        
             var option = "<option id='editmodel"+id+"' value='"+id+"' >"+name+"</option>"; 
           }
             $("#editmodelAdd").append(option); 
           }
         }

       }
    });
//    document.getElementById("editmodel20").selected = true;   
//    console.log(document.getElementById("editmodel20"));
//On Change Brand Id => Model Id should be change


      $('#editbrandid').change(function(){

       // Empty the dropdown
//         $('#editmodelAdd').find('option').not(':first').remove();

         var id = $(this).val();
//         alert(id);

         // AJAX request 
         var restURL="http://127.0.0.1:8000/particularmodel/item/"+id; 
         console.log(restURL);
     $('#editmodelAdd').find('option').not(':first').remove();
  
         $.ajax({
           type: 'get',
           url: restURL,
           dataType: 'json',
           success: function(response){
            //console.log(response['data']);
             var len = 0;
             if(response['data'] != null){
               len = response['data'].length;
            //console.log(len);
             }
             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){

                 var id = response['data'][i].id;
                 var name = response['data'][i].name;
            //console.log(name);

                 var option = "<option value='"+id+"' >"+name+"</option>"; 

                 $("#editmodelAdd").append(option); 
               }
             }

           }
        });
      }); 

});

</script>

<!-- Script -->

  <!-- Script -->
    <script type='text/javascript'>


      // Department Change
      $('#brandid').change(function(){

       // Empty the dropdown
         $('#modelAdd').find('option').not(':first').remove();

         var id = $(this).val();
//         alert(id);

         // AJAX request 
         var restURL="http://127.0.0.1:8000/particularmodel/item/"+id; 
         console.log(restURL);
  
         $.ajax({
           type: 'get',
           url: restURL,
           dataType: 'json',
           success: function(response){
            //console.log(response['data']);
             var len = 0;
             if(response['data'] != null){
               len = response['data'].length;
            //console.log(len);
             }
             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){

                 var id = response['data'][i].id;
                 var name = response['data'][i].name;
            //console.log(name);
                 var option = "<option value='"+id+"'>"+name+"</option>"; 

                 $("#modelAdd").append(option); 
               }
             }

           }
        });
  
      });
  
    </script>   
</body>
</html>
@endsection