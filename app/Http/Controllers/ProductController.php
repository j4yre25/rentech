<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('orders')
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
        ]);

        Product::create($validated);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function create()
    {
        return Inertia::render('Admin/CreateProducts');
    }

    public function view(Product $product)
    {
        return Inertia::render('Pages/ViewDetailsGadget', [
            'product' => $product,
        ]);
    }
}