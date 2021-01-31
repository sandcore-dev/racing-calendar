@extends('layouts.app')

@section('title', __('Admin') . ' - ' . $championship->name . ' - '  . __('Seasons'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h1 class="text-center">{{ $championship->name }}</h1>

			@if( session('success') )
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			<nav class="row mt-3 mb-3">
				<div class="col text-center">
					<a class="btn btn-primary" href="{{ route('admin.championship.index') }}">@lang('Back to championship index')</a>
				</div>
			</nav>

			{{ $seasons->links() }}

			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>@lang('Year')</th>
					<th class="text-center">
						@if($championship)
							<a href="{{ route('admin.season.create', ['championship' => $championship]) }}" title="@lang('Add season')">
								<span class="fa fa-plus"></span>
							</a>
						@endif
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $seasons as $season )
					<tr>
						<td>
							<a href="{{ route('admin.race.index', [ 'championship' => $championship, 'season' => $season ]) }}" title="@lang('Season races')">
								{{ $season->year }}
							</a>
						</td>
						<td class="text-center">
							<a href="{{ route('admin.season.edit', [ 'championship' => $championship, 'season' => $season ]) }}" title="@lang('Edit season')">
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" class="text-center">
							@lang('No seasons have been found')
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $seasons->links() }}
		</div>
	</div>
</div>
@endsection
