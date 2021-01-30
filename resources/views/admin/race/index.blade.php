@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h1 class="text-center">@lang(':season :championship', ['season' => $season->year, 'championship' => $championship->name])</h1>

			@if( session('success') )
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			<nav class="row mt-3 mb-3">
				<div class="col text-center">
					<a class="btn btn-primary" href="{{ route('admin.season.index', ['championship' => $championship]) }}">@lang('Back to season index')</a>
				</div>
			</nav>

			{{ $races->links() }}

			<table class="table table-striped table-hover mt-3">
				<thead>
				<tr>
					<th class="col-sm-2">@lang('Race time')</th>
					<th class="col-sm-2">@lang('Status')</th>
					<th>@lang('Name')</th>
					<th class="col-sm-3">@lang('Circuit')</th>
					<th class="col-sm-2 text-center">
						<a href="{{ route('admin.race.create', [ 'championship' => $championship, 'season' => $season ]) }}" title="@lang('Add race')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $races as $race )
					<tr>
						<td>
							{{ $race->start_time }}
						</td>
						<td>
							@switch($race->status)
								@case('scheduled')
								<span class="text-info">@lang('Scheduled')</span>
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
							<a href="{{ route('admin.race.session.index', ['championship' => $championship, 'season' => $season, 'race' => $race]) }}" title="@lang('To race sessions')">
								{{ $race->name }}
							</a>
						</td>
						<td>
							{{ $race->circuit->name }}
						</td>
						<td class="text-center">
							<a href="{{ route('admin.race.edit', ['championship' => $championship, 'season' => $season, 'race' => $race]) }}" title="@lang('Edit race')">
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center">
							<p>
								@lang('No races have been found')
							</p>
							@if($previousSeasons->count())
								<p>
									@lang('Copy races from season:')
								</p>
								<form action="{{ route('admin.race.copy-season', ['championship' => $championship, 'season' => $season]) }}" method="post">
									{{ csrf_field() }}
									<label>
										<select name="copyFromSeason">
											@foreach($previousSeasons as $previousSeason)
												<option value="{{ $previousSeason->id }}">{{ $previousSeason->year }}</option>
											@endforeach
										</select>
									</label>
									<button type="submit" class="btn btn-primary">
										@lang('Send')
									</button>
								</form>
							@endif
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $races->links() }}
		</div>
	</div>
</div>
@endsection
