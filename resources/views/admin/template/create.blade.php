@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Template') . ' - ' . __('Add template'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.template.store') }}" method="post">
			{{ csrf_field() }}

			<h1 class="text-center">@lang('Add template')</h1>

			@component('input.text')
				@slot('field', 'name')
				@slot('label', __('Name'))

				required autofocus
			@endcomponent

			@component('input.submit')
				@slot('label', __('Add template'))
				@slot('cancel', route('admin.template.index'))
			@endcomponent
		</form>
	</div>
</div>
@endsection
