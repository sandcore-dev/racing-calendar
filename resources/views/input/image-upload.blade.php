<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		@if( isset($value) && $value )
			<p>
				<img src="{{ Storage::url($value) }}" alt="{{ $label }}">
			</p>
		@endif
		
		<file-upload>
			<label class="btn btn-default">
				@lang('Afbeelding selecteren')
				<input id="{{ $field }}" type="file" name="{{ $field }}" accept="image/jpeg, image/png, image/gif" style="display: none;">
			</label>
		</file-upload>
		
		@if( isset($value) && $value )
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remove_{{ $field }}" value="1">
					@lang('Remove image')
				</label>
			</div>
		@endif

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
