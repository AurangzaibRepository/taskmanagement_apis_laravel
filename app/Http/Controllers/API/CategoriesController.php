<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryListingRequest;
use App\Http\Requests\CategoryStatusRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\ShowCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    public function __construct(
        private Category $category
    ) {
    }

    public function all(): JsonResponse
    {
        $data = $this->category->getAll();

        return getResponse(true, $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function listing(CategoryListingRequest $request, int $pageNumber, string $name = ''): JsonResponse
    {
        $data = $this->category->getListing($pageNumber, $name);

        return getResponse(true, $data);
    }

    public function show(ShowCategoryRequest $request, int $id): JsonResponse
    {
        $data = $this->category->getData($id);

        return getResponse(true, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $data = $this->category->saveRecord($request->all());

            return getResponse(true, $data, 'Category added successfully');
        } catch (Exception $exception) {
            report($exception);

            return getResponse(false, null, 'Error occurred');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        $this->category->updateRecord($id, $request->all());

        return getResponse(true, null, 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCategoryRequest $request, string $id): JsonResponse
    {
        $this->category->deleteRecord($id);

        return getResponse(true, null, 'Category deleted successfully');
    }

    public function changeStatus(CategoryStatusRequest $request, int $id, string $status): JsonResponse
    {
        $statusText = ($status === 'Active' ? 'activated' : 'deactivated');

        $this->category->updateStatus($id, $status);

        return getResponse(true, null, "Category {$statusText} successfully");
    }
}
