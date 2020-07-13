@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race session') . ' - ' . __('Edit session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.race.session.update', [ 'race' => $race->id, 'session' => $session->id ]) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit session')</h1>

				@component('input.datetime')
					@slot('field', 'start_time')
					@slot('label', __('Start time'))
					@slot('value', $session->start_time)

					required autofocus
				@endcomponent

				@component('input.datetime')
					@slot('field', 'end_time')
					@slot('label', __('End time'))
					@slot('value', $session->end_time)

					required
				@endcomponent

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))
					@slot('value', $session->name)

					required
				@endcomponent

				@component('input.submit')
					@slot('label', __('Edit session'))
					@slot('cancel', route('admin.race.session.index', [ 'race' => $race->id ]))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
