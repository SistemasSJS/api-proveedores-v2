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
 *     name="Proveedores",
 *     description="Operaciones sobre proveedores"
 * )
 */
class ProveedorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/Proveedors",
     *     tags={"Proveedores"},
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
        $Proveedors = Proveedor::paginate();
        return ProveedorResource::collection($Proveedors);
    }

    /**
     * @OA\Post(
     *     path="/api/Proveedors",
     *     tags={"Proveedores"},
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
            $data['photo_path'] = $request->file('photo')->store('Proveedors', 'public');
        }
        $Proveedor = Proveedor::create($data);
        return new ProveedorResource($Proveedor);
    }

    /**
     * @OA\Get(
     *     path="/api/Proveedors/{id}",
     *     tags={"Proveedores"},
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
     *     path="/api/Proveedors/{id}",
     *     tags={"Proveedores"},
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
            $data['photo_path'] = $request->file('photo')->store('Proveedors', 'public');
        }
        $Proveedor->update($data);
        return new ProveedorResource($Proveedor);
    }

    /**
     * @OA\Delete(
     *     path="/api/Proveedors/{id}",
     *     tags={"Proveedores"},
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