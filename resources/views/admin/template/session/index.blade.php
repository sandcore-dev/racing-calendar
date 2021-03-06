@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Template session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
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
					<th>@lang('Days')</th>
					<th>@lang('Start time')</th>
					<th>@lang('End time')</th>
					<th>@lang('Name')</th>
					<th class="text-center">
						<a href="{{ route('admin.template.session.create', [ 'template' => $template->id ]) }}" title="@lang('Add session')">
							<span class="fa fa-plus"></span>
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
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center">
							@lang('No sessions have been found')
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $sessions->links() }}
		</div>
	</div>
</div>
@endsection
