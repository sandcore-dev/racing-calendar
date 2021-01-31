@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Location'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			@if( session('success') )
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			{{ $locations->links() }}

			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>@lang('Location')</th>
					<th class="text-center">
						<a href="{{ route('admin.location.create') }}" title="@lang('Add location')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $locations as $location )
					<tr>
						<td>
							<a href="{{ route('admin.location.edit', [ 'location' => $location->id ]) }}" title="@lang('Edit location')">
								{{ $location->name }}
							</a>
						</td>
						<td class="text-center">
							<a href="{{ route('admin.location.edit', [ 'location' => $location->id ]) }}" title="@lang('Edit location')">
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" class="text-center">
							@lang('No locations have been found')
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $locations->links() }}
		</div>
	</div>
</div>
@endsection
