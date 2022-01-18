@extends('layouts.main')

@section('subtitle', 'Crear fase')

@section('content')
    <div id="app" v-cloak>

        {{-- textos necesarios para vue --}}
        @include('phases.partials.texts')
        {{-- /textos necesarios para vue --}}

        <div class="container py-4 bg-light">
            <div class="py-2 mb-2">
                <a class="btn btn-secondary" href="{{ route('phases.index') }}" role="button">
                    <i class="fas fa-arrow-left"></i>
                    @lang('Volver al listado de fases')
                </a>
            </div>
            <div class="card text-dark">
                <div class="card-body">
                    <h2 class="border-bottom border-2 border-primary pb-3">@lang('Crear nueva fase')</h2>
                    <form-component></form-component>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/phases/create.js') }}"></script>
@stop
