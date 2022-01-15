@extends('layouts.main')

@section('subtitle', 'Fases')

@section('content')
    <div id="app" v-cloak>

        <div class="d-none" id="labels" data-phase="@lang('Listado de fases')"
            data-create-phase="@lang('Crear fase')" data-search="@lang('Buscar...')"
            data-not-found="@lang('Elemento no encontrado')" data-loading="@lang('Buscando, por favor espere...')"
            data-showing="@lang('Mostrando')" data-to="@lang('a')" data-of="@lang('de')" data-entries="@lang('entradas')"
            data-title="@lang('Título')" data-number="@lang('Fase número')" data-videos="@lang('Videos')"
            data-created="@lang('Creado')" data-updated="@lang('Ultima actualización')" data-actions="@lang('Acciones')"
            data-tooltip-edit="@lang('Editar')" data-tooltip-delete="@lang('Eliminar')" data-tooltip-show="@lang('Mostrar')"
            data-confirmation-title="@lang('Confirmación')"
            data-confirmation-text="@lang('¿Está seguro que desea eliminar?')" data-no="@lang('No')" data-yes="@lang('Sí')"
            data-cancel="@lang('Cancelar')" data-ok="@lang('Aceptar')" data-delete-phases="@lang('Eliminar')"
            data-delete-phase="@lang('Eliminar fase')" data-export-csv="@lang('Exportar a CSV')"
            data-export-xls="@lang('Exportar a XLS')" data-export="@lang('Exportar')"
            data-show-phase="@lang('Información de la fase')" data-edit-phase="@lang('Editar fase')"
            data-create-phase="@lang('Crear fase')" data-close="@lang('Cerrar')"></div>

        <div class="container my-4 bg-white">
            <index-component></index-component>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/phases/index.js') }}"></script>
@stop
