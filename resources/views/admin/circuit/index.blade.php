@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Circuit'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		@if( session('success') )
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif
		
		{{ $circuits->links() }}
	
		<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>@lang('Circuit')</th>
				<th>@lang('City')</th>
				<th>@lang('Area')</th>
				<th>@lang('Country')</th>
				<th class="col-sm-2 text-center">
					<a href="{{ route('admin.circuit.create') }}" title="@lang('Add circuit')">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $circuits as $circuit )
				<tr>
					<td>
						<a href="{{ route('admin.circuit.edit', [ 'circuit' => $circuit->id ]) }}" title="@lang('Edit circuit')">
							{{ $circuit->name }}
						</a>
					</td>
					<td>
							{{ $circuit->city }}
					</td>
					<td>
							{{ $circuit->area }}
					</td>
					<td>
							{{ $circuit->country->name }}
					</td>
					<td class="text-center">
						<a href="{{ route('admin.circuit.edit', [ 'circuit' => $circuit->id ]) }}" title="@lang('Edit circuit')">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" class="text-center">
						@lang('No circuits have been found')
					</td>
				</tr>
			@endforelse
		</tbody>
		</table>
		
		{{ $circuits->links() }}
	</div>
</div>
@endsection
