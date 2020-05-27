@extends('adminlte::page')
@section('title','All Orders')
@section('content_header')
  <h1>All Orders</h1>
@endsection
@section('content')
@include('error')
<input class="form-control mb-4 " id="ordersTable" type="text"
      placeholder="Type something to search list items">
  <table class="table table-haver">
    <thead>
      <th>#</th>
      <th>User Name</th>
      <th>Total Price</th>
      <th>State</th>
      <th>State</th>
      <th>Actions</th>
    </thead>
    <tbody id="ordersTable">
      @foreach ($orders as $index => $order)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $order->user->name }}</td>
          <td>{{ $order->total_price }}</td>
          <td>{{ $order->state }}</td>
          <td>{{ $order->created_at }}</td>
          <td>
            <a href="{!! route('order.show',$order->id) !!}" method="post" class="btn btn-success btn-sm">Show</a>
              <a href="{!!route('order.edit',$order->id)!!}" class="btn btn-primary btn-sm">Edit</a>
              @if ($order->state == "In Progress")
              <form action="{!!route('order.deliver',$order->id)!!}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-warning btn-sm text-white">Deliver</button>
              </form>
              @endif
              @if ($order->state == "On the Way")
              <form action="{!! route('order.finish',$order->id) !!}" method="POST" class="d-inline">
                @csrf
                <button  class="btn btn-warning btn-sm text-white">Finish</button>
              </form>
              @endif
            <form action="{!! route('order.delete',$order->id) !!}" method="post" delete="delete{{$order->id}}" class="delete{{$order->id}} d-inline">
              @csrf
              <input type="hidden" name="id" value="{{ $order->id }}">
              <button type="button" class="btn-danger btn delete btn-sm">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
@section('js')
<script>
  $(document).ready(function(){
    $("#ordersTable").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#ordersTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script >
  $(document).on('click', '.delete',function(e){
    {{-- you have to add class="delete{{object->id}}" and delete="delete={{object->id}}" to your form and add class ="delete" to the submit butoon--}}
    e.preventDefault();
    var id = $(this).parent().attr('delete');
    var url = ($(this).attr('href'));
      swal({
        title: "Are you sure you want to delete?",
        icon: "warning",
        buttons: ["Cancel","Delete"],
        dangerMode: true
      }).then((willDelete) => {
        if(willDelete) {
          $("."+id).submit();
        }
      })
  });
  </script>
@endsection