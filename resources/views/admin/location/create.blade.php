@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Add location'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.location.store') }}" method="post">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add location')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Location'))

					required autofocus
				@endcomponent

				@component('input.submit')
					@slot('label', __('Add location'))
					@slot('cancel', route('admin.location.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
