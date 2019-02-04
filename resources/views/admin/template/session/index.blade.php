@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Template session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<h1 class="text-center">@lang('Template: :name', [ 'name' => $template->name ])</h1>

		@if( session('success') )
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif

		{{ $sessions->links() }}

		<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-sm-1">@lang('Days')</th>
				<th class="col-sm-2">@lang('Start time')</th>
				<th class="col-sm-2">@lang('End time')</th>
				<th>@lang('Name')</th>
				<th class="col-sm-2 text-center">
					<a href="{{ route('admin.template.session.create', [ 'template' => $template->id ]) }}" title="@lang('Add session')">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $sessions as $session )
				<tr>
					<td>
						{{ $session->days }}
					</td>
					<td>
						{{ $session->start_time }}
					</td>
					<td>
						{{ $session->end_time }}
					</td>
					<td>
						<a href="{{ route('admin.template.session.edit', [ 'template' => $template->id, 'session' => $session->id ]) }}" title="@lang('Edit session')">
							{{ $session->name }}
						</a>
					</td>
					<td class="text-center">
						<a href="{{ route('admin.template.session.edit', [ 'template' => $template->id, 'session' => $session->id ]) }}" title="@lang('Edit session')">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">
						@lang('No sessions have been found')
					</td>
				</tr>
			@endforelse
		</tbody>
		</table>

		{{ $sessions->links() }}
	</div>
</div>
@endsection
