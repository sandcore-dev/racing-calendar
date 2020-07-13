@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Race session'))

@section('nav-title', __('Admin'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h1 class="text-center">@lang('Race: :name (:start_time)', [ 'start_time' => $race->start_time, 'name' => $race->name ])</h1>

			@if( session('success') )
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			{{ $sessions->links() }}

			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th class="col-sm-2">@lang('Start time')</th>
					<th class="col-sm-2">@lang('End time')</th>
					<th>@lang('Name')</th>
					<th class="col-sm-2 text-center">
						<a href="{{ route('admin.race.session.create', [ 'race' => $race->id ]) }}" title="@lang('Add session')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $sessions as $session )
					<tr>
						<td>
							{{ $session->start_time }}
						</td>
						<td>
							{{ $session->end_time }}
						</td>
						<td>
							<a href="{{ route('admin.race.session.edit', [ 'race' => $race->id, 'session' => $session->id ]) }}" title="@lang('Edit session')">
								{{ $session->name }}
							</a>
						</td>
						<td class="text-center">
							<a href="{{ route('admin.race.session.edit', [ 'race' => $race->id, 'session' => $session->id ]) }}" title="@lang('Edit session')">
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="4" class="text-center">
							<p>
								@lang('No sessions have been found')
							</p>
							@if($templates)
								<form action="{{ route('admin.race.session.apply-template') }}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="race" value="{{ $race->id }}"/>
									<select name="template">
										@foreach($templates as $template)
											<option value="{{ $template->id }}">{{ $template->name }}</option>
										@endforeach
									</select>
									<button type="submit" class="btn btn-primary">
										@lang('Apply template')
									</button>
								</form>
							@endif
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
