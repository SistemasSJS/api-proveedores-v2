<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Marcas",
 *     description="Operaciones sobre marcas"
 * )
 */
class BrandController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/brands",
     *     tags={"Marcas"},
     *     summary="Listar marcas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de marcas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Brand"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $brands = Brand::paginate();
        return BrandResource::collection($brands);
    }

    /**
     * @OA\Post(
     *     path="/api/brands",
     *     tags={"Marcas"},
     *     summary="Crear marca",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Brand")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Marca creada",
     *         @OA\JsonContent(ref="#/components/schemas/Brand")
     *     )
     * )
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('brands', 'public');
        }
        $brand = Brand::create($data);
        return new BrandResource($brand);
    }

    /**
     * @OA\Get(
     *     path="/api/brands/{id}",
     *     tags={"Marcas"},
     *     summary="Obtener marca por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Marca encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Brand")
     *     ),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * @OA\Put(
     *     path="/api/brands/{id}",
     *     tags={"Marcas"},
     *     summary="Actualizar marca",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Brand")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Marca actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Brand")
     *     )
     * )
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($brand->photo_path) {
                Storage::disk('public')->delete($brand->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('brands', 'public');
        }
        $brand->update($data);
        return new BrandResource($brand);
    }

    /**
     * @OA\Delete(
     *     path="/api/brands/{id}",
     *     tags={"Marcas"},
     *     summary="Eliminar marca",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Marca eliminada")
     * )
     */
    public function destroy(Brand $brand)
    {
        if ($brand->photo_path) {
            Storage::disk('public')->delete($brand->photo_path);
        }
        $brand->delete();
        return response()->json(['message' => 'Marca eliminada']);
    }
}