@extends('layouts.app')

@section('title', $race->season->year . ': ' . __($race->circuit->country->name))

@section('nav-title', $race->season->year . ': ' . __($race->circuit->country->name))

@section('content')
<div class="container">
	<div class="row">
		<form class="form-horizontal" action="{{ route('calendar.location.update', [ 'access_token' => $race->season->accessToken, 'race' => $race->id ]) }}" method="post">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@component('input.text')
				@slot('field', 'year')
				@slot('label', __('Year'))
				@slot('value', $race->season->year)

				disabled
			@endcomponent

			@component('input.text')
				@slot('field', 'date')
				@slot('label', __('Date'))
				@slot('value', $race->date)

				disabled
			@endcomponent

			@component('input.text')
				@slot('field', 'time')
				@slot('label', __('Race time'))
				@slot('value', $race->time)

				disabled
			@endcomponent

			@component('input.text')
				@slot('field', 'country')
				@slot('label', __('Country'))
				@slot('value', $race->circuit->country->name)

				disabled
			@endcomponent

			@if($race->remarks)
			<div class="form-group">
				<label class="col-sm-4 control-label">@lang('Remarks')</label>

				<div class="col-sm-6">
					<div class="alert alert-warning">
						{{ $race->remarks }}
					</div>
				</div>
			</div>
			@endif

			@component('input.locations')
				@slot('field', 'location')
				@slot('label', __('Location'))
				@slot('locations', $race->season->locations)
				@slot('value', $race->location)
			@endcomponent

			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-4">
					<a class="btn btn-primary" href="{{ route('calendar', [ 'access_token' => $race->season->accessToken ]) }}">{{ __('Cancel') }}</a>

					@if( $race->location->id )
					<button class="btn btn-danger pull-right" type="submit" name="erase_location" value="1">
						@lang('Erase current location')
					</button>
					@endif
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
