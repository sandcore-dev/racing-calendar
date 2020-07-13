@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Template session') . ' - ' . __('Add session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.template.session.store', [ 'template' => $template ]) }}" method="post">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add session')</h1>

				@component('input.text')
					@slot('type', 'number')
					@slot('field', 'days')
					@slot('label', __('Days before race day'))

					required autofocus min="0" max="7"
				@endcomponent

				@component('input.time')
					@slot('field', 'start_time')
					@slot('label', __('Start time'))

					required
				@endcomponent

				@component('input.time')
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
					@slot('cancel', route('admin.template.session.index', [ 'template' => $template->id ]))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
