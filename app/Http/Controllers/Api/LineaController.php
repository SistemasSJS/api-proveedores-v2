<?php

namespace App\Http\Controllers\Api;

use App\Models\Linea;
use App\Http\Requests\Linea\StoreLineaRequest;
use App\Http\Requests\Linea\UpdateLineaRequest;
use App\Http\Resources\LineaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Líneas",
 *     description="Operaciones sobre líneas"
 * )
 */
class LineaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/lineas",
     *     tags={"Líneas"},
     *     summary="Listar líneas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de líneas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Linea"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $lineas = Linea::paginate();
        return LineaResource::collection($lineas);
    }

    /**
     * @OA\Post(
     *     path="/api/lineas",
     *     tags={"Líneas"},
     *     summary="Crear línea",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Linea")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Línea creada",
     *         @OA\JsonContent(ref="#/components/schemas/Linea")
     *     )
     * )
     */
    public function store(StoreLineaRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('lineas', 'public');
        }
        $Linea = Linea::create($data);
        return new LineaResource($Linea);
    }

    /**
     * @OA\Get(
     *     path="/api/lineas/{id}",
     *     tags={"Líneas"},
     *     summary="Obtener línea por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Línea encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Linea")
     *     ),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Linea $Linea)
    {
        return new LineaResource($Linea);
    }

    /**
     * @OA\Put(
     *     path="/api/lineas/{id}",
     *     tags={"Líneas"},
     *     summary="Actualizar línea",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Linea")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Línea actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Linea")
     *     )
     * )
     */
    public function update(UpdateLineaRequest $request, Linea $Linea)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($Linea->photo_path) {
                Storage::disk('public')->delete($Linea->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('lineas', 'public');
        }
        $Linea->update($data);
        return new LineaResource($Linea);
    }

    /**
     * @OA\Delete(
     *     path="/api/lineas/{id}",
     *     tags={"Líneas"},
     *     summary="Eliminar línea",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Línea eliminada")
     * )
     */
    public function destroy(Linea $Linea)
    {
        if ($Linea->photo_path) {
            Storage::disk('public')->delete($Linea->photo_path);
        }
        $Linea->delete();
        return response()->json(['message' => 'Línea eliminada']);
    }
}