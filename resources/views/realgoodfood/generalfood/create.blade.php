@extends('common.layout')
@section('extra_css')
<style type="text/css">
	/*div.checker {
    	margin-top: 2px;
    	margin-left: -2px;
	}*/
	textarea { resize: vertical; }
	.thumbnail{
		width: 200px; height: 150px;
	}
	.thumbnail>img {
		max-width:100%;max-height:100%; 
	}
</style>
@endsection

@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		General Food <small>add and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">General Food</a>
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
							<i class="fa fa-home"></i> Add General Food
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ url('general-food') }}" method="post" role="form" enctype="multipart/form-data">
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group" >
									<label class="col-md-3 control-label">Restaurant</label>
									<div class="col-md-9 {{ $errors->has('restaurantid') ? 'has-error' : '' }}">
										<select class="form-control select2" name="restaurantid" id="restaurantid">
											<option value="">- - - select restaurant - - -</option>
											@if(!empty($allRestaurant))
											@foreach ($allRestaurant as $restaurantid => $restaurantname )
											<option value="{{ $restaurantid }}" {{ ( old('restaurantid') == $restaurantid ) ? 'selected' : '' }}>
												{{ $restaurantname }}
											</option>
											@endforeach
											@endif
										</select>
										
										@if ($errors->has('restaurantid'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('restaurantid') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group" >
									<label class="col-md-3 control-label required">General Category</label>
									<div class="col-md-9 {{ $errors->has('categoryid') ? 'has-error' : '' }}">
										<select class="form-control select2" name="categoryid" id="categoryid">
											<option value="">- - - select category - - -</option>
											@if(!empty($allgeneralcategory))
											@foreach ($allgeneralcategory as $gnl_categoryid => $gnl_categorname )
											<option value="{{ $gnl_categoryid }}" {{ ( old('categoryid') == $gnl_categoryid ) ? 'selected' : '' }}>
												{{ $gnl_categorname }}
											</option>
											@endforeach
											@endif
										</select>
										
										@if ($errors->has('categoryid'))
	                                    <span class="help-block has-error">
	                                       <strong>{{ $errors->first('categoryid') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-3 control-label required">Food Name</label>
									<div class="col-md-9 {{ $errors->has('foodname') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="foodname" value="{{ old('foodname') }}" placeholder="Enter  food name">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Food Name Color</label>
									<div class="col-md-9 {{ $errors->has('foodnamecolor') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="foodnamecolor" value="{{ old('foodnamecolor') }}" placeholder="Enter food name color">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Detail</label>
									<div class="col-md-9 {{ $errors->has('otherdetail') ? 'has-error' : '' }}">
										<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Enter details" >{{ old('otherdetail') }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label ">Food Picture</label>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" >
												<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="preview" id="preview-image" />
											</div>
											<div>
												<span class="btn default btn-file">
												<input type="file" name="originalpicture" id="image-upload">
												</span>
												<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput" id="remove-preview" onclick="resetPreview()">
												Remove </a>
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="status" value="1" {{ old('status') != '0' ? 'checked' : '' }}  > Published </label>
											<label class="radio-inline">
											<input type="radio" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}  > Not Published </label>
											<label class="radio-inline">
										</div>
									</div>
								</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Submit</button>
										<button type="reset" class="btn red">Reset</button>
										<a href="#" class="btn default">Cancel</a>
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
    function readURL(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
		  $('#preview-image').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
		}
	}

	$("#image-upload").change(function() {
	 	readURL(this);
	});

	function resetPreview(){
		$('#image-upload').val('');
		$('#preview-image').attr('src',"https://www.placehold.it/200x150?text=no+image"); //remove preview-images
	}
jQuery('#categoryid').select2();
jQuery('#restaurantid').select2();
</script>
@endsection