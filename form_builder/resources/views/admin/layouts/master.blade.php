<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>@yield('title') | {{config('app.name')}}</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">	
		<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
		@include('admin.layouts.header')
	</head>
	<body class="hold-transition sidebar-mini">
				<!-- Site wrapper -->
		<div class="wrapper">	
				<!--begin::Aside-->
				@include('admin.layouts.topnavbar')
				@include('admin.layouts.sidebar')		
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content-wrapper">
					<section class="content-header">
						<div class="container-fluid">
					        	@yield('admin-content')							
						</div><!-- /.container-fluid -->
						</section>
						   <!-- Main content -->
						<section class="content">
							<!-- Default box -->	
								  @yield('admin-main-content')						    
						</section>			
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					@include('admin.layouts.footer')
					<!--end::Footer-->
				<!-- </div> -->
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
		@include('admin.layouts.scripts')
	</body>
	<!--end::Body-->
</html>