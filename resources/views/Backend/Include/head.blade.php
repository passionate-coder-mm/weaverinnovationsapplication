<head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <title>WeaverInnovations</title>
          <!-- Tell the browser to be responsive to screen width -->
          <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : '' }}">
          <!-- Bootstrap 3.3.7 -->
         <link rel="stylesheet" href="{{asset('themeasset/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
         <link rel="stylesheet" href="{{asset('themeasset/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
          <!-- Font Awesome -->
          <link rel="stylesheet" href="{{asset('themeasset/bower_components/font-awesome/css/font-awesome.min.css')}}">
          <!-- Ionicons -->
          <link rel="stylesheet" href="{{asset('themeasset/bower_components/Ionicons/css/ionicons.min.css')}}">
          <!-- daterange picker -->
          <link rel="stylesheet" href="{{asset('themeasset/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
          <!-- bootstrap datepicker -->
          <link rel="stylesheet" href="{{asset('themeasset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
          <!-- iCheck for checkboxes and radio inputs -->
          <link rel="stylesheet" href="{{asset('themeasset/plugins/iCheck/all.css')}}">
          <!-- Bootstrap Color Picker -->
          <link rel="stylesheet" href="{{asset('themeasset/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
          <!-- Bootstrap time Picker -->
          <link rel="stylesheet" href="{{asset('themeasset/plugins/timepicker/bootstrap-timepicker.min.css')}}">
          <!-- Select2 -->
          <link rel="stylesheet" href="{{asset('themeasset/bower_components/select2/dist/css/select2.min.css')}}">
          <!-- Theme style -->
          <link rel="stylesheet" href="{{asset('themeasset/dist/css/AdminLTE.min.css')}}">
          <!-- AdminLTE Skins. Choose a skin from the css/skins
               folder instead of downloading all of them to reduce the load. -->
          <link rel="stylesheet" href="{{asset('themeasset/dist/css/skins/_all-skins.min.css')}}">
          <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
          <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
         
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
          <script type="text/javascript" src="{{asset('themeasset/instascan.min.js')}}" ></script>

          {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.min.css" />
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
          <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
          <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
         

          {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.14.0/printThis.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.14.0/printThis.min.js"></script> --}}
          {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.14.0/printThis.min.js.map"></script> --}}
          <!-- Google Font -->
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
          <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
          <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

           <link rel="stylesheet" href="{{asset('themeasset/mycustom.css')}}">

           <script>
                    window.Laravel = {!! json_encode([
                        'csrfToken' => csrf_token(),
                       ]); 
                    !!}
                </script>

               @if(!auth()->guest())
                    <script>
                    window.Laravel.userId = {!! auth()->user()->id; !!}
                    </script>
               @endif
        </head>
