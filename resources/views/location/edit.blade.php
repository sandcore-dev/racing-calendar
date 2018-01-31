@extends('layouts.app')

@section('title', $race->season->year . ': ' . __($race->circuit->country->name))

@section('nav-title', $race->season->year . ': ' . __($race->circuit->country->name))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('calendar.location.update', [ 'token' => $race->season->access_token, 'race' => $race->id ]) }}" method="post">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			@component('input.text')
				@slot('field', 'year')
				@slot('label', __('Year'))
				@slot('value', $race->season->year)
				@slot('attributes', 'disabled')
			@endcomponent
			
			@component('input.text')
				@slot('field', 'date')
				@slot('label', __('Date'))
				@slot('value', $race->date)
				@slot('attributes', 'disabled')
			@endcomponent
			
			@component('input.text')
				@slot('field', 'time')
				@slot('label', __('Race time'))
				@slot('value', $race->time)
				@slot('attributes', 'disabled')
			@endcomponent
			
			@component('input.text')
				@slot('field', 'country')
				@slot('label', __('Country'))
				@slot('value', $race->circuit->country->name)
				@slot('attributes', 'disabled')
			@endcomponent
			
			@component('input.locations')
				@slot('field', 'location')
				@slot('label', __('Location'))
				@slot('locations', $race->season->locations)
				@slot('value', $race->location)
			@endcomponent
			
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-4">
					<a class="btn btn-danger" href="{{ route('calendar', [ 'token' => $race->season->access_token ]) }}">{{ __('Cancel') }}</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
