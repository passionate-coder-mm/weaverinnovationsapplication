@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Designation</h3>
    </div>
    {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'designationform'])!!}
        <div class="box-body">
           
            <div class="form-group">
               <label for="designame" class="col-sm-2 control-label">Designation Name</label>
                <div class="col-sm-6 no-error">
                <input type="text" class="form-control" id="designame" name="designation_name" placeholder="Enter Designation Name">
                <label id="designameunq-error" class="error" for="designame"></label>
              </div>
           </div>
           <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Select Department</label>
               <div class="col-sm-6">
               <select id="departmentselection" class="form-control select2 " style="width: 100%;" name="department_id">
                   <option clss="removeable" value="">Select department</option>
                   @foreach($department_list as $department)
                       <option value="{{$department->id}}">{{$department->department_name}}</option>
                   @endforeach
               </select>
           </div>
           </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-info" id="desicreat">Create Designation</button>
        </div>
        {!!Form::close()!!}
    </div>
</section>
<section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Designation list</h3>
                 <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                  </div>
                 </div>
              <div class="box-body">
                <table id="example3" class="table table-bordered table-striped ajaxprependdesig">
                  <thead>
                  <tr>
                    <th>Designation Name</th>
                    <th>Department Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($designation_list as $designation)
                  <tr class="unqdesigid{{$designation->desigid}}">
                    <td>{{$designation->designation_name}}
                    </td>
                    <td>{{$designation->department_name}}</td>
                     <td><a data-desigid="{{$designation->desigid}}" data-designame="{{$designation->designation_name}}" data-deptname="{{$designation->department_name}}" data-deptid = "{{$designation->department_id}}"  data-toggle="modal" data-target="#modal-desig" class="edit_desig" ><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <a data-desigid ="{{$designation->desigid}}" class="deletedesignation"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
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
        <div class="modal fade" id="modal-desig">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Edit Designation</h4>
                </div>
                <div class="modal-body">
                   {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'editdesig'])!!}
                    <div class="form-group">
                        <div class="box-body">
                         <label for="designame" class="col-sm-4">Designation Name</label>
                          <div class="col-sm-8 no-error">
                          <input type="text" class="form-control" id="desig_name" name="designation_name" value>
                          <input type="hidden" class="form-control" id="desigid" name="designation_id" value>
                           <span class="desiger"></span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="box-body">  
                        <label for="department_name" class="col-sm-4">Select Department</label>
                        <div class="col-sm-8">
                          <select class="form-control select2 mydeptselected" style="width: 100%;" name="department_id">
                          </select>
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
      </section>
    <script>
