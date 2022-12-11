@extends('common.layout')
@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		Category <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('category.index') }}">Category</a>
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
							<i class="fa fa-home"></i> Edit Category
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('category.update') }}" method="post" role="form">
	                        {{ csrf_field() }}
							<input type="hidden" name="catid" value="{{ $category['categoryid'] }}">

							<div class="form-body">

								<div class="form-group" >
									<label class="col-md-3 control-label required">Kitchen</label>
									<div class="col-md-9 {{ $errors->has('kitchen') ? 'has-error' : '' }}">
										<select class="form-control select2" name="kitchen" id="kitchenid">
											<option value="">- - - select a kitchen - - -</option>
											@foreach ($allKitchen as $kitchenid => $kitchenname )
											<option value="{{ $kitchenid }}" {{ ( old('branch') == $kitchenid || $category['kitchenid'] == $kitchenid ) ? 'selected' : '' }} >
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

								<div class="form-group">
									<label class="col-md-3 control-label required">Category Name</label>
									<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $category['name'] }}" placeholder="Name">
										@if ($errors->has('name'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Serial No</label>
									<div class="col-md-9 {{ $errors->has('serialno') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="serialno" value="{{ old('serialno') ? old('serialno') : $category['serialno'] }}" placeholder="serial no">
										@if ($errors->has('serialno'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('serialno') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Other Detail</label>
									<div class="col-md-9 {{ $errors->has('otherdetail') ? 'has-error' : '' }}">
										<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Other Detail">{{ old('otherdetail') ? old('otherdetail') : $category['otherdetail'] }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label ">Food Picture</label>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" >
												@if(isset($category['originalpicture']) && $category['originalpicture'] )
												<img src="{{ URL::asset('upload/menu/normal_images/'.$category['originalpicture']) }}" alt="preview" id="preview-image" style="width: 100px" />
												@else
												<img src="{{ asset('imageFolder/no-image.jpg') }}" alt="preview" id="preview-image" style="width: 100px" />
												@endif
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
											<input type="radio" name="is_active" value="1" {{ old('is_active') != '0' || $category['is_active'] == 1 ? 'checked' : '' }}  > Active </label>
											<label class="radio-inline">
											<input type="radio" name="is_active" value="0" {{ old('is_active') == '0' || $category['is_active'] == '0'  ? 'checked' : '' }}  > Inactive </label>
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
										<a href="{{ route('category.index') }}" class="btn default">Cancel</a>
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

	$('#kitchenid').on('change', function() {
    	var kitchenID = this.value;
    	$.ajax({
	        method: "POST",
	        url: "{{ url('ajax/categorybykitchen') }}",
	        dataType: "json",
	        data: { _token: "{{ csrf_token() }}" , kitchen_id : kitchenID }
	    }).done(function( resultData ) {
	    	console.log(resultData);
	        if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
	            var _data = resultData.data;
	            var _optValue = "<option value='' >-select an option-</option>";
	            for( var i=0; i<resultData.data.length; i++ ) {
	                _optValue+= '<option value="'+resultData.data[i].categoryid+'">'+resultData.data[i].categoryname+'</option>';
	            }
	            $('#parentid').find('option').remove().end().append(_optValue);
	        } else if( resultData.msg && resultData.msg=='nodata' ) {
	            $('#parentid').find('option').remove();
	        }
	    });

    });
</script>
@endsection