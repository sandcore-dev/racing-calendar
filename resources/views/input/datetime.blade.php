<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		<input class="form-control" type="text" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, isset($value) ? $value : '') }}" placeholder="@lang('YYYY-MM-DD HH:MM:SS')" pattern="^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$" title="@lang('YYYY-MM-DD HH:MM:SS')" {!! trim($slot) !!}>

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
