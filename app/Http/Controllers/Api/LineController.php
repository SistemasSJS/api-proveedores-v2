<?php

namespace App\Http\Controllers\Api;

use App\Models\Line;
use App\Http\Requests\Line\StoreLineRequest;
use App\Http\Requests\Line\UpdateLineRequest;
use App\Http\Resources\LineResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Líneas",
 *     description="Operaciones sobre líneas"
 * )
 */
class LineController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/lines",
     *     tags={"Líneas"},
     *     summary="Listar líneas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de líneas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Line"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $lines = Line::paginate();
        return LineResource::collection($lines);
    }

    /**
     * @OA\Post(
     *     path="/api/lines",
     *     tags={"Líneas"},
     *     summary="Crear línea",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Line")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Línea creada",
     *         @OA\JsonContent(ref="#/components/schemas/Line")
     *     )
     * )
     */
    public function store(StoreLineRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('lines', 'public');
        }
        $line = Line::create($data);
        return new LineResource($line);
    }

    /**
     * @OA\Get(
     *     path="/api/lines/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Line")
     *     ),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Line $line)
    {
        return new LineResource($line);
    }

    /**
     * @OA\Put(
     *     path="/api/lines/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Line")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Línea actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Line")
     *     )
     * )
     */
    public function update(UpdateLineRequest $request, Line $line)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($line->photo_path) {
                Storage::disk('public')->delete($line->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('lines', 'public');
        }
        $line->update($data);
        return new LineResource($line);
    }

    /**
     * @OA\Delete(
     *     path="/api/lines/{id}",
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
    public function destroy(Line $line)
    {
        if ($line->photo_path) {
            Storage::disk('public')->delete($line->photo_path);
        }
        $line->delete();
        return response()->json(['message' => 'Línea eliminada']);
    }
}