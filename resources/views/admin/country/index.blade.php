@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Country'))

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

			{{ $countries->links() }}

			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>@lang('Country')</th>
					<th>@lang('Code')</th>
					<th class="text-center">
						<a href="{{ route('admin.country.create') }}" title="@lang('Add country')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $countries as $country )
					<tr>
						<td>
							<a href="{{ route('admin.country.edit', [ 'country' => $country->id ]) }}" title="@lang('Edit country')">
								{{ $country->name }}
							</a>
						</td>
						<td>
							{{ $country->code }}
						</td>
						<td class="text-center">
							<a href="{{ route('admin.country.edit', [ 'country' => $country->id ]) }}" title="@lang('Edit country')">
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="3" class="text-center">
							@lang('No countries have been found')
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $countries->links() }}
		</div>
	</div>
</div>
@endsection
