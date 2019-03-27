@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="box box-info">
         <div class="box-header with-border">
           <h3 class="box-title">User</h3>
              <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
           </div>
         </div>

       {!!Form::open(['method' => 'POST','id'=>'userform','enctype'=>'multipart/form-data'])!!}
        <div class="box-body">
          <div class="row">
               <div class="col-md-6">
                   <div class="form-group">
                       <label for="username">User Name</label>
                       <input type="text" class="form-control" id="username" name="name"  placeholder="Enter User Name">
                   </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"  placeholder="Enter Email">
                       
                   </div>
                </div>
          </div>
          <div class="row">
               <div class="col-md-6">
                   <div class="form-group">
                        <label for="mobileno">Mobile No</label>
                        <input type="number" class="form-control" id="mobileno" name="mobile_no"  placeholder="Enter Mobile No">
                   </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                       <label for="nid">NID</label>
                       <input type="text" class="form-control" id="nid" name="nid"  placeholder="Enter National Id Number">
                   </div>
                </div>
          </div>
          <div class="row">
             <div class="col-md-6">
                 <div class="form-group">
                     <label for="department">Select Department</label>
                     <select id="departmentwiseloadchange" class="form-control select2" style="width: 100%;" name="department_id">
                        <option value="">Select Department</option>
                         @foreach($department_list as $department)
                            <option data-deptid="{{$department->id}}" value="{{$department->id}}" >{{$department->department_name}}</option>
                         @endforeach
                     </select>
                  </div>
             </div>
               <div class="col-md-6">
                   <div class="form-group">
                       <label for="designation">Select Designation</label>
                       <select  id="deptwisedesig" class="form-control select2" style="width: 100%;" name="designation_id">
                          
                       </select>
                   </div>
               </div>
           </div>
          
           <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                       <label for="office_id">Office Id</label>
                       <input type="text" class="form-control" id="office_id" name="office_id" placeholder="Enter Office Id">
                   </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                     <label for="finp_id">Fingerprint Id</label>
                     <input type="text" class="form-control" id="finp_id" name="finger_id"  placeholder="Enter finger print Id">
                 </div>
              </div>
           </div>
           <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                       <label for="image">User Image</label>
                       <input type="file" class="form-control" id="image" name="image">
                       <img id="img" src="#" alt="your image" width="100" height="80" />
                   </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                     <label for="password">Password</label>
                     <input type="password" class="form-control" id="password" name="password"  placeholder="Enter Password(atleast 8 characters)">
                     {{-- <input type="text" class="form-control" id="conpass" name="con_pass"  placeholder="Enter Password(atleast 8 characters)"> --}}

                    </div>
              </div>
           </div>
           <div class="row">
              
                <div class="col-md-12">
                     <div class="form-group customrole">
                         <label for="exampleInputEmail1">Select Role</label>
                         <select id="roleset" class="form-control select2" style="width: 100%;" name="role">
                           <option  value="">Select Role</option>
                           @foreach($role_list as $role)
                            <option class="forroletype" value="{{$role->id}}" >{{$role->role_name}}</option>
                           @endforeach
                         </select>
                    </div>
                   </div>
             </div>
           <div class="box-footer">
               <button type="submit" class="btn btn-primary">Create User</button>
           </div>
         </div>
         {!!Form::close()!!}
       </div>
   </section>
   <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">User List</h3>
                 <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                  </div>
                 </div>
              <div class="box-body">
                <table id="example3" class="table table-bordered table-striped ajaxuserprepend">
                  <thead>
                  <tr>
                    <th>User Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($user_list as $user)
                   <tr class="unquser{{$user->id}}">
                    <td>{{$user->name}}</td>
                    <td>
                        @php
                         $deprtmentname = DB::table('userdepartments')
                                          ->leftJoin('departments','userdepartments.department_id','=','departments.id')
                                          ->select('departments.department_name','departments.id')
                                          ->where('userdepartments.user_id','=',$user->id)
                                          ->first();
                                          if($deprtmentname){
                                            $deptname = $deprtmentname->department_name;
                                            echo $deptname; 
                                          } else{
                                            echo 'N/A';
                                          }
                       @endphp 
                    </td>
                    <td>
                        @php
                            $designation= DB::table('userdesignations')
                                             ->leftJoin('designations','userdesignations.designation_id','=','designations.id')
                                             ->select('designations.designation_name','designations.id')
                                             ->where('userdesignations.user_id','=',$user->id)
                                             ->first();
                                             if($designation){
                                               $designame = $designation->designation_name;
                                               echo $designame; 
                                             } else{
                                               echo 'N/A';
                                             }
                          @endphp 
                    </td>
                    <td><img src="{{url('/'.$user->image)}}" width="100" height="50"></td>
                   <td>
                       <a data-userid="{{$user->id}}" class="profile-view" data-designame="{{$designation != '' ? $designation->designation_name : 'N/A' }}" data-desigid ="{{$designation != '' ? $designation->id : ''}}" data-deptname="{{$deprtmentname !='' ? $deprtmentname->department_name : 'N/A'}}" data-deptid="{{$deprtmentname !='' ? $deprtmentname->id : ''}}" data-toggle="modal" data-target="#modal-profile-view" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                      <a  data-toggle="modal" data-userid="{{$user->id}}" data-designame="{{$designation != '' ? $designation->designation_name : 'N/A' }}" data-desigid ="{{$designation != '' ? $designation->id : ''}}" data-deptname="{{$deprtmentname !='' ? $deprtmentname->department_name : 'N/A'}}" data-deptid="{{$deprtmentname !='' ? $deprtmentname->id : ''}}"   data-target="#user-edit" class="edit_user" ><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <a data-userid="{{$user->id}}" class="delete_user" ><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
   </section>
   {{-- user update modal --}}
   <div class="modal fade" id="user-edit">
      <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Edit</h4>
        </div>
        <div class="modal-body">
            {!!Form::open(['method' => 'POST','id'=>'usereditform','enctype'=>'multipart/form-data'])!!}
            <div class="box-body">
              <div class="row">
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="username">User Name</label>
                           <input type="text" class="form-control" id="editname" name="name"  placeholder="Enter User Name">
                           <input type="hidden" class="form-control" id="userid" name="user_id" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="editemail" name="email"  placeholder="Enter Email">
                        </div>
                     </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="mobileno">Mobile No</label>
                          <input type="number" class="form-control" id="editmobileno" name="mobile_no"  placeholder="Enter Mobile No">
                      </div>
                   </div>
                   
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="email">NID</label>
                          <input type="text" class="form-control" id="editnid" name="nid"  placeholder="Enter NID Number">
                      </div>
                   </div>
                   
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="manager">Select Department</label>
                          <select id="editdeptselect" class="form-control select2" style="width: 100%;" name="department_id">
                              
                           </select>
                      </div>
                  </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="designation">Select Designation</label>
                           <select id="editdesigselect" class="form-control select2" style="width: 100%;" name="designation_id">
                            </select>
                       </div>
                   </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                         <label for="office_id">Office Id</label>
                         <input type="text" class="form-control" id="editofficeid" name="office_id" placeholder="Enter Office Id">
                         <input type="hidden" class="form-control" id="hiddenrole" name="hiddenrole" placeholder="Enter Office Id">

                     </div>
                  </div>
                  <div class="col-md-6">
                   <div class="form-group">
                       <label for="finp_id">Fingerprint Id</label>
                       <input type="text" class="form-control" id="editfinid" name="finger_id"  placeholder="Enter finger print Id">
                   </div>
                </div>
             </div>
              
               <div class="row">
                  <div class="col-md-12">
                      <img id="myImage" class="img-responsive" width="50" height="100" src="" alt="">
                  </div>
                </div>
               <div class="row">
                    <div class="col-md-6">
                      
                       <div class="form-group">
                           <label for="image">User Image</label>
                           <input type="file" class="form-control" id="editimage" name="image">
                       </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="editpass" name="password"  placeholder="Enter Password">
                        </div>
                     </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                       <div class="form-group customrole">
                           <label for="exampleInputEmail1">Select Role</label>
                           <select id="editroleset" class="form-control select2 myroleselected" style="width: 100%;" name="role">
                            
                           </select>
                      </div>
                  </div>
               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update User</button>
              </div>
             </div>
             {!!Form::close()!!}
        </div>
        
      </div>
    </div>
   </div>

   <div class="modal fade" id="modal-profile-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title" id="myModalLabel">More About <span class="profile_name"></span></h4>
                  </div>
              <div class="modal-body">
                  <center>
                    <img id="mymodal-profile-img" src="" name="image" width="140" height="140"  class="img-circle"></a>                 
                     <h3 class="media-heading "><span class="headname"></span> - <small class="topdesignation" ></small></h3>
                    <span><strong>Bio: </strong></span>
                    <span class="label label-warning department"></span>
                    <span class="label label-info designation"></span>
                  </center>
                  <hr>
                  <center>
                  <p class="text-left"><strong>Basic Info: </strong><br>
                    <ul class="personalinfo">
                        <li class="email"></li>
                        <li class="officeid"></li>
                        <li class="mobile"></li>
                        {{-- <li class="nid"></li> --}}
                      </ul>
                  <br>
                  </center>
              </div>
              <div class="modal-footer">
                  <center>
                  <button type="button" class="btn btn-default" data-dismiss="modal">I've heard enough about Joe</button>
                  </center>
              </div>
          </div>
      </div>
  </div>
  
