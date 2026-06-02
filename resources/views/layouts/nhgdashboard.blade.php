<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{env("APP_NAME")}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('admin/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  
    <style>
        .dropzone .dz-preview .dz-image img {
            width: 100%;
            height: 100%;
        }
        .select2-container--default .select2-selection--single {
    direction: rtl;
        }
        .select2-results__option[aria-selected] {

    text-align: right;
}
   .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .no-sort::after { display: none!important; }

.no-sort { pointer-events: none!important; cursor: default!important; }
.skin-purple .main-header .navbar {
    background-color: #3c8dbc;
}
.skin-purple .sidebar a {
    color: #FFFFED;
    font-size: 15px !important;
}
.skin-purple .main-header .navbar {
    background-color: #000000;
}
.sidebar-menu
{
    background-color: black;
}
.btn-black{
    background:black;
    color:white;
}
tbody{
    font-weight: bold;
}
.active{
    background:gray;
}
.select2-container--default .select2-selection--multiple .select2-selection__rendered li {
    list-style: none;
    color: black;
}
.sorting_1 {
    background-color: black;
}

table.dataTable.display tbody tr.even>.sorting_1{
    background-color: #000000;
}
table.dataTable.display tbody tr.odd>.sorting_1 {
    background-color: #000000 !important;
}
    </style>
    
    @yield('css')
</head>

<body class="skin-purple sidebar-mini">
<?php $levels=App\CourseLevel::orderBy('created_at','desc')->get(); ?>
   


@if (Session::has('warning'))
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        {{Session::get('warning')}}
    </div>
@endif


@if (Session::has('info'))
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        {{Session::get('info')}}
    </div>
@endif


@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        {{Session::get('success')}}
    </div>
@endif

        @include('flash::message')
            @yield('content')



    </div>


<!-- jQuery 3.1.1 -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    
        <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
               
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                  <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
                   <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script>
       $(document).ready(function() {
    $('.example').DataTable( {
           responsive: true,
           scrollX: true,
            dom: 'Bfrtip',
        buttons: [
             'excel','pageLength'
        ],
     "aaSorting": []

        
    } );
});
  $(document).ready(function () {
  $(".select").select2();
  });
    </script>
@stack('scripts')

</body>
</html>
