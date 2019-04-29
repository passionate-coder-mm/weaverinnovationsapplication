@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <section class="content" id="refreshdiv">
        <div class="box box-info">
             <div class="box-header with-border">
             <h3 class="box-title">Leave Request Form</h3>
                 <div class="box-tools pull-right">
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
             </div>
             </div>
             @php
            if(Auth::check()){
                $user = Auth::user();
                $user_name = $user->id;
            }
            else{
                return redirect('login');
            }
       @endphp
             {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'leaverequestform'])!!}
             <div class="box-body">
               <div class="form-group">
                     <label for="inputPassword3" class="col-sm-2 control-label">Request Type</label>
                     <div class="col-sm-6">
                         <select id="leavereason" class="form-control select2 " style="width: 100%;" name="type">
                            <option value="">Select a Type</option>
                             <option value="sick leave">Sick Leave</option>
                             <option value="annual leave">Annual Leave</option>
                             <option value="latecome/earlyleave">Late Come/Early Leave</option>
                          </select>
                     </div>
                 </div>
                 @if(!empty($find_login_user_dept_mng))
                 <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Department Manager</label>
                    <div class="col-sm-6">
                    <input type="text" name="manager" class="form-control " id="manager" value="{{$find_login_user_dept_mng->name}}" readonly>
                    <input type="hidden" name="manager_id" class="form-control " id="manager_id" value="{{$find_login_user_dept_mng->id}}">
                 </div>
                </div>
                @endif
                 <div class="form-group sicannudate">
                    <label  class="col-sm-2 control-label">Select Date</label>
                    <div class="col-sm-3">
                      <input type="text" name="from_date" class="form-control " id="datepicker4" placeholder="From Date">
                      {{-- <input type="text" name="start_date" class="form-control " id="startdate" placeholder="From Date"> --}}
                    </div>
                    <div class="col-sm-3">
                       <input type="text" name="to_date" class="form-control " id="datepicker5" placeholder="To Date">
                       {{-- <input type="text" name="end_date" class="form-control " id="enddate" placeholder="To Date"> --}}
                    </div>
                 </div>
                 <div class="form-group laeadate">
                        <label  class="col-sm-2 control-label">Select Date</label>
                        <div class="col-sm-6">
                          <input type="text" name="laeadate" class="form-control " id="datepicker6" placeholder="Date">
                        </div>
                     </div>
                 <div class="form-group">
                    <label for="teamname" class="col-sm-2 control-label">Purpose of Leave</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" rows="6" name="cause"></textarea>
                        <input type="hidden" name="user_id" class="form-control " id="user_id" value="{{ $user_name}}">

                    </div>
                </div>
             </div>
             <div class="box-footer"  style="text-align:center">
                 <button type="submit" class="btn btn-info leavebutton">Send Request</button>
                 <button type="reset" class="btn btn-danger">Reset</button>
             </div>
             {!!Form::close()!!}
         </div>
     </section>
     {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

</section>
<?php
 if(Auth::check()){
   $user_role = Auth::user()->role;
    if($user_role != 3){?>
     <section class="content">
        <div class="row">
            <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                <h3 class="box-title">Leave Request List</h3>
                   <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                    </div>
                 <div class="box-body">
                <table id="example3" class="table table-bordered table-striped ajaxappendrequest">
                    <thead>
                    <tr>
                    <th>Name</th>
                    <th>Request Type</th>
                    <th>Cause</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_request_by_id as $single_request)
                    <tr>
                    <td>{{$single_request->name}}</td>
                    <td>{{$single_request->purpose}}</td>
                    <td>{{$single_request->cause}}</td>
                    <td>{{$single_request->created_at}}</td>
                    <td>
                        <a class="request-view" data-request="{{$single_request->purpose}}" data-unq="{{$single_request->uniqueidentification}}"  data-toggle="modal" data-target="#view-request" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                         @if($single_request->leaveapproval =="yes" || $single_request->lateearlyapprove =="yes")
                          <a   class="btn btn-success btn-sm">Approved</a>
                          @elseif($single_request->leaveapproval =="no" || $single_request->lateearlyapprove =="no")
                          <a   class="btn btn-danger btn-sm">Rejected</a>
                          @else
                          <a class="btn btn-warning btn-sm">Pending</a>
                        @endif
                    </tr>
                   @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
   <?php } else {?>
    <section class="content">
            <div class="row">
                <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                    <h3 class="box-title">Leave Request List</h3>
                       <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                        </div>
                        {{-- @php
                        echo"<pre>";
                            print_r($manager_notifications);
                            echo"</pre>";
                        @endphp --}}
                    <div class="box-body">
                    <table id="example3" class="table table-bordered table-striped ajaxappendrequest">
                        <thead>
                        <tr>
                        <th>Request Sender</th>
                        <th>Request Type</th>
                        <th>Cause</th>
                        <th>Submitted At</th>
                        <th>Accepted At</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                       @foreach($manager_notifications as $manager_notification)
                        <tr>
                        <td>{{$manager_notification->name}}</td>
                        <td>{{$manager_notification->purpose}}</td>
                        <td>{{$manager_notification->cause}}</td>
                        <td>{{$manager_notification->created_at}}</td>
                        <td>{{$manager_notification->updated_at}}</td>
                        <td>
                            <a class="request-view" data-request="{{$manager_notification->purpose}}" data-unq="{{$manager_notification->uniqueidentification}}"  data-toggle="modal" data-target="#view-request" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                             @if($manager_notification->lateearlyapprove=="yes" || $manager_notification->leaveapproval=="yes") 
                              <a class="btn btn-success btn-sm">Approved</a>
                              @elseif($manager_notification->leaveapproval =="no" || $manager_notification->lateearlyapprove =="no")
                              <a   class="btn btn-danger btn-sm">Rejected</a>
                              @else
                              <a href="javascript:void(0)" class="btn btn-warning btn-sm approve" data-request="{{$manager_notification->purpose}}" data-unq="{{$manager_notification->uniqueidentification}}">Approve ?</a>
                            
                              <a href="javascript:void(0)" class="btn btn-danger btn-sm onlydisapprove disapprove{{$manager_notification->uniqueidentification}}" data-request="{{$manager_notification->purpose}}" data-unq="{{$manager_notification->uniqueidentification}}">Disapprove ?</a>
                            
                              @endif
                        </tr>
                      @endforeach
                        </tbody>
                    </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </section>
    <?php } }?>
    <div class="modal fade" id="view-request">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Request Detail</h4>
                </div>
                <div class="modal-body">
                        {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'requestdetail'])!!}
                        <div class="box-body">
                                <div class="form-group">
                                      <label for="inputPassword3" class="col-sm-3 control-label">Request From</label>
                                      <div class="col-sm-9">
                                      <input type="text" name="name" id="req_name" class="form-control" readonly>
                                      </div>
                                  </div>
                 
                                  <div class="form-group">
                                         <label for="inputPassword3" class="col-sm-3 control-label">Request Type</label>
                                         <div class="col-sm-9">
                                                <input type="text" name="type" id="req_type" class="form-control " readonly>
                                         </div>
                                     </div>
                                    <div class="form-group lateearly">
                                             <label  class="col-sm-3 control-label">Leave/Late Date</label>
                                             <div class="col-sm-9">
                                             <input type="text" name="laeadate" id="req_latedate" class="form-control " readonly>
                                             </div>
                                     </div>
                                 
                                    
                                  <div class="form-group tofromdate">
                                         <label  class="col-sm-3 control-label">Leave/Late Date</label>
                                           <div class="col-sm-4">
                                            <input type="text" name="from_date" id="req_fromdate" class="form-control" readonly >
                                            </div>
                                            
                                            <div class="col-sm-4">
                                            <input type="text" name="to_date" id="req_todate" class="form-control" readonly>
                                            </div>
                                           
                                      </div>
                              
                                  <div class="form-group">
                                     <label for="teamname" class="col-sm-3 control-label">Purpose</label>
                                     <div class="col-sm-9">
                                         <textarea class="form-control" rows="6" name="cause" id="req_cause" readonly></textarea>
                 
                                     </div>
                                 </div>
                              </div>
                        {!!Form::close()!!}
                </div>
              </div>
           </div>
    </div>
