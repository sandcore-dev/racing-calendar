<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ isset($label) ? $label : __('Country') }}</label>

	<div class="col-sm-6">
		<select class="form-control" id="{{ $field }}" name="{{ $field }}">
		@foreach( Countries::getList( config('app.locale') ) as $code => $name )
			<option value="{{ $code }}"{{ isset( $value ) && $code == $value ? ' selected' : '' }}>
				{{ $name }}
			</option>
		@endforeach
		</select>

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
