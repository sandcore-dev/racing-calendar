@extends('layouts.app')

@section('title', config('app.name') . ' - ' . $season->year)
@section('nav-title', $season->year)
@section('image', env('APP_URL') . $season->header_url)

@section('content')
	<div class="container calendar">
		@if( $season->header_url )
			<div class="row">
				<div class="col-sm-12">
					<img class="header" src="{{ $season->header_url }}" alt="{{ $season->year }}">
				</div>
			</div>
		@endif

		<div class="row mt-3">
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
								<span class="d-none d-md-inline">
									{{ $race->date }}
								</span>
								<span class="d-md-none">
									{{ $race->dateShort }}
								</span>
							</td>
							<td>
								@switch ($race->status)
									@case('scheduled')
										{{ $race->time }}
										@break
									@case('postponed')
										<span class="text-warning">@lang('Postponed')</span>
										@break
									@case('cancelled')
										<span class="text-danger">@lang('Cancelled')</span>
										@break
								@endswitch
							</td>
							<td>
								<span class="{{ $race->circuit->country->flagClass }}" title="{{ $race->circuit->country->localName }}"></span>
								<span class="{{ $showLocations ? 'd-none d-md-inline' : '' }}">
									{{ $race->circuit->city }}
								</span>
							</td>
							@if( $showLocations )
							<td>
								@if($race->status === 'scheduled')
									@if( $race->start_time->isPast() )
										{{ $race->location->name }}
									@else
										<a href="{{ route('calendar.location.edit', [ 'championship' => $championship, 'season' => $season, 'race' => $race ]) }}">
											@if( $race->location->name )
												{{ $race->location->name }}
											@else
												<span class="fa fa-plus"></span>
											@endif
										</a>
									@endif
								@endif
							</td>
							@endif
						</tr>
						@if($race->status === 'scheduled' && !$race->sessions->isEmpty())
							<tr class="collapse details{{ $index }}">
								<td colspan="4" class="text-center">
									<div class="h4">
										{{ $race->name }}
									</div>
									<div class="h5">
										{{ $race->circuit->full_name }}
									</div>
								</td>
							</tr>
							@foreach($race->sessions as $sessionIndex => $session)
								<tr class="collapse details{{ $index }}">
									<td>
										<small class="d-none d-md-inline">
											{{ $session->date }}
										</small>
										<small class="d-md-none">
											{{ $session->dateShort }}
										</small>
									</td>
									<td>
										<small>{{ $session->time }}</small>
									</td>
									<td colspan="2">
										<small>{{ $session->name }}</small>
									</td>
								</tr>
							@endforeach
							<tr class="collapse details{{ $index }} bg-white">
								<td colspan="4">
									&nbsp;
								</td>
							</tr>
						@endif
						@if($race->status === 'scheduled' && $race->sessions->count() && $race->sessions->count() % 2 != 0)
						<tr class="d-none">
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
