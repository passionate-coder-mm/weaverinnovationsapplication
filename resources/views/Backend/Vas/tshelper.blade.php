@extends('Backend.admin_master')
@section('main-content')
<section class="content">
        <div class="box box-info">
                <div class="row">
                    <div class="col-sm-6">
                            <div class="box-header with-border">
                                    <h3 class="box-title">Daily Cash</h3>
                                </div>
                                {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'dailycash'])!!}
                                    <div class="box-body">
                                       
                                        <div class="form-group refreshcash">
                                           <label for="cashamount" class="col-sm-4 control-label">Cash Amount</label>
                                            <div class="col-sm-8">
                                            <input type="text" class="form-control" id="cashamount" name="cash_amount" placeholder="Enter Cash Amount"><br>
                                            <input type="text" class="form-control" value="{{$helperInfo->cash_amount}}" readonly>

                                        </div>
                                       </div>
                
                                    </div>
                                    <div class="box-footer">
                                            <button type="submit" class="btn btn-info" id="">Submit</button>
                                            {{-- <a   class="btn btn-info testamnt" data-type="advance" data-amount="{{$helperInfo->cash_amount}}">Demo</a> --}}

                                    </div>
                                    {!!Form::close()!!}
                    </div>
             
                    <div class="col-sm-6 ">
                            <div class="box-header with-border">
                                    <h3 class="box-title">Percentage</h3>
                                </div>
                                {!!Form::open(['method' => 'POST','class' => 'form-horizontal','id'=>'percentcash'])!!}
                                    <div class="box-body">
                                       
                                        <div class="form-group refreshpercentcash">
                                           <label for="cashamount" class="col-sm-4 control-label">Percentage</label>
                                            <div class="col-sm-8">
                                            <input type="text" class="form-control" id="cashamount" name="percent_amount" placeholder="Enter Percent Cash Amount"><br>
                                            <input type="text" class="form-control" value="{{$helperInfo->percent_amount}}" readonly>
                                        </div>
                                       </div>
                
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info pull-right" id="">Submit</button>
                                    </div>
                                    {!!Form::close()!!}
                 </div>
                    
            </div>
<script>
$(document).on('submit','#dailycash',function(e){
  e.preventDefault();
  var data = $(this).serialize();
  
        $.ajax({
          url:"{{route('helper.updatecash')}}",
          method:"POST",
          data:data,
          dataType:"json",
          success:function(data)
          { 
          $('#dailycash').trigger('reset');
          toastr.options = {
                  "debug": false,
                  "positionClass": "toast-bottom-right",
                  "onclick": null,
                  "fadeIn": 300,
                  "fadeOut": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 2000
              };
          toastr.success('Cash Updated Successfully');
          $(".refreshcash").load(location.href + " .refreshcash");

        }
      });
})

$(document).on('submit','#percentcash',function(e){
  e.preventDefault();
  var data = $(this).serialize();
  
        $.ajax({
          url:"{{route('helper.updatepercentcash')}}",
          method:"POST",
          data:data,
          dataType:"json",
          success:function(data)
          { 
          $('#percentcash').trigger('reset');
          toastr.options = {
                  "debug": false,
                  "positionClass": "toast-bottom-right",
                  "onclick": null,
                  "fadeIn": 300,
                  "fadeOut": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 2000
              };
          toastr.success('Percent Cash Updated Successfully');
          $(".refreshpercentcash").load(location.href + " .refreshpercentcash");

        }
      });
})
</script>
</section>
@endsection