<script> 
    //Edition of user

    $(document).on('click','.edit_user',function(){
      $('#editdeptselect').empty();
      $('#editdesigselect').empty();
      $('#editroleset').empty();
      var userid = $(this).data('userid');
        var d_id = $(this).data('deptid');
        var d_name =$(this).data('deptname');
        var des_name = $(this).data('designame');
        var des_id = $(this).data('desigid');
        if(d_id > 0){
          $('#editdeptselect').append(`<option selected="selected" value="`+d_id+`">`+d_name+`</option>`);
         } else{
          $('#editdeptselect').append(`<option selected="selected" value="">Select Department</option>`);
         }

         if(des_id > 0){
          $('#editdesigselect').append(`<option selected="selected" value="`+des_id+`">`+des_name+`</option>`);
         } else{
          $('#editdesigselect').append(`<option selected="selected" value="">Select Designation</option>`);
         }

      $.get('getusereditinfo/'+userid,function(data){
        console.log(data[1]);
        var img =data[0].image;
        var srcimg='/'+img;
        $('#usereditform #myImage').attr("src", srcimg);
        $('#usereditform').find('#editname').val(data[0].name);
        $('#usereditform').find('#editmobileno').val(data[0].mobile_no);
        $('#usereditform').find('#editemail').val(data[0].email);
        $('#usereditform').find('#userid').val(data[0].id);
        $('#usereditform').find('#editnid').val(data[0].nid);
        $('#usereditform').find('#editofficeid').val(data[0].office_id);
        $('#usereditform').find('#editfinid').val(data[0].finger_id);
        $('#usereditform').find('#hiddenrole').val(data[0].role);
        $.each(data[1],function(index,remainingdept){
          $('#editdeptselect').append(`<option  value="`+remainingdept.id+`">`+remainingdept.department_name+`</option>`);
        });
        $.each(data[2],function(index,remainingdesig){
          $('#editdesigselect').append(`<option  value="`+remainingdesig.id+`">`+remainingdesig.designation_name+`</option>`);
        });
        $.each(data[3],function(index,userrole){
          var userrolesele = data[0].role;
          var userroleid = userrole.id;
          if(userrolesele == userroleid){
            $('#editroleset').append(`<option selected = "selected" value="`+userrole.id+`">`+userrole.role_name+`</option>`);
          } else{
            $('#editroleset').append(`<option value="`+userrole.id+`">`+userrole.role_name+`</option>`);
          }
        })
       })
    });
          
   //User form validation script
   $(document).ready(function () {
      $('#userform').validate({ 
    rules: {
        name: 
        {
            required: true
        },
        mobile_no:
        {
            required:true,
            maxlength: 11
        },
        nid:
        {
            required:true,
            maxlength: 12
        },
        office_id:
        {
            required:true
        },
        finger_id:
        {
            required:true
        },
        email: 
        {
            required: true,
            betterEmail: true,
            remote: 
            {
              url: "uniqueemailchk"
            },
        },
        role:
        {
            required:true
        },
        // department_id:
        // {
        //     required:true
        // },
        image: 
        {
            required: true,
            extension: "jpg|png|jpeg"
        },
        password:
         {
            required: true,
            minlength:8
        }
    },
     messages: 
     {
        email: 
        {
            required:"Please enter an email address",
            email:"Please enter a valid email address",
            remote:("Email is already in use")
        },
        image: 
        {
            extension:("Only jpg,png,jpeg image is accepted")
        },
    },
    highlight: function(element) 
    {
        $(element).parent().addClass('has-error');
    },
    unhighlight: function(element)
    {
        $(element).parent().removeClass('has-error');
    },
    });
});

