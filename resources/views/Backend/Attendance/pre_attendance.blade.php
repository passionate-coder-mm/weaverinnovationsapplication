@extends('Backend.admin_master')
@section('main-content')
<?php
use App\Department;
?>
<section class="content">
    <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Attendance UI</h3>
            </div>
            {!!Form::open(['class'=>'form-horizontal','id'=>'preattendance','method' => 'post'])!!}
              <div class="box-body">
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Select User</label>
                    <div class="col-sm-6">
                        <select id="user_selection" class="form-control select2" style="width: 100%;" name="user_id" data-placeholder="Select Users">
                            <option value="">Select User</option>
                            @foreach($user_list as $user)
                             <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        <span class="errortxt"></span>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="attendanceid" class="col-sm-2 control-label">Attendance ID</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="attendanceid" name="attendance_id" placeholder="Enter Attendance Id">
                  </div>
                </div>
                </div>
                <div class="box-footer">
                    <button type="submit" id="attbtn" class="btn btn-info">Create</button>
                </div>
               {!!Form::close()!!}
    </div>
</section>
<section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Role list</h3>
                 <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                  </div>
                 </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped ajaxattendanceprepend">
                  <thead>
                  <tr>
                    <th>User Name</th>
                    <th>Attendance Id</th>
                    <th>Department</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($attendance_list as $attendance)
                     <tr>
                        <td>{{$attendance->name}}</td>
                         <td>{{$attendance->attendance_id}}</td>
                         <td>
                           
                          {{$attendance->department_name =='' ? "N/A" : $attendance->department_name}} 
                         </td>
                         <td><img src="{{url('/'.$attendance->image)}}" width="100" height="50"></td>
                         <td>
                            <label class="switch">
                                <input type="checkbox" {{$attendance->status ==1 ? 'checked':''}}>
                                <span data-teamid="{{$attendance->preattid}}" data-ofid="0" data-onid="1" class="slider round {{$attendance->status == 1 ? 'deactive':'active'}}"></span>
                            </label>
                        </td>
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
        <!-- /.row -->
      </section>
<script>
               
    $(document).ready(function () {
        $('#preattendance').validate({ 
        rules: {
            attendance_id: {
                    required: true,
                    remote: {
                            url: "uniqueattchk"
                    },
                },
            user_id:{
              userselectionvalidation: true,
                //required:true,
                
            }
            
            },
            messages: {
              attendance_id: {
                        remote:("Id is already in use")
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
        $.validator.addMethod("userselectionvalidation", function(value, element) {
              if ($("#user_selection")[0].selectedIndex =='') {
                return false;
              } 
                return true;
        }, "  Please Select An User");
        $(document).on('submit','#preattendance',function(e){
          e.preventDefault();
          var data = $(this).serialize();
            $.ajax({
                  url:"{{ route('attendance.store') }}",
                  method:"POST",
                  data:data,
                  dataType:'JSON',
                success:function(data){
                    console.log(data);
                    $('#preattendance').trigger('reset');
                    toastr.options = {
                                  "debug": false,
                                  "positionClass": "toast-bottom-right",
                                  "onclick": null,
                                  "fadeIn": 300,
                                  "fadeOut": 1000,
                                  "timeOut": 5000,
                                  "extendedTimeOut": 1000
                                };
                                var deactive = 'deactive';
                                var active = 'active';
                                var checked = 'checked';
                          toastr.success('Attendance info Created Successfully');
                         $('.ajaxattendanceprepend').prepend(`<tr>
                        <td>`+data.name+`</td>
                        <td>`+data.attendance_id+`</td>
                        <td>`+((data.department_name ==null) ? 'N/A': data.department_name)+`</td>
                         <td><img src="/`+data.image+`" width="100" height="50"></td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" `+((data.status == 1) ? checked : '')+`>
                                <span data-teamid="`+data.preattid+`" data-ofid="0" data-onid="1" class="slider round `+((data.status == 1) ? deactive : active)+`"></span>
                            </label>
                        </td>
                    </tr>`);          
                }
            })
        });
        $(document).on('change','#user_selection',function(){
          var user_id = $(this).find(":selected").val()
            $.get('uniqueuserchk/'+user_id,function(data){
              //console.log(data);
              if(data =='true'){
                $('.errortxt').text('This name is already taken');
                $("#attbtn").attr("disabled", true);
              } else{
                $('.errortxt').text('');
                $('#user_selection-error').text('');
                $("#attbtn").attr("disabled", false);
              }
            })
        })
       $(document).on('click','.actdeact',function(){
            var attendanceid = $(this).data('attid');
            //alert(attendanceid);
            $.get('activedeactive/'+attendanceid,function(data){
              console.log(data);
            });
        })

      $(document).on('click','.deactive',function(){
        var id = $(this).data('ofid');
        var teamid = $(this).data('teamid');
        $(this).removeClass('deactive');
        $(this).addClass('active');
        $.get('updateuserattstatus/'+id+'/'+teamid,function(data){

        })
    })
    $(document).on('click','.active',function(){
        var id = $(this).data('onid');
        var teamid = $(this).data('teamid');
        $(this).removeClass('active');
        $(this).addClass('deactive');
        $.get('updateuserattstatus/'+id+'/'+teamid,function(data){
            
        })
    })
      
  </script>
@endsection