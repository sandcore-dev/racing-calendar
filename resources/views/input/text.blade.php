<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		<input id="{{ $field }}" type="{{ isset($type) ? $type : 'text' }}" class="form-control" name="{{ $field }}" value="{{ old($field, isset($value) ? $value : '') }}" {!! trim($slot) !!}>

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>