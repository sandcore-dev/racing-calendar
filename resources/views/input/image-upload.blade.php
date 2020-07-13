<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-4 col-form-label text-sm-right">{{ $label }}</label>

	<div class="col-sm-6">
		@if( isset($value) && $value )
			<p>
				<img src="{{ Storage::url($value) }}" alt="{{ $label }}">
			</p>
		@endif
		
		<file-upload>
			<label class="btn btn-secondary">
				@lang('Afbeelding selecteren')
				<input id="{{ $field }}" type="file" class="{{ $errors->has($field) ? 'is-invalid' : '' }}" name="{{ $field }}" accept="image/jpeg, image/png, image/gif" style="display: none;">
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
			<span class="is-invalid">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
