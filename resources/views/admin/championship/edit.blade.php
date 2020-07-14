@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Championship') . ' - ' . __('Edit championship'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.championship.update', [ 'championship' => $championship->id ]) }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<h1 class="text-center">@lang('Edit championship')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))
					@slot('value', $championship->name)

					required autofocus
				@endcomponent

				@component('input.text')
					@slot('field', 'domain')
					@slot('label', __('Domain'))
					@slot('value', $championship->domain)

					required
				@endcomponent

				@component('input.submit')
					@slot('label', __('Edit championship'))
					@slot('cancel', route('admin.championship.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
