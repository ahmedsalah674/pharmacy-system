@extends('adminlte::page')
@section('title','My Orders')
@section('content_header')
  <h1>My Orders</h1>
@endsection
@section('content')
<input class="form-control mb-4 " id="myOrdersTable" type="text"
      placeholder="Type something to search list items">
  
  <table class="table myOrdersTable">
    <thead>
      <th>#</th>
      <th>Total Price</th>
      <th>Address</th>
      <th>Created At</th>
      <th>State</th>
      <th>Actions</th>
    </thead>
    <tbody class="myOrdersTable">
      @foreach ($myOrders as $index => $order)
        <tr>
          <td>{{ $index+1 }}</td>
          <td class="pl-5">{{ $order->total_price }}</td>
          <td>{{ $order->address }}</td>
          <td>{{ $order->created_at }}</td>
          <td>{{ $order->state }}</td>
          <td>
            <form  action="{!! route('order.delete',$order->id) !!}" method="post" delete="delete{{$order->id}}" class="delete{{$order->id}}">
              <a href="{!! route('order.show',$order->id) !!}" class="btn btn-success btn-sm">Show</a>
              <a href="{!! route('order.edit',$order->id) !!}" class="btn btn-primary btn-sm">Edit</a>
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
  $("#myOrdersTable").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myOrdersTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>
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