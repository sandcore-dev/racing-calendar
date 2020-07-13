@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Edit season'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.season.update', [ 'season' => $season->id ]) }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit season')</h1>

				@component('input.text')
					@slot('type', 'number')
					@slot('field', 'year')
					@slot('label', __('Year'))
					@slot('value', $season->year)

					required autofocus min="1970" max="9999"
				@endcomponent

				@component('input.image-upload')
					@slot('field', 'header_image')
					@slot('label', __('Header image'))
					@slot('value', $season->header_image);
				@endcomponent

				@component('input.image-upload')
					@slot('field', 'footer_image')
					@slot('label', __('Footer image'))
					@slot('value', $season->footer_image);
				@endcomponent

				@component('input.checkbox')
					@slot('field', 'regenerate_token')
					@slot('label', __('Generate a new access token'))
				@endcomponent

				<div class="form-group row">
					<label class="col-sm-4 text-sm-right">@lang('Locations')</label>

					<location-sync class="col-sm-6" api-token="{{ auth()->user()->api_token }}" season-id="{{ $season->id }}" search-placeholder="@lang('Search for a location')"></location-sync>
				</div>

				@component('input.submit')
					@slot('label', __('Edit season'))
					@slot('cancel', route('admin.season.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
