<?php

namespace App\Http\Controllers\Api;

use App\Models\Marca;
use App\Http\Requests\Marca\StoreMarcaRequest;
use App\Http\Requests\Marca\UpdateMarcaRequest;
use App\Http\Resources\MarcaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="marcas",
 *     description="Operaciones sobre marcas"
 * )
 */
class MarcaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/marcas",
     *     tags={"marcas"},
     *     summary="Listar marcas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de marcas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Marca"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $marcas = Marca::paginate();
        return MarcaResource::collection($marcas);
    }

    /**
     * @OA\Post(
     *     path="/api/marcas",
     *     tags={"marcas"},
     *     summary="Crear marca",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Marca")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Marca creada",
     *         @OA\JsonContent(ref="#/components/schemas/Marca")
     *     )
     * )
     */
    public function store(StoreMarcaRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('marcas', 'public');
        }
        $Marca = Marca::create($data);
        return new MarcaResource($Marca);
    }

    /**
     * @OA\Get(
     *     path="/api/marcas/{id}",
     *     tags={"marcas"},
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
     *         @OA\JsonContent(ref="#/components/schemas/Marca")
     *     ),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Marca $Marca)
    {
        return new MarcaResource($Marca);
    }

    /**
     * @OA\Put(
     *     path="/api/marcas/{id}",
     *     tags={"marcas"},
     *     summary="Actualizar marca",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Marca")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Marca actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Marca")
     *     )
     * )
     */
    public function update(UpdateMarcaRequest $request, Marca $Marca)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($Marca->photo_path) {
                Storage::disk('public')->delete($Marca->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('marcas', 'public');
        }
        $Marca->update($data);
        return new MarcaResource($Marca);
    }

    /**
     * @OA\Delete(
     *     path="/api/marcas/{id}",
     *     tags={"marcas"},
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
    public function destroy(Marca $Marca)
    {
        if ($Marca->photo_path) {
            Storage::disk('public')->delete($Marca->photo_path);
        }
        $Marca->delete();
        return response()->json(['message' => 'Marca eliminada']);
    }
}