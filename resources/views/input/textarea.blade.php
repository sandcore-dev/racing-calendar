<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		<textarea id="{{ $field }}" class="form-control" name="{{ $field }}" {!! trim($slot) !!}>{{ old($field, isset($value) ? $value : '') }}</textarea>

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
