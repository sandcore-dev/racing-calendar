@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Add circuit'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.circuit.store') }}" method="post">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add circuit')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Circuit'))

					required autofocus
				@endcomponent

				@component('input.text')
					@slot('field', 'city')
					@slot('label', __('City'))

					required
				@endcomponent

				@component('input.text')
					@slot('field', 'area')
					@slot('label', __('Area'))
				@endcomponent

				@component('input.select')
					@slot('field', 'country_id')
					@slot('label', __('Country'))

					@slot('options', $countries)
				@endcomponent

				@component('input.submit')
					@slot('label', __('Add circuit'))
					@slot('cancel', route('admin.circuit.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
