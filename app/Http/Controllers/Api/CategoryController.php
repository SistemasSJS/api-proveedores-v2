<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Categorías",
 *     description="Operaciones sobre categorías"
 * )
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Categorías"},
     *     summary="Listar categorías",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorías",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Category"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $categories = Category::paginate();
        return CategoryResource::collection($categories);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Categorías"},
     *     summary="Crear categoría",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('categories', 'public');
        }
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
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
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($category->photo_path) {
                Storage::disk('public')->delete($category->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('categories', 'public');
        }
        $category->update($data);
        return new CategoryResource($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
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
    public function destroy(Category $category)
    {
        if ($category->photo_path) {
            Storage::disk('public')->delete($category->photo_path);
        }
        $category->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }
}