@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="box box-default">
         <div class="box-header with-border">
           <h3 class="box-title">Admin Dashboard</h3>
              <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
           </div>
         </div>
         {!!Form::open(['id'=>'departmentform','method' => 'post'])!!}
           <div class="box-body">
               <div class="row"> 
                  <div class="form-group">
                        <label for="departmentname" class="col-sm-2 control-label">Department Name</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" id="departmentname" name="department_name" placeholder="Enter Department Name">
                        </div>
                    </div>
               </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info">Create Department</button>
            </div>
         {!!Form::close()!!}
        </div>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Department list</h3>
               <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
               </div>
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped deprtmentprepend">
                <thead>
                <tr>
                  <th>Department Name</th>
                  <th>Manager</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($department_list as $department)
                <tr class="unqdeptid{{$department->id}}">
                    <td>{{$department->department_name}}</td>
                    <td>Win 95+</td>
                    <td><a data-deptname="{{$department->department_name}}" data-deptid ="{{$department->id}}" data-deptname="{{$department->department_name}}" data-toggle="modal" data-target="#edit-department" class="editdepartment"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <a class="deletedept" data-deptid="{{$department->id}}" ><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
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
    {{-- //department edit modal --}}
    <div class="modal fade" id="edit-department">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Department</h4>
            </div>
              <div class="modal-body">
                    {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'departmentedit'])!!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="teamname" class="col-sm-3 control-label">Department Name</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="edtdeptname" name="department_name" readonly>
                            <input type="text" class="form-control" id="deptid" name="dept_id" placeholder="Enter Designation Name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"> Manager</label>
                            <div class="col-sm-9">
                                <select id="deptmanager" class="form-control select2 " style="width: 100%;" name="maanger_id">
                                    <option value="">select Manager</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Assitant Manager</label>
                            <div class="col-sm-9">
                                <select id="deptassmanager" class="form-control select2 " style="width: 100%;" name="assmaanger_id">
                                    <option value="">select Assistant Manager</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                
                            <label for="inputPassword3" class="col-sm-3 control-label">Select Executives</label>
                            <div class="col-sm-9">
                                    <div class='shodepartmentmembers'></div>
                                    <select id="deptmembers" class="form-control select2" multiple="multiple" data-placeholder="Select members"
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
    <script>
        //Form validation Script
        $(document).ready(function () {
          $('#departmentform').validate({ 
            rules: {
                  department_name: 
                  {
                    required: true,
                    remote: {
                            url: "uniquenametest"
                    },
                 }
            },
            messages: {
                department_name: {
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
       //Department insertion
       $('#departmentform').on('submit',function(e){
          e.preventDefault();
          var data = $(this).serialize();
           $.ajax({
              url:"{{route('department_options.store')}}",
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
                        "extendedTimeOut": 1000
                      };
                toastr.success('Department Inserted Successfully');
                $('.deprtmentprepend').prepend(`<tr class="unqdeptid`+data.id+`"><td>`+data.department_name+`</td><td>Win 95+</td><td><a data-toggle="modal" data-target="#edit-department" class="editdepartment" data-deptname="`+data.department_name+`" data-deptid="`+data.id+`" ><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a> <a class="deletedept" data-deptid="`+data.id+`"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td></tr>`);          
                $('#departmentform').trigger('reset');
              }
          });
     });
     //edit department
     $(document).on('click','.editdepartment',function(){
       var dept_id = $(this).data('deptid');
       var dept_name = $(this).data('deptname');
       $('#departmentedit').find('#edtdeptname').val(dept_name);
       $('#deptmanager').empty();
       $.get('getdeptinfo/'+dept_id,function(data){
 
         $.each(data[0],function(index,manager){
           $('#deptmanager').append(`<option value="`+manager.id+`">`+manager.name+`</option>`);
         })
        //  console.log(data);
       })
     })
     //Deletion script
     $(document).on('click','.deletedept',function(e) {
        e.preventDefault();
        var deptid = $(this).data('deptid');
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
             $.get('deletedept/'+deptid,function(){
            })
            $(this).closest('tr').hide();
              }
          })
      });
    </script>
@endsection