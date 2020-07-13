@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Template') . ' - ' . __('Edit template'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.template.update', [ 'template' => $template->id ]) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit template')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))
					@slot('value', $template->name)

					required autofocus
				@endcomponent

				@component('input.submit')
					@slot('label', __('Edit template'))
					@slot('cancel', route('admin.template.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