<script>
$(document).ready(function () {
    $('#leaverequestform').validate({ 
    rules: {
           from_date: 
            {
            required: true,
            
            },
            to_date: 
            {
              required: true,
            
            },
            type:
            {
              required: true,
            
            },
            cause:
            {
              required: true,
            
            },
            laeadate:
            {
              required: true,
            
            }
    },

    highlight: function(element) {
        $(element).parent().addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).parent().removeClass('has-error');
    },
    });
});
    $( function() {
    $("#datepicker4" ).datepicker();
    $("#datepicker5" ).datepicker();
    $("#datepicker6" ).datepicker();
    $("#datepicker4").attr("autocomplete", "off");
    $("#datepicker5").attr("autocomplete", "off");
    $("#datepicker6").attr("autocomplete", "off");
}); 
$(document).on('change','#leavereason',function(){
    var leave_reason = $('#leavereason  :selected').val();
    if(leave_reason =="latecome/earlyleave"){
     $('.laeadate').css('display','block');
     $('.sicannudate').css('display','none');;
    }else{
        $( ".leavebutton" ).prop( "disabled", false );
        $('.laeadate').css('display','none');
        $('.sicannudate').css('display','block');
    }
    //alert(leave_reason);
})
$(document).on('submit','#leaverequestform',function(e){
  e.preventDefault();
  var data = $(this).serialize();
  $.ajax({
        url:"{{route('leave_options.store')}}",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data){
       console.log(data);
          if(data =='Error'){
            Swal.fire({
                text: "My be you were present those days",
                type: 'warning',
                confirmButtonColor: 'red',
                confirmButtonText: 'OK',
                });
          }else{
          toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
            $('.ajaxappendrequest').prepend(`<tr>
                    <td>`+data.name+`</td>
                    <td>`+data.purpose+`</td>
                    <td>`+data.cause+`</td>
                    <td>`+data.created_at+`</td>
                    <td>
                        <a class="request-view" data-request="`+data.purpose+`" data-unq="`+data.uniqueidentification+`"  data-toggle="modal" data-target="#view-request" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                        <a class="btn btn-warning btn-sm">Pending</a>
                    </td>
                    </tr>`);
            toastr.success('Request Was sent successfully');
          $('#leaverequestform').trigger("reset");
        }
        }
        
  });
});
$(document).on('click','.approve',function(e) {
    e.preventDefault();
    var unique_id = $(this).data('unq');
    var type= $(this).data('request');
    if(type=="latecome/earlyleave"){
        type ="latecomeearlyleave"
    }else{
       type=type;
    }
    //aler
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Approve it!',
    
    }).then(result => {
    if (result.value) {
        $.get('approveleavefrommng/'+unique_id+'/'+type,function(data){
        toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
            
            toastr.success('Leave Request was Approved');
        })
           $(this).text('Approved');
            $(this).removeClass('btn-warning');
            $(this).addClass('btn-success');
            $('.ajaxappendrequest').find('.disapprove'+unique_id).remove();
    }
   }
  )
});

