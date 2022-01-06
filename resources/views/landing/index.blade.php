@extends('layouts.main')

@section('subtitle', 'Bienvenido')

@section('content')
    <div id="app" v-cloak>
        <landing-component></landing-component>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/landing/landing.js') }}"></script>
@stop
