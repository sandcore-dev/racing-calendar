@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Championship') . ' - ' . __('Add championship'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<form action="{{ route('admin.championship.store') }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}

				<h1 class="text-center">@lang('Add championship')</h1>

				@component('input.text')
					@slot('field', 'name')
					@slot('label', __('Name'))

					required autofocus
				@endcomponent

				@component('input.text')
					@slot('field', 'domain')
					@slot('label', __('Domain'))

					required
				@endcomponent

				@component('input.submit')
					@slot('label', __('Add championship'))
					@slot('cancel', route('admin.championship.index'))
				@endcomponent
			</form>
		</div>
	</div>
</div>
@endsection
