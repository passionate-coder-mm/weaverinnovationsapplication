@extends('Backend.admin_master')
@section('main-content')
<section class="content">
@php
    if(Auth::check()){
         $user = Auth::user();
         $user_id = $user->id;
         $user_role= $user->role;
       }else{
        return redirect('login');
       }
       //dd($data);
@endphp
    <div class="box box-info">
         <div class="box-header with-border">
         <h3 class="box-title">Conveyance Voucher</h3>
             <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
         </div>
         {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'conveyanceform'])!!}
               
         <div class="box-body">
                <div class="box-header with-border">
                    <div class="custom-control-lg custom-control custom-checkbox">

                        <input class="custom-control-input col-sm-4" id="checkbox-large" type="checkbox" name="general-chk" value="">
                        <label style="padding: 5px;">General</label>
                    </div>
                 <div class="form-group proname">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="projectname" name="project_name" placeholder="Enter Project Name">
                       <input type="hidden" class="form-control" id="userid" name="user_id" value="{{$user_id}}">

                    </div>
                </div>
            </div>
            <div class="list" data-index_no="0">
                <div class="itemWrapper">
                    <table class="table table-bordered moreTable">
                        <tr>
                            <th width="15%">Date</th>
                            <th width="15%">From</th>
                            <th width="15%">To</th>
                            <th width="15%">Mode</th>
                            <th width="15%">Purpose</th>
                            <th width="15%">Amount</th>
                            <th width="10%">Option</th>
                        </tr>

                        <tr class="item_tr single_list">
                            <td><input type="text" class="form-control mydatepicker date" id="pro_date"   name="program[0][date]"></td>
                            <td><input type="text" class="form-control from" id="pro_from" name="program[0][from]"><br></td>
                            <td><input type="text" class="form-control to" id="pro_to" name="program[0][to]"><br></td>
                            <td> <select  class="form-control select2 select2-select mode" id="pro_mode" style="width: 100%;" name="program[0][mode]">
                                    <option value="">Select Mode</option>
                                    <option value="Rickshaw">Rickshaw</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Uber/Pathao">Uber/Pahao</option>
                                </select><br></td>
                                <td> <select id="pro_purpose" class="form-control select2 select2-select purpose" style="width: 100%;" name="program[0][purpose]">
                                        <option value="">Select Purpose</option>
                                        <option value="Purpose one">Purpose one</option>
                                        <option value="Purpose two">Purpose one</option>
                                        <option value="Purpose three">Purpose three</option>
                                        <option value="Purpose four">Purpose four</option>
                                    </select><br></td>
                                    <td><input type="number" class="form-control amount" id="pro_amount" name="program[0][amount]"><br></td>
                            <td><span class="remove" style="background: #ed3610;padding: 8px 10px;color: #fff;border-radius: 6%;text-decoration: none;cursor:pointer">-</span></td>
                        </tr>

                    </table>
                    <span  class="add_more" style="background: #28d19c;
                                                            padding: 8px 21px;
                                                            color: #fff;
                                                            border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                </div>
            </div>
             
         </div>
         <div class="box-footer">
             <button type="submit" class="btn btn-info">Submit</button>
         </div>
     {!!Form::close()!!}
     </div>
 </section>
