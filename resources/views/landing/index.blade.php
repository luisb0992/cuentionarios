@extends('layouts.main')

@section('subtitle', 'Sitio exclusivo para socios')

@section('content')
    <div id="app" v-cloak>
        @php
            $phase = [
                'title' =>'Mi primera fase',
                'number' => 1,
                'videos' => [
                    'phase_id' => 1,
                    'data'  => 'sajhfsjahfkshjadlkasd',
                    'url'   => 'https://www.youtube.com/embed/sajhfsjahfkshjadlkasd',
                    'size'  => '450',
                    'name'  => 'Video de youtube',
                ]
            ];
        @endphp
        <landing-component title="@lang('Título')" video="@lang('Video')" subtitle="@lang('Sitio exclusivo para socios')"
            password-placeholder="@lang('Introduce un password...')" :phase="{{ json_encode($phase) }}"/>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/landing/landing.js') }}"></script>
@stop
