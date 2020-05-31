@extends('adminlte::page')
@section('title','Orders History')
@section('content_header')
  <h1>My Orders History</h1>
@endsection
@section('content')
<input class="form-control mb-4 " id="history_ordersTable" type="text"
      placeholder="Type something to search list items">
  
  <table class="table history_ordersTable">
    <thead>
      <th>#</th>
      <th class="pl-3">Total Price</th>
      <th>Address</th>
      <th>Created At</th>
      <th>State</th>
      <th class="pl-4">Actions</th>
    </thead>
    <tbody id="history_ordersTable">
      @foreach ($orders_history as $index => $order)
        <tr>
          <td>{{ $index+1 }}</td>
          <td class="pl-5"><b>{{ $order->total_price }}<i class="fas fa-pound-sign"></i></b></td>
          <td>{{ $order->address }}</td>
          <td>{{ $order->created_at }}</td>
          <td>{{ $order->state }}</td>
          <td>
              <form action="{!! route('order.delete',$order->id) !!}" method="post" delete="delete{{$order->id}}" class="delete{{$order->id}}">
                  @csrf
                  <a href="{!! route('order.show',$order->id) !!}" method="post" class="btn btn-success btn-sm">Show</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
  $("#history_ordersTable").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#history_ordersTable tr").filter(function() {
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