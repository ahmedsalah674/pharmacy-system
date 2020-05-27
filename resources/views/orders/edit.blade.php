@extends('adminlte::page')
@section('title','Edit Order')
@section('content_header')
  <h1> Edit Order</h1>
@endsection
@section('content')
@include('error')
  <form class="col-md-6" action="{!! route('order.update',$order->id) !!}"  method="post">
    @csrf
    <div class="form-group">
      <select class="form-control select2 " id="item_picker">
        <option disabled selected >Select Item</option>
        @foreach ($items as $item)
          <option value="{{ $item->id }}" price="{{ $item->price }}" quantity="{{ $item->quantity }}" image="{{ $item->image }}">{{ $item->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <table class="table table-hover">
        <thead id="container_header" >
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Image</th>
          <th>Remove</th>
         
        </thead>
        <tbody id="items_container">
          @foreach ($products as $product)
            <tr id="row{{$product->item->id}}" class="rowjs">
              <td class="pt-5">{{ $product->item->name }}</td>
              <td class="pt-5">{{ $product->item->price }}</td>
              <td class="w-25"><input type="number" name="quantity[]" value="{{ $product->quantity }}" class=" form-control text-center mt-4" min="1"></td>
              <td><img src="{{ $product->item->image }}" alt="Product Image" height="100" width="100"></td>
              <td hidden><input type="hidden" name="id[]" value="{{ $product->item->id }}" min="1"></td>
              <td hidden><input type="hidden" name="item_order->{{ $product->id }}" value="{{ $product->id }}" min="1"></td>
              <td><button type="button" class="btn btn-danger btn-sm rounded-pill ml-3 mt-4 " id="remove{{ $product->id }}"><i class="fas fa-times"></i></button></td>
              
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if (Auth::user()->role == 0)
      <div class="form-group dia">
        <select class="form-control" id="delivery" name="delivery_name" required>
          <option selected disabled >Select Delivery</option>
          @foreach ($deliveries as $delivery)
            <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>
          @endforeach
        </select>
      </div>
    @endif
    <div class="form-group">
      <label>Adress</label>
      <input type="text" name="address" class="form-control"value="{{$order->address}}">
    </div>
    
    <button type="submit" class="btn btn-primary mb-5 ml-5 w-75 " id="submit" >Submit</button>
  </form>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" /> 
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
  <script>
    $(".select2,#delivery").select2({theme:"classic"});
    var items = $("#items_container").find('tr').length;
    console.log("when we start "+items); 
    $(".rowjs").hover(function()  {
      var ids =$(this).find('td').children('input').last().val();;
      $("#remove"+ids).click(function(){

              
              document.getElementById("item_picker").selectedIndex = 0;
              $(this).parent('td').parent('tr').remove();
              items=$("#items_container").find('tr').length;
              console.log("hover and click "+items);
              if(items == 0)
              $("#container_header").hide();
          });
          });
      $("#items_container").ready(function()  {
      $("#item_picker").change(function(){
     
        $("#container_header").show();
        var price = $(this).find(":selected").attr('price');
        var quantity = $(this).find(':selected').attr('price');
        var name = $(this).find(":selected").text();
        var id = $(this).val();
        var image = $(this).find(':selected').attr('image');
        if(!$("#row"+id).length){
          $("#items_container").append(`
            <tr id="row`+id+`">
            <td class="pt-5">`+name+`</td>
            <td class="pt-5">`+price+`</td>
            <td class="w-25"><input type="number" name="quantity[]" value="1" class=" form-control text-center mt-4" min="1"></td>
            <td><img src="`+image+`" alt="Product Image" height="100" width="100"></td>
            // <td hidden><input type="hidden" name="price[]" value="`+price+`"></td>
            <td hidden><input type="hidden" name="id[]" value="`+id+`" min="1"></td>
            <td><button type="button" class="btn btn-danger btn-sm rounded-pill ml-3 mt-4 " id="remove`+id+`"><i class="fas fa-times"></i></button></td>
            </tr>
            `);
        }
            $("#remove"+id).on('click',function(){     
              $("#row"+id).remove();
              document.getElementById("item_picker").selectedIndex = 0;
              items=$("#items_container").find('tr').length;
              console.log("lower remove "+items);
              if(items == 0)
                $("#container_header").hide();
            });
      });
    });
  </script>
@endsection
