@extends('layouts.main')

@section('subtitle', 'Fases')

@section('content')
    <div id="app">

        <div class="container py-4 bg-white">
            <h2 class="text-muted">@lang('Listado de fases')</h2>
            <div class="py-2">
                <a class="btn btn-outline-success btn-lg" href="{{ route('phases.create') }}" role="button">
                    <i class="fas fa-plus"></i>
                    @lang('Crear fase')
                </a>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Título')</th>
                            <th>@lang('Fase Nº')</th>
                            <th>@lang('Videos')</th>
                            <th>@lang('Acciones')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($phases as $phase)
                            <tr>
                                <td>{{ $phase->title }}</td>
                                <td>{{ $phase->number }}</td>
                                <td>{{ $phase->totalVideos() }}</td>
                                <td>
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('phases.show', $phase->id) }}" role="button">
                                        <i class="fas fa-eye"></i>
                                        @lang('Ver')
                                    </a>
                                    <a class="btn btn-outline-warning btn-sm" href="{{ route('phases.edit', $phase->id) }}" role="button">
                                        <i class="fas fa-edit"></i>
                                        @lang('Editar')
                                    </a>
                                    {{--  <form action="{{ route('phases.destroy', $phase->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit">
                                            <i class="fas fa-trash-alt"></i>
                                            @lang('Eliminar')
                                        </button>
                                    </form>  --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-info" role="alert">
                                        @lang('No hay fases creadas')
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    {{-- <script src="{{ mix('js/landing/landing.js') }}"></script> --}}
@stop
