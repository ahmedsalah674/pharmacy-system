@extends('adminlte::page')
@section('title','Add Product')
@section('content_header')
  <h1><i class="fas fa-plus-circle text-info"></i> Add New Product</h1>
@endsection
@section('content')
@include('error')
  <form class="col-md-6" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="form-group">
        <label><i class="fas fa-signature text-info"></i> Name</label>
          <input type="text" class="form-control" name="name" value="{{ old('name') }}">
      </div>
      <div class="form-group">
        <label><i class="fas fa-money-bill-alt text-info"></i> price</label>
        <input type="number" name="price" class="form-control" value="{{ old('price') }}">
      </div>
      <div class="form-group">
        <label><i class="fas fa-calendar-check text-info"></i> Expiration Date</label>
      <input type="date" name="expiration" id="datepicker" class="datepicker form-control" value="{{ old('expiration') }}" min="{{Carbon\Carbon::now()->format('Y-m-d')}}">
      </div>
      <div class="form-group">
        <label><i class="fas fa-cubes text-info"></i> Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control" min="1">
      </div>
      <div class="form-group ">
        <label><i class="fas fa-money-bill-wave text-info"></i> Discount</label>
        <input type="number" name="discount" class="form-control" value="{{old('discount')}}" max="100">
      </div>
      <div class="form-group">
        <label><i class="fas fa-image text-info"></i> Image</label>
        <input type="file" name="image" value="{{old('image')}}">
      </div>
      <div class="form-group ml-5">
        <button type="submit" class="btn btn-primary col-md-6 "><i class="fas fa-plus-circle"></i> Add Product</button>
      </div>
  </form>
@endsection

@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
  <style>
    [type="date"]::-webkit-calendar-picker-indicator {
      display: none;}
  </style>
@endsection
@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script>$( ".datepicker" ).datepicker({format: 'yyyy-mm-dd',});</script>
@endsection