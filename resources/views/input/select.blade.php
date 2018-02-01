<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label for="{{ $field }}" class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		<select class="form-control" id="{{ $field }}" name="{{ $field }}">
		@foreach( $options as $option )
			<option value="{{ $option->id }}"{{ isset( $value ) && $option->is( $value ) ? ' selected' : '' }}>
				{{ $option->{ isset( $option_label ) ? $option_label : 'name' } }}
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
