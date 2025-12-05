<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['orders', 'category']) // Include category relationship
            ->when($request->name, function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->paginate(15);

        if ($request->expectsJson()) {
            return response()->json($products);
        }

        return Inertia::render('Admin/Products', [
            'products' => $products,
            'filters' => $request->only(['name']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'color' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ]);

        Product::create($request->only(['name', 'price', 'category_id', 'stock_quantity', 'color', 'description', 'images']));

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'color' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ]);

        $product->update($request->only(['name', 'price', 'category_id', 'stock_quantity', 'color', 'description', 'images']));

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function create()
    {
        $categories = Category::all()->toArray(); // Convert to plain array

        return Inertia::render('Admin/CreateProducts', [
            'categories' => $categories,
        ]);
    }
}
