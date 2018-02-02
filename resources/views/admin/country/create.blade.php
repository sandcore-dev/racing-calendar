@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Add country'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.country.store') }}" method="post">
			{{ csrf_field() }}
			
			<h1 class="text-center">@lang('Add country')</h1>
		
			@component('input.text')
				@slot('field', 'name')
				@slot('label', __('Country'))
				
				required autofocus
			@endcomponent
		
			@component('input.text')
				@slot('field', 'code')
				@slot('label', __('Country code'))
				
				required
			@endcomponent
		
			@component('input.submit')
				@slot('label', __('Add country'))
				@slot('cancel', route('admin.country.index'))
			@endcomponent
		</form>
	</div>
</div>
@endsection
