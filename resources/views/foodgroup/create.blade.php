@extends('common.layout')
@section('extra_css')
<style type="text/css">
	div.checker {
    	margin-top: 2px;
    	margin-left: -2px;
	}

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
		Food Group <small>add and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('foodgroup.index') }}">Food Group</a>
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
							<i class="fa fa-home"></i> Add New Food Group
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('foodgroup.store') }}" method="post" role="form" enctype="multipart/form-data">
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group" >
									<label class="col-md-3 control-label required">Kitchen</label>
									<div class="col-md-9 {{ $errors->has('kitchen') ? 'has-error' : '' }}">
										<select class="form-control select2" name="kitchen" id="kitchenid">
											<option value="">-select a kitchen-</option>
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
										<select class="form-control select2" name="categoryid" id="categoryid" >
											<option value="">-select a category-</option>
										</select>
										@if ($errors->has('categoryid'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('categoryid') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Food Group Name</label>
									<div class="col-md-9 {{ $errors->has('foodgroupname') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="foodgroupname" value="{{ old('foodgroupname') }}" placeholder="Food Name">
										<span class="help-block">
										enter food group name. </span>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Detail</label>
									<div class="col-md-9 {{ $errors->has('otherdetail') ? 'has-error' : '' }}">
										<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Other Detail">{{ old('otherdetail') }}</textarea>
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
										<a href="{{ route('foodgroup.index') }}" class="btn default">Cancel</a>
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
	            $('#categoryid').find('option').remove().end().append(_optValue);
	        } else if( resultData.msg && resultData.msg=='nodata' ) {
	            $('#categoryid').find('option').remove();
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
		$('#preview-image').attr('src','http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image'); //remove preview-images
	}


	$("#checkbox_branch").click(function(){
	    if($("#checkbox_branch").is(':checked') ){
	        $("#select2_multiple > option").prop("selected","selected");
	        $("#select2_multiple").trigger("change");
	    }else{
	        $("#select2_multiple > option").removeAttr("selected");
	         $("#select2_multiple").trigger("change");
	     }
	});

</script>
@endsection