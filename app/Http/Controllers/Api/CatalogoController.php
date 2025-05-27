<?php

namespace App\Http\Controllers\Api;

use App\Models\Catalogo;
use App\Http\Requests\Catalogo\StoreCatalogoRequest;
use App\Http\Requests\Catalogo\UpdateCatalogoRequest;
use App\Http\Resources\CatalogoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Catálogos",
 *     description="Operaciones sobre catálogos"
 * )
 */
class CatalogoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/Catalogos",
     *     tags={"Catálogos"},
     *     summary="Listar catálogos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de catálogos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Catalogo"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $Catalogos = Catalogo::with('Proveedor')->paginate();
        return CatalogoResource::collection($Catalogos);
    }

    /**
     * @OA\Post(
     *     path="/api/Catalogos",
     *     tags={"Catálogos"},
     *     summary="Crear catálogo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Catalogo")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Catálogo creado",
     *         @OA\JsonContent(ref="#/components/schemas/Catalogo")
     *     )
     * )
     */
    public function store(StoreCatalogoRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('Catalogos', 'public');
        }
        $Catalogo = Catalogo::create($data);
        return new CatalogoResource($Catalogo->fresh('Proveedor'));
    }

    /**
     * @OA\Get(
     *     path="/api/Catalogos/{id}",
     *     tags={"Catálogos"},
     *     summary="Obtener catálogo por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Catálogo encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Catalogo")
     *     ),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Catalogo $Catalogo)
    {
        $Catalogo->load('Proveedor');
        return new CatalogoResource($Catalogo);
    }

    /**
     * @OA\Put(
     *     path="/api/Catalogos/{id}",
     *     tags={"Catálogos"},
     *     summary="Actualizar catálogo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Catalogo")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Catálogo actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Catalogo")
     *     )
     * )
     */
    public function update(UpdateCatalogoRequest $request, Catalogo $Catalogo)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($Catalogo->photo_path) {
                Storage::disk('public')->delete($Catalogo->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('Catalogos', 'public');
        }
        $Catalogo->update($data);
        return new CatalogoResource($Catalogo->fresh('Proveedor'));
    }

    /**
     * @OA\Delete(
     *     path="/api/Catalogos/{id}",
     *     tags={"Catálogos"},
     *     summary="Eliminar catálogo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Catálogo eliminado")
     * )
     */
    public function destroy(Catalogo $Catalogo)
    {
        if ($Catalogo->photo_path) {
            Storage::disk('public')->delete($Catalogo->photo_path);
        }
        $Catalogo->delete();
        return response()->json(['message' => 'Catálogo eliminado']);
    }
}