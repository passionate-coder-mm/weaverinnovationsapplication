@extends('Backend.admin_master')
@section('main-content')
<section class="content">
<script type="text/javascript" src="{{asset('themeasset/printThis.js')}}" ></script>

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
             <h3 class="box-title">Cash Voucher</h3>
                 <div class="box-tools pull-right">
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
             </div>
             </div>
             {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'cashvoucher'])!!}
                   
             <div class="box-body">
                    <div class="box-header with-border">
                     <div class="form-group">
                                   <div class="col-sm-6 projectselectboxall">
                                       <select  class="form-control select2 select2-select project_nameall" id="pro_name" style="width: 100%;" name="project_nameall">
                                            <option value="">Select Project</option>
                                            @foreach($data['project-name'] as $projectname)
                                             <option value="{{$projectname->id}}">{{$projectname->project_name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 projectselectboxg" style="display:none">
                                        <select  class="form-control select2 select2-select project_nameg" id="pro_name" style="width: 100%;" name="project_nameg">
                                            <option value="4">General</option>
                                         </select>        
                                    </div>
                       <div class="col-sm-6">
                        <div class="custom-control-lg custom-control custom-checkbox">
                         <div class="col-sm-3">
                            <input class="custom-control-input col-sm-4 cash_type" id="checkbox-large" type="checkbox" name="general_chk" value="Expense">
                            <label style="padding: 5px;">Expense</label>
                         </div>
                         <div class="col-sm-3">
                            <input class="custom-control-input col-sm-4 cash_type" id="checkbox-large" type="checkbox" name="general_chk" value="Advance">
                            <label style="padding: 5px;">Advance</label>
                        </div>
                       
                        </div>
                    </div>
                        
                    </div>
                </div>
                <div class="list" data-index_no="0">
                    <div class="itemWrapper">
                        <table class="table table-bordered moreTable1">
                            <tr>
                                <th width="15%">Date</th>
                                <th width="35%">Description</th>
                                <th width="20%">Amount</th>
                                {{-- <th width="20%">Total</th> --}}
                                <th width="10%">Option</th>
                            </tr>
    
                            <tr class="item_tr single_list">
                                <td><input type="text" class="form-control mydatepicker date" id="pro_date"   name="program[0][date]"></td>
                                <td><textarea  class="form-control description" id="pro_description" name="program[0][description]" rows="1"></textarea><br></td>
                                 <td><input type="number" class="form-control amount" id="pro_amount" name="program[0][amount]"><br></td>
                                 {{-- <td><input type="number" class="form-control total" id="pro_total" name="program[0][total]" readonly><br></td> --}}
                                <td><span class="remove" style="background: #ed3610;padding: 8px 10px;color: #fff;border-radius: 6%;text-decoration: none;cursor:pointer">-</span></td>
                            </tr>
                        </table>
                           
                        <span  class="add_more" style="background: #28d19c;
                                                                padding: 8px 21px;
                                                                color: #fff;
                                                                border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                     <div class="text-center">Total : <input type="hiddentext" class="assistant" readonly></div>
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
        {{-- <h3 class="box-title">Cash Voucher Processing List</h3> --}}
            
            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
<ul class="nav nav-tabs">
    <li class="active commonlitabforcash"><a data-toggle="tab" href="#home">Advanced </a></li>
    <li class="commonlitabforcash"><a data-toggle="tab" href="#menu2">Advance Succeed</a></li>
    <li class="commonlitabforcash"><a data-toggle="tab" href="#menu5">Request Advance Expenses</a></li>
    <li class="commonlitabforcash"><a data-toggle="tab" href="#menu4">Success Settled list</a></li>
    <li class="commonlitabforcash"><a data-toggle="tab" href="#menu1">Expense </a></li>
    <li class="commonlitabforcash"><a data-toggle="tab" href="#menu3">Expense Succeed</a></li>
</ul>
<div class="tab-content">
<div id="home" class="tab-pane fade in active">
 <div class="box-body">
        <table id="example3" class="table table-bordered table-striped cashappend">
            <thead>
            <tr>
            <th>Submited date</th>
            <th>Project Name</th>
            <th>Type</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
            </thead>
            @if($user_role == 5)
            <tbody>
                @foreach($data['for_executive'] as $cash_list)
                <tr class="unqcash{{$cash_list->unq_id}}">
                    <td>{{$cash_list->created_at}}</td>
                    <td>
                    {{$cash_list->project_name}}
                    </td>
                    <td>{{$cash_list->type}}</td>
                    <td>{{$cash_list->total}} Tk</td>
                    <td>{{$cash_list->status}}</td>
                    <td>
                        <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                        @if($cash_list->status == 'ACC')
                       <a data-toggle="modal" data-type="{{$cash_list->type}}"  data-unqid ="{{$cash_list->unq_id}}" class="advanceqr"  ><span class="btn btn-success btn-sm">QR</span></a>
                        @elseif($cash_list->review=='yes')
                        <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>

                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            @elseif($user_role == 3)
            <tbody>
                    @foreach($data['for_manager'] as $cash_list)
                    <tr class="unqcash{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            {{-- @if($cash_list->type =='Advance')                        
                            <a data-toggle="modal" data-target="" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm">Settle</a>
                            @endif --}}
                            @if($cash_list->status == 'ACC')
                            <a data-toggle="modal"  data-type="{{$cash_list->type}}" data-unqid ="{{$cash_list->unq_id}}" class="advanceqr"><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 4)
                <tbody>
                    @foreach($data['for_assmng'] as $cash_list)
                    <tr class="unqconveyance{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            {{-- @if($cash_list->type =='Advance')                        
                            <a data-toggle="modal" data-target="" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm">Settle</a>
                                @endif --}}
                                @if($cash_list->status == 'ACC')
                                <a data-toggle="modal"  data-type="{{$cash_list->type}}" data-unqid ="{{$cash_list->unq_id}}" class="advanceqr"><span class="btn btn-success btn-sm">QR</span></a>
                               @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 6)
                    <tbody>
                    @foreach($data['for_ceo'] as $cash_list)
                    <tr class="unqconveyance{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            {{-- @if($cash_list->type =='Advance')                        
                            <a data-toggle="modal" data-target="" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm">Settle</a>
                            @endif --}}
                            @if($cash_list->status == 'ACC')
                            <a data-toggle="modal"  data-type="{{$cash_list->type}}" data-unqid ="{{$cash_list->unq_id}}" class="advanceqr"><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 7)
                    <tbody>
                    @foreach($data['for_cfo'] as $cash_list)
                    <tr class="unqconveyance{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($cash_list->status == 'ACC')
                            <a data-toggle="modal"  data-type="{{$cash_list->type}}" data-unqid ="{{$cash_list->unq_id}}" class="advanceqr"><span class="btn btn-success btn-sm">QR</span></a>
                             @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        </div>
        {{-- Show  modal --}}
        <div class="modal fade" id="cashModal" role="dialog">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Bill Details</h4>
        </div>
        <div class="modal-body">
        <ul class="cashbillul">
        <li>Project Name:- <span class="pro_name"></span></li>
        <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="40%">Description</th>
                    <th width="15%">Amount</th>
                </tr>
            </thead>
            <tbody class="cashinfo">

            </tbody>
        </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
        </div>
        {{-- Edit modal --}}
