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

        Product::create($validated); // Use validated data

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // Retrieve all categories for the dropdown

        return Inertia::render('Admin/EditProducts', [
            'product' => $product,
            'categories' => $categories,
        ]);
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

    public function destroy(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'exists:products,id', // Ensure each product ID exists
        ]);

        Product::whereIn('id', $request->products)->delete();

        return response()->json(['message' => 'Selected products deleted successfully.']);
    }
    public function create()
    {
        $categories = Category::all()->toArray(); // Convert to plain array

        return Inertia::render('Admin/CreateProducts', [
            'categories' => $categories,
        ]);
    }


    public function view(Product $product)
    {
        return Inertia::render('Pages/ViewDetailsGadget', [
            'product' => $product,
        ]);
    }
}
