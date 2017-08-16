<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<!-- <script type="text/javascript" src="{{asset('/plugins/jquery-2.2.3.min.js')}}"></script> -->
<script type="text/javascript" src="{{asset('/plugins/select2.js')}}"></script>
<!-- <script src="{{ url ('/plugins/jquery-2.2.3.min.js') }}" type="text/javascript"></script> -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

 <script type="text/javascript">
 	$(document).ready(function() {
 	  $("#part_no").select2();
 	});
 	// alert('test');
 </script>
 <link rel="stylesheet" type="text/css" href="{{asset('/plugins/select2.css')}}">
