@extends('layouts.app')

@section('title', __('Admin') . ' - ' . $name . ' - '  . $year . ' - '  . __('Images'))

@section('nav-title', __('Admin'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center">{{ $name }} - {{ $year }}</h1>

                <div class="text-center mb-5">
                    <a class="btn btn-primary" href="{{ $back }}">
                        @lang('Back to index')
                    </a>
                </div>

                @isset($headerUrl)
                    <div class="mb-3">
                        <h3 class="text-center">@lang('Icon image')</h3>
                        <image-crop
                                square
                                season-id="{{ $id }}"
                                name="icon"
                                src="{{ $headerUrl }}"
                                alt="@lang('Icon image')"
                        ></image-crop>
                    </div>
                @endisset

                @isset($headerUrl)
                    <div class="mb-3">
                        <h3 class="text-center">@lang('Header image')</h3>
                        <image-crop
                                season-id="{{ $id }}"
                                name="header"
                                src="{{ $headerUrl }}"
                                alt="@lang('Header image')"
                        ></image-crop>
                    </div>
                @endisset

                @isset($footerUrl)
                    <div class="mb-3">
                        <h3 class="text-center">@lang('Footer image')</h3>
                        <image-crop
                                season-id="{{ $id }}"
                                name="footer"
                                src="{{ $footerUrl }}"
                                alt="@lang('Header image')"
                        ></image-crop>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
