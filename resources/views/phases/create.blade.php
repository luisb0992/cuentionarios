@extends('layouts.main')

@section('subtitle', 'Crear fase')

@section('content')
    <div id="app">

        <div class="container py-4 bg-white">
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
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('Nombre de la fase')</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="@lang('Nombre de la fase')">
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('Descripción de la fase')</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="@lang('Descripción de la fase')"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">@lang('Fecha de inicio')</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" placeholder="@lang('Fecha de inicio')">
                        </div>
                        <div class="form-group">
                            <label for="end_date">@lang('Fecha de fin')</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" placeholder="@lang('Fecha de fin')">
                        </div>
                        <div class="form-group">
                            <label for="status">@lang('Estado de la fase')</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">@lang('Activa')</option>
                                <option value="0">@lang('Inactiva')</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('Crear fase')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/phases/create.js') }}"></script>
@stop
