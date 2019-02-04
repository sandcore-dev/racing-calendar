@extends('layouts.app')

@section('title', config('app.name') . ' - ' . $season->year)
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
						<th class="col-xs-3">
							@lang('Date')
						</th>
						<th class="col-xs-3">
							@lang('Race time')
						</th>
						<th>
							@lang('Race')
						</th>
						@if( $showLocations )
						<th class="col-xs-3">
							@lang('Location')
						</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach( $season->races as $index => $race )
						<tr class="{{ $race->thisWeek ? 'warning' : '' }}" data-toggle="collapse" data-target=".details{{ $index }}">
							<td>
								<span class="hidden-xs">
									{{ $race->date }}
								</span>
								<span class="visible-xs-inline">
									{{ $race->dateShort }}
								</span>
							</td>
							<td>
								{{ $race->time }}
							</td>
							<td>
								<span class="{{ $race->circuit->country->flagClass }}" title="{{ $race->circuit->country->localName }}"></span>
								<span class="{{ $showLocations ? 'hidden-xs' : '' }}">
									{{ $race->circuit->city }}
								</span>
							</td>
							@if( $showLocations )
							<td>
								@if( $race->start_time->isPast() )
									{{ $race->location->name }}
								@else
									<a href="{{ route('calendar.location.edit', [ 'token' => $race->season->access_token, 'race' => $race->id ]) }}">
										@if( $race->location->name )
											{{ $race->location->name }}
										@else
											<span class="glyphicon glyphicon-plus"></span>
										@endif
									</a>
								@endif
							</td>
							@endif
						</tr>
						@if(!$race->sessions->isEmpty())
							<tr class="collapse details{{ $index }}">
								<td colspan="4" class="text-center">
									<div class="h4">
										@lang(':race timetable', [ 'race' => $race->name ])
									</div>
									<div class="h5">
										{{ $race->circuit->full_name }}
									</div>
								</th>
							</tr>
							@foreach($race->sessions as $sessionIndex => $session)
								<tr class="collapse details{{ $index }}">
									<td>
										<small>{{ $session->date }}</small>
									</td>
									<td>
										<small>{{ $session->time }}</small>
									</td>
									<td colspan="2">
										<small>{{ $session->name }}</small>
									</td>
								</tr>
							@endforeach
							<tr class="collapse details{{ $index }}">
								<td colspan="4">
									&nbsp;
								</td>
							</tr>
						@endif
						@if($race->sessions->count() && $race->sessions->count() % 2 != 0)
						<tr class="hidden">
							<td colspan="4">
								&nbsp;
							</td>
						</tr>
						@endif
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
