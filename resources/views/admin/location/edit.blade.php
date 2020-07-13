@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Edit location'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.location.update', [ 'location' => $location->id ]) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit location')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Location'))
					@slot('value', $location->name)

					required autofocus
				@endcomponent

				@component('input.submit')
					@slot('label', __('Edit location'))
					@slot('cancel', route('admin.location.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
