@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race session') . ' - ' . __('Add session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.race.session.store', ['championship' => $championship, 'season' => $season, 'race' => $race]) }}" method="post">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add session')</h1>

				@component('input.datetime')
					@slot('field', 'start_time')
					@slot('label', __('Start time'))

					required autofocus
				@endcomponent

				@component('input.datetime')
					@slot('field', 'end_time')
					@slot('label', __('End time'))

					required
				@endcomponent

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))

					required
				@endcomponent

				@component('input.submit')
					@slot('label', __('Add session'))
					@slot('cancel', route('admin.race.session.index', ['championship' => $championship, 'season' => $season, 'race' => $race]))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
