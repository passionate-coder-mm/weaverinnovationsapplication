@extends('Backend.admin_master')
@section('main-content')

<section class="content" id="refreshdiv">
   <div class="box box-info">
        <div class="box-header with-border">
        <h3 class="box-title">Team Building</h3>
            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
        </div>
        {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'teamform'])!!}
        <div class="box-body">
            <div class="form-group">
                <label for="teamname" class="col-sm-2 control-label">Team Name</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="teamname" name="team_name" placeholder="Enter Designation Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Select Teamleader</label>
                <div class="col-sm-6">
                    <select id="remainingteamleader" class="form-control select2 " style="width: 100%;" name="teamleader_id">
                        <option value="">select Teamleader</option>
                        @foreach($teammembers_from_user as $executive)
                            <option value="{{$executive->id}}">{{$executive->name}}</option>
                          @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Select Executives</label>
                <div class="col-sm-6">
                        <select id="remainingexecutive" class="form-control select2" multiple="multiple" data-placeholder="Select Executives"
                        style="width: 100%;" name="teammember_id[]">
                        @foreach($teammembers_from_user as $executive)
                            <option value="{{$executive->id}}">{{$executive->name}}</option>
                          @endforeach
                </select>
                </div>
              </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-info">Create Team</button>
        </div>
        {!!Form::close()!!}
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
            <h3 class="box-title">Team List</h3>
            
           
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                </div>
            <div class="box-body">
            <table id="example3" class="table table-bordered table-striped ajaxprependteam">
                <thead>
                <tr>
                <th>Team Name</th>
                <th>Team Leader</th>
                <th>Creation Time</th>
                <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($team_info as $team)
                <tr class="unqteam{{$team->teamid}}">
                <td>{{$team->team_name}}</td>
                <td>{{$team->teamleader_name}}</td>
                <td>{{$team->created_at}}</td>
                   
                <td>
                    <a data-teamid="{{$team->teamid}}" class="team-view"  data-toggle="modal" data-target="#modal-team-view" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                    <a class="edit_team" data-teamid="{{$team->teamid}}"  data-toggle="modal"  data-target="#edit-team"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <label class="switch">
                    <input type="checkbox" {{$team->status ==1 ? 'checked':''}}>
                            <span data-teamid="{{$team->teamid}}" data-ofid="0" data-onid="1" class="slider round {{$team->status == 1 ? 'deactive':'active'}}"></span>
                    </label>
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

<!--Team edit modal-->
<div class="modal fade" id="edit-team">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Team</h4>
            </div>
            <div class="modal-body">
                    {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'teameditform'])!!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="teamname" class="col-sm-3 control-label">Team Name</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="editteamname" name="team_name" placeholder="Enter Team Name">
                            <input type="hidden" class="form-control" id="teamid" name="team_id" placeholder="Enter Designation Name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Select Teamleader</label>
                            <div class="col-sm-9">
                                <select id="editremainingteamleader" class="form-control select2 " style="width: 100%;" name="teamleader_id">
                                    <option value="">select Teamleader</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                
                            <label for="inputPassword3" class="col-sm-3 control-label">Select Executives</label>
                            <div class="col-sm-9">
                                    <div class='selectedexecutivelist'></div>
                                    <select id="editremainingexecutive" class="form-control select2" multiple="multiple" data-placeholder="Select Executives"
                                    style="width: 100%;" name="teammember_id[]">
                                    
                            </select>
                            </div>
                          </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info">Create Team</button>
                    </div>
                    {!!Form::close()!!}
            </div>
          </div>
       </div>
</div>
<div class="modal fade" id="modal-team-view">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title topteamname">Team Details</h4>
            </div>
            <div class="modal-body">
                 <table class="table table-bordered table-striped">
                   <tr>
                     <td><b>Team name</b></td>
                     <td class="teamname"></td>
                   </tr>
                   <tr>
                      <td><b>Team Formed at</b></td>
                      <td class="formeddate"></td>
                    </tr>
                    <tr>
                        <td><b>Team Leader Name</b></td>
                        <td class="teamleader"></td>
                      </tr>
                      <tr>
                          <td><b>Team Members</b></td>
                          <td class="executives"></td>
                        </tr>
                        <tr>
                            <td><b>Team Status</b></td>
                            <td class="status"></td>
                        </tr>
                 </table>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                 
                </div>
            </div>
           </div>
        </div>
     </div>
