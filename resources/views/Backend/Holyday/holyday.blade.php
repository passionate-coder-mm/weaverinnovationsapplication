@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Holyday UI</h3>
            </div>
            {!!Form::open(['class'=>'form-horizontal','id'=>'holydayform','method' => 'post'])!!}
              <div class="box-body">
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-6">
                        <input type="text" name="date" class="form-control datepicker" id="holydaypicker" placeholder="Holyday Date">
                    </div> 
                </div>
                <div class="form-group">
                    <label for="attendanceid" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
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
                <h3 class="box-title">Holyday list</h3>
                 <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                  </div>
                 </div>
              <div class="box-body">
                <table id="example3" class="table table-bordered table-striped ajaxholyday">
                  <thead>
                  <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($holydayList as $holyday)
                  <tr class="unqholyid{{$holyday->id}}">
                    <td>{{$holyday->title}}
                    </td>
                    <td>{{$holyday->date}}</td>
                     <td><a data-holyid="{{$holyday->id}}" data-title="{{$holyday->title}}" data-date="{{$holyday->date}}"   data-toggle="modal" data-target="#modal-holyday" class="edit_holyday" ><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                    <a data-holyid="{{$holyday->id}}" class="deleteholyday"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
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
<div class="modal fade" id="modal-holyday">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Holyday</h4>
    </div>
    <div class="modal-body">
        {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'editholyday'])!!}
        <div class="box-body">
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-8">
                        <input type="text" name="date" class="form-control datepicker" id="holydaypicker1" placeholder="Holyday Date">
                        <input type="hidden" name="holydayid" class="form-control datepicker" id="holydayid" >

                    </div> 
                </div>
                <div class="form-group">
                    <label for="attendanceid" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="holydaytitle" name="title" placeholder="Enter Title">
                  </div>
                </div>
                </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
        {!!Form::close()!!}
    </div>
    </div>
</div>
</div>
<script>
     $( function() {
            $("#holydaypicker" ).datepicker();
            $(".datepicker").attr("autocomplete", "off");
            $("#holydaypicker1" ).datepicker();
            $(".datepicker1").attr("autocomplete", "off");
        });
$(document).ready(function () {
$('#holydayform').validate({ 
    rules: {
        title: 
        {
            required: true
            
        },
        date:
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
$(document).ready(function () {
$('#editholyday').validate({ 
    rules: {
        title: 
        {
            required: true
            
        },
        date:
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
//holyday Insertion
$(document).on('submit','#holydayform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    if ($('#holydayform').valid()) {
    $.ajax({
        url:"{{route('holyday-option.store')}}",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        { 
        $('#holydayform').trigger('reset');
        toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
        toastr.success('Holyday Created Successfully');
        $('.ajaxholyday').prepend(`<tr class="unqholyid`+data.id+`">
                <td>`+data.title+`
                </td>
                <td>`+data.date+`</td>
                    <td><a data-holyid="`+data.id+`" data-title="`+data.title+`" data-date="`+data.date+`"   data-toggle="modal" data-target="#modal-holyday" class="edit_holyday" ><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                <a data-holyid="`+data.id+`" class="deleteholyday"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
                </tr>`);          
    }
    });
    }
});
$(document).on('click','.edit_holyday',function(e){
    e.preventDefault();
    $('#editholyday').find('#holydaypicker1').val($(this).data('date'));
    $('#editholyday').find('#holydaytitle').val($(this).data('title'));
    $('#editholyday').find('#holydayid').val($(this).data('holyid'));
  })

  //holyday updation
$(document).on('submit','#editholyday',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    if ($('#editholyday').valid()) {
    $.ajax({
        url:"updateholyday",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        { 
        $('#holydayform').trigger('reset');
        toastr.options = {
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 2000
            };
        toastr.success('Holyday Updated Successfully');
      
        $('.unqholyid'+data.id).replaceWith(`<tr class="unqholyid`+data.id+`">
                <td>`+data.title+`
                </td>
                <td>`+data.date+`</td>
                    <td><a data-holyid="`+data.id+`" data-title="`+data.title+`" data-date="`+data.date+`"   data-toggle="modal" data-target="#modal-holyday" class="edit_holyday" ><span class="glyphicon glyphicon-edit btn btn-primary btn-sm"></span></a>
                <a data-holyid="`+data.id+`" class="deleteholyday"><span class="glyphicon glyphicon-trash btn btn-danger btn-sm"></span></a></td>
                </tr>`);          
    }
   });
   setTimeout(function() {$('#modal-holyday').modal('hide');}, 1500);
 }
});
$(document).on('click','.deleteholyday',function(e) {
    e.preventDefault();
    var holydayid = $(this).data('holyid');
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
    $.get('deleteholyday/'+holydayid,function(){
    })
    $(this).closest('tr').hide();
    }
   }
  )
});

</script>
@endsection