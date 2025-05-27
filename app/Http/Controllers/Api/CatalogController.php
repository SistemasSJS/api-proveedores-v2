<?php

namespace App\Http\Controllers\Api;

use App\Models\Catalog;
use App\Http\Requests\Catalog\StoreCatalogRequest;
use App\Http\Requests\Catalog\UpdateCatalogRequest;
use App\Http\Resources\CatalogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Catálogos",
 *     description="Operaciones sobre catálogos"
 * )
 */
class CatalogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/catalogs",
     *     tags={"Catálogos"},
     *     summary="Listar catálogos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de catálogos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Catalog"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $catalogs = Catalog::with('provider')->paginate();
        return CatalogResource::collection($catalogs);
    }

    /**
     * @OA\Post(
     *     path="/api/catalogs",
     *     tags={"Catálogos"},
     *     summary="Crear catálogo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Catalog")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Catálogo creado",
     *         @OA\JsonContent(ref="#/components/schemas/Catalog")
     *     )
     * )
     */
    public function store(StoreCatalogRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('catalogs', 'public');
        }
        $catalog = Catalog::create($data);
        return new CatalogResource($catalog->fresh('provider'));
    }

    /**
     * @OA\Get(
     *     path="/api/catalogs/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Catalog")
     *     ),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Catalog $catalog)
    {
        $catalog->load('provider');
        return new CatalogResource($catalog);
    }

    /**
     * @OA\Put(
     *     path="/api/catalogs/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Catalog")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Catálogo actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Catalog")
     *     )
     * )
     */
    public function update(UpdateCatalogRequest $request, Catalog $catalog)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($catalog->photo_path) {
                Storage::disk('public')->delete($catalog->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('catalogs', 'public');
        }
        $catalog->update($data);
        return new CatalogResource($catalog->fresh('provider'));
    }

    /**
     * @OA\Delete(
     *     path="/api/catalogs/{id}",
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
    public function destroy(Catalog $catalog)
    {
        if ($catalog->photo_path) {
            Storage::disk('public')->delete($catalog->photo_path);
        }
        $catalog->delete();
        return response()->json(['message' => 'Catálogo eliminado']);
    }
}