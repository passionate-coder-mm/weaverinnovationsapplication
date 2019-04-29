@extends('Backend.admin_master')
@section('main-content')
<section class="content">
      <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Filter</h3>
    </div>    
   
         <div class="box-body">
          {!!Form::open(['method' => 'POST','id'=>'filter'])!!}
          <div class="row">
            <?php
             if(Auth::check()){
              $user_role = Auth::user()->role;
              $user_name = Auth::user()->name;
              $user_id = Auth::user()->id;
            }else{
              return redirect('login');
            }
            if($user_role=='5'){?>
            <div class="form-group">
                <div class="col-sm-3 customdesignfilter">
                  <select id="userserchid" class="form-control select2" style="width: 100%;" name="user_id">
                     
                   <option value="{{$user_id}}">{{$user_name}}</option>
                  </select> 
                </div>
            </div>
          <?php } else{?>
              <div class="form-group">
                  <div class="col-sm-3 customdesignfilter">
                    <select id="userserchid" class="form-control select2" style="width: 100%;" name="user_id">
                        <option value="">Select Name</option>
                     @foreach($all_user as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                   </select> 
                  </div>
              </div>
            <?php }?>
              <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="from_date" class="form-control datepicker" id="datepicker" placeholder="From Date">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="to_date" class="form-control datepicker1" id="datepicker1" placeholder="To Date">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
              </div>
            </div>
            {!!Form::close()!!}
            
            <div id="printable">
              <div class="box-header with-border">
                <h3 class="box-title">Datewise Filter</h3>
              </div> 
              <div class="box-header with-border col-sm-3 workingdaysdiv" style="display:none">
                <h3>Total-working days - <span class="noofworkingdays"></span></h3>
              </div>
              <div class="box-header with-border col-sm-3 latediv" style="display:none">
                  <h3>Annual Leave - <span class="annualleave" ></span></h3>
                </div>
                <div class="box-header with-border col-sm-3 latediv" style="display:none">
                    <h3>Sick Leave - <span class="sickleave" ></span></h3>
                  </div>
              <div class="box-header with-border col-sm-3 absentdiv" style="display:none">
                <h3>No-ofAbsent - <span class="noofabsent"></span></h3>
              </div>
              <div class="box-header with-border col-sm-3 latediv" style="display:none">
                <h3>Latecount - <span class="latecountcls" ></span></h3>
              </div>
              <div class="box-header with-border col-sm-3 latediv" style="display:none">
                  <h3>Late Approval - <span class="lateapproval" ></span></h3>
                </div>
                
              <div class="print col-sm-3 box-header with-border"style="display:none">
                <a  class="myprint btn btn-info btn-sm"><i class="fa fa-print"></i></a>
             </div>
             
              <table class="table">
                <thead>
                  <tr>
                    <th width="20%">Name</th>
                    <th width="20%">Date</th>
                    <th width="20%">Inn Time</th>
                    <th width="20%">Out Time</th>
                  </tr>
                </thead>
                <tbody class="datewiseappend">
                </tbody>
              </table>
          </div>
        </div>
        
      </div>
    </div>
  </section>
 
<script>
        

    $(function() {
       $('.myprint').on('click', function() {
        $("#printable").printThis({
                     
        });
      });
    });

      $( function() {
            $("#datepicker" ).datepicker();
            $("#datepicker1" ).datepicker();
        });
        $(document).on('submit','#filter',function(e){
          e.preventDefault();
          var minval = $('#filter').find('#datepicker').val();
          var conmindate = Date.parse(minval);
          var maxval = $('#filter').find('#datepicker1').val();
          var conmaxdate = Date.parse(maxval);

          if(minval ==''|| maxval==''){
            Swal.fire({
                  text: "Field must not be empty",
                  type: 'warning',
                  confirmButtonColor: 'red',
                  confirmButtonText: 'OK',
                })
          }else if(minval > maxval){
            Swal.fire({
                  text: "From Date Must be Smaller Than To Date!",
                  type: 'warning',
                  confirmButtonColor: 'red',
                  confirmButtonText: 'OK',
                })
          }else {
         var data = $(this).serialize();
                $('.latecountcls').text('');
                $('.noofabsent').text('')
                $('.noofworkingdays').text('');
          $.ajax({
              url:"datewiseattendance",
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
                toastr.success('Attendance Was Filtered Successfully');
                var latecount = 0;
                $('.datewiseappend').empty();
                if(data[0].length < 1){
                  $('.datewiseappend').append(`<tr><td</td><td>No Result Found</td><td></td><td></td></tr>`);
                }else{
                  $.each(data[0],function(index,filterdata){
                         var  intimeuser  = filterdata.in_time;
                         var  outtimeuser  = filterdata.out_time;
                         var intimes = intimeuser.split(":");
                        
                         var outtimes = outtimeuser.split(":");
                         var inseconds =(intimes[0]*60*60)+intimes[1]*60 ;
                         var outseconds =(outtimes[0]*60*60)+outtimes[1]*60 ;
                         if(inseconds > 32400 || outseconds < 21600 ){
                          latecount++
                          $('.datewiseappend').append(` <tr class="timeerror">
                        <td scope="row">`+filterdata.name+`</td>
                        <td>`+filterdata.att_date+`</td>
                        <td>`+filterdata.in_time+`</td>
                        <td>`+filterdata.out_time+`</td>
                      </tr>`);
                         }else if(inseconds < 32400 && intimes[2] =='pm'){
                           latecount++
                          $('.datewiseappend').append(` <tr class="timeerror">
                        <td scope="row">`+filterdata.name+`</td>
                        <td>`+filterdata.att_date+`</td>
                        <td>`+filterdata.in_time+`</td>
                        <td>`+filterdata.out_time+`</td>
                      </tr>`);
                         }else{
                            $('.datewiseappend').append(` <tr>
                          <td scope="row">`+filterdata.name+`</td>
                          <td>`+filterdata.att_date+`</td>
                          <td>`+filterdata.in_time+`</td>
                          <td>`+filterdata.out_time+`</td>
                        </tr>`);
                      }
                    })
                 }


          var s = new Date($('#filter').find('#datepicker').val());
          var e = new Date($('#filter').find('#datepicker1').val());
          s.setHours(12,0,0,0);
          e.setHours(12,0,0,0);

          var totalDays = Math.round((e - s) / 8.64e7);
          //getting number of weeks
          var wholeWeeks = totalDays / 7 | 0;
          // Estimate business days as number of whole weeks * 6
            var days = wholeWeeks * 6;
            // If not even number of weeks, calc remaining weekend days
          if (totalDays % 7) {
            s.setDate(s.getDate() + wholeWeeks * 7);
            while (s < e) {
              s.setDate(s.getDate() + 1);
             // If day isn't afriday, add to business days
              if (s.getDay() != 5) {
                ++days;
              }
            }
          }
          //return days;
          var hdayar = data[1];
          var weekend = 5, 
           holDate, holDay;
          var phdays = 0;
           var json = data[1];
          var arr = [];
          for(var elm in json){
            arr.push(json[elm]);
          }
           for (var i = 0; i < arr.length; i++){
          holDate = Date.parse(arr[i]);
          holDay = new Date(holDate).getDay()
          if (holDay != weekend && holDate >= Date.parse(minval) && holDate <= Date.parse(maxval)) {
              phdays ++;
          }
      }
     var start_date = Date.parse(minval);
     var start_date_index = new Date(start_date).getDay();
     var end_date = Date.parse(maxval);
     var end_date_index = new Date(end_date).getDay();
     var total_bussenessday = 0;
     if(start_date_index != 5 && end_date_index != 5){
         total_bussenessday = days + 1;
     }else if(start_date_index == 5 && end_date_index == 5){
         total_bussenessday = days;
     }else if(start_date_index == 5 && end_date_index != 5){
      total_bussenessday = days;
     }else if(start_date_index != 5 && end_date_index == 5){
      total_bussenessday = days + 1;
     }else{
      total_bussenessday = days;
     }
     var total_bussenessday = total_bussenessday -  phdays;    
                
                // holDate1 = Date.parse(arr[0]);
                // holDay1 = new Date(holDate1).getDay()
                //console.log(holDate);
                var present_date_record = data[0].length;
                var no_of_absence_1 =(total_bussenessday - present_date_record);
                console.log(no_of_absence_1);
                $('.latediv').css('display','block');
                $('.print').css('display','block');
                $('.workingdaysdiv').css('display','block');
                $('.latecountcls').text(latecount);
                $('.noofabsent').text(no_of_absence_1)
                $('.absentdiv').css('display','block');
                $('.noofworkingdays').text(total_bussenessday);
                $('.lateapproval').text(data[2]);
                $('.annualleave').text(data[3]);
                $('.sickleave').text(data[4]);
               }
          });
        }
       });
       $(".datepicker").attr("autocomplete", "off");
       $(".datepicker1").attr("autocomplete", "off");
      </script>
@endsection