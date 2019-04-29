@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    @php
   
    if(Auth::check()){
       $user = Auth::user();
       $user_role = $user->role;
      
     }
     else{
         return redirect('login');
     }
   @endphp
 <div class="row">
   @if($user_role==8)
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
          <h3 class="smallboxh3">{{count($data['transportbill'])}}</h3>
            <p class="smallboxp">Transport Bill Request</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        <a href="{{url('/transport/allpayabletransportBilllist')}}" class="small-box-footer">Show List <i class="fa fa-arrow-circle-right"></i></a>
        </div>
  </div>
 
  @endif
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3 class="smallboxh3">{{$data['annualLeave']}}</h3>
            <p class="smallboxp">Annual Leave</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3 class="smallboxh3">{{$data['sickLeave']}}</h3>

        <p class="smallboxp">Annual SicK Leave</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3 class="smallboxh3">{{$data['lateEntry']}}</h3>

        <p class="smallboxp">Annual Late Come</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3 class="smallboxh3">{{$data['earlyLeave']}}</h3>
  
          <p class="smallboxp">Annual Early Leave</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3 class="smallboxh3">{{$data['lateApproval']}}</h3>

        <p class="smallboxp">Annual Late Approval</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
 
</section>
<script src="{{ mix('js/app.js') }}"></script>
@endsection
