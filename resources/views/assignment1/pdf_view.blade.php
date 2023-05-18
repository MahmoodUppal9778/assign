<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
<style>
table, th, td {
    border: 2px solid grey;
    border-collapse: collapse;
}
th {
    padding:9px;
    text-align: left;
    vertical-align: middle;
    font-family: Times New Roman;
    font-size: 20px;
    color: #3a93a6;    
}
td{
    padding:9px;
    text-align: left;
    font-family: Times New Roman;
    font-size: 18px;
    color:#865c1d;        

}
table#table {
    width: 100%;    
    background-color: #4bd5d8  ;
}
header h1 {
  font-size: 40px;
  font-weight: 400;
  background-image: linear-gradient(to left, #553c9a, #b393d3);
  color: #a63a5a;
  background-clip: text;
  -webkit-background-clip: text;
  text-align: center;
}

</style>  
  </head>
  <body>
   <header>
        <h1>Total Items Record</h1>
    </header>   
    <table id="basic-datatable" class="table dt-responsive nowrap w-100 border-bottom: 1px solid Black" align="center">
        <thead>
            <tr>
                <th >Sl</th>
                <th >Item Name</th>
                <th >Amount</th>
                <th >Brand</th>
                <th >Model</th>
            </tr>
        </thead>
    
    
        <tbody>
          @foreach($data as $key => $item )
            <tr >
                <td  >{{ $key+1 }}</td>
                <td  >{{ $item->name}}</td>
                <td  >{{$item->amount}}</td>
                <td  >{{ $item->brand->name}}</td>
                <td >
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
              </tr>
          @endforeach    
      </tbody>
     </table>
  </body>
</html>
