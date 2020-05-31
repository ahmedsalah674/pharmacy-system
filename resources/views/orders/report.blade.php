@extends('adminlte::page')
@section('title','All reports')
@section('content_header')
  <h1>All reports</h1>
@endsection
@section('content')
  <table class="table ">
    <thead>
      <th>#</th>
      <th>Item Name</th>
      <th>Created At</th>
      <th>Action</th>
    </thead>
    <tbody>
      @foreach ($reports as $index => $report)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $report->item->name }}</td>
          <td>{{ $report->created_at}}</td>
          
          <td>
            <button type="button"  class="btn btn-success" data-toggle="modal" data-target="#modalPush{{$index}}">show</button>
          <div class="modal fade" style="margin-top:9%" id="modalPush{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="false" data-backdrop="true" >
              <div class="modal-dialog modal-notify modal-info" role="document" >
                <!--Content-->
                <div class="modal-content text-center" >
                  <!--Header-->
                  <div class="modal-header gb-primary d-flex justify-content-center" >
                    <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                    <button type="button"  class="btn btn-link" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-times fa-lg animated rotateIn mt-2"></i></button>  
                  </div>
                  <!--Body-->
                  <div class="modal-body">
                      <div class="text-center">

                          <p>we import this week with {{$report->quantity_imports}} items last week we import {{$report->lastWeek_quantity_imports}} items</p>
                          <p>we sell out this week {{$report->quantity_sells}} items last week we sell {{$report->lastWeek_quantity_sells}} items</p>
                      </div>
                  </div>
                </div>
                <!--/.Content-->
              </div>
            </div>
            <!--Modal: modalPush--> 
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection