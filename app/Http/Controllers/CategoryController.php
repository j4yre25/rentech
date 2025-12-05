<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        return Inertia::render('Admin/Categories', ['categories' => $categories]);
    }

    public function create()
    {
        return Inertia::render('Admin/CreateCategories');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'visible' => 'required|boolean',
        ]);

        $imagePath = $request->file('image')?->store('categories', 'public');

        Category::create([
            'name' => $request->name,
            'image' => $imagePath,
            'visible' => $request->visible,
        ]);

        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $products = Product::distinct()->get();
        
        return Inertia::render('Admin/EditCategories', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'visible' => 'required|boolean',
        ]);

        $imagePath = $request->file('image')?->store('categories', 'public');

        $category->update([
            'name' => $request->name,
            'image' => $imagePath,
            'visible' => $request->visible,
        ]);

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
