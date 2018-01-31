@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Season'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		@if( isset($success) && $success )
			<div class="alert alert-success">
				{{ $success }}
			</div>
		@endif
		
		{{ $seasons->links() }}
	
		<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>@lang('Jaar')</th>
				<th class="col-sm-2 text-center">
					<a href="{{ route('admin.season.create') }}" title="@lang('Add season')">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $seasons as $season )
				<tr>
					<td>
						<a href="{{ route('admin.season.edit', [ 'season' => $season->id ]) }}" title="@lang('Edit season')">
							{{ $season->year }}
						</a>
					</td>
					<td class="text-center">
						<a href="{{ route('admin.season.edit', [ 'season' => $season->id ]) }}" title="@lang('Edit season')">
							<span class="glyphicon glyphicon-edit"></span>
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
@endsection
