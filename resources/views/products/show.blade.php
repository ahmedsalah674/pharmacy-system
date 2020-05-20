@extends('adminlte::page')
@section('title','Product Details')
@section('content_header')
  <h1>Product Details:</h1>
@endsection
@section('content')
<table class="table">
  <tbody>
    <tr>
      <img src="{{$product->image}}" alt="" height="320" width="320">
    </tr>
    <tr>
      <td>Product Name: {{ $product->name }}</td>
      <td>Product Price: {{ $product->price }}EGP</td>
    </tr>
    <tr>
      <td>Available Quantity: {{ $product->quantity }}</td>
      <td>Expiration Date: {{ $product->expiration_date }}</td>
    </tr>
    {{-- <tr>
      <td></td>
    </tr> --}}
  </tbody>
</table>
<a href="{!!route('product.edit',$product->id)!!}" class="btn btn-info col-md-6 ml-5">Edit</a>
@endsection
