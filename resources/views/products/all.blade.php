@extends('adminlte::page')
@section('title','ALl Products')
@section('content_header')
  <h1>All Products</h1>
@endsection
@section('content')
@include('error')
  <table class="table table-hover ">
    <thead>
      <th>Name</th>
      <th>Price</th>
      <th>Qunatity</th>
      <th>Expiration Date</th>
      <th>Discount</th>
      <th>Actions</th>
    </thead>
    <tbody id="productsTable">
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->name }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->quantity }}</td>
          <td>{{ $product->expiration_date }}</td>
          <td>{{ ($product->discount || $product->discount!=0)? $product->discount."%" : 'No Discount'}}</td>
          <td>
            <form action="" method="post" delete="delete{{$product->id}}" class="delete{{$product->id}}">
              @csrf
              <a href="" class="btn btn-primary btn-sm">Edit</a>
              <a href="{!! route('product.show',$product->id) !!}" method="post" class="btn btn-success btn-sm">Show</a>
              <input type="hidden" name="id" value="{{ $product->id }}">
              <button type="button" class="btn-danger btn delete btn-sm">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="row d-flex justify-content-center ">
    <div class="  ">{{$products->appends(['sort_desc' => ['created_at','desc']])->links()}}</div>
    </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
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
