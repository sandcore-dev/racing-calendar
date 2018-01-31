@extends('layouts.app')

@section('title', $season->year)
@section('nav-title', $season->year)

@section('content')
	<div class="container calendar">
		@if( $season->header_url )
		<div class="row">
			<div class="col-sm-12">
				<img class="header" src="{{ $season->header_url }}" alt="{{ $season->year }}">
			</div>
		</div>
		@endif
		
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped">
				<thead>
					<tr>
						<th class="col-sm-3">
							@lang('Date')
						</th>
						<th class="col-sm-3">
							@lang('Race time')
						</th>
						<th>
							@lang('Country')
						</th>
						@if( $showLocations )
						<th class="col-sm-3">
							@lang('Location')
						</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach( $season->races as $race )
						<tr>
							<td>
								{{ $race->date }}
							</td>
							<td>
								{{ $race->time }}
							</td>
							<td>
								@lang($race->circuit->country->name)
							</td>
							@if( $showLocations )
							<td>
								{{ $race->location->name }}
							</td>
							@endif
						</tr>
					@endforeach
				</tbody>
				</table>
			</div>
		</div>
		
		@if( $season->footer_url )
		<div class="row">
			<div class="col-sm-12">
				<img class="footer" src="{{ $season->footer_url }}" alt="{{ $season->year }}">
			</div>
		</div>
		@endif
	</div>
@endsection
