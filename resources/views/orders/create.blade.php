@extends('adminlte::page')
@section('title','Create New Order')
@section('content_header')
  <h1>Create New Order</h1>
@endsection
@section('content')
@include('error')
  <form class="col-md-7" action="{!! route('order.store') !!}" method="post">
    @csrf
    <div class="form-group " >
      <select class="form-control select2 " id="item_picker">
        <option disabled selected >Select Item</option>
        @foreach ($products as $product)
          <option value="{{ $product->id }}" price="{{ $product->price }}"  discount="{{ $product->discount }}" quantity="{{ $product->quantity }}" image="{{ $product->image }}">{{ $product->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <table class="table table-hover">
        <thead id="container_header" style="display:none;">
          <th>Name</th>
          <th>Price</th>
          <th>Discount</th>
          <th class="text-center">Quantity</th>
          <th>Image</th>
          <th>Remove</th>
        </thead>
        <tbody id="items_container">
        </tbody>
      </table>
    </div>
    @if (Auth::user()->role == 0)
    <div class="form-group">
      <select class="form-control select2 " name="delivery_id"  >
        <option selected disabled>Select Delivery</option>
        @foreach ($deliveries as $delivery)
          <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>
        @endforeach
      </select>
    </div>
  @endif
    <div class="form-group">
      <label>Adress</label>
      <input type="text" name="address" class="form-control" @if(isset($address) && Auth::user()->role > 0) value="{{$address->address}}" @endif>
    </div>
    <button type="submit" class="btn btn-primary w-75 ml-5">Submit</button>
  </form>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function(){
      var items = 0;
      $("#item_picker").change(function(){
        items++;
        console.log(`ITEM AFTER ++ `+items);
        $("#container_header").show();
        var price = $(this).find(":selected").attr('price');
        var discount = $(this).find(":selected").attr('discount');
        var quantity = $(this).find(':selected').attr('price');
        var name = $(this).find(":selected").text();
        var id = $(this).val();
        var image = $(this).find(':selected').attr('image');
        if(!$("#row"+id).length){
          $("#items_container").append(`
            <tr id="row`+id+`">
            <td>`+name+`</td>
            <td>`+price+`</td>
            <td>`+discount+`%</td>
            <td><input type="number" name="quantity[]" value="1" class="col-md-6 form-control text-center mt-2 mx-auto" min="1"></td>
            <td><img src="`+image+`" alt="Product Image" height="100" width="100"></td>
            <td hidden><input type="hidden" name="id[]" value="`+id+`" min="1"></td>
            <td hidden><input type="hidden" name="price[]" value="`+price+`"></td>
            <td hidden><input type="hidden" name="discount[]" value="`+discount+`"></td>
            <td><button type="button" class="btn btn-danger btn-sm rounded-pill ml-3" id="remove`+id+`"><i class="fas fa-times"></i></button></td>
            </tr>
            `);
        }
            
            console.log(items);
            $("#remove"+id).on('click',function(){
              items--;
              console.log(items);
              $("#row"+id).remove();
              document.getElementById("item_picker").selectedIndex = 0;
              console.log(items);
              if(items == 0){
                $("#container_header").hide();
              }
            });
      });
    });
  </script>
   <script>
    // Filter table
    $(document).ready(function(){
      $("#ordersTable").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".ordersTable option").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script>
    
    <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
@endsection
