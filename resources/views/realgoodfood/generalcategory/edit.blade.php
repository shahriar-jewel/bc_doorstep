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
		General Category <small>add and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">General Category</a>
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
							<i class="fa fa-home"></i> Update General Category
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ url('general-category/'.$category['id']) }}" method="post" role="form" enctype="multipart/form-data">
	                         {{ csrf_field() }}
                             {{method_field('PUT')}}
							@include('realgoodfood.generalcategory.form')
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

jQuery('#restaurantid').select2();
</script>
@endsection