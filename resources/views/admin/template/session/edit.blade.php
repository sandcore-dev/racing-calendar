@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('template.session') . ' - ' . __('Edit template.session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.template.session.update', [ 'template' => $template->id, 'session' => $session->id ]) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit session')</h1>

				@component('input.text')
					@slot('type', 'number')
					@slot('field', 'days')
					@slot('label', __('Days before race day'))
					@slot('value', $session->days)

					required autofocus min="0" max="7"
				@endcomponent

				@component('input.time')
					@slot('field', 'start_time')
					@slot('label', __('Start time'))
					@slot('value', $session->start_time)

					required
				@endcomponent

				@component('input.time')
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
					@slot('cancel', route('admin.template.session.index', [ 'template' => $template->id ]))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
