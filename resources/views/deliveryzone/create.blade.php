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
		Deliveryzone <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('deliveryzone.index') }}">Deliveryzone</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Add New</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
							@if ($errors->any())
    <div class="alert alert-danger messageFadeTime">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Please check the form below for errors
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				 <div class="portlet box green-haze ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-home"></i> Create New Deliveryzone
						</div>
					</div>
					<div class="portlet-body form">
						<form class="form-horizontal" action="{{ url('deliveryzone') }}" method="post" role="form">
	                        {{ csrf_field() }}
							<div class="form-body">

								<div class="form-group">
									<label class="col-md-3 control-label required">Deliveryzone</label>
									<div class="col-md-9">
											<input type="text" class="form-control" name="zonename" placeholder="Enter deliveryzone">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="is_active" value="1" {{ old('is_active') != '0' ? 'checked' : '' }}  > Active </label>
											<label class="radio-inline">
											<input type="radio" name="is_active" value="0" {{ old('is_active') == '0' ? 'checked' : '' }}  > Inactive </label>
											<label class="radio-inline">
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Submit</button>
										
										<a href="{{ route('deliveryzone.index') }}" class="btn default">Cancel</a>
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