$.validator.addMethod('betterEmail', function (value, element) {
  return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
}, "Please enter a valid email address.");
//update form validation
$(document).ready(function () {
      $('#usereditform').validate({ 
    rules: {
        name: 
        {
            required: true
        },
        mobile_no:
        {
            required:true,
            maxlength: 11
        },
        nid:
        {
            required:true,
            maxlength: 12
        },
        office_id:
        {
            required:true
        },
        finger_id:
        {
            required:true
        },
        email: 
        {
            required: true,
            betterEmail: true,
            // remote: 
            // {
            //   url: "uniqueemailchk"
            // },
        },
        role:
        {
            required:true
        },
        // department_id:
        // {
        //     required:true
        // },
        image: 
        {
            extension: "jpg|png|jpeg"
        },
        password:
         {
            required: true,
            minlength:8
        }
    },
     messages: 
     {
        email: 
        {
            required:"Please enter an email address",
            email:"Please enter a valid email address",
            // remote:("Email is already in use")
        },
        image: 
        {
            extension:("Only jpg,png,jpeg image is accepted")
        },
    },
    highlight: function(element) 
    {
        $(element).parent().addClass('has-error');
    },
    unhighlight: function(element)
    {
        $(element).parent().removeClass('has-error');
    },
    });
});

$.validator.addMethod('betterEmail', function (value, element) {
  return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
}, "Please enter a valid email address.");

