@extends('layouts.main')

@section('subtitle', 'Crear fase')

@section('css')
    {{-- aplicar para usar bootstrap vue --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
@stop

@section('content')
    <div id="app" v-cloak class="bg-light">

        {{-- texto para labels --}}
        <div class="d-none" id="textLabels" data-title="@lang('Título')" data-phase="@lang('Fase a crear')"
            data-number="{{ $lastPhaseNumber }}" data-submit="@lang('Agregar nueva fase')"
            data-selected-videos="@lang('Archivos seleccionados')" data-name-files="@lang('Archivos seleccionados')"
            data-add-files="@lang('Agregar archivos')" data-select-method="@lang('Seleccione el método')"
            data-via-file="@lang('Vía subida de archivos')" data-via-url="@lang('Vía URL')"
            data-add-input-url="@lang('Agregar URL')" data-upload-files="@lang('Videos cargados')"
            data-video-name="@lang('Nombre')" data-video-type="@lang('Tipo')" data-video-size="@lang('Tamaño')"
            data-video-via="@lang('Vía')" data-video-actions="@lang('Acciones')"
            data-no-load-videos="@lang('Ningún video cargado')" data-delete-button="@lang('Eliminar')"
            data-load-videos-button="@lang('Cargar videos')" data-url="@lang('URL')" data-upload="@lang('Archivo')"></div>
        {{-- /texto para labels --}}

        {{-- placeholders --}}
        <div class="d-none" id="textPlaceholders" data-title="@lang('Título para la fase')"
            data-videos="@lang('Seleccionar archivos...')" data-drop="@lang('Arrastrar elementos...')"
            data-browse-input="@lang('Buscar')"></div>
        {{-- /placeholders --}}

        <div class="container py-4">
            <h2 class="text-muted">@lang('Crear nueva fase')</h2>
            <div class="py-2">
                <a class="btn btn-outline-danger btn-lg" href="{{ route('phases.index') }}" role="button">
                    <i class="fas fa-arrow-left"></i>
                    @lang('Volver al listado de fases')
                </a>
            </div>
            <hr>
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
