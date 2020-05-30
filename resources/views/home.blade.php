@extends('adminlte::page')
@php( $username = \Auth::user()->name)
@php( $userrole = \Auth::user()->role)
@if($userrole==0)
@php($userrole='Parmacist')
@elseif($userrole==1)
@php ($userrole='Customer')
@endif
@section('content')
@include('error')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-home text-info"></i> Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Welcome at PMS system {{$userrole}} : <b>{{$username}}</b>  
                    @if(\Auth::user()->role==0 && !$rates)
                        <div class="my-2">Average System Rate : <b>No rate yet</b></div>
                    @elseif(\Auth::user()->role ==0 && $rates)
                    <div class="my-2">
                        <b>Average System Rate: {{$rates}}%</b>
                    </div>
                    <div class="progress" style="border-radius:50px">
                      <div class="progress-bar"  role="progressbar" style="width:{{$rates}}%" aria-valuenow="{{App\SystemRate::pluck('rate')->avg()*10}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @elseif(\Auth::user()->role==1 && $active)
                      <button type="button"  class="btn btn-info w-100 mt-3" data-toggle="modal" data-target="#modalPush"><i class="fas fa-star fa-sm"></i> Rate us</button>  
                    @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalPush" tabindex="2" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="false" data-backdrop="false" >
    <div class="modal-dialog modal-notify modal-info" role="document" >
        <!--Content-->
        <div class="modal-content text-center" >
            <!--Header-->
            <div class="modal-header gb-primary d-flex justify-content-center" >
                <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                <button type="button"  class="btn btn-link" data-toggle="modal" data-target="#modalPush"><i class="fas fa-times fa-lg animated rotateIn mt-2"></i></button>  
             </div>
            <!--Body-->
            <div class="modal-body">
                <form action="{!!route('rate.store')!!}" method="POST">
                    @csrf
                    <span class="font-weight-bold text-primary Rate "></span>   
                    <div class=" d-flex justify-content-center">  
                        <i class="far fa-star"></i>                           
                        <input id="Rate" name= "rate" class="border-0 custom-range d-inline mx-2" style="width:80%" type="range" min="0" max="10" />
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="form-group">
                        <label class="mt-3">Feedback</label>
                        <textarea class="form-control" name="feedback" placeholder="If You Have Any Comment" ></textarea>
                    </div>
            </div>
            <!--Footer-->
            <div class="modal-footer m-auto">
                    <input type="hidden" name="customer_id" value="{{\Auth::user()->id}}">
                    <button type="submit" class="btn btn-primary m-2">Rate</button>
                </form>
            </div>
        </div>
    <!--/.Content-->
    </div>
</div>
<!--Modal: modalPush--> 

@endsection
@section('js')
    <script>
        $(document).ready(function() {
            const $RateSpan = $('.Rate');
            const $RateValue = $('#Rate');
            $RateSpan.html($RateValue.val());
            $RateValue.on('input change', () => {
            $RateSpan.html($RateValue.val());
            });
        });
    </script>
    
@endsection