<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phase extends Model
{
    /**
     * La tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'phases';

    /**
     * Los atributos que pueden ser asignados masivamente
     *
     * @var array
     */
    protected $fillable = [
        'user_id',          // ID del usuario que creó la fase.
        'title',            // Título de la fase.
        'number'            // Número de la fase.
    ];

    /**
     * La relación con la tabla de usuarios
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La relación con la tabla de videos
     *
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->HasMany(VideoPhase::class, 'video_phases_id');
    }

    /**
     * Devuelve el total de videos de la fase.
     *
     * @return Int      Total de videos asociados a la fase.
     */
    public function totalVideos(): int
    {
        return $this->videos()->count();
    }

    /**
     * Devuelve el ultimo número de la fase creada.
     * o el número 1 si no hay ninguna fase creada.
     *
     * @return Int      Número de la fase.
     */
    public static function lastPhaseNumber(): int
    {
        if (self::count() > 0) {
            return self::latest()->first()->number;
        } else {
            return 1;
        }
    }
}
