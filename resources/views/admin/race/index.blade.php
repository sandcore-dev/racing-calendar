@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		@if( session('success') )
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif
		
		<form action="{{ route('admin.race.index') }}" method="get">
			<select name="season" onchange="return this.form.submit();">
				@forelse( $seasons as $season )
					<option{{ $season->is( $currentSeason ) ? ' selected' : '' }} value="{{ $season->id }}">{{ $season->year }}</option>
				@empty
					<option value="0">@lang('No seasons have been found')</option>
				@endforelse
			</select>
			<noscript>
				<button type="submit" class="btn btn-primary">
					@lang('Send')
				</button>
			</noscript>
		</form>
		
		{{ $races->links() }}
	
		<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-sm-2">@lang('Race time')</th>
				<th>@lang('Name')</th>
				<th class="col-sm-3">@lang('Circuit')</th>
				<th class="col-sm-2 text-center">
					<a href="{{ route('admin.race.create', [ 'season' => $currentSeason->id ]) }}" title="@lang('Add race')">
						<span class="glyphicon glyphicon-plus"></span>
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
						<a href="{{ route('admin.race.edit', [ 'race' => $race->id ]) }}" title="@lang('Edit race')">
							{{ $race->name }}
						</a>
					</td>
					<td>
						{{ $race->circuit->name }}
					</td>
					<td class="text-center">
						<a href="{{ route('admin.race.edit', [ 'race' => $race->id ]) }}" title="@lang('Edit race')">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">
						@lang('No races have been found')
					</td>
				</tr>
			@endforelse
		</tbody>
		</table>
		
		{{ $races->links() }}
	</div>
</div>
@endsection
