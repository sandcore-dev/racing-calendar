@extends('layouts.app')

@section('title', $championship->name . ' - ' . config('app.name'))
@section('nav-title', $championship->name)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="alert alert-warning">
					@lang('No seasons have been found')
				</div>
			</div>
		</div>
	</div>
@endsection
