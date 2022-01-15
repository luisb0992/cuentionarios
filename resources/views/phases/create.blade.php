@extends('layouts.main')

@section('subtitle', 'Crear fase')

@section('css')
    {{-- aplicar para usar bootstrap vue --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
@stop

@section('content')
    <div id="app" v-cloak class="bg-light">

        {{--  textos necesarios para vue  --}}
        @include('phases.partials.texts')
        {{--  /textos necesarios para vue  --}}

        <div class="container py-4">
            <div class="py-2">
                <a class="btn btn-outline-danger" href="{{ route('phases.index') }}" role="button">
                    <i class="fas fa-arrow-left"></i>
                    @lang('Volver al listado de fases')
                </a>
            </div>
            <h2 class="text-muted">@lang('Crear nueva fase')</h2>
            <div class="card text-dark">
                <div class="card-body">
                    <form-component></form-component>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/phases/create.js') }}"></script>
@stop
