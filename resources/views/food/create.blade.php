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
		Food <small>add and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('food.index') }}">Food</a>
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
							<i class="fa fa-home"></i> Add New Food
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('food.store') }}" method="post" role="form" enctype="multipart/form-data">
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group" >
									<label class="col-md-3 control-label required">Kitchen</label>
									<div class="col-md-9 {{ $errors->has('kitchen') ? 'has-error' : '' }}">
										<select class="form-control select2" name="kitchen" id="kitchenid">
											<option value="">- - - select a kitchen - - -</option>
											@foreach ($allKitchen as $kitchenid => $kitchenname )
											<option value="{{ $kitchenid }}">
												{{ $kitchenname }}
											</option>
											@endforeach
										</select>
										
										@if ($errors->has('kitchen'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('kitchen') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group" >
									<label class="col-md-3 control-label required">Category</label>
									<div class="col-md-9 {{ $errors->has('categoryid') ? 'has-error' : '' }}">
										<select class="form-control select2me" name="categoryid" id="categoryid" >
											<option value="">-select an option-</option>
										</select>
										@if ($errors->has('categoryid'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('categoryid') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group" >
									<label class="col-md-3 control-label required">Food Group</label>
									<div class="col-md-9 {{ $errors->has('foodgroupid') ? 'has-error' : '' }}">
										<select class="form-control select2me" name="foodgroupid" id="foodgroupid" required="">
											<option value="">-select an option-</option>
										</select>
										@if ($errors->has('foodgroupid'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('foodgroupid') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Food Name</label>
									<div class="col-md-9 {{ $errors->has('foodname') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="foodname" value="{{ old('foodname') }}" placeholder="Food Name" required="">
										<span class="help-block">
										enter food name. </span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Detail</label>
									<div class="col-md-9 {{ $errors->has('otherdetail') ? 'has-error' : '' }}">
										<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Other Detail" >{{ old('otherdetail') }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Price</label>
									<div class="col-md-9 {{ $errors->has('price') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="Price">
										@if ($errors->has('price'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('price') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label ">Vat</label>
									<div class="col-md-9 {{ $errors->has('vat') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="vat" value="{{ old('vat') }}" placeholder="Vat">
										@if ($errors->has('vat'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('vat') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Quantity</label>
									<div class="col-md-9 {{ $errors->has('quantity') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}" placeholder="Quantity">
										@if ($errors->has('quantity'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('quantity') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label ">Food Picture</label>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" >
												<img src="{{ asset('imageFolder/no-image.jpg') }}" alt="preview" id="preview-image" />
											</div>
											<!-- <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
											</div> -->
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
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Submit</button>
										<button type="reset" class="btn red">Reset</button>
										<a href="{{ route('food.index') }}" class="btn default">Cancel</a>
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

	$("#comboitemSection").hide();

	// To get the branch list
	$('#kitchenid').on('change', function() {
    	var kitchenID = this.value;
    	$.ajax({
	        method: "POST",
	        url: "{{ url('ajax/categorybykitchen') }}",
	        dataType: "json",
	        data: { _token: "{{ csrf_token() }}" , kitchen_id : kitchenID }
	    }).done(function( resultData ) {
	    	// console.log(resultData);
	        if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
	            var _data = resultData.data;
	            var _optValue = "<option value='' >-select an option-</option>";
	            for( var i=0; i<resultData.data.length; i++ ) {
	                _optValue+= '<option value="'+resultData.data[i].categoryid+'" data-foodtype="'+resultData.data[i].categorytype+'" >'+resultData.data[i].categoryname+'</option>';
	            }
	            $('#categoryid').val(_optValue).trigger('change');
	            $('#categoryid').find('option').remove().end().append(_optValue);
	        } else if( resultData.msg && resultData.msg=='nodata' ) {
	            $('#categoryid').val("").trigger('change');
	            $('#categoryid').find('option').remove();
	        }
	    });

    });

	// to get the food group list
    $('#categoryid').on('change', function() {
    	var categoryID = this.value;
    	$.ajax({
	        method: "POST",
	        url: "{{ url('ajax/foodgroupbycategory') }}",
	        dataType: "json",
	        data: { _token: "{{ csrf_token() }}" , category_id : categoryID }
	    }).done(function( resultData ) {
	    	// console.log(resultData);
	        if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
	            var _data = resultData.data;
	            var _optValue = "<option value='' >-select a group-</option>";
	            for( var i=0; i<resultData.data.length; i++ ) {
	                _optValue+= '<option value="'+resultData.data[i].foodgroupid+'" >'+resultData.data[i].foodgroupname+'</option>';
	            }
	            $('#foodgroupid').val(_optValue).trigger('change');
	            $('#foodgroupid').find('option').remove().end().append(_optValue);
	        } else if( resultData.msg && resultData.msg=='nodata' ) {
	            $('#foodgroupid').val("").trigger('change');
	            $('#foodgroupid').find('option').remove();
	        }
	    });
    });



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
		$('#preview-image').attr('src',"{{ asset('imageFolder/no-image.jpg') }}"); //remove preview-images
	}

jQuery('#select2_multiple_tag').select2();
</script>
@endsection