<section class="content">
<div class="row">
    <div class="col-xs-12">
    <div class="box box-info">
        <div class="box-header">
        <h3 class="box-title">Conveyance Processing List</h3>
            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
        <div class="box-body">
        <table id="example3" class="table table-bordered table-striped conveyanceappend">
            <thead>
            <tr>
            <th>Submited date</th>
            <th>Project Name</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
            </thead>
            @if($user_role == 5)
            <tbody>
                @foreach($data['executive_con'] as $conveyance_list)
                <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                    <td>{{$conveyance_list->created_at}}</td>
                    <td>
                    {{$conveyance_list->project_name == null ? 'Genaral' : $conveyance_list->project_name}}
                    </td>
                    <td>{{$conveyance_list->total}} Tk</td>
                    <td>{{$conveyance_list->status}}</td>
                    <td>
                        <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                      @if($conveyance_list->status == 'ACC')
                      <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class=""><span class="btn btn-success btn-sm">QR</span></a>
                      @elseif($conveyance_list->review=='yes')
                      <a data-toggle="modal" data-target="#editbillModal" data-unqid ="{{$conveyance_list->unq_id}}" class="edit"><span class="btn btn-warning btn-sm">Reviewit</span></a>

                      @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            @elseif($user_role == 3)
            <tbody>
                    @foreach($data['manager_con'] as $conveyance_list)
                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                        <td>{{$conveyance_list->created_at}}</td>
                        <td>
                        {{$conveyance_list->project_name == null ? 'Genaral' : $conveyance_list->project_name}}
                        </td>
                        <td>{{$conveyance_list->total}} Tk</td>
                        <td>{{$conveyance_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($conveyance_list->status == 'ACC')
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class=""><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($conveyance_list->review=='yes')
                            <a data-toggle="modal" data-target="#editbillModal" data-unqid ="{{$conveyance_list->unq_id}}" class="edit"><span class="btn btn-warning btn-sm">Reviewit</span></a>
      
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 4)
               <tbody>
                    @foreach($data['assmanager_con'] as $conveyance_list)
                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                        <td>{{$conveyance_list->created_at}}</td>
                        <td>
                        {{$conveyance_list->project_name == null ? 'Genaral' : $conveyance_list->project_name}}
                        </td>
                        <td>{{$conveyance_list->total}} Tk</td>
                        <td>{{$conveyance_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($conveyance_list->status == 'ACC')
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class=""><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($conveyance_list->review=='yes')
                            <a data-toggle="modal" data-target="#editbillModal" data-unqid ="{{$conveyance_list->unq_id}}" class="edit"><span class="btn btn-warning btn-sm">Reviewit</span></a>
      
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 6)
                  <tbody>
                    @foreach($data['ceo_con'] as $conveyance_list)
                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                        <td>{{$conveyance_list->created_at}}</td>
                        <td>
                        {{$conveyance_list->project_name == null ? 'Genaral' : $conveyance_list->project_name}}
                        </td>
                        <td>{{$conveyance_list->total}} Tk</td>
                        <td>{{$conveyance_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($conveyance_list->status == 'ACC')
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class=""><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($conveyance_list->review=='yes')
                            <a data-toggle="modal" data-target="#editbillModal" data-unqid ="{{$conveyance_list->unq_id}}" class="edit"><span class="btn btn-warning btn-sm">Reviewit</span></a>
      
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 7)
                 <tbody>
                    @foreach($data['cfo_con'] as $conveyance_list)
                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                        <td>{{$conveyance_list->created_at}}</td>
                        <td>
                        {{$conveyance_list->project_name == null ? 'Genaral' : $conveyance_list->project_name}}
                        </td>
                        <td>{{$conveyance_list->total}} Tk</td>
                        <td>{{$conveyance_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($conveyance_list->status == 'ACC')
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class=""><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($conveyance_list->review=='yes')
                            <a data-toggle="modal" data-target="#editbillModal" data-unqid ="{{$conveyance_list->unq_id}}" class="edit"><span class="btn btn-warning btn-sm">Reviewit</span></a>
      
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<div class="modal fade" id="billModal" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Bill Details</h4>
            </div>
            <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="15%">From</th>
                                <th width="15%">To</th>
                                <th width="15%">Mode</th>
                                <th width="20%">Purpose</th>
                                <th width="15%">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="billinfo">

                        </tbody>
                    </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="editbillModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Bill</h4>
                </div>
                {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'editbillform'])!!}
                <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="20%">Date</th>
                                    <th width="15%">From</th>
                                    <th width="15%">To</th>
                                    <th width="15%">Mode</th>
                                    <th width="20%">Purpose</th>
                                    <th width="15%">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="editbillinfo">
    
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                   <button type="submit" class="btn btn-info">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!!Form::close()!!}
              </div>
            </div>
          </div>
</section>
<script>
$("#checkbox-large").click( function(){
    var chk= $(this).is(':checked') ? 1 : 0;
    //alert(chk);
    if(chk==1){
        $('.proname').hide();
    }else{
        $('.proname').show();
    }
});
  $('body').on('focus',".mydatepicker", function(){
    $(this).datepicker();
});

  $(document).ready(function () {
    $('.select2-select').select2();
    $(document).on('click', '.add_more', function () {
        var date =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.date').val();
        var from =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.from').val();
        var to =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.to').val();
        var amount =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.amount').val();
        var mode =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.mode').val();
        var purpose =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.purpose').val();   
        if(date ==''|| from=='' || to=='' || amount=='' || mode=='' || purpose==''){
            alert('Please fill all field first');
        }else{
            $('.select2-select').select2('destroy');
        var index = $('.list').data('index_no');
        $('.list').data('index_no', index + 1);
        var html = $('.itemWrapper .item_tr:last').clone().find('.form-control').each(function () {
            this.name = this.name.replace(/\d+/, index+1);
            this.id = this.id.replace(/\d+/, index+1);
            this.value = '';
        }).end();
        var $clone = $('.moreTable').append(html);
        var rowCount = $('.moreTable tr').length;
        // $(this).closest('.itemWrapper').find('.item_tr:last').find('.select2-select').select2('destroy');
         $(this).closest('.itemWrapper').find('.item_tr:last').find('.dayval').val(rowCount-1);
        $('.select2-select').select2();
        }
        
    });

    $(document).on('click', '.remove', function () {
        
        var count= $('.single_list').length;
        if(count == 1){
            alert("you can't remove it");
        }else{
         $(this).closest('tr').remove();

        }
    });
});

$(document).on('submit','#conveyanceform',function(e){
    e.preventDefault();
    var chk= $('#checkbox-large').is(':checked') ? 1 : 0;
    var project_name= $('#projectname').val();
    var date =  $('.add_more').closest('.itemWrapper').find('.item_tr:last').find('.date').val();
        var from =  $('.add_more').closest('.itemWrapper').find('.item_tr:last').find('.from').val();
        var to =  $('.add_more').closest('.itemWrapper').find('.item_tr:last').find('.to').val();
        var amount =  $('.add_more').closest('.itemWrapper').find('.item_tr:last').find('.amount').val();
        var mode =  $('.add_more').closest('.itemWrapper').find('.item_tr:last').find('.mode').val();
        var purpose =  $('.add_more').closest('.itemWrapper').find('.item_tr:last').find('.purpose').val();   
     if(chk== 0 && project_name =='' ){
         alert("Please write Project Name");
     }else if(date ==''|| from=='' || to=='' || amount=='' || mode=='' || purpose==''){
        alert("Please Fill all fields first");
     }else{
        var data = $(this).serialize();
     $.ajax({
        url:"{{route('transport-voucher.store')}}",
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
                        "extendedTimeOut": 3000
                      };
                toastr.success('Your bill was submitted successfully');
           $('.conveyanceappend').prepend(`<tr class="unqconveyance`+data.conveyance.unq_id+`">
                <td>`+data.submited_date+`</td>
                <td>`+((data.conveyance.project_name ==null) ? 'Genaral' : data.conveyance.project_name )+`</td>
                <td>`+data.total+`</td>
                <td>`+data.conveyance.status+`</td>
                <td>
                 <a data-toggle="modal" data-target="#billModal" class="showbill" data-unqid="`+data.conveyance.unq_id+`"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                </td>
            </tr>`);
        }
     });
    }
});
$(document).on('click','.showbill',function(){
    var unq_id = $(this).data('unqid');
   
    $.get('getallbillinfoByid/'+unq_id,function(data){
        $('.billinfo').empty();
        $.each(data,function(index, billInfo){
          
         $('.billinfo').append(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                            <td><input type="text" class="form-control from" value="`+billInfo.from+`" readonly><br></td>
                            <td><input type="text" class="form-control"  value="`+billInfo.to+`" readonly><br></td>
                            <td><input type="text" class="form-control"  value="`+billInfo.mode+`" readonly><br></td>
                            <td><input type="text" class="form-control" value="`+billInfo.purpose+`" readonly><br></td>
                            <td><input type="number" class="form-control" value="`+billInfo.amount+`" readonly><br></td>
                        </tr>`)
        })
        //$('.modal-body').replaceWith('blabla');
       console.log(data);
    })
})

$(document).on('click','.edit',function(){
    var unq_id = $(this).data('unqid');
   //alert(unq_id);
    $.get('getallbillinfoByid/'+unq_id,function(data){
        $('.editbillinfo').empty();
       
            $('.modal-body').prepend(` <input type="text" class="form-control" name="project_name"  value="`+data[0].project_name+`" >`);
       
         $('.modal-body').prepend(` <input type="hidden" class="form-control" name="user_id"  value="`+data[0].user_id+`" >`);
         $('.modal-body').prepend(` <input type="hidden" class="form-control" name="designation_name"  value="`+data[0].designation_name+`" >`);
         $('.modal-body').prepend(` <input type="hidden" class="form-control" name="unq_id" id="unqid"  value="`+data[0].unq_id+`" >`);

        $.each(data,function(index, billInfo){
          
         $('.editbillinfo').append(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control" name="program[`+index+`][date]"  value="`+billInfo.date+`" ></td>
                            <td><input type="text" class="form-control from" name="program[`+index+`][from]" value="`+billInfo.from+`"><br></td>
                            <td><input type="text" class="form-control" name="program[`+index+`][to]"  value="`+billInfo.to+`" ><br></td>
                            <td><input type="text" class="form-control" name="program[`+index+`][mode]"  value="`+billInfo.mode+`" ><br></td>
                            <td><input type="text" class="form-control" name="program[`+index+`][purpose]" value="`+billInfo.purpose+`"><br></td>
                            <td><input type="number" class="form-control" name="program[`+index+`][amount]" value="`+billInfo.amount+`">

                        </tr>`)
        })
        //$('.modal-body').replaceWith('blabla');
       console.log(data);
    })
})
$(document).on('submit','#editbillform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var unq_id = $('#editbillform').find('#unqid').val();
    

    //alert(unq_id);
    $('.unqconveyance'+unq_id).remove();
    $.ajax({
        url:"/transport/updatebillinfo",
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
                        "extendedTimeOut": 3000
                      };
                toastr.success('Your bill was Resubmitted successfully');


                $('.conveyanceappend').append(`<tr class="unqconveyance`+data.conveyance.id+`">
                        <td>`+data.submited_date+`</td>
                        <td>`+((data.conveyance.project_name ==null) ? 'Genaral' : data.conveyance.project_name )+`</td>
                        <td>`+data.total+`</td>
                        <td>`+data.conveyance.status+`</td>
                        <td>
                        <a data-toggle="modal" data-target="#billModal" class="showbill" data-unqid="`+data.conveyance.unq_id+`"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                        </td>
                    </tr>`);
                    setTimeout(function() {$('#editbillModal').modal('hide');}, 1500);
            console.log(data);
        }
    });

})
</script>
@endsection