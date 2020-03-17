<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Treatlocally | Dashboard</title>
 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <link rel="icon" href="{{url('/')}}/public/tl_admin/dist/img/favicon.ico" type="image/x-icon"> 
 
  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/dist/css/admin-style.css">

  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
 
  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/font-awesome/css/font-awesome.min.css">
 
  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/Ionicons/css/ionicons.min.css">
  
  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
 
  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/dist/css/skins/_all-skins.min.css">
  
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">


  <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/select2/dist/css/select2.min.css">


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">

<!--    <link rel="stylesheet" href="{{url('/')}}/public/js/assets/css/normalize.css">
  <link rel="stylesheet" href="{{url('/')}}/public/js/assets/css/skeleton.css"> -->
 

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

             @include('tl_admin.common.header')



            @include('tl_admin.common.sidebar')
  
                
  <div class="content-wrapper">
  
 

    @yield('content')

    

   </div>

   @include('tl_admin.common.footer')

   <!-- Control Sidebar -->
 
   @include('tl_admin.common.right-sidebar')
 

    <div class="control-sidebar-bg"></div>

    </div>


   
<script src="{{url('/')}}/public/tl_admin/bower_components/jquery/dist/jquery.min.js"></script>

<script src="{{url('/')}}/public/tl_admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<script src="{{url('/')}}/public/tl_admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
 <script src="{{ url('/') }}/public/tl_admin/bower_components/ckeditor/ckeditor.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button);
</script> -->

<script src="{{url('/')}}/public/tl_admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>





<!-- <script src="{{url('/')}}/public/tl_admin/bower_components/moment/min/moment.min.js"></script> -->

<script src="{{url('/')}}/public/tl_admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="{{url('/')}}/public/tl_admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>



<script src="{{url('/')}}/public/tl_admin/dist/js/adminlte.min.js"></script>



<script src="{{url('/')}}/public/tl_admin/dist/js/demo.js"></script>
<script src="{{url('/')}}/public/tl_admin/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/printThis.js"></script>

  <!-- demo -->
  <script>
   /*$('#basic').on("click", function () {

      $('.demo').printThis({
        debug: false,
        importCSS: false,            // import page CSS
        importStyle: false,         // import style tags
        printContainer: false,       // grab outer container as well as the contents of the selector
        pageTitle: "",
        removeInline: false,
        header: false,
        footer: false,
        base: false ,
        loadCSS: "{{url('/')}}/public/tl_admin/dist/css/admin-style.css"
      });
    });*/

$('#basic').on("click", function () {
       var printContents = document.getElementById('printableArea').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    });
    /*$('#advanced').on("click", function () {
      $('#print-one, #print-two').printThis({
        importCSS: true,
        header: "<h1>Look at all of my kitties!</h1>",
        base: "https://jasonday.github.io/printThis/"
      });
    });*/
  </script>

  <script>
    $('.select2').select2();

     jQuery(function(){
      var date = new Date();
    date.setDate(date.getDate());
	    jQuery('#treat_valid').datepicker(
        { startDate: date }
      );
	}); 
  </script>
  <script>
$(document).ready(function() {
    $('#example').DataTable({
      "language": {
    "lengthMenu": '<div> <select class="troopets_selectbox">'+
      '<option value="10">10</option>'+
      '<option value="20">20</option>'+
      '<option value="30">30</option>'+
      '<option value="40">40</option>'+
      '<option value="50">50</option>'+
      '<option value="60">60</option>'+

      '<option value="-1">All</option>'+
      '</select> <span class="record">Records Per Page </span></div>'
  }
    });
    soTable = $('#example').DataTable();
  $('#srch-term').keyup(function(){
         soTable.search($(this).val()).draw() ;
   });

$('.something').click( function () {
var ddval = $('.something option:selected').val();
console.log(ddval);
var oSettings = oTable.fnSettings();
oSettings._iDisplayLength = ddval;
oTable.fnDraw();
});
oTable = $('#example').dataTable();

} );

</script>

</body>
</html>

