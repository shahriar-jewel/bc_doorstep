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
		Customer <small> edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('customer.index') }}">Customer</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Edit</a>
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
							<i class="fa fa-home"></i> Edit Customer
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ url('updateordercustomer') }}" method="post" role="form">
	                        {{ csrf_field() }}
							<div class="form-body">

								<div class="form-group">
									<label class="col-md-3 control-label required">Customer Name</label>
									<div class="col-md-9 {{ $errors->has('cusname') ? 'has-error' : '' }}" >
										<input type="text" class="form-control" name="name" value="{{ $customerdata->name }}" placeholder="Customer Name">
										<span class="help-block">
										enter customer name. </span>
									</div>
								</div>

								<input type="hidden" name="customerid" value="{{ $customerdata->customerid }}">
								<input type="hidden" name="ordernumber" value="{{ $customerdata->ordernumber }}">

								<div class="form-group">
									<label class="col-md-3 control-label required">Mobile No</label>
									<div class="col-md-9 {{ $errors->has('cuscontactno') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-phone-square"></i>
											<input type="text" class="form-control" name="contactno" value="{{ $customerdata->contactno }}" placeholder="Mobile No">
											@if ($errors->has('cuscontactno'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('cuscontactno') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Date of Birth</label>
									<div class="col-md-9 {{ $errors->has('dateofbirth') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-calendar"></i>
											<input type="text" class="form-control date-picker" name="dateofbirth" value="{{ $customerdata->dateofbirth }}"  placeholder="Date of Birth">
											@if ($errors->has('dateofbirth'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('dateofbirth') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Gender</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="gender" value="1" {{ $customerdata->gender == 1 ? 'checked' : '' }}  > Male </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="2" {{ $customerdata->gender == 2 ? 'checked' : '' }}  > Female </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="3" {{ $customerdata->gender == 3 ? 'checked' : '' }}  > Other </label>
										</div>
									</div>
								</div>

								<div class="form-group ">
									<label class="col-md-3 control-label ">Email Address</label>
									<div class="col-md-9 {{ $errors->has('email') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-envelope"></i>
											<input type="text" class="form-control" name="email" value="{{ $customerdata->email }}"  placeholder="Email Address">
										</div>
										@if ($errors->has('email'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('email') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

							
								
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Update</button>
										
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
<script type="text/javascript">

	$('#branchid').on('change', function() {
    	var branchID = this.value;
    	$.ajax({
	        method: "POST",
	        url: "{{ url('ajax/categorybybranch') }}",
	        dataType: "json",
	        data: { _token: "{{ csrf_token() }}" , branch_id : branchID }
	    }).done(function( resultData ) {
	    	console.log(resultData);
	        if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
	            var _data = resultData.data;
	            var _optValue = "<option value='' >-select an option-</option>";
	            for( var i=0; i<resultData.data.length; i++ ) {
	                _optValue+= '<option value="'+resultData.data[i].categoryid+'">'+resultData.data[i].categoryname+'</option>';
	            }
	            $('#parentid').val(_optValue).trigger('change');
	            $('#parentid').find('option').remove().end().append(_optValue);
	        } else if( resultData.msg && resultData.msg=='nodata' ) {
	            $('#parentid').val("").trigger('change');
	            $('#parentid').find('option').remove();
	        }
	    });
    });
</script>
@endsection