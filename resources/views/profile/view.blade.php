@extends('common.layout')
@section('content')
		<div class="page-content">
			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Profile <small>view and edit</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{ route('dashboard.index') }}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Profile</a>
					</li>
				</ul>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="portlet green-haze box">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>Profile Information
							</div>
							<div class="actions">
								<a href="{{ route('profile.edit') }}" class="btn btn-default btn-sm">
								<i class="fa fa-pencil"></i> Edit </a>
							</div>
						</div>
						<div class="portlet-body">
							@include('common.alert')
							<div class="row static-info">
								<div class="col-md-5 name">
									 Full Name:
								</div>
								<div class="col-md-7 value">
									 {{ session()->get('doorstepuser.fullname') }}
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 name">
									 Email:
								</div>
								<div class="col-md-7 value">
									 {{ session()->get('doorstepuser.email') }}
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 name">
									 Phone Number:
								</div>
								<div class="col-md-7 value">
									 {{ session()->get('doorstepuser.contactno') }}
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 name">
									 Gender:
								</div>
								<div class="col-md-7 value">
									@if(session()->get('doorstepuser.gender') == 3)
										Other
									@elseif(session()->get('doorstepuser.gender') == 2)
										Female
									@else
										Male
									@endif
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 name">
									 Date of Birth:
								</div>
								<div class="col-md-7 value">
									 {{ session()->get('doorstepuser.dateofbirth') }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
@endsection
