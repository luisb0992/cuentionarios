<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoPhase extends Model
{
    /**
     * La tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'video_phases';

    /**
     * Los atributos que pueden ser asignados masivamente
     *
     * @var array
     */
    protected $fillable = [
        'phase_id',             // ID de la fase.
        'name',                 // Nombre del video.
        'size',                 // Tamaño del video.
        'data',                 // Datos del video (si es un archivo subido).
        'url',                  // URL del video (si es un video de YouTube, vimeo, etc).
    ];

    /**
     * La relación con la tabla de fases
     *
     * @return BelongsTo
     */
    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }
}