<div class="modal fade" id="editcashModal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Cash Voucher</h4>
</div>
{!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'editcashform'])!!}
<div class="modal-body cashedit">
            <div class="col-sm-6 projectselectboxall">
                <select  class="form-control select2 select2-select project_nameedtall" id="pro_name" style="width: 100%;" name="project_nameall">
                        <option value="">Select Project</option>
                        @foreach($data['project-name'] as $projectname)
                        <option value="{{$projectname->id}}">{{$projectname->project_name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-sm-6 projectselectboxg" style="display:none">
                    <select  class="form-control select2 select2-select project_nameg" id="pro_name" style="width: 100%;" name="project_nameg">
                        <option value="4">General</option>
                    </select>        
                </div><br>
                <div class="custom-control-lg  custom-control custom-checkbox">
                    <div class="col-sm-3">
                        <input class="custom-control-input  cash_type" id="checkbox-largeexp" type="checkbox" name="general_chk" value="Expense">
                        <label style="padding: 5px;">Expense</label>
                    </div>
                    <div class="col-sm-3">
                        <input class="custom-control-input  cash_type" id="checkbox-largead" type="checkbox" name="general_chk" value="Advance">
                        <label style="padding: 5px;">Advance</label>
                    </div>
                    
                </div>
<div class="mylist" data-index_no="0">
    <div class="myitemWrapper">
            <table class="table table-bordered editcashtable">
            <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="40%">Description</th>
                    <th width="15%">Amount</th>
                    <th width="15%">Option</th>
                </tr>
            </thead>
            <tbody class="editcashinfo">

            </tbody>
        </table>
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
{!!Form::close()!!}
</div>
</div>
</div>
{{-- Qrcode printing modal --}}
<div class="modal fade" id="blablaModal" role="dialog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Bill Details</h4>
    </div>
    <div class="modal-body advanceqrcodeid">
        <ul class="cashbillul">
            <li>User Name:- <span class="user_name"></span></li>
            <li>Project Name:- <span class="pro_name"></span></li>
            <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
            <li class="typeli">Total:- <span class="total"></span></li>

        </ul>
        
        <div class="">
            <img id="qr-img" src="" name="image" width="350" height="350" alter="blabla"></a>  
        </div>
    
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
</div>
</div>

    <script>
        $(document).on('click','.showcash',function(){
          var unq_id = $(this).data('unqid');
          $.ajax({
            url: "{!! route('cashinfo.cash') !!}",
            type: "get", 
            data: {  
                unq_id: unq_id, 

            },
            success: function(data) {
                $('#cashModal').find('.pro_name').text(data[0].project_name);
                $('#cashModal').find('.type').text(data[0].type);
                $('.cashinfo').empty();
                var total = 0;
                $.each(data,function(index, billInfo){
                    $('.cashinfo').prepend(`<tr class="item_tr single_list">
                                    <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                                    <td><textarea  class="form-control from"  readonly rows="1">`+billInfo.description+`</textarea><br></td>
                                    <td><input type="text" class="form-control"  value="`+billInfo.amount+`" readonly><br></td>                            
                                </tr>`)
                                total = (parseInt(total)) + (parseInt(billInfo.amount))
                })
                $('.cashinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+total+` Tk </span></td></tr>`)
 
            },
            error: function(xhr) {
                //Do Something to handle error
            }
            });
   
        })

        $(document).on('click','.editcash',function(){
       var unq_id = $(this).data('unqid');
    // $('.editcashtable').empty();
   //alert(unq_id);
    $.get('/cash/getallcashbillinfocashByid/'+unq_id,function(data){
        $('.editcashinfo').empty();
       $('.emptyable').empty();
        $('.cashedit').prepend(` <input type="hidden" class="form-control" name="unq_id" id="unqid"  value="`+data[0].unq_id+`">`);
        $('.cashedit').prepend(` <input type="hidden" class="form-control" name="user_id"  value="`+data[0].user_id+`" >`);
        var projecttype = data[0].type;
        if(projecttype =='Expense'){
            $("#checkbox-largeexp").prop('checked', true);
            $("#checkbox-largead").prop('checked', false);
            $('.projectselectboxall').hide();
           $('.projectselectboxg').show();
        }else{
            $("#checkbox-largead").prop('checked', true);
            $("#checkbox-largeexp").prop('checked', false);
            $('.project_nameedtall').append(`<option value='`+data[0].projectid+`' selected='selected'>`+data[0].project_name+`</option>`)
            $('.projectselectboxall').show();
            $('.projectselectboxg').hide();
        }
        var total = 0;
        $.each(data,function(index, billInfo){
          
         $('.editcashinfo').prepend(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control mydatepicker" name="program[`+index+`][date]"  value="`+billInfo.date+`" ></td>
                             <td><textarea  class="form-control description" name="program[`+index+`][description]" rows="1">`+billInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control amount" name="program[`+index+`][amount]" value="`+billInfo.amount+`"><br></td>
                            <td><span class="removefrmmodal" style="background: #ed3610;padding: 8px 10px;color: #fff;border-radius: 6%;text-decoration: none;cursor:pointer">-</span></td>
                        </tr>`)
            total = (parseInt(total)) + (parseInt(billInfo.amount));      
        })
        $('.editcashtable').append(`<div class="emptyable"><span  class="add_moreedit" style="background: #28d19c;
                                                                padding: 8px 21px;
                                                                color: #fff;
                                                                border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                     <div class="text-center">Total : <input type="hiddentext" class="editcashtotal" readonly value="`+total+`"></div></div>`);
       

        //$('.modal-body').replaceWith('blabla');
       console.log(data);
    })
})

$(document).on('submit','#editcashform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var unq_id = $('#editcashform').find('#unqid').val();
    //alert(unq_id);
    $('.unqcash'+unq_id).remove();
    $.ajax({
        url:"{{route('update.cashinfo')}}",
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
                $('.cashappend').prepend(`<tr class="unqcash`+data.cashvoucher.unq_id+`" style="background:#76c776;">
                <td>`+data.submited_date+`</td>
                <td>`+data.projectname+`</td>
                <td>`+data.cashvoucher.type+`</td>
                <td>`+data.total+` TK</td>
                <td>`+data.cashvoucher.status+`</td>
                <td>
                 <a data-toggle="modal" data-target="#cashModal" class="showcash" data-unqid="`+data.cashvoucher.unq_id+`"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                </td>
               </tr>`);
             setTimeout(function() {$('#editcashModal').modal('hide');}, 1500);
            console.log(data);
        }
    });
})

$(document).on('submit','#cashvoucher',function(e){
 e.preventDefault();
 var data = $(this).serialize();
 if ($('#cashvoucher').valid()) {
    $.ajax({
        url:"{{route('cash-voucher.store')}}",
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
                //console.log(data);
                $('.cashappend').prepend(`<tr class="unqcash`+data.cashvoucher.unq_id+`">
                <td>`+data.submited_date+`</td>
                <td>`+data.projectname+`</td>
                <td>`+data.cashvoucher.type+`</td>
                <td>`+data.total+` TK</td>
                <td>`+data.cashvoucher.status+`</td>
                <td>
                 <a data-toggle="modal" data-target="#cashModal" class="showcash" data-unqid="`+data.cashvoucher.unq_id+`"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                </td>
            </tr>`);
              
           $('#cashvoucher').trigger('reset');
        }
    });
 }

})
       var options ={
          importCSS : false,
          pageTitle:"<h1>Print pdf</h1>",
        //   base:"http://localhost:8000/print-this"
      }
      $('.advanceqr').click(function(){
        var id = $(this).data('unqid');
        var type = $(this).data('type');
        var srcimg='/images/'+id+'.png';
         $('.advanceqrcodeid #qr-img').attr("src", srcimg);
         $.ajax({
            url: "{!! route('qr.qrcode') !!}",
            type: "get", 
            data: { 
                id: id, 
                type: type,
           },
            success: function(data) {
                $('.advanceqrcodeid').find('.pro_name').text(data.project_name);
             $('.advanceqrcodeid').find('.user_name').text(data.name);
             $('.advanceqrcodeid').find('.total').text(data.total);
             $('.advanceqrcodeid').find('.type').text(data.type);

            }
         });
        setTimeout(function() {
            $('.advanceqrcodeid').printThis(options);

         }, 2000); 
      });

        </script>
        
