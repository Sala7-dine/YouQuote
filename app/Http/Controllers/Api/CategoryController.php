<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return response()->json(null, 204);
    }
}
