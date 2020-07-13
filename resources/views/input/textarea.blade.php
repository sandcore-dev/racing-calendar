<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-4 col-form-label text-sm-right">{{ $label }}</label>

	<div class="col-sm-6">
		<textarea id="{{ $field }}" class="form-control {{ $errors->has($field) ? 'is-invalid' : '' }}" name="{{ $field }}" {!! trim($slot) !!}>{{ old($field, isset($value) ? $value : '') }}</textarea>

		@if ($errors->has($field))
			<span class="is-invalid">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
