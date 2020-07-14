@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Add season'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.season.store', ['championship' => $championship]) }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add season')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))
					@slot('value', $championship->name)

					disabled
				@endcomponent

				@component('input.text')
					@slot('type', 'number')
					@slot('field', 'year')
					@slot('label', __('Year'))

					required autofocus min="1970" max="9999"
				@endcomponent

				@component('input.image-upload')
					@slot('field', 'header_image')
					@slot('label', __('Header image'))
				@endcomponent

				@component('input.image-upload')
					@slot('field', 'footer_image')
					@slot('label', __('Footer image'))
				@endcomponent

				@component('input.submit')
					@slot('label', __('Add season'))
					@slot('cancel', route('admin.season.index', ['championship' => $championship]))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
