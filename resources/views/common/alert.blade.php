@if(Session::has('message'))
	<div class="alert {{ Session::get('class') == '1' ? 'alert-success' : 'alert-danger' }}" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{ Session::get('message') }}</strong>
	</div>
@endif