<script>
//Team form validation
$(document).ready(function () {
    $('#teamform').validate({ 
    rules: {
    team_name: {
                required: true
            },
    teamleader_id: {
            required: true
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
$(document).ready(function () {
    $('#teameditform').validate({ 
    rules: {
    team_name: {
                required: true
            },
    teamleader_id: {
            required: true
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

//team submit form
$(document).on('submit','#teamform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    if ($('#teamform').valid()) {
     $('#remainingexecutive').empty();
     $('#remainingteamleader').empty();
    $.ajax({
        url:"{{route('team_options.store')}}",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        {
            // console.log(data[1]);
            $('#teamform').trigger('reset');
            toastr.options = {
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "fadeIn": 300,
                    "fadeOut": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000
                };
            toastr.success('Team Created Successfully');
            var deactive = 'deactive';
            var active = 'active';
            var checked = 'checked';
            
            $('.ajaxprependteam').prepend(`<tr class="unqteam`+data[0].teamid+`">
                <td>`+data[0].team_name+`</td>
                <td>`+data[0].teamleader_name+`</td>
                <td>`+data[0].created_at+`</td>
                <td>
                   
                    <a data-teamid="`+data[0].teamid+`" class="team-view"  data-toggle="modal" data-target="#modal-team-view" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                    <a class="edit_team" data-teamid="`+data[0].teamid+`"  data-toggle="modal"  data-target="#edit-team"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <label class="switch">
                    <input type="checkbox"`+((data.status == 1) ? checked : '')+`>
                            <span data-teamid="`+data[0].teamid+`" data-ofid="0" data-onid="1" class="slider round `+((data[0].status == 1) ? deactive : active)+`"></span>
                    </label>
                </td>
                </tr>`); 
         $.each(data[1],function(index,remainingleader){
            $('#remainingexecutive').append(`<option value="`+remainingleader.id+`">`+remainingleader.name+`</option>`);
         })  
         $('#remainingteamleader').append(`<option value="">Select Teamleader</option>`);
         $.each(data[1],function(index,remaininguser){
            $('#remainingteamleader').append(`<option value="`+remaininguser.id+`">`+remaininguser.name+`</option>`);
         })      
        }
    });
  }
});
//update team 
$(document).on('submit','#teameditform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    if ($('#teameditform').valid()) {
    //  $('#remainingexecutive').empty();
    //  $('#remainingteamleader').empty();
    $.ajax({
        url:"updateteam",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        {
             console.log(data);
            $('#teamform').trigger('reset');
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
            $('.unqteam'+data.teamid).replaceWith(`<tr class="unqteam`+data.teamid+`">
                <td>`+data.team_name+`</td>
                <td>`+data.teamleader_name+`</td>
                <td>`+data.created_at+`</td>
                <td>
                    <a data-teamid="`+data.teamid+`" class="team-view"  data-toggle="modal" data-target="#modal-team-view" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                    <a class="edit_team" data-teamid="`+data.teamid+`"  data-toggle="modal"  data-target="#edit-team"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <label class="switch">
                    <input type="checkbox" `+((data.status == 1) ? checked : '')+` >
                            <span data-teamid="`+data.teamid+`" data-ofid="0" data-onid="1" class="slider round `+((data.status == 1) ? deactive : active)+`"></span>
                    </label>
                </td>
                </tr>`); 
            setTimeout(function() {$('#edit-team').modal('hide');}, 1500);
            setTimeout(function() {toastr.success('Team Updated Successfully');}, 2000);
        }
    });
  }
});
//team details
$(document).on('click','.team-view',function(){
 var teamid = $(this).data('teamid');
 $('.executives').empty();
 $.get('getteaminfobyid/'+teamid,function(data){
     $('#modal-team-view').find('.teamname').text(data[0].team_name);
     $('#modal-team-view').find('.formeddate').text(data[0].created_at);
     $('#modal-team-view').find('.teamleader').text(data[0].teamleader_name);
     if(data[0].status ==1){
        $('#modal-team-view').find('.status').text('RUNNING');
     }else{
        $('#modal-team-view').find('.status').text('CLOSED');
     }
     $.each(data[1],function(index,teammembers){
        $('.executives').append(`<li class="myselectlist"><span></span>`+teammembers.name+`</li>`);
   })
   console.log(data[1]);
  });
});
//team edit script
 $(document).on('click','.edit_team',function(){
     var myteamid = $(this).data('teamid');
     //alert(myteamid);
    
     $('.selectedexecutivelist').empty();
     $('#editremainingteamleader').empty();
     $('#editremainingexecutive').empty();
     $.get('getdatabyteam/'+myteamid,function(data){
        $('#teameditform').find('#editteamname').val(data[0].team_name);
        $('#teameditform').find('#teamid').val(data[0].teamid);
        $('#editremainingteamleader').append(`<option selected="selected" value="`+data[0].userid+`">`+data[0].teamleader_name+`</option>`);
         console.log(data[3]);
         $.each(data[1],function(index,user){
             //console.log(user.name);
             $('.selectedexecutivelist').append(`<li id="uniqueexe`+user.id+`" class="myselectlist"><span class="removefromteam" data-teamid="`+myteamid+`" data-executiveid="`+user.id+`">×</span>`+user.name+`</li>`);
        })
        $.each(data[2],function(index,remainingleader){
             //console.log(user.name);
             $('#editremainingteamleader').append(`<option  value="`+remainingleader.id+`">`+remainingleader.name+`</option>`);
        })
        $.each(data[3],function(index,remaininguser){
             //console.log(user.name);
             $('#editremainingexecutive').append(`<option  value="`+remaininguser.id+`">`+remaininguser.name+`</option>`);
        })
    })
})
$(document).on('click','.removefromteam',function(){
        var exid  =$(this).data('executiveid');
        var teamid = $(this).data('teamid');
        //alert(exid);
         $('.selectedexecutivelist').find('#uniqueexe'+exid).remove();
        $.get('makeexecutiveteamless/'+exid+'/'+teamid,function(data){
           
            console.log(data);
        });
    })
  
    $(document).on('click','.deactive',function(){
        var id = $(this).data('ofid');
        var teamid = $(this).data('teamid');
        $(this).removeClass('deactive');
        $(this).addClass('active');
        $.get('updateteamstatus/'+id+'/'+teamid,function(data){

        })
        //alert(id)
    })
    $(document).on('click','.active',function(){
        var id = $(this).data('onid');
        var teamid = $(this).data('teamid');
        $(this).removeClass('active');
        $(this).addClass('deactive');
        $.get('updateteamstatus/'+id+'/'+teamid,function(data){
            
        })
        //alert(id)
    })

</script>
@endsection

     