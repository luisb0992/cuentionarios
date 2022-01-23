<?php

/**
 * Propiedades comunes
 */

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CommonController extends Controller
{
    /**
     * devuelve el path donde se encuentran los videos
     *
     * @return
     */
    public function getPathVideos(): JsonResponse
    {
        $path = env('APP_URL') . '/storage/' . config('videos.folder') . '/';

        return response()->json($path);
    }
}
