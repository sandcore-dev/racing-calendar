@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race') . ' - ' . __('Add race'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form class="form-horizontal" action="{{ route('admin.race.store', ['championship' => $championship, 'season' => $season]) }}" method="post">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add race')</h1>

				@component('input.text')
					@slot('field', 'championship')
					@slot('label', __('Championship'))
					@slot('value', $championship->name)

					disabled
				@endcomponent

				@component('input.text')
					@slot('field', 'year')
					@slot('label', __('Year'))
					@slot('value', $season->year)

					disabled
				@endcomponent

				@component('input.datetime')
					@slot('field', 'start_time')
					@slot('label', __('Race time'))
					@slot('value', $season->year . '-')

					required autofocus
				@endcomponent

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))

					required
				@endcomponent

				@component('input.select')
					@slot('field', 'circuit_id')
					@slot('label', __('Circuit'))

					@slot('options', $circuits)
					@slot('option_label', 'fullName')
				@endcomponent

				@component('input.textarea')
					@slot('field', 'remarks')
					@slot('label', __('Remarks'))
				@endcomponent

				@component('input.submit')
					@slot('label', __('Add race'))
					@slot('cancel', route('admin.race.index', ['championship' => $championship, 'season' => $season]))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
