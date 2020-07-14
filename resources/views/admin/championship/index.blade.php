@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Championship'))

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

			{{ $championships->links() }}

			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>@lang('Name')</th>
					<th class="col-sm-2 text-center">
						<a href="{{ route('admin.championship.create') }}" title="@lang('Add championship')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $championships as $championship )
					<tr>
						<td>
							<a href="{{ route('admin.championship.edit', [ 'championship' => $championship ]) }}" title="@lang('Edit championship')">
								{{ $championship->name }}
							</a>
						</td>
						<td class="text-center">
							<a href="{{ route('admin.championship.edit', [ 'championship' => $championship ]) }}" title="@lang('Edit championship')">
								<span class="fa fa-edit"></span>
							</a>
							<a href="{{ route('admin.season.index', [ 'championship' => $championship ]) }}" title="@lang('Championship seasons')">
								<span class="fa fa-table"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" class="text-center">
							@lang('No championships have been found')
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $championships->links() }}
		</div>
	</div>
</div>
@endsection