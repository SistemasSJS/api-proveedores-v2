<?php

namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use App\Http\Requests\Categoria\StoreCategoriaRequest;
use App\Http\Requests\Categoria\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Categorías",
 *     description="Operaciones sobre categorías"
 * )
 */
class CategoriaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categoria",
     *     tags={"Categorías"},
     *     summary="Listar categorías",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorías",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Categoria"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $categoria = Categoria::paginate();
        return CategoriaResource::collection($categoria);
    }

    /**
     * @OA\Post(
     *     path="/api/categoria",
     *     tags={"Categorías"},
     *     summary="Crear categoría",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     )
     * )
     */
    public function store(StoreCategoriaRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('categoria', 'public');
        }
        $Categoria = Categoria::create($data);
        return new CategoriaResource($Categoria);
    }

    /**
     * @OA\Get(
     *     path="/api/categoria/{id}",
     *     tags={"Categorías"},
     *     summary="Obtener categoría por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Categoria $Categoria)
    {
        return new CategoriaResource($Categoria);
    }

    /**
     * @OA\Put(
     *     path="/api/categoria/{id}",
     *     tags={"Categorías"},
     *     summary="Actualizar categoría",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     )
     * )
     */
    public function update(UpdateCategoriaRequest $request, Categoria $Categoria)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($Categoria->photo_path) {
                Storage::disk('public')->delete($Categoria->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('categoria', 'public');
        }
        $Categoria->update($data);
        return new CategoriaResource($Categoria);
    }

    /**
     * @OA\Delete(
     *     path="/api/categoria/{id}",
     *     tags={"Categorías"},
     *     summary="Eliminar categoría",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Categoría eliminada")
     * )
     */
    public function destroy(Categoria $Categoria)
    {
        if ($Categoria->photo_path) {
            Storage::disk('public')->delete($Categoria->photo_path);
        }
        $Categoria->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }
}