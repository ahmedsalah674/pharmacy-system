@extends('adminlte::page')
@section('title','All Rates')
@section('content_header')
  <h1>All Rates</h1>
@endsection
@section('content')
  <table class="table ">
    <thead>
      <th>#</th>
      <th class="pl-5">Date</th>
      <th>Rate</th>
      <th>Actions</th>
    </thead>
    <tbody>
      @foreach ($rates as $index => $rate)
        <tr>
          <td>{{ $index+1 }}</td>
          <td class="w-25">{{ $rate->created_at }}</td>
          <td>{{ $rate->rate}}</td>
          <td>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPush{{$index}}">Show</button>
                <!--Modal: modalPush-->
                <div class="modal fade" id="modalPush{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true" data-backdrop="true" >
                  <div class="modal-dialog modal-notify modal-info" role="document" >
                    <!--Content-->
                    <div class="modal-content text-center" >
                      <!--Header-->
                      <div class="modal-header bg-primary d-flex justify-content-center" >
                        <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                        <button type="button" class="btn  btn-sm text-white" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-times"></i> </button>
                      </div>
                      <!--Body-->
                      <div class="modal-body">
                        <i class="fas fa-star fa-4x mb-4 text-info"></i>
                        @if($rate->feedback)
                          <p>{{$rate->feedback}}</p>
                        @else
                          <p>No Feedback</p>
                        @endif
                        
                      </div>
                    <!--/.Content-->
                  </div>
                </div>
                
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
   <div class="row d-flex justify-content-center ">
        <div class="  ">{{$rates->appends(['sort_desc' => ['created_at','desc']])->links()}}</div>
        </div>
    
@endsection