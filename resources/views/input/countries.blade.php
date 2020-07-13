<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-4 col-form-label text-sm-right">{{ isset($label) ? $label : __('Country') }}</label>

	<div class="col-sm-6">
		<select class="form-control {{ $errors->has($field) ? 'is-invalid' : '' }}" id="{{ $field }}" name="{{ $field }}">
		@foreach( Countries::getList( config('app.locale') ) as $code => $name )
			<option value="{{ $code }}"{{ isset( $value ) && $code == $value ? ' selected' : '' }}>
				{{ $name }}
			</option>
		@endforeach
		</select>

		@if ($errors->has($field))
			<span class="invalid-feedback">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
