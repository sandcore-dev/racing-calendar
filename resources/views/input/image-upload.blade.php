<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		<file-upload>
			<label class="btn btn-default">
				@lang('Afbeelding selecteren')
				<input id="{{ $field }}" type="file" name="{{ $field }}" accept="image/*" style="display: none;">
			</label>
		</file-upload>

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
