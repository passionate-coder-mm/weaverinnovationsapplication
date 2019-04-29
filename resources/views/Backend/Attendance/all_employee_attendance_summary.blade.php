@extends('Backend.admin_master')
@section('main-content')
<section class="content">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Attendance Summary</h3>
      </div>    
     
           <div class="box-body">
            {!!Form::open(['method' => 'POST','id'=>'allfilter'])!!}
            <div class="row">
                <div class="attsearch">
                    <div class="col-sm-4">
                      <div class="form-group">
                       <input type="text" name="from_date" class="form-control datepicker2" id="datepicker2" placeholder="From Date">
                       </div>
                    </div>
                    <div class="col-sm-4">
                       <div class="form-group">
                         <input type="text" name="to_date" class="form-control datepicker3" id="datepicker3" placeholder="To Date">
                          </div>
                    </div>
                    <div class="col-sm-2">
                       <div class="form-group">
                      <button type="submit" class="btn btn-warning">Search</button>
                    </div>
                </div>
             </div>
            </div>
            {!!Form::close()!!}
            </div>
                {{-- <div style="text-align:center">
                    <img src="{{url('/images/img1.png')}}" width="200" height="100">
                </div> --}}
                <div class="box-header with-border">
                  <h3 class="box-title">Datewise Attendance Summary for (<span class="totalworkdays"></span>) working days</h3>
                </div> 
                <div class="box-header with-border col-sm-3 workingdaysdiv" style="display:none">
                  <h3>Total-working days - <span class="noofworkingdays"></span></h3>
                </div>
                <div class="box-header with-border col-sm-3 absentdiv" style="display:none">
                  <h3>No-ofAbsent - <span class="noofabsent"></span></h3>
                </div>
                <div class="box-header with-border col-sm-3 latediv" style="display:none">
                  <h3>Latecount - <span class="latecountcls" ></span></h3>
                </div>
                <div class="print col-sm-3 box-header with-border"style="display:none">
                  <a  class="myprint btn btn-info btn-sm"><i class="fa fa-print"></i></a>
               </div>
               
                <table class="table">
                  <thead>
                    <tr>
                      <th width="12%">Name</th>
                      <th width="12%">Late Entry</th>
                      <th width="12%">Early Leave</th>
                      <th width="13%">LateApproval</th>
                      <th width="13%">Annual Leave</th>
                      <th width="13%">Sick Leave</th>
                      <th width="12%">Attend</th>
                      <th width="13%">Absent</th>
                    </tr>
                  </thead>
                   <tbody class="datewisesummaryappend">
                  </tbody>
                </table>
            </div>
          </div>
          
        </div>
      </div>
    </section>
 <script>
$( function() {
    $("#datepicker2" ).datepicker();
    $("#datepicker3" ).datepicker();
    $("#datepicker2").attr("autocomplete", "off");
    $("#datepicker3").attr("autocomplete", "off");
}); 
$(document).on('submit','#allfilter',function(e){
    e.preventDefault();
    var sdate = $('#allfilter').find('#datepicker2').val();
    var edate = $('#allfilter').find('#datepicker3').val();
    var startdate = Date.parse(sdate);
    var enddate = Date.parse(edate);
    if(sdate ==''|| edate==''){
    Swal.fire({
        text: "Field must not be empty",
        type: 'warning',
        confirmButtonColor: 'red',
        confirmButtonText: 'OK',
    })
    }else if(sdate > edate){
    Swal.fire({
    text: "From Date Must be Smaller Than To Date!",
    type: 'warning',
    confirmButtonColor: 'red',
    confirmButtonText: 'OK',
   })
  }else {
    var data = $(this).serialize();
    $('.datewisesummaryappend').empty();
    $.ajax({
        url:"datewise_complete_attendance_summary",
        method:"POST",
        data:data,
        dataType:"json",
        success:function(data)
        {   
            var s = new Date($('#allfilter').find('#datepicker2').val());
            var e = new Date($('#allfilter').find('#datepicker3').val());
            s.setHours(12,0,0,0);
            e.setHours(12,0,0,0);
            var totalDays = Math.round((e - s) / 8.64e7);
            var wholeWeeks = totalDays / 7 | 0;
            var days = wholeWeeks * 6;
            if (totalDays % 7) {
            s.setDate(s.getDate() + wholeWeeks * 7);
             while (s < e) {
              s.setDate(s.getDate() + 1);
              if (s.getDay() != 5) {
                ++days;
              }
            }
            }
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
            if (holDay != weekend && holDate >= Date.parse(sdate) && holDate <= Date.parse(edate)) {
              phdays ++;
            }
            }
            var start_date = Date.parse(sdate);
            var start_date_index = new Date(start_date).getDay();
            var end_date = Date.parse(edate);
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
            $.each(data[0],function(indes,attendancesummary){
              $('.datewisesummaryappend').append(`<tr><td><span class="namecss">`+attendancesummary.name+`</span></td><td><span class="latecss">`+attendancesummary.latecount+`</span></td><td><span class="earlycss">`+attendancesummary.earlyleave+`</span></td><td><span class="earlycss">`+attendancesummary.lateapprove+`</span></td><td><span class="anualleavecss">`+attendancesummary.annualleave+`</span></td><td><span class="sickleave">`+attendancesummary.sickleave+`<span></td><td><span class="absentcss">`+attendancesummary.totalattend+`</td><td><span class="absentcss">`+(total_bussenessday - attendancesummary.totalattend) +`</td></tr>`)
            })
            $('.totalworkdays').text(total_bussenessday);
          console.log(total_bussenessday);  
        } 
    });
  }
})
</script>
@endsection