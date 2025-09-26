<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori dibuat');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori diupdate');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori dihapus');
    }
}
