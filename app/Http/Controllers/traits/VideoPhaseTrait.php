<?php

/**
 * Trait VideoPhaseTrait
 *
 * Gestiona los videos de las fases, agrega funcionalidad extra
 * como la manipulación de archivos y su estructura
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 * @copyright 2021 P4D http://www.p4d.com
 */

namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

trait VideoPhaseTrait
{
    /**
     * Genera una estructura  para almacenar los videos
     * junto al formato base64
     *
     * @var Array $files        Colección de archivos subidos
     * @return Collection       Colección de archivos con la estructura
     */
    public function getBase64Video(array $files): Collection
    {
        // convertir a una colección
        $files = collect($files);

        // setear los archivos tipo files
        $files = $files->map(function ($file) {
            if (is_file($file)) {
                return  [
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => filesize($file),
                    'data' => base64_encode(file_get_contents($file->getRealPath())),
                ];
            }
        });

        return $files;
    }

    /**
     * Genera la estructura para los videos por URL
     *
     * @param  Array $files         Colección de videos por URL
     * @return Collection           Colección de archivos con la estructura
     */
    public function getUrlVideo(array $urls): Collection
    {
        // convertir a una colección
        $urls = collect($urls);

        // setear los archivos tipo files
        $urls = $urls->map(fn ($url) => [
            'data'  => null,
            'name'  => $url,
            'size'  => null,
            'url'   => $url
        ]);

        return $urls;
    }

    /**
     * Genera la estructura para los videos a guardar en la base de datos
     *
     * @param  Collection $files    Colección de videos subidos
     * @param  Collection $urls     Colección de videos por url
     * @return Array                Colección de archivos con la estructura
     */
    public function getVideos(Collection $files, Collection $urls): array
    {
        return $files->union($urls->toArray())
            ->filter(fn ($file) => is_array($file))
            ->sortKeys()
            ->all();
    }
}
