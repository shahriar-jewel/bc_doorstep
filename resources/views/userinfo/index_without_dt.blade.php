@extends('common.layout')
@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		User <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ route('dashboard.index') }}">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">User</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">View All</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				 <div class="portlet box green-haze">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-user"></i>User List
						</div>
						<div class="actions">
							<a href="{{ route('userinfo.create') }}" class="btn btn-circle red-sunglo btn-sm">
							<i class="fa fa-plus"></i> Add New</a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-scrollable">
							@include('common.alert')	
							<table class="table table-striped table-hover">
							<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Full Name
								</th>
								<th>
									Gender
								</th>
								<th>
									Email
								</th>
								<th>
									Contact No
								</th>
								<th>
									User Type
								</th>
								<th>
									Status
								</th>
								<th>
									Action
								</th>
							</tr>
							</thead>
							<tbody>
							
							<?php $usrNo = ($allUser->currentPage() * $allUser->perPage() ) - ($allUser->perPage() - 1 ); 
							?>
							@foreach($allUser as $usr)
							<tr>
								<td>
									{{ $usrNo++ }}
								</td>
								<td>
									{{ $usr['fullname'] }}
								</td>
								<td>
									{{ isset( $alluserGender[$usr['gender']] ) ? $alluserGender[$usr['gender']] : ''  }}
								</td>
								<td>
									{{ $usr['email'] }}
								</td>
								
								<td>
									{{ $usr['contactno'] }}
								</td>
								<td>
									<span class="label label-sm label-info">
									{{ isset( $alluserType[ $usr['usertype'] ] ) ? $alluserType[ $usr['usertype'] ] : '' }}
									</span>
								</td>
								<td>
									<span class="label label-sm label-{{ $usr['isactive'] == 1 ? 'success' : 'danger' }} ">
									{{ $usr['isactive'] == 1 ? 'Active' : 'Inactive' }}
									</span>
								</td>
								<td>
									<a href="{{ route('userinfo.edit',$usr['userid']) }}" class="btn btn-circle btn-xs purple">
									<i class="fa fa-edit"></i> Edit </a>
									<a href="{{ route('userinfo.resetpassword',$usr['userid']) }}" class="btn btn-circle btn-xs red">
									<i class="fa fa-edit"></i> Reset Password </a>
								</td>
							</tr>
							@endforeach

							</tbody>
							</table>
							{{ $allUser->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
@endsection
