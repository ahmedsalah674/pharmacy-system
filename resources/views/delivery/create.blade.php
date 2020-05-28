@extends('adminlte::page')
@section('title','Add Delivery')
@section('content_header')
  <h1><i class="fas fa-truck text-info"></i> Add New Delivery</h1>
@endsection
@section('content')
@include('error')
  <form class="col-md-6" action="{{ route('delivery.store') }}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="form-group">
        <label><i class="fas fa-signature text-info"></i> Name</label>
          <input type="text" class="form-control" name="name" value="{{ old('name') }}">
      </div>
      <div class="form-group">
        <label><i class="far fa-money-bill-alt text-info "></i> Salary</label>
        <input type="number" name="salary" class="form-control" value="{{ old('salary') }}">
      </div>
      
      <div class="form-group">
        <label><i class="far fa-image text-info"></i> Image: </label>
        <input type="file" name="image" value="{{old('image')}}">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary w-100 ">ADD</button>
      </div>
  </form>
@endsection
