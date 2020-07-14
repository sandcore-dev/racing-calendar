<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-4 col-form-label text-sm-right">{{ $label }}</label>

	<div class="col-sm-6">
		<input id="{{ $field }}" type="{{ isset($type) ? $type : 'text' }}" class="form-control {{ $errors->has($field) ? 'is-invalid' : '' }}" name="{{ $field }}" value="{{ old($field, isset($value) ? $value : '') }}" {!! trim($slot) !!}>

		@if ($errors->has($field))
			<span class="invalid-feedback">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