$(document).on('click','.onlydisapprove',function(e) {
    e.preventDefault();
    var unique_id = $(this).data('unq');
    //aler
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Disapprove it!',
    
    }).then(result => {
    if (result.value) {
        $.get("disapprove/"+unique_id,function(data){
           toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
            
            toastr.success('Leave Request was Removed');
       })
        $(this).closest('tr').hide();
      }
    }
  )
});
// $(document).on('click','.approve',function(){
//     var unique_id = $(this).data('unq');
//     var type= $(this).data('request');
//     if(type=="latecome/earlyleave"){
//         type ="latecomeearlyleave"
//     }else{
//        type=type;
//     }
//     //alert(type);
//     $.get('approveleavefrommng/'+unique_id+'/'+type,function(data){
//         toastr.options = {
//                 "debug": false,
//                 "positionClass": "toast-bottom-right",
//                 "onclick": null,
//                 "fadeIn": 300,
//                 "fadeOut": 1000,
//                 "timeOut": 5000,
//                 "extendedTimeOut": 2000
//             };
            
//             toastr.success('Leave Request was Approved');

//     })
//            $(this).text('Approved');
//             $(this).removeClass('btn-warning');
//             $(this).addClass('btn-success');
//             $(this).closest('span').hide();
// })
// $(document).on('click','.onlydisapprove',function(e){
//   e.preventDefault();
//   var unique_id = $(this).data('unq');
//   $.get("disapprove/"+unique_id,function(data){
//     toastr.options = {
//                 "debug": false,
//                 "positionClass": "toast-bottom-right",
//                 "onclick": null,
//                 "fadeIn": 300,
//                 "fadeOut": 1000,
//                 "timeOut": 5000,
//                 "extendedTimeOut": 2000
//             };
            
