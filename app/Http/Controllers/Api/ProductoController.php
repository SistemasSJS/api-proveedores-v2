<?php

namespace App\Http\Controllers\Api;

use App\Models\Producto;
use App\Http\Requests\Producto\StoreProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Productoos",
 *     description="Operaciones sobre Productoos"
 * )
 */
class ProductoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/Productos",
     *     tags={"Productoos"},
     *     summary="Listar Productoos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de Productoos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Producto"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $Productos = Producto::with(['catalogo', 'marca', 'linea', 'categorias'])->paginate();
        return ProductoResource::collection($Productos);
    }

    /**
     * @OA\Post(
     *     path="/api/Productos",
     *     tags={"Productoos"},
     *     summary="Crear Productoo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Productoo creado",
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     )
     * )
     */
    public function store(StoreProductoRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('productos', 'public');
        }
        $Producto = Producto::create($data);
        if (isset($data['categoria'])) {
            $Producto->categoria()->sync($data['categoria']);
        }
        return new ProductoResource($Producto->fresh(['catalogo', 'marca', 'linea', 'categoria']));
    }

    /**
     * @OA\Get(
     *     path="/api/Productos/{id}",
     *     tags={"Productoos"},
     *     summary="Obtener Productoo por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Productoo encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Producto $Producto)
    {
        $Producto->load(['catalogo', 'marca', 'linea', 'categoria']);
        return new ProductoResource($Producto);
    }

    /**
     * @OA\Put(
     *     path="/api/Productos/{id}",
     *     tags={"Productoos"},
     *     summary="Actualizar Productoo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Productoo actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     )
     * )
     */
    public function update(UpdateProductoRequest $request, Producto $Producto)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($Producto->photo_path) {
                Storage::disk('public')->delete($Producto->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('productos', 'public');
        }
        $Producto->update($data);
        if (isset($data['categoria'])) {
            $Producto->categoria()->sync($data['categoria']);
        }
        return new ProductoResource($Producto->fresh(['catalogo', 'marca', 'linea', 'categoria']));
    }

    /**
     * @OA\Delete(
     *     path="/api/Productos/{id}",
     *     tags={"Productoos"},
     *     summary="Eliminar Productoo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Productoo eliminado")
     * )
     */
    public function destroy(Producto $Producto)
    {
        if ($Producto->photo_path) {
            Storage::disk('public')->delete($Producto->photo_path);
        }
        $Producto->categoria()->detach();
        $Producto->delete();
        return response()->json(['message' => 'Productoo eliminado']);
    }
}