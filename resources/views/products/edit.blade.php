@extends('adminlte::page')
@section('title','Update Product')
@section('content_header')
  <h1>Update Product</h1>
@endsection
@section('content')
@include('error')
  <form class="col-md-6" action="{{ route('product.update',$product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="form-group">
        <label>Name</label>
          <input type="text" class="form-control" name="name" value="{{ $product->name }}">
      </div>
      <div class="form-group">
        <label>price</label>
        <input type="number" name="price" class="form-control" value="{{ $product->price }}">
      </div>
      <div class="form-group">
        <label>Expiration Date</label>
        <input type="text" name="expiration" class="datepicker form-control" value="{{ $product->expiration_date }}">
      </div>
      <div class="form-group">
        <label>Quantity</label>
        <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Discount</label>
        <input type="number" name="discount" class="form-control" value="{{ $product->discount }}">
      </div>
      <div class="form-group">
        <label>Imgae</label>
        <input type="file" name="image" value="{{ $product->image }}">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
  </form>
@endsection
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>$( ".datepicker" ).datepicker({format: 'yyyy-mm-dd',});</script>
    
@endsection