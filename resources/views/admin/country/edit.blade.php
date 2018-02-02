@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Edit country'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.country.update', [ 'country' => $country->id ]) }}" method="post">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			<h1 class="text-center">@lang('Edit country')</h1>
		
			@component('input.text')
				@slot('field', 'name')
				@slot('label', __('Country'))
				@slot('value', $country->name)
				
				required autofocus
			@endcomponent
		
			@component('input.text')
				@slot('field', 'code')
				@slot('label', __('Country code'))
				@slot('value', $country->code)
				
				required
			@endcomponent
		
			@component('input.submit')
				@slot('label', __('Edit country'))
				@slot('cancel', route('admin.country.index'))
			@endcomponent
		</form>
	</div>
</div>
@endsection
