<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::all();
    return view('kategori', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    try {
        $category = Category::create($request->all());
        return response()->json($category, 201);
        return redirect()->route('categories')->with('success', 'Kategori berhasil ditambahkan.');
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to create category', 'message' => $e->getMessage()], 500);
        return redirect()->route('categories')->withErrors(['error' => 'Gagal menambahkan kategori: ' . $e->getMessage()]);
    }
}

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id)
{
    try {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete category', 'message' => $e->getMessage()], 500);
    }
}
}
