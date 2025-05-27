<?php

namespace App\Http\Controllers\Api;

use App\Models\Provider;
use App\Http\Requests\Provider\StoreProviderRequest;
use App\Http\Requests\Provider\UpdateProviderRequest;
use App\Http\Resources\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Proveedores",
 *     description="Operaciones sobre proveedores"
 * )
 */
class ProviderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/providers",
     *     tags={"Proveedores"},
     *     summary="Listar proveedores",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de proveedores",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Provider"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $providers = Provider::paginate();
        return ProviderResource::collection($providers);
    }

    /**
     * @OA\Post(
     *     path="/api/providers",
     *     tags={"Proveedores"},
     *     summary="Crear proveedor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Provider")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Proveedor creado",
     *         @OA\JsonContent(ref="#/components/schemas/Provider")
     *     )
     * )
     */
    public function store(StoreProviderRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('providers', 'public');
        }
        $provider = Provider::create($data);
        return new ProviderResource($provider);
    }

    /**
     * @OA\Get(
     *     path="/api/providers/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Provider")
     *     ),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(Provider $provider)
    {
        return new ProviderResource($provider);
    }

    /**
     * @OA\Put(
     *     path="/api/providers/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Provider")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Provider")
     *     )
     * )
     */
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($provider->photo_path) {
                Storage::disk('public')->delete($provider->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('providers', 'public');
        }
        $provider->update($data);
        return new ProviderResource($provider);
    }

    /**
     * @OA\Delete(
     *     path="/api/providers/{id}",
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
    public function destroy(Provider $provider)
    {
        if ($provider->photo_path) {
            Storage::disk('public')->delete($provider->photo_path);
        }
        $provider->delete();
        return response()->json(['message' => 'Proveedor eliminado']);
    }
}