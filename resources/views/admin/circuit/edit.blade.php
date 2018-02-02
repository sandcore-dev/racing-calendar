@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season') . ' - ' . __('Edit circuit'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('admin.circuit.update', [ 'circuit' => $circuit->id ]) }}" method="post">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			<h1 class="text-center">@lang('Edit circuit')</h1>
		
			@component('input.text')
				@slot('field', 'name')
				@slot('label', __('Circuit'))
				@slot('value', $circuit->name)
				
				required autofocus
			@endcomponent
		
			@component('input.submit')
				@slot('label', __('Edit circuit'))
				@slot('cancel', route('admin.circuit.index'))
			@endcomponent
		</form>
	</div>
</div>
@endsection
