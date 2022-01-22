@extends('layouts.main')

@section('subtitle', 'Sitio exclusivo para socios')

@section('content')

    <div id="app" v-cloak>
        <landing title="@lang('Título')" video="@lang('Video')" subtitle="@lang('Sitio exclusivo para socios')"
            password-placeholder="@lang('Introduce un password...')" :phases="{{ json_encode($phases) }}"
            path-videos="{{ $path_videos }}" />
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/landing/landing.js') }}"></script>
@stop
