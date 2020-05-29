@extends('adminlte::page')
@section('title','Edit Profile')
@section('content_header')
@include('error')
  <h1><i class="fas fa-user-edit text-info"></i> Edit Delivery</h1>
@endsection
@section('content')
 
<form class="col-md-6" action="{!!route('delivery.update')!!}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
      @if($delivery->image !=asset('images/delivery/') )
        <i class="fas fa-image"></i>
        <label class="col-sm-5 col-form-label text-info" >Image</label>
    <div> <a href="{{$delivery->image}}"><img src="{{$delivery->image}}" alt="delivery image" height="120" width="200" style="border-radius:50% " value="{{$delivery->image}}"></a></div>
      @endif
      <div class="form-group mt-2">
        <i class="fas fa-signature text-info"></i>
        <label>Name</label>
          <input type="text" class="form-control" name="name" value="{{ $delivery->name }}">
      </div>
      <div class="form-group">
        <i class="fas fa-envelope text-info"></i>
        <label>Salary </label>
        <input type="number" name="salary" class="form-control" value="{{ $delivery->salary }}">
      </div>
      <div class="form-group">
        <i class="fas fa-image text-info"></i>
        <label> Imgae: </label>
        <input type="file" name="image" value="{{old('image')}}">
      <input type="hidden" name="id" value="{{$delivery->id}}">
      </div>
      <div class="form-group mt-4 text-info ">
        <button type="submit" style="width:40%" class="btn btn-primary" ><i class="fas fa-edit fa-sm"></i> Update</button>
      </div>
  </form>
@endsection
