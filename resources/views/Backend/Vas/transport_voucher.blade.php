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
         <h3 class="box-title">Conveyance Voucher</h3>
             <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
         </div>
         </div>
         {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'conveyanceform'])!!}
               
         <div class="box-body">
                <div class="box-header with-border">
                    
                 <div class="form-group">
                        <div class="col-sm-4 custom-control-lg custom-control custom-checkbox">

                                <input class="custom-control-input" id="checkbox-large" type="checkbox" name="general_chk" value="">
                                <label style="padding: 5px;">General</label>
                            </div>
                    <div class="col-sm-8" id="selectedtext">
                        {{-- <input type="text" class="form-control" id="projectname" name="project_name" placeholder="Enter Project Name"> --}}
                        <div class="projectselectboxall">
                                <select  class="form-control select2 select2-select allselect project_nameall" id="pro_name" style="width: 100%;" name="project_nameall">
                                     <option value="">Select Project</option>
                                     @foreach($data['project-name'] as $projectname)
                                      <option value="{{$projectname->id}}">{{$projectname->project_name}}</option>
                                    @endforeach
                                 </select>
                             </div>
                             <div class="projectselectboxg" style="display:none">
                                 <select  class="form-control select2 select2-select gnselect project_nameg" id="pro_name" style="width: 100%;" name="project_nameg">
                                     <option value="4">General</option>
                                  </select>        
                             </div>
                       <input type="hidden" class="form-control" id="userid" name="user_id" value="{{$user_id}}">
                       {{-- <input type="hidden" class="form-control" id="projectname" name="project_name" value=""> --}}

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
 <script>

