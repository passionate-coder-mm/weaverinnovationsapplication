@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Role</h3>
        </div>
        {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'roleform'])!!}
        <div class="box-body">
        <div class="form-group">
            <label for="rolename" class="col-sm-2 control-label">Role Name</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" id="rolename" name="role_name" placeholder="Enter Role Name">
            <span class="message"></span>
            </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-info btn_CommitAll" id="create_role">Create Role</button>
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
                <table id="example3" class="table table-bordered table-striped ajaxprependrole">
                  <thead>
                  <tr>
                    <th>Role Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($role_list as $role)
                  <tr class='roleunq{{$role->id}}'>
                    <td>{{$role->role_name}}</td>
                    <td><a data-roleid="{{$role->id}}"  data-role="{{$role->role_name}}" data-toggle="modal" data-target="#modal-role" class="edit_modal"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
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
      <div class="modal fade" id="modal-role">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Role</h4>
            </div>
            <div class="modal-body">
                {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'editrole'])!!}
                
                <div class="form-group">
                 <div class="box-body">
                  <label for="rolename" class="col-sm-4 control-label">Role Name</label>
                    <div class="col-sm-8">
                     <input type="text" class="form-control" id="editrolename" name="role_name" value="">
                     <span class="edtunqerrtxt"></span>
                     <input type="hidden" class="form-control" id="roleid" name="role_id" value="" >
                  </div>
                  </div>
                  </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              {!!Form::close()!!}
            </div>
            
          </div>
         
        </div>
       
      </div>
    <script>
        $(document).ready(function () {
               $('#roleform').validate({ 
                rules: {
                    role_name: {
                         required: true,
                         remote: {
                            url: "uniquetest",
                            complete: function(data){
                                if(data.responseText=='Name is already taken'){
                                }
                            
                            }
                        },
                      }
                   },
                   messages: {
                    role_name: {
                          remote:("Name is already in use")
                        },
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
              $('#editrole').validate({ 
                rules: {
                    role_name: {
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
        //Unique role check
        // $("#rolename").on('blur',function(){
        //     var rolename = $('#roleform').find('#rolename').val();
        //     //alert(rolename);
        //     $.get('uniquetest/'+rolename,function(response){
        //     console.log(response);
        //     $('#roleform').find('.message').html(response);
        //     $('#roleform').find('.message').css("color",'red');
        //     });
        //  }); 

         //Role insertion
         $(document).on('submit','#roleform',function(e){
            e.preventDefault();
            var data = $(this).serialize();
           if ($('#roleform').valid()) {
            $.ajax({
                url:"{{route('role_options.store')}}",
                method:"POST",
                data:data,
                dataType:"json",
                success:function(data)
               
                {
                  console.log(data);
                 toastr.options = {
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "fadeIn": 300,
                        "fadeOut": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000
                    };
                    $('#roleform').trigger('reset');
                    toastr.success('Role Created Successfully');
                    $('.ajaxprependrole').prepend(`<tr class="roleunq`+data.id+`"><td>`+data.role_name+`</td><td><a data-toggle="modal" data-target="#modal-role" class="edit_modal" data-role="`+data.role_name+`" data-roleid="`+data.id+`"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a></td></tr>`);          
                }
            });
         }
        });
        //edition of role
        $(document).on('click','.edit_modal',function(e){
              e.preventDefault();
              $('#editrole').find('#editrolename').val($(this).data('role'));
              $('#editrole').find('#roleid').val($(this).data('roleid'));
        })
        //updation of role
        $('#editrole').on('submit',function(e){
          var roelid = $('#editrole').find('#roleid').val();
            e.preventDefault();
            var data = $(this).serialize();
              $.ajax({
                url:"updaterole",
                method:"POST",
                data:data,
                dataType:"json",
                success:function(data)
                {
                  //console.log(data);
                  $('#roleform').trigger('reset');
                  toastr.options = {
                          "debug": false,
                          "positionClass": "toast-bottom-right",
                          "onclick": null,
                          "fadeIn": 300,
                          "fadeOut": 1000,
                          "timeOut": 5000,
                          "extendedTimeOut": 1000
                        };
                  setTimeout(function() {toastr.success('Role Updated Successfully');}, 2000);
                    
                    $('.roleunq'+data.id).replaceWith(`<tr class="roleunq`+data.id+`"><td>`+data.role_name+`</td><td><a data-toggle="modal" data-target="#modal-role" class="edit_modal" data-role="`+data.role_name+`" data-roleid="`+data.id+`"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a></td></tr>`);          
                    setTimeout(function() {$('#modal-role').modal('hide');}, 1500);
                }
            });
       });
</script>
@endsection