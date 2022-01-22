<?php

/**
 * Gestiona las fases junto a su estructura de videos,  cuestionarios, etc
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 * @copyright 2021 P4D http://www.p4d.com
 */

namespace App\Http\Controllers;

// modelos
use App\Models\Phase;

// traits
use App\Http\Controllers\Traits\VideoPhaseTrait;

// extras
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class PhaseController extends Controller
{

    use VideoPhaseTrait;

    /**
     * Devuelve la vista con el listado de fases.
     *
     * @return View
     */
    public function index(): View
    {
        return view('phases.index');
    }

    /**
     * Devuelve las fases en un objeto json.
     *
     * @return JsonResponse
     */
    public function getPhases(): JsonResponse
    {
        $phases = Phase::with('videos')->get();

        return response()->json($phases);
    }

    /**
     * Devuelve la vista de creación de fases.
     *
     * @return View
     */
    public function create(): View
    {
        return view('phases.create', [
            'lastPhaseNumber' => Phase::lastPhaseNumber(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(): JsonResponse
    {
        $data = request()->all();
        $fileVideos = $data['videos']['file'] ?? [];
        $urlVideos = $data['videos']['url'] ?? [];

        // videos subidos
        // $files = $this->getBase64Video($fileVideos);
        $files = $this->uploadFiles($fileVideos);

        // videos por URL
        $urls = $this->getUrlVideo($urlVideos);

        // videos a guardar en la base de datos
        $videos = $this->getVideos($files, $urls);

        // datos de la phase
        $phase = [
            'user_id'   => Auth::id(),
            'title'     => $data['title'],
            'number'    => Phase::lastPhaseNumber()
        ];

        $id = DB::transaction(function () use ($phase, $videos) {

            $phaseCreated = Phase::create($phase);

            $phaseCreated->videos()->createMany($videos);

            return $phaseCreated->id;
        });

        if ($id) {
            return response()->json([
                'message' => Lang::get('La fase se ha creado correctamente.'),
                'id' => $id,
            ], 201);
        } else {
            return response()->json([
                'message' => Lang::get('Ha ocurrido un error al crear la fase.'),
            ], 500);
        }
    }


    /**
     * Devuelve la fase con el id especificado.
     *
     * @param  \App\Models\Phase  $phase
     * @return View
     */
    public function edit(Phase $phase): View
    {
        return view('phases.edit', [
            'phase' => $phase->load('videos'),
            'lastPhaseNumber' => Phase::lastPhaseNumber(),
        ]);
    }

    /**
     * Actualizar la fase y sus propiedades
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function updatePhase(Phase $phase)
    {
        $data = request()->all();

        // videos subidos por archivo
        $fileVideos = $data['videos']['file'] ?? [];

        // videos subidos por url
        $urlVideos = $data['videos']['url'] ?? [];

        // ids de videos a ignorar, no modificables
        $idsVideos = $data['videos']['ids'] ?? [];

        // videos base 64
        // $files = $this->getBase64Video($fileVideos);
        // archivos de videos subidos
        $files = $this->uploadFiles($fileVideos);

        // videos por URL
        $urls = $this->getUrlVideo($urlVideos);

        // // videos a guardar en la base de datos
        $videos = $this->getVideos($files, $urls);

        // formato limpio con los ids a ignorar - no modificables
        $idsToIgnore = $this->getIdsToIgnore($idsVideos);

        $id = DB::transaction(function () use ($phase, $videos, $data, $idsToIgnore) {

            // actualizar la phase
            $phase->update(['title' => $data['title']]);

            // eliminar videos fuera del array de ids de videos a ignorar
            $phase->videos()->whereNotIn('id', $idsToIgnore)->delete();

            // guardar videos de la phase actual
            $phase->videos()->createMany($videos);

            return $phase->id;
        });

        if ($id) {
            return response()->json([
                'message' => Lang::get('La fase se ha actualizado correctamente.'),
                'id' => $id,
            ], 201);
        } else {
            return response()->json([
                'message' => Lang::get('Ha ocurrido un error al actualizar la fase.'),
            ], 500);
        }
    }

    /**
     * Eliminar la fase temporalmente de la tabla
     *
     * @param  \App\Models\Phase  $phase
     * @return Response
     */
    public function destroy(Phase $phase): JsonResponse
    {
        $phase->delete();

        return response()->json([
            'message' => Lang::get('La fase se ha eliminado correctamente.'),
        ], 200);
    }

    /**
     * Eliminar las fases seleccionadas de la tabla
     *
     * @return Response
     */
    public function destroySelected(): JsonResponse
    {
        // ids recibidos
        $ids = request()->all();

        // fases encontradas
        $phases = Phase::whereIn('id', $ids)->get();

        // eliminar las fases
        $phases->each(fn ($phase) => $phase->delete());

        return response()->json([
            'message' => Lang::get('Las fases seleccionadas se han eliminado correctamente.'),
        ], 200);
    }
}
