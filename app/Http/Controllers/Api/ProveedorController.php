<?php

namespace App\Http\Controllers\Api;

use App\Models\Proveedor;
use App\Http\Requests\Proveedor\StoreProveedorRequest;
use App\Http\Requests\Proveedor\UpdateProveedorRequest;
use App\Http\Resources\ProveedorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="proveedores",
 *     description="Operaciones sobre proveedores"
 * )
 */
class ProveedorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/proveedores",
     *     tags={"proveedores"},
     *     summary="Listar proveedores",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de proveedores",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Proveedor"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $proveedores = Proveedor::paginate();
        return ProveedorResource::collection($proveedores);
    }

    /**
     * @OA\Post(
     *     path="/api/proveedores",
     *     tags={"proveedores"},
     *     summary="Crear proveedor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Proveedor")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Proveedor creado",
     *         @OA\JsonContent(ref="#/components/schemas/Proveedor")
     *     )
     * )
     */
    public function store(StoreProveedorRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('proveedores', 'public');
        }
        $Proveedor = Proveedor::create($data);
        return new ProveedorResource($Proveedor);
    }

    /**
     * @OA\Get(
     *     path="/api/proveedores/{id}",
     *     tags={"proveedores"},
     *     summary="Obtener proveedor por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Proveedor")
     *     ),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Proveedor $Proveedor)
    {
        return new ProveedorResource($Proveedor);
    }

    /**
     * @OA\Put(
     *     path="/api/proveedores/{id}",
     *     tags={"proveedores"},
     *     summary="Actualizar proveedor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Proveedor")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Proveedor")
     *     )
     * )
     */
    public function update(UpdateProveedorRequest $request, Proveedor $Proveedor)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($Proveedor->photo_path) {
                Storage::disk('public')->delete($Proveedor->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('proveedores', 'public');
        }
        $Proveedor->update($data);
        return new ProveedorResource($Proveedor);
    }

    /**
     * @OA\Delete(
     *     path="/api/proveedores/{id}",
     *     tags={"proveedores"},
     *     summary="Eliminar proveedor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Proveedor eliminado")
     * )
     */
    public function destroy(Proveedor $Proveedor)
    {
        if ($Proveedor->photo_path) {
            Storage::disk('public')->delete($Proveedor->photo_path);
        }
        $Proveedor->delete();
        return response()->json(['message' => 'Proveedor eliminado']);
    }
}