</div>
<div id="menu1" class="tab-pane fade">

<div class="box-body">
    <table id="example4" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>Submited date</th>
    <th>Project Name</th>
    <th>Type</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
    </tr>
    </thead>
    @if($user_role == 5)
    <tbody>
        @foreach($data['for_executive_expense'] as $expense)
        <tr class="unqconveyance{{$expense->unq_id}}">
                <td>{{$expense->created_at}}</td>
                <td>
                {{$expense->project_name}}
                </td>
                <td>{{$expense->type}}</td>
                <td>{{$expense->total}} Tk</td>
                <td>{{$expense->status}}</td>
                <td>
                    <a data-toggle="modal" data-target="#expenseModal" data-unqid ="{{$expense->unq_id}}" class="showexpense"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                    
                    @if($expense->status == 'ACC')
                     <a data-toggle="modal" data-type="{{$expense->type}}"  data-unqid ="{{$expense->unq_id}}" class="expenseqr"  ><span class="btn btn-success btn-sm">QR</span></a>
                      @endif
                    @if($expense->review=='yes')
                    <a data-toggle="modal" data-target="#editexpenseModal" data-unqid ="{{$expense->unq_id}}" class="editexpense"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                    @endif
                    
                </td>
            </tr>
            @endforeach
       </tbody>
       @elseif($user_role == 3)
            <tbody>
                    @foreach($data['for_manager_expense'] as $cash_list)
                    <tr class="unqcash{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($cash_list->status == 'ACC')
                                <a data-toggle="modal" data-type="{{$cash_list->type}}"  data-unqid ="{{$cash_list->unq_id}}" class="expenseqr"  ><span class="btn btn-success btn-sm">QR</span></a>
                                @endif
                            @if($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 4)
                <tbody>
                    @foreach($data['for_assmng_expense'] as $cash_list)
                    <tr class="unqconveyance{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($cash_list->status == 'ACC')
                                <a data-toggle="modal" data-type="{{$cash_list->type}}"  data-unqid ="{{$cash_list->unq_id}}" class="expenseqr"  ><span class="btn btn-success btn-sm">QR</span></a>
                                @endif
                            @if($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
        
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 6)
                    <tbody>
                    @foreach($data['for_ceo_expense'] as $cash_list)
                    <tr class="unqconveyance{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($cash_list->status == 'ACC')
                                <a data-toggle="modal" data-type="{{$cash_list->type}}"  data-unqid ="{{$cash_list->unq_id}}" class="expenseqr"  ><span class="btn btn-success btn-sm">QR</span></a>
                                @endif
                            @if($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 7)
                    <tbody>
                    @foreach($data['for_cfo_expense'] as $cash_list)
                    <tr class="unqconveyance{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->type}}</td>
                        <td>{{$cash_list->total}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cashModal" data-unqid ="{{$cash_list->unq_id}}" class="showcash"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            @if($cash_list->status == 'ACC')
                            <a data-toggle="modal" data-type="{{$cash_list->type}}"  data-unqid ="{{$cash_list->unq_id}}" class="expenseqr"  ><span class="btn btn-success btn-sm">QR</span></a>
                            @endif

                            @if($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editcashModal" data-unqid ="{{$cash_list->unq_id}}" class="editcash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
         </tbody>
    @endif
    </table>
</div>
    {{-- Show  modal --}}
    <div class="modal fade" id="expenseModal" role="dialog">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Bill Details</h4>
            </div>
            <div class="modal-body">
            <ul class="cashbillul">
            <li>Project Name:- <span class="pro_name"></span></li>
            <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
            </ul>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="20%">Date</th>
                        <th width="40%">Description</th>
                        <th width="15%">Amount</th>
                    </tr>
                </thead>
                <tbody class="expenseinfo">
    
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
            </div>
            </div>
            {{-- Edit modal --}}
    <div class="modal fade" id="editexpenseModal" role="dialog">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Cash Voucher</h4>
    </div>
    {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'editexpenseform'])!!}
    <div class="modal-body expenseedit">
                <div class="col-sm-6 projectselectboxall">
                    <select  class="form-control select2 select2-select project_nameedtall" id="pro_name" style="width: 100%;" name="project_nameall">
                            <option value="">Select Project</option>
                            @foreach($data['project-name'] as $projectname)
                            <option value="{{$projectname->id}}">{{$projectname->project_name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 projectselectboxg" style="display:none">
                        <select  class="form-control select2 select2-select project_nameg" id="pro_name" style="width: 100%;" name="project_nameg">
                            <option value="4">General</option>
                        </select>        
                    </div><br>
                    <div class="custom-control-lg  custom-control custom-checkbox">
                        <div class="col-sm-3">
                            <input class="custom-control-input  cash_type" id="checkbox-largeexp" type="checkbox" name="general_chk" value="Expense">
                            <label style="padding: 5px;">Expense</label>
                        </div>
                        <div class="col-sm-3">
                            <input class="custom-control-input  cash_type" id="checkbox-largead" type="checkbox" name="general_chk" value="Advance">
                            <label style="padding: 5px;">Advance</label>
                        </div>
                        
                    </div>
    <div class="mylist" data-index_no="0">
        <div class="myitemWrapper">
                <table class="table table-bordered editcashtable">
                <thead>
                    <tr>
                        <th width="20%">Date</th>
                        <th width="40%">Description</th>
                        <th width="15%">Amount</th>
                        <th width="15%">Option</th>
                    </tr>
                </thead>
                <tbody class="editexpenseinfo">
    
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    {!!Form::close()!!}
    </div>
    </div>
    </div>
    {{-- Qrcode printing modal --}}
    <div class="modal fade" id="" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Bill Details</h4>
        </div>
        <div class="modal-body expenseqrcode">
            <ul class="cashbillul">
                <li>User Name:- <span class="user_name"></span></li>
                <li>Project Name:- <span class="pro_name"></span></li>
                <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
                <li class="typeli">Total:- <span class="total"></span></li>
    
            </ul>
            
            <div class="">
                <img id="qr-img" src="" name="image" width="350" height="350" alter="blabla"></a>  
            </div>
        
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <script>
              var options ={
          importCSS : false,
          pageTitle:"<h1>Print pdf</h1>",
        //   base:"http://localhost:8000/print-this"
      }
      $('.expenseqr').click(function(){
        var id = $(this).data('unqid');
        var type = $(this).data('type');
        var srcimg='/images/'+id+'.png';
         $('.expenseqrcode #qr-img').attr("src", srcimg);
         $.ajax({
            url: "{!! route('qr.qrcode') !!}",
            type: "get", 
            data: { 
                id: id, 
                type: type,
           },
            success: function(data) {
             $('.expenseqrcode').find('.pro_name').text(data.project_name);
             $('.expenseqrcode').find('.user_name').text(data.name);
             $('.expenseqrcode').find('.total').text(data.total);
             $('.expenseqrcode').find('.type').text(data.type);

            }
         });
        setTimeout(function() {
            $('.expenseqrcode').printThis(options);

         }, 2000); 
      });

        $(document).on('click','.showexpense',function(){
          var unq_id = $(this).data('unqid');
            $.get('/cash/getallcashbillinfocashByid/'+unq_id,function(data){
                // var firstdata = data[0].slice(0);
                $('#expenseModal').find('.pro_name').text(data[0].project_name);
                $('#expenseModal').find('.type').text(data[0].type);
                $('.expenseinfo').empty();
                var total = 0;
                $.each(data,function(index, billInfo){
                    $('.expenseinfo').prepend(`<tr class="item_tr single_list">
                                    <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                                    <td><textarea  class="form-control from"  readonly rows="1">`+billInfo.description+`</textarea><br></td>
                                    <td><input type="text" class="form-control"  value="`+billInfo.amount+`" readonly><br></td>                            
                                </tr>`)
                                total = (parseInt(total)) + (parseInt(billInfo.amount))
                })
                $('.expenseinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+total+` Tk </span></td></tr>`)
                //$('.modal-body').replaceWith('blabla');
            console.log(data);
            })
        })

        $(document).on('click','.editexpense',function(){
       var unq_id = $(this).data('unqid');
    // $('.editcashtable').empty();
   //alert(unq_id);
    $.get('/cash/getallcashbillinfocashByid/'+unq_id,function(data){
        $('.editexpenseinfo').empty();
       $('.emptyable').empty();
        $('.expenseedit').prepend(` <input type="hidden" class="form-control" name="unq_id" id="unqid"  value="`+data[0].unq_id+`">`);
        $('.expenseedit').prepend(` <input type="hidden" class="form-control" name="user_id"  value="`+data[0].user_id+`" >`);
        var projecttype = data[0].type;
        if(projecttype =='Expense'){
            $("#editexpenseform #checkbox-largeexp").prop('checked', true);
            $("#editexpenseform #checkbox-largead").prop('checked', false);
            $('#editexpenseform .projectselectboxall').hide();
           $('#editexpenseform .projectselectboxg').show();
        }else{
            $("#editexpenseform #checkbox-largead").prop('checked', true);
            $("#editexpenseform #checkbox-largeexp").prop('checked', false);
            $('#editexpenseform .project_nameedtall').append(`<option value='`+data[0].projectid+`' selected='selected'>`+data[0].project_name+`</option>`)
            $('#editexpenseform .projectselectboxall').show();
            $('#editexpenseform .projectselectboxg').hide();
        }
        var total = 0;
        $.each(data,function(index, billInfo){
          
         $('.editexpenseinfo').prepend(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control mydatepicker" name="program[`+index+`][date]"  value="`+billInfo.date+`" ></td>
                             <td><textarea  class="form-control description" name="program[`+index+`][description]" rows="1">`+billInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control amount" name="program[`+index+`][amount]" value="`+billInfo.amount+`"><br></td>
                            <td><span class="removefrmmodal" style="background: #ed3610;padding: 8px 10px;color: #fff;border-radius: 6%;text-decoration: none;cursor:pointer">-</span></td>
                        </tr>`)
            total = (parseInt(total)) + (parseInt(billInfo.amount));      
        })
        $('.editexpensetable').append(`<div class="emptyable"><span  class="add_moreedit" style="background: #28d19c;
                                                                padding: 8px 21px;
                                                                color: #fff;
                                                                border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                     <div class="text-center">Total : <input type="hiddentext" class="editcashtotal" readonly value="`+total+`"></div></div>`);
       

        //$('.modal-body').replaceWith('blabla');
       console.log(data);
    })
})

$(document).on('submit','#editexpenseform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var unq_id = $('#editexpenseform').find('#unqid').val();
    //alert(unq_id);
    $('.unqexpense'+unq_id).remove();
    $.ajax({
        url:"{{route('update.cashinfo')}}",
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
                $('.expenseappend').prepend(`<tr class="unqcash`+data.cashvoucher.unq_id+`" style="background:#76c776;">
                <td>`+data.submited_date+`</td>
                <td>`+data.projectname+`</td>
                <td>`+data.cashvoucher.type+`</td>
                <td>`+data.total+` TK</td>
                <td>`+data.cashvoucher.status+`</td>
                <td>
                 <a data-toggle="modal" data-target="#cashModal" class="showcash" data-unqid="`+data.cashvoucher.unq_id+`"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                </td>
               </tr>`);
             setTimeout(function() {$('#editexpenseModal').modal('hide');}, 1500);
            console.log(data);
        }
    });
})

</script>
</div>
<div id="menu2" class="tab-pane fade">
        <div class="box-body">
                <table id="example3" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>Submited date</th>
                    <th>Project Name</th>
                    <th>Advncd Amount</th>
                    <th>Total Expense</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    @if($user_role == 5)
                    <tbody>
                        @foreach($data['for_executive_ad_succeed'] as $cash_list)
                        <tr class="unqcash{{$cash_list->unq_id}}">
                            <td>{{$cash_list->created_at}}</td>
                            <td>
                            {{$cash_list->project_name}}
                            </td>
                            @php
                                $percent =  $data['percent']->percent_amount;
                                $advance = $cash_list->total; 
                                $advanceamntpercent = ($advance * $percent)/100;
                                $expense = $cash_list->expenseamount;
                                $advancewithPercent = $advance + $advanceamntpercent;
                                
                            @endphp
                            <td>{{$cash_list->total}} Tk </td>
                        <td>{{$cash_list->expenseamount}} Tk  </td>
                            <td>
                                <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" class="showcashsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                @if($expense < $advancewithPercent)
                                 <a data-toggle="modal" data-target="#cashsettlemodal" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm settle">Settle</a>
                                @endif
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @elseif($user_role == 3)
                    <tbody>
                            @foreach($data['for_manager_ad_succeed'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                    <td>{{$cash_list->created_at}}</td>
                                    <td>
                                    {{$cash_list->project_name}}
                                    </td>
                                    @php
                                        $advance = $cash_list->total; 
                                        $advanceamntpercent = ($advance * 10)/100;
                                        $expense = $cash_list->expenseamount;
                                        $advancewithPercent = $advance + $advanceamntpercent;
                                        
                                    @endphp
                                    <td>{{$cash_list->total}} Tk </td>
                                    <td>{{$cash_list->expenseamount}} Tk</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" class="showcashsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                        @if($expense < $advancewithPercent)
                                         <a data-toggle="modal" data-target="#cashsettlemodal" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm settle">Settle</a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 4)
                        <tbody>
                            @foreach($data['for_assmng_ad_succeed'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                    <td>{{$cash_list->created_at}}</td>
                                    <td>
                                    {{$cash_list->project_name}}
                                    </td>
                                    @php
                                        $advance = $cash_list->total; 
                                        $advanceamntpercent = ($advance * 10)/100;
                                        $expense = $cash_list->expenseamount;
                                        $advancewithPercent = $advance + $advanceamntpercent;
                                        
                                    @endphp
                                    <td>{{$cash_list->total}} Tk </td>
                                    <td>{{$cash_list->expenseamount}} Tk</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" class="showcashsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                        @if($expense < $advancewithPercent)
                                         <a data-toggle="modal" data-target="#cashsettlemodal" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm settle">Settle</a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 6)
                            <tbody>
                            @foreach($data['for_ceo_ad_succeed'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                    <td>{{$cash_list->created_at}}</td>
                                    <td>
                                    {{$cash_list->project_name}}
                                    </td>
                                    @php
                                        $advance = $cash_list->total; 
                                        $advanceamntpercent = ($advance * 10)/100;
                                        $expense = $cash_list->expenseamount;
                                        $advancewithPercent = $advance + $advanceamntpercent;
                                        
                                    @endphp
                                    <td>{{$cash_list->total}} Tk </td>
                                    <td>{{$cash_list->expenseamount}} Tk</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" class="showcashsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                        @if($expense < $advancewithPercent)
                                         <a data-toggle="modal" data-target="#cashsettlemodal" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm settle">Settle</a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 7)
                            <tbody>
                            @foreach($data['for_cfo_ad_succeed'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                    <td>{{$cash_list->created_at}}</td>
                                    <td>
                                    {{$cash_list->project_name}}
                                    </td>
                                    @php
                                        $advance = $cash_list->total; 
                                        $advanceamntpercent = ($advance * 10)/100;
                                        $expense = $cash_list->expenseamount;
                                        $advancewithPercent = $advance + $advanceamntpercent;
                                        
                                    @endphp
                                    <td>{{$cash_list->total}} Tk </td>
                                    <td>{{$cash_list->expenseamount}} Tk</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" class="showcashsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                        @if($expense < $advancewithPercent)
                                         <a data-toggle="modal" data-target="#cashsettlemodal" data-unqid ="{{$cash_list->unq_id}}" class="btn btn-success btn-sm settle">Settle</a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
        </div>
        <div class="modal fade" id="cashsettlemodal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cash Settlement</h4>
                    </div>
                    {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'settleform'])!!}
                     <div class="modal-body">
                        <ul class="cashsettleul">
                            <li>Project Name:- <span class="pro_name"></span></li>
                            <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
                            <li class="typeli">Advance was Taken: <span class="advance"></span> TK</li>
                        </ul>
                        <div class="unquappend"></div>
                        <div class="settlelist" data-index_no="0">
                                <div class="settleitemWrapper">
                                    <table class="table table-bordered settletable">
                                        <tr>
                                            <th width="15%">Date</th>
                                            <th width="35%">Description</th>
                                            <th width="20%">Amount</th>
                                            {{-- <th width="20%">Total</th> --}}
                                            <th width="10%">Option</th>
                                        </tr>
                                    <tbody class="settlecash">
                                        <tr class="item_tr single_list">
                                            <td><input type="text" class="form-control mydatepicker" id="pro_date"   name="program[0][date]"></td>
                                            <td><textarea  class="form-control description" id="pro_description" name="program[0][description]" rows="1"></textarea><br></td>
                                             <td><input type="number" class="form-control amount" id="pro_amount" name="program[0][amount]"><br></td>
                                             {{-- <td><input type="number" class="form-control total" id="pro_total" name="program[0][total]" readonly><br></td> --}}
                                            <td><span class="removesettle" style="background: #ed3610;padding: 8px 10px;color: #fff;border-radius: 6%;text-decoration: none;cursor:pointer">-</span></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                       
                                    <span  class="add_moreforsettle" style="background: #28d19c;
                                                                            padding: 8px 21px;
                                                                            color: #fff;
                                                                            border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                                 <div class="text-center">Total : <input type="hiddentext" name="totalexp" class="settletotalva" readonly></div>
                            </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Settle</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                   
            </div>
            {!!Form::close()!!}
        </div>
        </div>
    <script>
        $(document).on('click','.showcashsettle',function(){
     var unq_id = $(this).data('unqid');

     $.ajax({
    url: "{!! route('cashsettle.info') !!}",
    type: "get", 
    data: {  
        unq_id: unq_id
    },
    success: function(data) {
        var firstdata = data[0].slice(0);
        $('#cassettleshowhModal').find('.pro_name').text(firstdata[0].project_name);
        $('#cassettleshowhModal').find('.type').text(firstdata[0].type);
        $('.cashinfo').empty();
        $('.cashsettleinfo').empty();
        var totalsettle = 0;
        var total = 0;
        $.each(data[0],function(index, billInfo){
            $('.cashinfo').prepend(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                            <td><textarea  class="form-control from"  readonly rows="1">`+billInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control"  value="`+billInfo.amount+`" readonly><br></td>                            
                        </tr>`)
                        total = (parseInt(total)) + (parseInt(billInfo.amount))
        })
        $('.cashinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+total+` Tk </span></td></tr>`)

        $.each(data[1],function(index, settlebillInfo){
            $('.cashsettleinfo').append(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control"  value="`+settlebillInfo.date+`" readonly></td>
                            <td><textarea  class="form-control from"  readonly rows="1">`+settlebillInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control"  value="`+settlebillInfo.advance_expense+`" readonly><br></td>                            
                        </tr>`)
                        totalsettle = (parseInt(totalsettle)) + (parseInt(settlebillInfo.advance_expense))
        })
        $('.cashsettleinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+totalsettle+` Tk </span></td></tr>`)

    },
    error: function(xhr) {
        //Do Something to handle error
    }
    });   
     $.get('/cash/getcashsettleinfo/'+unq_id,function(data){
       
        //$('.modal-body').replaceWith('blabla');
       console.log(data[1]);
    })
})
$(document).on('click','.settle',function(){
    var unq_id = $(this).data('unqid');
    $('#settleform').trigger('reset')
    $('.unquappend').empty(); 
    //alert(unq_id);
    $.ajax({
        url: "{!! route('settle.data') !!}",
        type: "get", 
        data: { 
            unq_id: unq_id, 
            
        },
        success: function(data) {
            $('.unquappend').append(`<input type="hidden" class="form-control" name="unq_id"  value="`+data[0].unq_id+`" > `);
        $('.unquappend').append(`<input type="hidden" class="form-control" name="user_id"  value="`+data[0].userid+`" >`);
        $('.unquappend').append(`<input type="hidden" class="form-control" name="project_id"  value="`+data[0].projectid+`" >`);
        $('.unquappend').append(`<input type="hidden" class="form-control" name="advanceclaim_date"  value="`+data[0].created_at+`" >`);
        $('.unquappend').append(`<input type="hidden" class="form-control" name="advance_amount"  value="`+data[0].total+`" >`);

      $('.unquappend').append(`<input type="hidden" class="form-control" name="role"  value="`+data[0].role+`" >`);


        $('#cashsettlemodal').find('.pro_name').text(data[0].project_name);
        $('#cashsettlemodal').find('.type').text(data[0].type);
        $('#cashsettlemodal').find('.advance').text(data[0].total);

        }
    });
});
$(document).on('click', '.add_moreforsettle', function () {
    
    var date =  $(this).closest('.settleitemWrapper').find('.item_tr:last').find('.date').val();
    var description =  $(this).closest('.settleitemWrapper').find('.item_tr:last').find('.description').val();
    var amount =  $(this).closest('.settleitemWrapper').find('.item_tr:last').find('.amount').val();
    // var rowCount = $('.moreTable1 tr').length;
    
    if(date==''|| description==''||amount==''){
        Swal.fire({
        text: "Please Fill All Field First",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else{
        var index = $('.settlelist').data('index_no');
        //$('.list').data('index_no', index + 1);
        var html = $('.settleitemWrapper .item_tr:last').clone().find('.form-control').each(function () {
            this.name = this.name.replace(/\d+/, index+1000);
            this.id = this.id.replace(/\d+/, index+1000);
            this.value = '';
        }).end();
        var $clone = $('.settlecash').append(html);
        //alert(rowCount);
        
    }
});
$(document).ready(function () {
       $(".settletable").on('input', '.amount', function () {
          var calculated_total_sum = 0;
          $(".settletable .amount").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseInt(get_textbox_value);
              }                  
            });
            $(".settletotalva").val(calculated_total_sum);
       });
   
    });
$(document).on('click', '.removesettle', function () {
    var rowCount = $('.settletable tr').length;
    //alert(rowCount);
    if(rowCount == 2){
        alert("you can't remove it");
    }else{
        var subtrval = $(this).closest('tr').find('.amount').val();
        if(subtrval !=''){
            var storedval = $(".editcashtotal").val();
            subtrval = subtrval;
            var orginalval = parseInt(storedval) - parseInt(subtrval)
            $(this).closest('tr').remove();
            $(".editcashtotal").val(orginalval);
            
        }else{
            var storedval = $(".editcashtotal").val();
            var orginalval = parseInt(storedval) - 0;
            $(this).closest('tr').remove();
            $(".editcashtotal").val(orginalval);
        }
        
        
    }
});
$(document).on('submit','#settleform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url:"{{route('settele.store')}}",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        {
            $('#settleform').trigger('reset')
            toastr.options = {
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "fadeIn": 300,
                        "fadeOut": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 3000
                      };
                toastr.success('Your Settlement Request was Sent successfully');
                setTimeout(function() {$('#cashsettlemodal').modal('hide');}, 1500);
            console.log(data);
        }
    });

})
</script>
</div>
<div id="menu3" class="tab-pane fade">
        <div class="box-body">
                <table id="example3" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>Submited date</th>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    @if($user_role == 5)
                    <tbody>
                        @foreach($data['for_executive_exp_succeed'] as $cash_list)
                        <tr class="unqcash{{$cash_list->unq_id}}">
                            <td>{{$cash_list->created_at}}</td>
                            <td>
                            {{$cash_list->project_name}}
                            </td>
                            <td>{{$cash_list->type}}</td>
                            <td>{{$cash_list->total}} Tk</td>
                            <td>{{$cash_list->status}}</td>
                            <td>
                                <a data-toggle="modal" data-target="#expensesModal" data-unqid ="{{$cash_list->unq_id}}" class="showexpenses"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                              </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @elseif($user_role == 3)
                    <tbody>
                            @foreach($data['for_manager_exp_succeed'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->type}}</td>
                                <td>{{$cash_list->total}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                <a data-toggle="modal" data-target="#expensesModal" data-unqid ="{{$cash_list->unq_id}}" class="showexpenses"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 4)
                        <tbody>
                            @foreach($data['for_assmng_exp_succeed'] as $cash_list)
                            <tr class="unqconveyance{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->type}}</td>
                                <td>{{$cash_list->total}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                        <a data-toggle="modal" data-target="#expensesModal" data-unqid ="{{$cash_list->unq_id}}" class="showexpenses"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                       
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 6)
                            <tbody>
                            @foreach($data['for_ceo_exp_succeed'] as $cash_list)
                            <tr class="unqconveyance{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->type}}</td>
                                <td>{{$cash_list->total}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                        <a data-toggle="modal" data-target="#expensesModal" data-unqid ="{{$cash_list->unq_id}}" class="showexpenses"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                       
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 7)
                            <tbody>
                            @foreach($data['for_cfo_exp_succeed'] as $cash_list)
                            <tr class="unqconveyance{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->type}}</td>
                                <td>{{$cash_list->total}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                        <a data-toggle="modal" data-target="#expensesModal" data-unqid ="{{$cash_list->unq_id}}" class="showexpenses"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                       
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
                </div>
                 {{-- Show  modal --}}
        <div class="modal fade" id="expensesModal" role="dialog">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bill Details</h4>
                </div>
                <div class="modal-body">
                <ul class="cashbillul">
                <li>Project Name:- <span class="pro_name"></span></li>
                <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
                </ul>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="40%">Description</th>
                            <th width="15%">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="expenseinfo">
        
                    </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
                </div>
                </div>
            <script>
       $(document).on('click','.showexpenses',function(){
          var unq_id = $(this).data('unqid');
            $.get('/cash/getallcashbillinfocashByid/'+unq_id,function(data){
                // var firstdata = data[0].slice(0);
                $('#expensesModal').find('.pro_name').text(data[0].project_name);
                $('#expensesModal').find('.type').text(data[0].type);
                $('.expenseinfo').empty();
                var total = 0;
                $.each(data,function(index, billInfo){
                    $('.expenseinfo').prepend(`<tr class="item_tr single_list">
                                    <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                                    <td><textarea  class="form-control from"  readonly rows="1">`+billInfo.description+`</textarea><br></td>
                                    <td><input type="text" class="form-control"  value="`+billInfo.amount+`" readonly><br></td>                            
                                </tr>`)
                                total = (parseInt(total)) + (parseInt(billInfo.amount))
                })
                $('.expenseinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+total+` Tk </span></td></tr>`)
                //$('.modal-body').replaceWith('blabla');
            console.log(data);
            })
        })
 </script>

</div>
<div id="menu4" class="tab-pane fade">
        <div class="box-body">
                <table id="example3" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>Submited date</th>
                    <th>Project Name</th>
                    <th>Total Advance</th>
                    <th>Expense On Advance</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    @if($user_role == 5)
                    <tbody>
                        @foreach($data['for_executive_ad_expenses_success'] as $cash_list)
                        <tr class="unqcash{{$cash_list->unq_id}}">
                            <td>{{$cash_list->created_at}}</td>
                            <td>
                            {{$cash_list->project_name}}
                            </td>
                            <td>{{$cash_list->advance_amount}} TK</td>
                            <td>{{$cash_list->totalexpense}} Tk</td>
                            <td>{{$cash_list->status}}</td>
                            <td>
                                <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @elseif($user_role == 3)
                    <tbody>
                            @foreach($data['for_manager_ad_expenses_success'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->advance_amount}} TK</td>
                                <td>{{$cash_list->totalexpense}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 4)
                        <tbody>
                            @foreach($data['for_assmng_ad_expenses_success'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->advance_amount}} TK</td>
                                <td>{{$cash_list->totalexpense}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 6)
                            <tbody>
                            @foreach($data['for_ceo_ad_expenses_success'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->advance_amount}} TK</td>
                                <td>{{$cash_list->totalexpense}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                                                   </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($user_role == 7)
                            <tbody>
                            @foreach($data['for_cfo_ad_expenses_success'] as $cash_list)
                            <tr class="unqcash{{$cash_list->unq_id}}">
                                <td>{{$cash_list->created_at}}</td>
                                <td>
                                {{$cash_list->project_name}}
                                </td>
                                <td>{{$cash_list->advance_amount}} TK</td>
                                <td>{{$cash_list->totalexpense}} Tk</td>
                                <td>{{$cash_list->status}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                                                   </td>
                            </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
     </div>

</div>
<div id="menu5" class="tab-pane fade">
    <div class="box-body">
        <table id="example3" class="table table-bordered table-striped settleappend">
            <thead>
            <tr>
            <th>Submited date</th>
            <th>Project Name</th>
            <th>Total Advance</th>
            <th>Expense On Advance</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
            </thead>
            @if($user_role == 5)
            <tbody>
                @foreach($data['for_executive_ad_expenses'] as $cash_list)
                <tr class="unqcash{{$cash_list->unq_id}}">
                    <td>{{$cash_list->created_at}}</td>
                    <td>
                    {{$cash_list->project_name}}
                    </td>
                    <td>{{$cash_list->advance_amount}} TK</td>
                    <td>{{$cash_list->totalexpense}} Tk</td>
                    <td>{{$cash_list->status}}</td>
                    <td>
                        <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                       
                        @if($cash_list->status == 'ACC')
                         <a  data-toggle="modal" data-unqid ="{{$cash_list->anotherunq_id}}" class="cashqrcode"><span class="btn btn-success btn-sm">QR</span></a>
                        @elseif($cash_list->review=='yes')
                        <a data-toggle="modal" data-target="#editsettlecashModal" data-unqid ="{{$cash_list->anotherunq_id}}" class="editsettlecash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                       @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            @elseif($user_role == 3)
            <tbody>
                    @foreach($data['for_manager_ad_expenses'] as $cash_list)
                    <tr class="unqcash{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->advance_amount}} TK</td>
                        <td>{{$cash_list->totalexpense}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                           
                            @if($cash_list->status == 'ACC')
                             <a  data-toggle="modal" data-unqid ="{{$cash_list->anotherunq_id}}" class="cashqrcode"><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editsettlecashModal" data-unqid ="{{$cash_list->anotherunq_id}}" class="editsettlecash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                           @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 4)
                <tbody>
                    @foreach($data['for_assmng_ad_expenses'] as $cash_list)
                    <tr class="unqcash{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->advance_amount}} TK</td>
                        <td>{{$cash_list->totalexpense}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                           
                            @if($cash_list->status == 'ACC')
                             <a  data-toggle="modal" data-unqid ="{{$cash_list->anotherunq_id}}" class="cashqrcode"><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editsettlecashModal" data-unqid ="{{$cash_list->anotherunq_id}}" class="editsettlecash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                           @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 6)
                    <tbody>
                    @foreach($data['for_ceo_ad_expenses'] as $cash_list)
                    <tr class="unqcash{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->advance_amount}} TK</td>
                        <td>{{$cash_list->totalexpense}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                           
                            @if($cash_list->status == 'ACC')
                             <a  data-toggle="modal"   data-unqid ="{{$cash_list->anotherunq_id}}" class="cashqrcode"><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editsettlecashModal" data-unqid ="{{$cash_list->anotherunq_id}}" class="editsettlecash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                           @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @elseif($user_role == 7)
                    <tbody>
                    @foreach($data['for_cfo_ad_expenses'] as $cash_list)
                    <tr class="unqcash{{$cash_list->unq_id}}">
                        <td>{{$cash_list->created_at}}</td>
                        <td>
                        {{$cash_list->project_name}}
                        </td>
                        <td>{{$cash_list->advance_amount}} TK</td>
                        <td>{{$cash_list->totalexpense}} Tk</td>
                        <td>{{$cash_list->status}}</td>
                        <td>
                            <a data-toggle="modal" data-target="#cassettleshowhModal" data-unqid ="{{$cash_list->unq_id}}" data-anotherunqid ="{{$cash_list->anotherunq_id}}" class="showcashwithsettle"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                           
                            @if($cash_list->status == 'ACC')
                             <a  data-toggle="modal"  data-unqid ="{{$cash_list->anotherunq_id}}" class="cashqrcode"><span class="btn btn-success btn-sm">QR</span></a>
                            @elseif($cash_list->review=='yes')
                            <a data-toggle="modal" data-target="#editsettlecashModal" data-unqid ="{{$cash_list->anotherunq_id}}" class="editsettlecash"><span class="btn btn-warning btn-sm">Reviewit</span></a>
                           @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        </div>
        <div class="modal fade" id="" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Bill Details</h4>
                    </div>
                    <div class="modal-body settleqrcode">
                        <ul class="cashbillul">
                            <li>User Name:- <span class="user_name"></span></li>
                            <li>Project Name:- <span class="pro_name"></span></li>
                            <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
                            <li class="typeli">Total Advance:- <span class="total"></span></li>
                            <li class="typeli">Expense:- <span class="totalexp"></span></li>

                        </ul>
                      
                       <div class="">
                            <img id="qr-img" src="" name="image" width="350" height="350" alter="blabla"></a>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>
<script>
    var options ={
    importCSS : false,
    pageTitle:"<h1>Print pdf</h1>",
    //   base:"http://localhost:8000/print-this"
    }
    $('.cashqrcode').click(function(){
    var id = $(this).data('unqid');
    var srcimg='/images/'+id+'.png';
    $('.settleqrcode #qr-img').attr("src", srcimg);
    $.ajax({
        url: "{!! route('cash.qrcode') !!}",
        type: "get", 
        data: { 
            id: id, 
            
        },
        success: function(data) {
        $('.settleqrcode').find('.pro_name').text(data.project_name);
        $('.settleqrcode').find('.user_name').text(data.name);
        $('.settleqrcode').find('.totalexp').text(data.totalexpense);
        $('.settleqrcode').find('.total').text(data.advance_amount);
        $('.settleqrcode').find('.type').text(data.type);

        }
    });
    setTimeout(function() {
        $('.settleqrcode').printThis(options);

    }, 2000); 
    });

</script>

</div>
</div>

</div>
</div>
</div>
<div class="modal fade" id="" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title tti">Bill Details</h4>
        </div>
        <div class="modal-body qrcodehtml">
               <img id="mymodal-profile-img" src="" name="image" width="250" height="250"></a>                 
         </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <script>
        // $(document).on('click','.cashqrcode',function(){
        //     var unq_id = $(this).data('unqid');
        //     $.get('/cash/cashqr-code/'+unq_id,function(data){
        //         var srcimg='/images/'+unq_id+'.png';
        //         $('#cashqrcodemodal #mymodal-profile-img').attr("src", srcimg); 
        //         console.log(data);
        //     })
        //     //alert(unq_id);
        // })
    </script>


<div class="modal fade" id="cassettleshowhModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Bill Details</h4>
        </div>
        <div class="modal-body">
            <ul class="cashbillul">
                <li>Project Name:- <span class="pro_name"></span></li>
                <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
            </ul>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="40%">Description</th>
                            <th width="15%">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="cashinfo">

                    </tbody>
                </table>
               </div>
                <div class="modal-header">
                    <h4 class="modal-title">Cash Settle List</h4>
                </div>
                <div class="modal-body">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="40%">Description</th>
                            <th width="15%">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="cashsettleinfo">

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

     <div class="modal fade" id="editsettlecashModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit SettleMent</h4>
            </div>
            {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'editsettlecashform'])!!}
            <div class="modal-body">
                <div class="unquappendsettle"></div>
        <div class="mysettlelist" data-index_no="0">
                <div class="settleWrapper">
                     <table class="table table-bordered editsettletable">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="40%">Description</th>
                                <th width="15%">Amount</th>
                                <th width="15%">Option</th>
                            </tr>
                        </thead>
                        <tbody class="editsettlecashinfo">

                        </tbody>
                    </table>
                    <span  class="add_moresettle" style="background: #28d19c;
                    padding: 8px 21px;
                    color: #fff;
                    border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                <div class="text-center">Total : <input type="text" name="totalexp" class="totalsettaleamount" readonly></div>

                </div>
            </div>
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
    $(document).on('submit','#editsettlecashform',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url:"{{route('update.settle')}}",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        {
            $('#editsettlecashform').trigger('reset')
            toastr.options = {
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "fadeIn": 300,
                        "fadeOut": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 3000
                      };
                toastr.success('Your  Request was Resubmitted successfully');
                setTimeout(function() {$('#editsettlecashModal').modal('hide');}, 1500);
            console.log(data);
        }
    });

})
$(document).ready(function () {
    $('#cashvoucher').validate({ 
        rules: {
        project_name: 
           {
            required: true,
            
            },
        general_chk:{
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
$('body').on('focus',".mydatepicker", function(){
$(this).datepicker();
});
$(document).ready(function(){ 
    $('.cash_type').on('change', function() {
        var type = $(this).val();
        $('.cash_type').not(this).prop('checked', false);  
        if(type =='Expense'){
            $('.projectselectboxall').hide();
           $('.projectselectboxg').show();
        }else{
            $('.projectselectboxall').show();
           $('.projectselectboxg').hide();
        }
        //alert(type);
    });     
}); 
$(document).ready(function () {
       $(".moreTable1").on('input', '.amount', function () {
          var calculated_total_sum = 0;
          $(".moreTable1 .amount").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseInt(get_textbox_value);
              }                  
            });
            $(".assistant").val(calculated_total_sum);
       });
   
    });

$(document).on('click', '.add_more', function () {
    var date =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.date').val();
    var description =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.description').val();
    var amount =  $(this).closest('.itemWrapper').find('.item_tr:last').find('.amount').val();
    var rowCount = $('.moreTable1 tr').length;
    
    if(date==''|| description==''||amount==''){
        Swal.fire({
        text: "Please Fill All Field First",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else{
        var index = $('.list').data('index_no');
        $('.list').data('index_no', index + 1);
        var html = $('.itemWrapper .item_tr:last').clone().find('.form-control').each(function () {
            this.name = this.name.replace(/\d+/, index+1);
            this.id = this.id.replace(/\d+/, index+1);
            this.value = '';
        }).end();
        var $clone = $('.moreTable1').append(html);
        //alert(rowCount);
        
    }
});
$(document).on('click', '.remove', function () {
var count= $('.single_list').length;
if(count == 1){
    alert("you can't remove it");
}else{
    var subtrval = $(this).closest('tr').find('.amount').val();
    if(subtrval !=''){
        var storedval = $(".assistant").val();
        subtrval = subtrval;
        var orginalval = parseInt(storedval) - parseInt(subtrval)
        $(this).closest('tr').remove();
        $(".assistant").val(orginalval);
        
    }else{
        var storedval = $(".assistant").val();
        var orginalval = parseInt(storedval) - 0;
        $(this).closest('tr').remove();
        $(".assistant").val(orginalval);
    }
    
    
    }
});


$(document).on('click','.showcashwithsettle',function(){
     var unq_id = $(this).data('unqid');
     var anotherunq_id = $(this).data('anotherunqid');
     $.ajax({
            url: "{!! route('cashinfo.cash') !!}",
            type: "get", 
            data: {  
                unq_id: unq_id, 
                anotherunq_id: anotherunq_id, 

            },
            success: function(data) {
                var firstdata = data[0].slice(0);
        $('#cassettleshowhModal').find('.pro_name').text(firstdata[0].project_name);
        $('#cassettleshowhModal').find('.type').text(firstdata[0].type);
        $('.cashinfo').empty();
        $('.cashsettleinfo').empty();
        var totalsettle = 0;
        var total = 0;
        $.each(data[0],function(index, billInfo){
            $('.cashinfo').prepend(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                            <td><textarea  class="form-control from"  readonly rows="1">`+billInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control"  value="`+billInfo.amount+`" readonly><br></td>                            
                        </tr>`)
                        total = (parseInt(total)) + (parseInt(billInfo.amount))
        })
        $('.cashinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+total+` Tk </span></td></tr>`)

        $.each(data[1],function(index, settlebillInfo){
            $('.cashsettleinfo').append(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control"  value="`+settlebillInfo.date+`" readonly></td>
                            <td><textarea  class="form-control from"  readonly rows="1">`+settlebillInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control"  value="`+settlebillInfo.advance_expense+`" readonly><br></td>                            
                        </tr>`)
                        totalsettle = (parseInt(totalsettle)) + (parseInt(settlebillInfo.advance_expense))
        })
        $('.cashsettleinfo').append(`<tr><td></td><td></td><td><span class="totalspan">Total: `+totalsettle+` Tk </span></td></tr>`)

            },
            error: function(xhr) {
                //Do Something to handle error
            }
            });
   

     
})
$(document).on('click','.editsettlecash',function(){
   var unq_id = $(this).data('unqid');
   $('.editsettlecashinfo').empty();
   $.ajax({
        url: "{!! route('advance.settlelist') !!}",
        type: "get", 
        data: { 
            unq_id: unq_id, 
            
        },
        success: function(data) {
            $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="unq_id"  value="`+data[0].unq_id+`" > `);
        $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="anotherunq_id"  value="`+data[0].anotherunq_id+`" >`);
        $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="project_id"  value="`+data[0].projectid+`" >`);
        $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="user_id"  value="`+data[0].userid+`" >`);
        $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="role"  value="`+data[0].role+`" >`);
        $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="advanceclaim_date"  value="`+data[0].advanceclaim_date+`" >`);
        $('.unquappendsettle').append(`<input type="hidden" class="form-control" name="advance_amount"  value="`+data[0].advance_amount+`" >`);


       var totalsettle = 0;
    $.each(data,function(index, settlebillInfo){
        $('.editsettlecashinfo').prepend(`<tr class="item_tr single_list">
                            <td><input type="text" class="form-control date mydatepicker" name="program[`+index+`][date]"  value="`+settlebillInfo.date+`" ></td>
                            <td><textarea  class="form-control from description" name="program[`+index+`][description]"   rows="1">`+settlebillInfo.description+`</textarea><br></td>
                            <td><input type="text" class="form-control amount" name="program[`+index+`][advance_expense]"  value="`+settlebillInfo.advance_expense+`"><br></td>  
                            <td><span class="removeeditsettle" style="background: #ed3610;padding: 8px 10px;color: #fff;border-radius: 6%;text-decoration: none;cursor:pointer">-</span></td>
                          
                        </tr>`);
                        totalsettle = (parseInt(totalsettle)) + (parseInt(settlebillInfo.advance_expense))
    })
    $('.totalsettaleamount').val(totalsettle);

        }
   });
  
})

$(document).on('click', '.add_moresettle', function () {
    
    var date =  $(this).closest('.settleWrapper').find('.item_tr:last').find('.date').val();
    var description =  $(this).closest('.settleWrapper').find('.item_tr:last').find('.description').val();
    var amount =  $(this).closest('.settleWrapper').find('.item_tr:last').find('.amount').val();
     alert(date);
    // var rowCount = $('.moreTable1 tr').length;
    
    if(date==''|| description==''||amount==''){
        Swal.fire({
        text: "Please Fill All Field First",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else{
        var index = $('.mysettlelist').data('index_no');
        //$('.list').data('index_no', index + 1);
        var html = $('.settleWrapper .item_tr:last').clone().find('.form-control').each(function () {
            this.name = this.name.replace(/\d+/, index+2000);
            this.id = this.id.replace(/\d+/, index+2000);
            this.value = '';
        }).end();
        var $clone = $('.editsettlecashinfo').append(html);
        //alert(rowCount);
        
    }
});
$(document).on('click', '.removeeditsettle', function () {
    var rowCount = $('.editsettletable tr').length;
    //alert(rowCount);
    if(rowCount == 2){
        alert("you can't remove it");
    }else{
        var subtrval = $(this).closest('tr').find('.amount').val();
        if(subtrval !=''){
            var storedval = $(".totalsettaleamount").val();
            subtrval = subtrval;
            var orginalval = parseInt(storedval) - parseInt(subtrval)
            $(this).closest('tr').remove();
            $(".totalsettaleamount").val(orginalval);
            
        }else{
            var storedval = $(".totalsettaleamount").val();
            var orginalval = parseInt(storedval) - 0;
            $(this).closest('tr').remove();
            $(".totalsettaleamount").val(orginalval);
        }
        
        
    }
});
$(document).ready(function () {
       $(".editsettletable").on('input', '.amount', function () {
          var calculated_total_sum = 0;
          $(".editsettletable .amount").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseInt(get_textbox_value);
              }                  
            });
            $(".totalsettaleamount").val(calculated_total_sum);
       });
   
    });




$(document).on('click', '.add_moreedit', function () {
    var date =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.date').val();
    var description =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.description').val();
    var amount =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.amount').val();
    // var rowCount = $('.moreTable1 tr').length;
    
    if(date==''|| description==''||amount==''){
        Swal.fire({
        text: "Please Fill All Field First",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
        });
    }else{
        var index = $('.mylist').data('index_no');
        //$('.list').data('index_no', index + 1);
        var html = $('.myitemWrapper .item_tr:last').clone().find('.form-control').each(function () {
            this.name = this.name.replace(/\d+/, index+1000);
            this.id = this.id.replace(/\d+/, index+1000);
            this.value = '';
        }).end();
        var $clone = $('.editcashinfo').append(html);
        //alert(rowCount);
        
    }
});
$(document).ready(function () {
       $(".editcashtable").on('input', '.amount', function () {
          var calculated_total_sum = 0;
          $(".editcashtable .amount").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseInt(get_textbox_value);
              }                  
            });
            $(".editcashtotal").val(calculated_total_sum);
       });
   
    });
$(document).on('click', '.removefrmmodal', function () {
var count= $('.single_list').length;
//alert(count);
if(count == 2){
    alert("you can't remove it");
}else{
    var subtrval = $(this).closest('tr').find('.amount').val();
    if(subtrval !=''){
        var storedval = $(".editcashtotal").val();
        subtrval = subtrval;
        var orginalval = parseInt(storedval) - parseInt(subtrval)
        $(this).closest('tr').remove();
        $(".editcashtotal").val(orginalval);
        
    }else{
        var storedval = $(".editcashtotal").val();
        var orginalval = parseInt(storedval) - 0;
        $(this).closest('tr').remove();
        $(".editcashtotal").val(orginalval);
    }
    
    
    }
});

</script>
@endsection