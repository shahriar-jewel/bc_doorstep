@extends('common.layout')
@section('extra_css')
<style type="text/css">
	div.checker {
    	margin-top: 2px;
    	margin-left: -2px;
	}
</style>
@endsection

@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		Member <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('member.index') }}">Member</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Add New</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				 <div class="portlet box green-haze ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-home"></i> Create New Member
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('member.store') }}" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
	                        {{ csrf_field() }}
							<div class="form-body">

								<div class="form-group">
									<label class="col-md-3 control-label required">Member ID</label>
									<div class="col-md-9 {{ $errors->has('member_id') ? 'has-error' : '' }}" >
										<input type="text" class="form-control" name="member_id" value="{{ old('member_id') }}" placeholder="Enter member id">
										@if ($errors->has('member_id'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('member_id') }}</strong>
		                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Member Name</label>
									<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}" >
										<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter member name">
										@if ($errors->has('name'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('name') }}</strong>
		                                    </span>
		                                @endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label required">Member Type</label>
									<div class="col-md-9 {{ $errors->has('type') ? 'has-error' : '' }}" >
										<input type="text" class="form-control" name="type" value="{{ old('type') }}" placeholder="Enter member type">
										@if ($errors->has('type'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('type') }}</strong>
		                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Mobile No</label>
									<div class="col-md-9 {{ $errors->has('contactno') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-phone-square"></i>
											<input type="text" class="form-control" name="contactno" value="{{ old('contactno') }}" placeholder="Enter mobile No">
											@if ($errors->has('contactno'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('contactno') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Mobile Image</label>
									<div class="col-md-9 {{ $errors->has('image') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-phone-square"></i>
											<input type="text" class="form-control" name="imageurl" value="{{ old('image') }}" placeholder="Enter image url">
											@if ($errors->has('image'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('image') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="isactive" value="Y" {{ old('isactive') != 'N' ? 'checked' : '' }}  > Active </label>
											<label class="radio-inline">
											<input type="radio" name="isactive" value="N" {{ old('isactive') == 'N' ? 'checked' : '' }}  > Inactive </label>
											<label class="radio-inline">
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Submit</button>
										<button type="reset" class="btn red">Reset</button>
										<a href="{{ route('member.index') }}" class="btn default">Cancel</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
@endsection

@section('extra_js')


@endsection