@extends('adminlte::page')
@section('title','Order Details')
@section('content_header')
  <h1 class="text-info"><i class="fas fa-shopping-bag"></i> Order Details</h1>
@endsection
@section('content')
@include('error')
<table class="table table-hover">
    <tbody>
      <tr>
        @if($order->delivery)
          <td><b><i class="fas fa-signature text-info"></i> Delivery Name:</b> {{ $order->delivery->name }}</td>
        @else 
          <td><b><i class="fas fa-signature text-info"></i> Delivery Name:</b><span class="text-danger"> No dellivery avaluble</span></td>
        @endif
        <td><b><i class="fas fa-map-marker-alt text-info"></i> Address:</b> {{ $order->address }}</td>
        <td><b><i class="fas fa-calendar-alt text-info"></i> Date:</b> {{ $order->created_at }}</td>
      </tr>
    </tbody>  
</table>
    <label class="text-lg text-center col-md-10 text-info"><i class="fas fa-sitemap"></i> Items</label>
<table class="table ">
    <thead class="bg-dark">
      <th>Name</th>
      <th>Qunatity</th>
      <th >Discount</th>
      <th>Image</th>
      <th >Price</th>
    </thead>
     <tbody>
      @foreach ($items_order as  $item_order)
        <tr>
          <td><b> {{ $item_order->item->name }}</b></td>
          <td class="pl-5"><b>{{ $item_order->quantity }}</b></td>
          <td class="pl-4"><b>{{ $item_order->item->discount}}%</b></td>
          <td><img src="{{ $item_order->item->image}}" alt="" height="100" width="100"></th>
          <td><b>{{ $item_order->item->price }} <i class="fas fa-pound-sign"></i></b> </td>
        </tr>
      @endforeach
    </tbody> 
    <tfooter >   
          <tr>  
            <td></td>
            <td></td>
            <td></td>
            <td></td> 
            <td class="text-secondary"><b>total: {{ $order->total_price}}<i class="fas fa-pound-sign"></i></b></td>
          </tr>
    </tfooter> 
  </table>
@endsection