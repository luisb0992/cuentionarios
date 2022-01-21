{{-- texto para labels --}}
<div class="d-none" id="textLabels" data-title="@lang('Título')" data-phase="@lang('Fase')"
    data-number-phase="@lang('Nº')"
    data-phase-number="@lang('Fase Nº')" data-number="{{ $lastPhaseNumber }}" data-submit="@lang('Agregar nueva fase')"
    data-selected-videos="@lang('Archivos seleccionados')" data-name-files="@lang('Archivos seleccionados')"
    data-add-files="@lang('Agregar archivos')" data-select-method="@lang('Seleccione el método')"
    data-via-file="@lang('Vía subida de archivos')" data-via-url="@lang('Vía URL')"
    data-add-input-url="@lang('Agregar URL')" data-upload-files="@lang('Videos cargados')"
    data-video-name="@lang('Nombre')" data-video-type="@lang('Tipo')" data-video-size="@lang('Tamaño')"
    data-video-via="@lang('Vía')" data-video-actions="@lang('Acciones')"
    data-no-load-videos="@lang('Ningún video cargado')" data-delete-button="@lang('Eliminar')"
    data-load-videos-button="@lang('Cargar videos')" data-url="@lang('URL')" data-upload="@lang('Archivo')"
    data-dragdrop="@lang('Arrastre y suelte los archivos aquí para cargarlos')" data-browse-input="@lang('Buscar...')"
    data-submit-edit="@lang('Guardar cambios')" >
</div>
{{-- /texto para labels --}}

{{-- placeholders --}}
<div class="d-none" id="textPlaceholders" data-title="@lang('Título para la fase')"
    data-videos="@lang('Seleccionar archivos...')" data-drop="@lang('Arrastrar elementos...')"
    data-browse-input="@lang('Buscar')"></div>
{{-- /placeholders --}}

{{-- mensajes informativos de la app --}}
<div class="d-none" id="appMessages" data-empty-videos="@lang('No hay videos que agregar')"
    data-required-videos="@lang('Debe cargar al menos un video antes de crear la fase')"
    data-required-title="@lang('Debe agregar un título para la fase')"
    data-invalid-upload-files="@lang('Uno o más archivos subidos son inválidos.<br> Los formatos aceptados son: MP4, AVI, FLV.')"
    data-success-phase="@lang('Nueva fase creada con éxito')" data-error-phase="@lang('Error al crear la fase')"
    data-delete-video="@lang('Video eliminado')"
    data-no-video-selected="@lang('Ningún video seleccionado')">
</div>