</script>
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
            <ul class="nav nav-tabs">
            <li class="active commonlitabforcash"><a data-toggle="tab" href="#menu1">Transport Expense </a></li>
            <li class="commonlitabforcash"><a data-toggle="tab" href="#menu2">Transport Expense Success</a></li>
        </ul>
        <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active">
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
                                    {{$conveyance_list->project_name}}
                                    </td>
                                    <td>{{$conveyance_list->total}} Tk</td>
                                    <td>{{$conveyance_list->status}}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                      @if($conveyance_list->status == 'ACC')
                                      <a data-toggle="modal"  data-unqid ="{{$conveyance_list->unq_id}}" class="conqr"><span class="btn btn-success btn-sm">QR</span></a>
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
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                            @if($conveyance_list->status == 'ACC')
                                            <a data-toggle="modal"  data-unqid ="{{$conveyance_list->unq_id}}" class="conqr"><span class="btn btn-success btn-sm">QR</span></a>
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
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                            @if($conveyance_list->status == 'ACC')
                                            <a data-toggle="modal"  data-unqid ="{{$conveyance_list->unq_id}}" class="conqr"><span class="btn btn-success btn-sm">QR</span></a>
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
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                            @if($conveyance_list->status == 'ACC')
                                            <a data-toggle="modal"  data-unqid ="{{$conveyance_list->unq_id}}" class="conqr"><span class="btn btn-success btn-sm">QR</span></a>
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
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$conveyance_list->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                            @if($conveyance_list->status == 'ACC')
                                            <a data-toggle="modal"  data-unqid ="{{$conveyance_list->unq_id}}" class="conqr"><span class="btn btn-success btn-sm">QR</span></a>
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
                        <div class="modal fade" id="billModal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Bill Details</h4>
                                    </div>
                                    <div class="modal-body">
                                            <h4>ProjectName:<span class="pro_name"></span></h4>
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
                              <div class="modal fade" id="" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Bill Details</h4>
                                        </div>
                                        <div class="modal-body transqrcode">
                                            <ul class="cashbillul">
                                                <li>User Name:- <span class="user_name"></span></li>
                                                <li>Project Name:- <span class="pro_name"></span></li>
                                                <li class="typeli">Cash Bill Type:- <span class="type"></span></li>
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
                                    <div class="modal fade" id="editbillModal" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h4 class="modal-title">Edit Bill</h4>
                                                </div>
                                                {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'editbillform'])!!}
                                                <div class="modal-body">
                                                    <div class="editbillcon"></div>
                                                    <div class="mylist" data-index_no="0">
                                                        <div class="myitemWrapper">
                                                        <table class="table table-bordered editcontable">
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
                                          <script>
                                                var options ={
                                               importCSS : false,
                                               pageTitle:"<h1>Print pdf</h1>",
                                               //   base:"http://localhost:8000/print-this"
                                               }
                                               $('.conqr').click(function(){
                                               var id = $(this).data('unqid');
                                               var srcimg='/images/'+id+'.png';
                                               $('.transqrcode #qr-img').attr("src", srcimg);
                                               $.get('/transport/transqr-code/'+id,function(data){
                                                   $('.transqrcode').find('.pro_name').text(data.project_name);
                                                   $('.transqrcode').find('.user_name').text(data.name);
                                                   $('.transqrcode').find('.totalexp').text(data.totalexpense);
                                                   $('.transqrcode').find('.type').text('Transport');
                                           
                                                    console.log(data);
                                                   });
                                               setTimeout(function() {
                                                   $('.transqrcode').printThis(options);
                                           
                                               }, 2000); 
                                               });
                                               
                                           
                                           $("#checkbox-large").click( function(){
                                               var chk= $(this).is(':checked') ? 1 : 0;
                                               // $('#selectedtext #projectname').val("General");
                                               
                                               if(chk==1){
                                                   $('.projectselectboxg').show();
                                                   $('.projectselectboxall').hide();
                                               }else{
                                                   $('.projectselectboxg').hide();
                                                   $('.projectselectboxall').show();
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
                                                if(chk== 0 && project_name==''){
                                                    alert("Please Select Project Name");
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
                                                   $('#billModal .pro_name').text(data[0].project_name);
                                                   $('.billinfo').empty();
                                                   var total = 0;
                                                   $.each(data,function(index, billInfo){
                                                     
                                                    $('.billinfo').prepend(`<tr class="item_tr single_list">
                                                                       <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                                                                       <td><input type="text" class="form-control from" value="`+billInfo.from+`" readonly><br></td>
                                                                       <td><input type="text" class="form-control"  value="`+billInfo.to+`" readonly><br></td>
                                                                       <td><input type="text" class="form-control"  value="`+billInfo.mode+`" readonly><br></td>
                                                                       <td><input type="text" class="form-control" value="`+billInfo.purpose+`" readonly><br></td>
                                                                       <td><input type="number" class="form-control" value="`+billInfo.amount+`" readonly><br></td>
                                                                   </tr>`)  
                                                                   total = (parseInt(total)) + (parseInt(billInfo.amount))
                                                   })
                                                   $('.billinfo').append(`<tr><td></td><td></td><td></td><td></td><td></td><td><span class="totalspan">Total: `+total+` Tk </span></td></tr>`)
                                           
                                                   //$('.modal-body').replaceWith('blabla');
                                                  console.log(data);
                                               })
                                           })
                                           
                                           $(document).on('click','.edit',function(){
                                               var unq_id = $(this).data('unqid');
                                              //alert(unq_id);
                                               $.get('getallbillinfoByid/'+unq_id,function(data){
                                                   $('.editbillinfo').empty();
                                                   $('.editbillcon').empty();
                                                       $('.editbillcon').prepend(` <input type="text" class="form-control" readonly  name="project_name"  value="`+data[0].project_name+`" >`);
                                                  
                                                    $('.editbillcon').prepend(` <input type="hidden" class="form-control" name="user_id"  value="`+data[0].user_id+`" >`);
                                                    $('.editbillcon').prepend(` <input type="hidden" class="form-control" name="designation_name"  value="`+data[0].designation_name+`" >`);
                                                    $('.editbillcon').prepend(` <input type="hidden" class="form-control" name="unq_id" id="unqid"  value="`+data[0].unq_id+`" >`);
                                                    $('.editbillcon').prepend(` <input type="hidden" class="form-control" name="project_id" id="projectid"  value="`+data[0].project_id+`" >`);
                                           
                                                    var total = 0;
                                                   $.each(data,function(index, billInfo){
                                                     
                                                    $('.editbillinfo').prepend(`<tr class="item_tr single_list">
                                                                       <td><input type="text" class="form-control date mydatepicker"  name="program[`+index+`][date]"  value="`+billInfo.date+`" ></td>
                                                                       <td><input type="text" class="form-control from" name="program[`+index+`][from]" value="`+billInfo.from+`"><br></td>
                                                                       <td><input type="text" class="form-control to" name="program[`+index+`][to]"  value="`+billInfo.to+`" ><br></td>
                                                                       <td><input type="text" class="form-control mode" name="program[`+index+`][mode]"  value="`+billInfo.mode+`" ><br></td>
                                                                       <td><input type="text" class="form-control purpose" name="program[`+index+`][purpose]" value="`+billInfo.purpose+`"><br></td>
                                                                       <td><input type="number" class="form-control amount" name="program[`+index+`][amount]" value="`+billInfo.amount+`">
                                           
                                                                   </tr>`)
                                                                   total = (parseInt(total)) + (parseInt(billInfo.amount));  
                                                   })
                                                   $('.editcontable').append(`<div class="emptyable"><span  class="add_moreedit" style="background: #28d19c;
                                                                                                           padding: 8px 21px;
                                                                                                           color: #fff;
                                                                                                           border-radius: 8%;text-decoration: none; margin-bottom: 10px;cursor:pointer;">+</span><br><br>
                                                                <div class="text-center">Total : <input type="hiddentext" class="editcontotal" readonly value="`+total+`"></div></div>`);
                                                   //$('.modal-body').replaceWith('blabla');
                                                  console.log(data);
                                               })
                                           })
                                           $('body').on('focus',".mydatepicker", function(){
                                           $(this).datepicker();
                                           });
                                           $(document).on('click', '.add_moreedit', function () {
                                               var date =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.date').val();
                                               var from =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.from').val();
                                               var to =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.to').val();
                                               var purpose =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.purpose').val();
                                               var amount =  $(this).closest('.myitemWrapper').find('.item_tr:last').find('.amount').val();
                                           
                                               // var rowCount = $('.moreTable1 tr').length;
                                               
                                               if(date==''|| from==''|| to==''|| purpose=='' || amount==''){
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
                                                   var $clone = $('.editbillinfo').append(html);
                                                   //alert(rowCount);
                                                   
                                               }
                                           });
                                           $(document).ready(function () {
                                                  $(".editcontable").on('input', '.amount', function () {
                                                     var calculated_total_sum = 0;
                                                     $(".editcontable .amount").each(function () {
                                                      var get_textbox_value = $(this).val();
                                                      if ($.isNumeric(get_textbox_value)) {
                                                         calculated_total_sum += parseInt(get_textbox_value);
                                                         }                  
                                                       });
                                                       $(".editcontotal").val(calculated_total_sum);
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
        </div>
        <div id="menu2" class="tab-pane fade in">
                <div class="box-body">
                        <table id="example4" class="table table-bordered table-striped conveyanceappend">
                            <thead>
                            <tr>
                            <th>Submited date</th>
                            <th>Project Name</th>
                            <th>Total</th>
                            <th>Status</th>
                            </tr>
                            </thead>
                            @if($user_role == 5)
                            <tbody>
                                @foreach($data['executive_con_success'] as $conveyance_list)
                                <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                                    <td>{{$conveyance_list->created_at}}</td>
                                    <td>
                                    {{$conveyance_list->project_name}}
                                    </td>
                                    <td>{{$conveyance_list->total}} Tk</td>
                                    <td>{{$conveyance_list->status}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            @elseif($user_role == 3)
                            <tbody>
                                    @foreach($data['manager_con_success'] as $conveyance_list)
                                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                                        <td>{{$conveyance_list->created_at}}</td>
                                        <td>
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                                @elseif($user_role == 4)
                               <tbody>
                                    @foreach($data['assmanager_con_success'] as $conveyance_list)
                                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                                        <td>{{$conveyance_list->created_at}}</td>
                                        <td>
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                                @elseif($user_role == 6)
                                  <tbody>
                                    @foreach($data['ceo_con_success'] as $conveyance_list)
                                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                                        <td>{{$conveyance_list->created_at}}</td>
                                        <td>
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                                @elseif($user_role == 7)
                                 <tbody>
                                    @foreach($data['cfo_con_success'] as $conveyance_list)
                                    <tr class="unqconveyance{{$conveyance_list->unq_id}}">
                                        <td>{{$conveyance_list->created_at}}</td>
                                        <td>
                                        {{$conveyance_list->project_name}}
                                        </td>
                                        <td>{{$conveyance_list->total}} Tk</td>
                                        <td>{{$conveyance_list->status}}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                        </div>
        </div>
     
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </div>
</div>

    </div>
 
          
         
                
</section>

@endsection