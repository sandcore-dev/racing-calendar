@extends('layouts.app')

@section('title', __('Admin') . ' - ' . __('Template'))

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

			{{ $templates->links() }}

			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>@lang('Name')</th>
					<th class="text-center">
						<a href="{{ route('admin.template.create') }}" title="@lang('Add template')">
							<span class="fa fa-plus"></span>
						</a>
					</th>
				</tr>
				</thead>
				<tbody>
				@forelse( $templates as $template )
					<tr>
						<td>
							<a href="{{ route('admin.template.session.index', [ 'template' => $template->id ]) }}" title="@lang('To template sessions')">
								{{ $template->name }}
							</a>
						</td>
						<td class="text-center">
							<a href="{{ route('admin.template.edit', [ 'template' => $template->id ]) }}" title="@lang('Edit template')">
								<span class="fa fa-edit"></span>
							</a>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" class="text-center">
							@lang('No templates have been found')
						</td>
					</tr>
				@endforelse
				</tbody>
			</table>

			{{ $templates->links() }}
		</div>
	</div>
</div>
@endsection