//Designation load insert
$(document).on('change','#departmentwiseloadchange',function(){
    var deptid  = $('#departmentwiseloadchange :selected').val();
    $('#deptwisedesig').empty();
    $('#roleset').empty();
    $.get('getdesignation/'+deptid,function(data){
        console.log(data[1]);
        $('#deptwisedesig').append('<option value=""  disable="true" selected="true">Select Designation</option>');
        $.each(data[0],function(index,desigantion){
        $('#deptwisedesig').append(`<option value="`+desigantion.id+`">`+desigantion.designation_name+`</option>`);
       });
       $('#roleset').append(`<option value="">Select Role</option>`);
       $.each(data[1],function(index,role){
        $('#roleset').append(`<option value="`+role.id+`">`+role.role_name+`</option>`);
       });
    });
  });
  //Designation load edit
  $(document).on('change','#editdeptselect',function(){
    var deptid  = $('#editdeptselect :selected').val();
    $('#editdesigselect').empty();
    $('#editroleset').empty();
    $.get('getdesignation/'+deptid,function(data){
        console.log(data);
        $('#editdesigselect').append('<option value=""  disable="true" selected="true">Select Designation</option>');
        $.each(data[0],function(index,desigantion){
        $('#editdesigselect').append(`<option value="`+desigantion.id+`">`+desigantion.designation_name+`</option>`);
       });
      //  $('#editroleset').append(`<option value="">Select Role</option>`);
       $.each(data[1],function(index,myrole){
        var userrolesele = $('#usereditform').find('#hiddenrole').val();
        console.log(userrolesele);
          var userroleid = myrole.id; 
          if(userrolesele == userroleid ){
            $('#editroleset').append(`<option selected=="selected" value="`+myrole.id+`">`+myrole.role_name+`</option>`);

          }else{
            $('#editroleset').append(`<option value="`+myrole.id+`">`+myrole.role_name+`</option>`);

          }
       });
    });
  });

  //User insertion
  $(document).on('submit','#userform', function(eveent){
     eveent.preventDefault();
        $.ajax({
            url:"{{route('user_options.store')}}",
            method:"POST",
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data)
            { 
            console.log(data);
            $('#userform').trigger('reset');
            toastr.options =
                   {
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "fadeIn": 300,
                    "fadeOut": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000
                    };
                    
                toastr.success('User Created Successfully');
                $('#img').attr('src', '');
                $('.ajaxuserprepend').prepend(`<tr class="unquser`+data.id+`">
                <td>`+data[0].name+`</td>
                <td>`+((data[1]=="N/A") ? "N/A" : data[1].department_name)+`</td>
                <td>`+((data[2]=="N/A") ? "N/A" : data[2].designation_name)+`</td>
                <td><img src="/`+data[0].image+`" width="100" height="50"></td>
                <td><a data-userid="`+data[0].id+`" class="profile-view" data-designame="`+((data[2]=="N/A") ? "N/A" : data[2].designation_name)+`" data-desigid ="`+((data[2]=="N/A") ? "" : data[2].id)+`" data-deptname="`+((data[1]=="N/A") ? "N/A" : data[1].department_name)+`" data-deptid="`+((data[1]=="N/A") ? "" : data[1].id)+`" data-toggle="modal" data-target="#modal-profile-view" " ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                <a data-toggle="modal" data-userid="`+data[0].id+`"  data-target="#user-edit" data-designame="`+((data[2]=="N/A") ? "N/A" : data[2].designation_name)+`" data-desigid ="`+((data[2]=="N/A") ? "" : data[2].id)+`" data-deptname="`+((data[1]=="N/A") ? "N/A" : data[1].department_name)+`" data-deptid="`+((data[1]=="N/A") ? "" : data[1].id)+`" class="edit_user"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                <a data-userid=`+data[0].id+` class="delete_user"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
            </tr>`);
         }
      })
  });
  //Profile show
  $(document).on('click','.profile-view',function(){
        var userid = $(this).data('userid');
        var deptname = $(this).data('deptname');
        var designame = $(this).data('designame');
        //alert(userid);
        $.get('getuserinfo/'+userid,function(data){
          // console.log(data.image);
            var img = data.image;
            var srcimg='/'+img;
            $('#modal-profile-view #mymodal-profile-img').attr("src", srcimg);
            $('#modal-profile-view').find('.profile_name').text(data.name);
            $('#modal-profile-view').find('.topdesignation').text(designame);
            $('#modal-profile-view').find('.department').text(deptname);
            $('#modal-profile-view').find('.designation').text(designame);
            $('#modal-profile-view').find('.email').text(data.email);
            $('#modal-profile-view').find('.headname').text(data.name);
            $('#modal-profile-view').find('.mobile').text(data.mobile_no);
            $('#modal-profile-view').find('.officeid').text(data.mobile_no);
            $('#modal-profile-view ').find('.nid').text(data.nid);
        });
  });
  //update info 
  $(document).on('submit','#usereditform', function(eveent){
    event.preventDefault();
    //alert('hi');
    $.ajax({
      url:"updateuser",
      method:"POST",
      data:new FormData(this),
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success:function(data)
      { 
        if(data[1] !=''){
                      var departmentname = data[1].department_name;
                      var departmentid = data[1].id;
                    } else{
                      var departmentname = 'N/A';
                      var departmentid = 0;

                    }

                    if(data[2] !=''){
                      var designationname = data[2].designation_name;
                      var designationid = data[2].id;
                     } else{
                      var designationname = 'N/A';
                      var designationid = 0;
                     }
        console.log(data);
        $('.unquser'+data[0].id).replaceWith(`<tr class="unquser`+data[0].id+`">
                <td>`+data[0].name+`</td>
                <td>`+data[1].department_name+`</td>
                <td>`+data[2].designation_name+`</td>
                <td><img src="/`+data[0].image+`" width="100" height="50"></td>
                <td><a data-userid="`+data[0].id+`" class="profile-view" data-designame="`+designationname+`" data-desigid ="`+designationid+`" data-deptname="`+departmentname+`" data-deptid="`+departmentid+`" data-toggle="modal" data-target="#modal-profile-view" " ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                <a data-toggle="modal" data-userid="`+data[0].id+`"  data-target="#user-edit" data-designame="`+designationname+`" data-desigid ="`+designationid+`" data-deptname="`+departmentname+`" data-deptid="`+departmentid+`" class="edit_user"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                <a data-userid=`+data[0].id+` class="delete_user"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
            </tr>`);
        $('#usereditform').trigger('reset');
        toastr.options = {
                      "debug": false,
                      "positionClass": "toast-bottom-right",
                      "onclick": null,
                      "fadeIn": 300,
                      "fadeOut": 1000,
                      "timeOut": 5000,
                      "extendedTimeOut": 1000
                    };
        setTimeout(function() {toastr.success('User Updated Successfully');}, 2000);
        setTimeout(function() {$('#user-edit').modal('hide');}, 1500);

      
      }
    })
  });
  //Delete user
  $(document).on('click','.delete_user',function(e) {
                e.preventDefault();
                var userid = $(this).data('userid');
                //alert(role);
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!',
                  
                }).then(result => {
                  
                  if (result.value) {
                    
                    $.get('deleteuser/'+userid,function(){
                        //console.log('yes');
                        
                   })
                   
                   $(this).closest('tr').hide();
                    
                  }
                 }
              )
       });
       //image preview script
       function readURL(input) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }else{
         $('#img').attr('src', '/assets/no_preview.png');
    }
}


$("#image").change(function(){ 
        readURL(this);
    });
</script>
@endsection