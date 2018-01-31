<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
	<label class="col-sm-4 control-label">{{ $label }}</label>

	<div class="col-sm-6">
		@foreach( $locations as $location )
			<button name="{{ $field }}" value="{{ $location->id }}" class="btn btn-block {{ $location->is( $value ) ? 'btn-primary' : 'btn-default' }}">
				{{ $location->name }}
			</button>
		@endforeach

		@if ($errors->has($field))
			<span class="help-block">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
