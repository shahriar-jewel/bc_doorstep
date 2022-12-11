	
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<!--[if lt IE 9]>
	<script src="../../assets/global/plugins/respond.min.js"></script>
	<script src="../../assets/global/plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ URL::asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/global/plugins/backstretch/jquery.backstretch.min.js') }} " type="text/javascript"></script>
	<script src="{{ URL::asset('assets/admin/pages/scripts/login-soft.js') }}" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
	jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Login.init();
	Demo.init();
	// init background slide images
	var baseurl = "{{ asset('/') }}";
       $.backstretch([
	        baseurl+"assets/admin/pages/media/bg/1.jpg",
	        // baseurl+"assets/admin/pages/media/bg/2.jpg",
	        // baseurl+"assets/admin/pages/media/bg/3.jpg",
	        // baseurl+"assets/admin/pages/media/bg/4.jpg"
	        ], {
	          fade: 1000,
	          duration: 8000
	    }
	    );
	});
	</script>
	<!-- END JAVASCRIPTS -->