//             toastr.success('Leave Request was Removed');
//   })
//   $(this).closest('tr').hide();
// })
$(document).on('click','.request-view',function(){
    var unq_id = $(this).data('unq');

    var type= $(this).data('request');
    if(type=="latecome/earlyleave"){
        type ="latecomeearlyleave"
    }else{
       type=type;
    }
    //alert(unq_id);
    $.get('detailrequest/'+unq_id+'/'+type,function(data){
        $('#requestdetail').find('#req_name').val(data[0].name);
        $('#requestdetail').find('#req_type').val(data[0].purpose);
        if(data[0].purpose =="latecome/earlyleave"){
            $('#requestdetail').find('#req_latedate').val(data[0].date);
            $('.tofromdate').hide();
            $('.lateearly').show();
          }else{
            $('#requestdetail').find('#req_fromdate').val(data[1][0]);
            $('#requestdetail').find('#req_todate').val(data[1].pop());

            $('.lateearly').hide();
            $('.tofromdate').show();
        }
        $('#requestdetail').find('#req_cause').val(data[0].cause);
        //console.log(data[1][0]);

    })
})
$(document).on('change','#datepicker4',function(){
   var initial_date =$('#datepicker4').val();
    var final_date =$('#datepicker5').val();
    if(final_date!='' && initial_date > final_date){
        $('#datepicker4').val('');
        Swal.fire({
        text: "Start date must be smaller than End date",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }
$('#leaverequestform').find('#startdate').val(initial_date)
    //console.log(start_date);
   
})
$(document).on('change','#datepicker5',function(){
    var initial_date =$('#datepicker4').val();
    var final_date =$('#datepicker5').val();
    var start_date =new Date($('#datepicker4').val());
    var end_date =new Date($('#datepicker5').val());
    var today = new Date();
    var currentmonthindex = (today.getMonth()+1);
    var nextmonthindex = currentmonthindex + 1;
    var previousmonthindex = currentmonthindex - 1;
    var start_index = (start_date.getMonth()+1);
    var end_index = (end_date.getMonth()+1);
    if(initial_date==''){
        $('#datepicker5').val('');
        Swal.fire({
        text: "First Select Start Date!",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else if(initial_date > final_date){
        $('#datepicker5').val('');
        Swal.fire({
        text: "Start date must be smaller than End date",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else if(start_index > nextmonthindex || end_index > nextmonthindex ){
        $('#datepicker5').val('');
        $('#datepicker4').val('');
        Swal.fire({
        text: "You can only make request at most for the next month",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else if(start_index < previousmonthindex || end_index < previousmonthindex ){
        $('#datepicker5').val('');
        $('#datepicker4').val('');
        Swal.fire({
        text: "You can make request for before the previous month",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else{
    
    console.log("success");
    }
})
function GetMonthName(monthNumber) {
  var months = ['January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'];
  return months[monthNumber-1];
}
$(document).on('change','#datepicker6',function(){
    var leavedate = $(this).val();
    var dateindex = new Date(leavedate).getDay();
    if(dateindex== 5){
        Swal.fire({
        text: "Hey It was Friday",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
        $('#datepicker6').val('');
        $( ".leavebutton" ).prop( "disabled", true );
    }else{
        var leave = leavedate.split('/');
        var user_id = $('#user_id').val();
        var newleave =leave[0]+'-'+leave[1]+'-'+leave[2];
         $.get('checkdateexistance/'+newleave+'/'+user_id,function(data){
            // alert(user_id);
             //console.log(data);
             if(data=='Match'){
                Swal.fire({
                text: "Hey It was Government Holiday",
                type: 'warning',
                confirmButtonColor: 'red',
                confirmButtonText: 'OK',
                });
                $('#datepicker6').val('');
              $( ".leavebutton" ).prop( "disabled", true );
             }else if(data=='Absent'){
                Swal.fire({
                text: "Hey You were Absent in This day",
                type: 'warning',
                confirmButtonColor: 'red',
                confirmButtonText: 'OK',
                });
                $('#datepicker6').val('');
              $( ".leavebutton" ).prop( "disabled", true );
             }else if(data=='Intime'){
                Swal.fire({
                text: "Hey You were In time that day",
                type: 'warning',
                confirmButtonColor: 'red',
                confirmButtonText: 'OK',
                });
                $('#datepicker6').val('');
              $( ".leavebutton" ).prop( "disabled", true );
             }else{
              $( ".leavebutton" ).prop( "disabled", false );
                console.log('request sent');
             }
        
      })
    }
})

</script>
@endsection