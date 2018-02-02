@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Add country'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.country.store') }}" method="post">
			{{ csrf_field() }}
			
			<h1 class="text-center">@lang('Add country')</h1>
			
			@component('input.countries')
				@slot('field', 'code')
				
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
