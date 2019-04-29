@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <section class="content" id="refreshdiv">
        <div class="box box-info">
             <div class="box-header with-border">
             <h3 class="box-title">Leave /Late Request Approval</h3>
                 <div class="box-tools pull-right">
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
             </div>
             </div>
            
           
             {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'leaverequestapproveform'])!!}
             <div class="box-body">
               <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Request From</label>
                     <div class="col-sm-6">
                     <input type="text" name="name" class="form-control"  value="{{$find_name->name}}">
                     </div>
                 </div>

                 <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Request Type</label>
                        <div class="col-sm-6">
                               <input type="text" name="type" class="form-control "  value="{{$request_user_id->purpose}}">
                        </div>
                    </div>
              
                 @if($request_user_id->purpose == "latecome/earlyleave")
                    <div class="form-group">
                            <label  class="col-sm-2 control-label">Leave/Late Date</label>
                            <div class="col-sm-6">
                            <input type="text" name="laeadate" class="form-control "  value="{{$request_user_id->date}}">
                            </div>
                    </div>
                 @else
                    @php
                       $fromdate= array_shift($request);
                        $todate= array_pop($request);
                    @endphp
                 <div class="form-group sicannudate">
                        <label  class="col-sm-2 control-label">Leave/Late Date</label>
                        <div class="col-sm-3">
                          <input type="text" name="from_date" class="form-control "  value="{{$fromdate}}">
                        </div>
                        
                        <div class="col-sm-3">
                        <input type="text" name="to_date" class="form-control "  value="{{$todate}}">
                        </div>
                     </div>
                @endif
                 <div class="form-group">
                    <label for="teamname" class="col-sm-2 control-label">Purpose</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" rows="6" name="cause">{{$request_user_id->cause}} </textarea>
                        <input type="hidden" name="attendance_id" class="form-control " id="user_id" value="{{$request_user_id->attendance_id}}" >
                        <input type="hidden" name="uniqueidentification" class="form-control" id="unq_id" value="{{$request_user_id->uniqueidentification}}" >
                       <input type="hidden" name="leaveid" class="form-control " value="{{$request_user_id->id}}" >

                    </div>
                </div>
             </div>
             <div class="box-footer"  style="text-align:center">
                 <button type="submit" class="btn btn-info">Approve</button>
                 <button type="button" class="btn btn-danger disapprove">Disapprove</button>
             </div>
             {!!Form::close()!!}
         </div>
     </section>
     {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

</section>
<script>
$(document).on('submit','#leaverequestapproveform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url:"/leave/leaveorlateapproval",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        {
            toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
            toastr.success('Leave Request was Approves');
            // setTimeout(function() {window.location.href="/admin-dashboard";}, 2000);
        }
    });
})
$(document).on('click','.disapprove',function(e){
  e.preventDefault();
  var unqid = $('#leaverequestapproveform').find('#unq_id').val();
  $.get("/leave/disapprove/"+unqid,function(data){
    toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
            toastr.success('Leave Request was Disapproved');
            // setTimeout(function() {window.location.href="/admin-dashboard";}, 2000);
    
    //console.log(data);
  })
})
</script>
@endsection