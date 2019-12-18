<?php
declare(strict_types=1);

namespace App\Services;


use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryService
{
    public function index(Request $request) : JsonResponse
    {
        $categories = Category::paginate();

        return response()->json([
            'categories' => $categories
        ], 200);
    }

    /** получение информации для формы добавления */
    public function create(Category $category)
    {
        return response()->json([
            'category' => $category
        ], 200);
    }

    /** сохранение информации о категории */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    /** обновление информации о категории */
    public function update(CategoryStoreRequest $request, Category $category) : JsonResponse
    {
        $category->update($request->validated());

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    /** получение детальной информации для просмотра */
    public function show(Category $category)
    {
        return response()->json([
            'category' => $category
        ], 200);
    }

    /** получение информации для формы добавления */
    public function edit(Category $category)
    {
        return response()->json([
            'category' => $category
        ], 200);
    }

    /** удаление категории */
    public function destroy(Category $category)
    {
        $category->delete($category->id);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

}