<div class="form-body">
	<div class="form-group" >
		<label class="col-md-3 control-label required">Restaurant</label>
		<div class="col-md-9 {{ $errors->has('restaurantid') ? 'has-error' : '' }}">
			<select class="form-control select2" name="restaurantid" id="restaurantid">
				<option value="">- - - select a restaurant - - -</option>
				@if(!empty($allRestaurant))
				@foreach ($allRestaurant as $restaurantid => $restaurantname )
				<option value="{{ $restaurantid }}" {{ isset($category) ? ($category['restaurantid']==$restaurantid ? 'selected':'')  : (old('restaurantid') == $restaurantid ? 'selected' : '') }}>
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

	<div class="form-group">
		<label class="col-md-3 control-label required">Category Name</label>
		<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}">
			<input type="text" class="form-control" name="name" value="{{ isset($category)?$category['name'] : old('name') }}" placeholder="Enter category name">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label required">Name Color</label>
		<div class="col-md-9 {{ $errors->has('namecolor') ? 'has-error' : '' }}">
			<input type="text" class="form-control" name="namecolor" value="{{ isset($category)?$category['namecolor'] : old('namecolor') }}" placeholder="Enter category name color">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label">Detail</label>
		<div class="col-md-9 {{ $errors->has('otherdetail') ? 'has-error' : '' }}">
			<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Enter details" >{{ isset($category)?$category['otherdetail'] : old('otherdetail') }}</textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label ">Category Picture</label>
		<div class="col-md-9">
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail" >
					@if(!empty($category['picture']))
					<img src="{{ url('upload/menu/thumbnail_images/'.$category['picture']) }}" alt="preview" id="preview-image" />
					@else
					<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="preview" id="preview-image" />
					@endif
				</div>
											<!-- <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
											</div> -->
											<div>
												<span class="btn default btn-file">
													<input type="file" name="picture" id="image-upload">
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
												<input type="radio" name="is_active" value="1" {{ isset($category) ? ($category['is_active'] !=0 ? 'checked':'')  : (old('is_active') !=0 ? 'checked' : '') }}  > Published </label>
												<label class="radio-inline">
													<input type="radio" name="is_active" value="0" {{ isset($category) ? ($category['is_active'] ==0 ? 'checked':'')  : (old('is_active') ==0 ? 'checked' : '') }}  > Not Published </label>
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