//designation creation form validation
$(document).ready(function () {
    $('#designationform').validate({ 
        rules: {
            designation_name: 
            {
              required: true
              
            },
            department_id:
            {
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
    // jQuery.validator.addMethod('selectcheck', function (value) {
    //     return (value != '0');
    //     }, "Select Departmetn");
});

//onchange designation uniquechk for speific department
$(document).on('change','#departmentselection',function(){
    var designation = $('#designationform').find('#designame').val();
    var deptid  = $('#departmentselection :selected').val();
    if(designation ==''){
        alert('First write desgnation Name');
        $('#departmentselection').append(`<option selected='selected' value="">Select department</option>`);
    }else{
    $.get('uniqdesignation/'+deptid+'/'+designation,function(data){
        if(data == 'exist'){
        $('#designationform').find('.no-error').addClass('has-error');
        $('#designationform').find('#designameunq-error').css('display','block');
        $('#designationform').find('#designameunq-error').text('Designation is already exist for this department')
          $('#desicreat').prop('disabled', true)
        }else{
          $('#designationform').find('.no-error').removeClass('has-error');
          $('#designationform').find('#designameunq-error').css('display','none');
          $('#designationform').find('#designameunq-error').text('');
          $('#desicreat').prop('disabled', false);
        }
    });
  }
})

//designation edit form validation
 $(document).ready(function () {
    $('#editdesig').validate({ 
        rules: {
            designation_name:
             {
               required: true
              },
            department_id:  
            {
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
//Desigantion Insertion
$(document).on('submit','#designationform',function(e){
    e.preventDefault();
     var data = $(this).serialize();
     if ($('#designationform').valid()) {
        $.ajax({
          url:"{{route('designation_options.store')}}",
          method:"POST",
          data:data,
          dataType:"json",
          success:function(data)
          { 
          $('#designationform').trigger('reset');
          toastr.options = {
                  "debug": false,
                  "positionClass": "toast-bottom-right",
                  "onclick": null,
                  "fadeIn": 300,
                  "fadeOut": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 2000
              };
          toastr.success('Designation Created Successfully');
          $('.ajaxprependdesig').prepend(`<tr class="unqdesigid`+data.desigid+`"><td>`+data.designation_name+`</td><td>`+data.department_name+`</td><td><a data-desigid=`+data.desigid+` data-deptid =`+data.department_id+` data-designame="`+data.designation_name+`" data-deptname="`+data.department_name+`"  data-toggle="modal" data-target="#modal-desig" class="edit_desig"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a> <a  data-desigid="`+data.desigid+`" class="deletedesignation"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm "></span></a></td></tr>`);          
          $('#departmentselection').append(`<option selected='selected' value="">Select department</option>`);
        }
      });
    }
});
//Edit designation
$(document).on('click','.edit_desig',function(e){
    $('.mydeptselected').empty();
    e.preventDefault();
    $('#editdesig').find('#desig_name').val($(this).data('designame'));
    $('#editdesig').find('#desigid').val($(this).data('desigid'));
    var deptid = $(this).data('deptid');
    var deptname= $(this).data('deptname');
    $('#editdesig').find('.mydeptselected').append(`<option selected="selected" value="`+deptid+`">`+deptname+`</option>`);
    $.get('remainingdepartment/'+deptid,function(data){
        $.each(data,function(index,remainingdept){
        $('#editdesig').find('.mydeptselected').append(`<option  value="`+remainingdept.id+`">`+remainingdept.department_name+`</option>`);
    })
  })
})
   
//Update Designation
$(document).on('submit','#editdesig',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
    url:"updatedesignation",
    method:"POST",
    data:data,
    dataType:"json",
    success:function(data)
    { 
      if(data =='exist'){
        $('#editdesig').find('.no-error').addClass('has-error');
        $('#editdesig').find('.desiger').text('This designation is already taken for this department')
        $('.desiger').css('color','red');
      }else{
        $('#editdesig').trigger('reset');
        $('#editdesig').find('.no-error').removeClass('has-error');
        $('#editdesig').find('.desiger').text('')

        toastr.options = {
              "debug": false,
              "positionClass": "toast-bottom-right",
              "onclick": null,
              "fadeIn": 300,
              "fadeOut": 1000,
              "timeOut": 5000,
              "extendedTimeOut": 1000
        };
        setTimeout(function() {toastr.success('Designation Updated Successfully');}, 2000);
        $('.unqdesigid'+data.desigid).replaceWith(`<tr class="unqdesigid`+data.desigid+`"><td>`+data.designation_name+`</td><td>`+data.department_name+`</td><td><a data-desigid=`+data.desigid+` data-deptid =`+data.department_id+` data-designame="`+data.designation_name+`" data-deptname="`+data.department_name+`" data-toggle="modal" data-target="#modal-desig" class="edit_desig"><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a> <a  data-desigid="`+data.desigid+`" class="deletedesignation"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm "></span></a></td></tr>`);          
        setTimeout(function() {$('#modal-desig').modal('hide');}, 1500);
        $('.ajaxprependdesig').prepend(); 
    }         
    }
  });
});
//Delete script
$(document).on('click','.deletedesignation',function(e) {
    e.preventDefault();
    var designationid = $(this).data('desigid');
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
    $.get('deletedesig/'+designationid,function(){
    })
    $(this).closest('tr').hide();
    }
   }
  )
});
</script>
@endsection