<div class="form-group row">
	<label class="col-sm-4 col-form-label text-sm-right">{{ $label }}</label>

	<div class="col-sm-6">
		@foreach( $locations as $location )
			<button name="{{ $field }}" value="{{ $location->id }}" class="btn btn-block {{ $location->is( $value ) ? 'btn-primary' : 'btn-light' }} {{ $errors->has($field) ? 'is-invalid' : '' }}">
				{{ $location->name }}
			</button>
		@endforeach

		@if ($errors->has($field))
			<span class="is-invalid">
				<strong>{{ $errors->first($field) }}</strong>
			</span>
		@endif
	</div>
</div>
