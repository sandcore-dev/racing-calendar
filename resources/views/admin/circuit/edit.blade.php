@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Edit circuit'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.circuit.update', [ 'circuit' => $circuit->id ]) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit circuit')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Circuit'))
					@slot('value', $circuit->name)

					required autofocus
				@endcomponent

				@component('input.text')
					@slot('field', 'city')
					@slot('label', __('City'))
					@slot('value', $circuit->city)

					required
				@endcomponent

				@component('input.text')
					@slot('field', 'area')
					@slot('label', __('Area'))
					@slot('value', $circuit->area)
				@endcomponent

				@component('input.select')
					@slot('field', 'country_id')
					@slot('label', __('Country'))
					@slot('value', $circuit->country)

					@slot('options', $countries)
				@endcomponent

				@component('input.submit')
					@slot('label', __('Edit circuit'))
					@slot('cancel', route('admin.circuit.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
