@extends('adminlte::page')
@section('title','ALl deliveries')
@section('content_header')
  <h1>All deliveries</h1>
@endsection
@section('content')
@include('error')
    <input class="form-control mb-4 " id="deliveriesTable" type="text"
      placeholder="Type something to search list items">
  
    <table class="table table-hover " >
        <thead class="black white-text">
            <th>#</th>
            <th>Name</th>
            <th>Salary</th>
            <th class="text-center">Actions</th>
          </thead>
          <tbody id="deliveriesTable">
            @foreach ($deliveries as $index => $delivery)
              <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $delivery->name }}</td>
                <td><b> {{ $delivery->salary }} EGP</b></td>
                <td>
                  <form action="{!!route('delivery.delete')!!}"  method="post" delete="delete{{$delivery->id}}" class="delete{{$delivery->id}} text-center">
                    @csrf
                    <a href="{!!route('delivery.show',$delivery->id)!!}" method="post" class="btn btn-success btn-sm">Show</a>
                    <a href="{!!route('delivery.edit',$delivery->id)!!}" class="btn btn-primary btn-sm">Edit</a>
                    <input type="hidden" name="id" value="{{ $delivery->id }}">
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
  $("#deliveriesTable").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#deliveriesTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
  $(document).on('click', '.delete',function(e){
    {{--you have to add class="delete{{object->id}}" and delete="delete={{object->id}}" to your form and add class ="delete" to the submit butoon --}}
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